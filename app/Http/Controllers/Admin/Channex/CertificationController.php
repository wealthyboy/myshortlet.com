<?php

namespace App\Http\Controllers\Admin\Channex;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessChannexAriOutbox;
use App\Models\Apartment;
use App\Models\ChannexCertificationLog;
use App\Models\Property;
use App\Services\Channex\AriOutboxService;
use App\Services\Channex\CertificationLogService;
use App\Services\Channex\DailyAriService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CertificationController extends Controller
{
    public function ariIndex()
    {
        $apartments = Apartment::with(['property', 'channexRatePlans'])
            ->orderBy('name')
            ->get();

        return view('admin.channex.ari_updates', compact('apartments'));
    }

    public function queueAriUiBatch(Request $request)
    {
        $rows = collect((array) $request->input('updates', []))
            ->filter(function ($row) {
                return ! empty($row['apartment_id'])
                    && ! empty($row['date_from'])
                    && ! empty($row['date_to']);
            })
            ->values()
            ->all();

        if (empty($rows)) {
            return redirect()->back()->with(
                'error',
                'Add at least one complete update row.'
            );
        }

        $validator = Validator::make([
            'scenario' => $request->input('scenario'),
            'updates' => $rows,
        ], [
            'scenario' => 'nullable|string|max:60',
            'updates' => 'required|array|min:1',
            'updates.*.apartment_id' => 'required|integer|exists:apartments,id',
            'updates.*.rate_plan_id' => 'nullable|integer|exists:channex_rate_plans,id',
            'updates.*.date_from' => 'required|date',
            'updates.*.date_to' => 'required|date',
            'updates.*.availability' => 'nullable|integer|min:0',
            'updates.*.rate' => 'nullable|numeric|min:0',
            'updates.*.min_stay_arrival' => 'nullable|integer|min:0',
            'updates.*.min_stay_through' => 'nullable|integer|min:0',
            'updates.*.max_stay' => 'nullable|integer|min:0',
            'updates.*.closed_to_arrival' => 'nullable|in:0,1',
            'updates.*.closed_to_departure' => 'nullable|in:0,1',
            'updates.*.stop_sell' => 'nullable|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach ($rows as $row) {
            if (strtotime($row['date_to']) < strtotime($row['date_from'])) {
                return redirect()->back()->with(
                    'error',
                    'Each update date_to must be greater than or equal to date_from.'
                );
            }

            if (! $this->hasAriChanges($row)) {
                return redirect()->back()->with(
                    'error',
                    'Each completed row must include at least one rate, availability or restriction change.'
                )->withInput();
            }

            if ($this->hasRestrictionChanges($row) && empty($row['rate_plan_id'])) {
                return redirect()->back()->with(
                    'error',
                    'Select a rate plan for every rate or restriction change.'
                )->withInput();
            }

            if (! empty($row['rate_plan_id']) && ! $this->ratePlanBelongsToApartment($row)) {
                return redirect()->back()->with(
                    'error',
                    'The selected rate plan does not belong to the selected apartment.'
                )->withInput();
            }
        }

        $scenario = $request->input('scenario') ?: null;

        DB::transaction(function () use ($rows, $scenario) {
            $outboxService = app(AriOutboxService::class);
            $certificationLogService = app(CertificationLogService::class);
            $dailyAriService = app(DailyAriService::class);

            $firstPropertyId = null;
            $eventIds = [];

            foreach ($rows as $row) {
                $apartment = Apartment::with('property')->findOrFail((int) $row['apartment_id']);

                $payload = [
                    'date_from' => $row['date_from'],
                    'date_to' => $row['date_to'],
                ];

                if (! empty($row['rate_plan_id'])) {
                    $ratePlan = $apartment->channexRatePlans()->findOrFail((int) $row['rate_plan_id']);
                    $payload['rate_plan_id'] = $ratePlan->id;
                }

                foreach ([
                    'availability',
                    'rate',
                    'min_stay_arrival',
                    'min_stay_through',
                    'max_stay',
                ] as $field) {
                    if (array_key_exists($field, $row) && $row[$field] !== '' && $row[$field] !== null) {
                        $payload[$field] = $row[$field];
                    }
                }

                foreach (['closed_to_arrival', 'closed_to_departure', 'stop_sell'] as $field) {
                    if (array_key_exists($field, $row) && $row[$field] !== '' && $row[$field] !== null) {
                        $payload[$field] = (bool) ((int) $row[$field]);
                    }
                }

                $dailyAriService->storeRange(
                    $apartment,
                    $payload['date_from'],
                    $payload['date_to'],
                    $payload
                );

                $event = $outboxService->queueApartmentChange($apartment, $payload, $scenario);
                $eventIds[] = $event->id;

                if (! $firstPropertyId) {
                    $firstPropertyId = (int) $apartment->property_id;
                }
            }

            $certificationLogService->log(
                'ari_ui_queue',
                'success',
                $scenario,
                $firstPropertyId,
                null,
                [],
                [
                    'event_ids' => $eventIds,
                    'updates' => $rows,
                ],
                null
            );

            ProcessChannexAriOutbox::dispatch();
        });

        return redirect()->back()->with(
            'success',
            'ARI updates queued from PMS UI. Task IDs will appear in Channex Certification Logs.'
        );
    }

    public function index(Request $request)
    {
        $query = ChannexCertificationLog::query()->latest();

        if ($request->filled('test_number')) {
            $testNumber = (int) $request->test_number;

            if ($testNumber >= 1 && $testNumber <= 14) {
                $query->where(function ($q) use ($testNumber) {
                    $q->where('scenario', 'like', 'test_' . $testNumber . '_%')
                        ->orWhere('scenario', 'test_' . $testNumber);
                });
            }
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('scenario')) {
            $query->where('scenario', 'like', '%' . $request->scenario . '%');
        }

        $logs = $query->paginate(30)->appends($request->query());

        return view('admin.channex.certification_logs', compact('logs'));
    }

    public function show(ChannexCertificationLog $log)
    {
        $submittedData = (array) $log->request_payload;
        $returnedData = (array) $log->response_payload;
        $propertyUuid = data_get($submittedData, 'property_uuid')
            ?: data_get($submittedData, 'property_channex_id');

        if (! $propertyUuid && $log->property_id) {
            $propertyUuid = Property::query()
                ->whereKey($log->property_id)
                ->value('channex_property_id');
        }

        return view('admin.channex.certification_log_show', [
            'log' => $log,
            'submittedData' => $submittedData,
            'returnedData' => $returnedData,
            'submittedFields' => $this->flattenLogData($submittedData),
            'returnedFields' => $this->flattenLogData($returnedData),
            'propertyUuid' => $propertyUuid,
        ]);
    }

    protected function flattenLogData(array $data, string $prefix = ''): array
    {
        $fields = [];

        foreach ($data as $key => $value) {
            $label = trim($prefix . ' ' . str_replace('_', ' ', (string) $key));

            if (is_array($value)) {
                if (empty($value)) {
                    $fields[] = ['label' => $label, 'value' => 'None'];
                    continue;
                }

                $fields = array_merge(
                    $fields,
                    $this->flattenLogData($value, $label)
                );
                continue;
            }

            if (is_bool($value)) {
                $value = $value ? 'Yes' : 'No';
            } elseif ($value === null || $value === '') {
                $value = '—';
            }

            $fields[] = [
                'label' => ucwords($label),
                'value' => (string) $value,
            ];
        }

        return $fields;
    }

    public function queueAriBatch(Request $request)
    {
        $validated = $request->validate([
            'scenario' => 'nullable|string|max:60',
            'updates' => 'required|array|min:1',
            'updates.*.apartment_id' => 'required|integer|exists:apartments,id',
            'updates.*.rate_plan_id' => 'nullable|integer|exists:channex_rate_plans,id',
            'updates.*.date_from' => 'required|date',
            'updates.*.date_to' => 'required|date',
            'updates.*.availability' => 'nullable|integer|min:0',
            'updates.*.rate' => 'nullable|numeric|min:0',
            'updates.*.min_stay_arrival' => 'nullable|integer|min:0',
            'updates.*.min_stay_through' => 'nullable|integer|min:0',
            'updates.*.max_stay' => 'nullable|integer|min:0',
            'updates.*.closed_to_arrival' => 'nullable|boolean',
            'updates.*.closed_to_departure' => 'nullable|boolean',
            'updates.*.stop_sell' => 'nullable|boolean',
        ]);

        foreach ($validated['updates'] as $update) {
            if (strtotime($update['date_to']) < strtotime($update['date_from'])) {
                return redirect()->back()->with(
                    'error',
                    'Each update date_to must be greater than or equal to date_from.'
                );
            }

            if (! $this->hasAriChanges($update)) {
                return redirect()->back()->with(
                    'error',
                    'Each update must include at least one rate, availability or restriction change.'
                )->withInput();
            }

            if ($this->hasRestrictionChanges($update) && empty($update['rate_plan_id'])) {
                return redirect()->back()->with(
                    'error',
                    'Select a rate plan for every rate or restriction change.'
                )->withInput();
            }

            if (! empty($update['rate_plan_id']) && ! $this->ratePlanBelongsToApartment($update)) {
                return redirect()->back()->with(
                    'error',
                    'The selected rate plan does not belong to the selected apartment.'
                )->withInput();
            }
        }

        $scenario = $validated['scenario'] ?? 'manual_ari_batch';

        DB::transaction(function () use ($validated, $scenario) {
            $outboxService = app(AriOutboxService::class);
            $certificationLogService = app(CertificationLogService::class);
            $dailyAriService = app(DailyAriService::class);

            $firstPropertyId = null;
            $eventIds = [];

            foreach ($validated['updates'] as $update) {
                $apartment = Apartment::with('property')->findOrFail($update['apartment_id']);

                $payload = [
                    'date_from' => $update['date_from'],
                    'date_to' => $update['date_to'],
                ];

                if (! empty($update['rate_plan_id'])) {
                    $ratePlan = $apartment->channexRatePlans()->findOrFail((int) $update['rate_plan_id']);
                    $payload['rate_plan_id'] = $ratePlan->id;
                }

                foreach ([
                    'availability',
                    'rate',
                    'min_stay_arrival',
                    'min_stay_through',
                    'max_stay',
                    'closed_to_arrival',
                    'closed_to_departure',
                    'stop_sell',
                ] as $field) {
                    if (array_key_exists($field, $update)) {
                        $payload[$field] = $update[$field];
                    }
                }

                $dailyAriService->storeRange(
                    $apartment,
                    $payload['date_from'],
                    $payload['date_to'],
                    $payload
                );

                $event = $outboxService->queueApartmentChange($apartment, $payload, $scenario);
                $eventIds[] = $event->id;

                if (! $firstPropertyId) {
                    $firstPropertyId = (int) $apartment->property_id;
                }
            }

            $certificationLogService->log(
                'ari_batch_queue',
                'success',
                $scenario,
                $firstPropertyId,
                null,
                [],
                [
                    'event_ids' => $eventIds,
                    'updates' => $validated['updates'],
                ],
                null
            );

            ProcessChannexAriOutbox::dispatch()->afterCommit();
        });

        return redirect()->back()->with(
            'success',
            'ARI batch queued. Check channex_certification_logs for task IDs.'
        );
    }

    protected function hasAriChanges(array $row): bool
    {
        foreach ([
            'availability',
            'rate',
            'min_stay_arrival',
            'min_stay_through',
            'max_stay',
            'closed_to_arrival',
            'closed_to_departure',
            'stop_sell',
        ] as $field) {
            if (array_key_exists($field, $row) && $row[$field] !== '' && $row[$field] !== null) {
                return true;
            }
        }

        return false;
    }

    protected function hasRestrictionChanges(array $row): bool
    {
        foreach ([
            'rate',
            'min_stay_arrival',
            'min_stay_through',
            'max_stay',
            'closed_to_arrival',
            'closed_to_departure',
            'stop_sell',
        ] as $field) {
            if (array_key_exists($field, $row) && $row[$field] !== '' && $row[$field] !== null) {
                return true;
            }
        }

        return false;
    }

    protected function ratePlanBelongsToApartment(array $row): bool
    {
        return DB::table('channex_rate_plans')
            ->where('id', (int) $row['rate_plan_id'])
            ->where('apartment_id', (int) $row['apartment_id'])
            ->exists();
    }
}
