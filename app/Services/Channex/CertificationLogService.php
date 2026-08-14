<?php

namespace App\Services\Channex;

use App\Models\ChannexCertificationLog;
use App\Models\Property;

class CertificationLogService
{
    public function log(
        string $source,
        string $status,
        ?string $scenario = null,
        ?int $propertyId = null,
        ?int $apartmentId = null,
        array $taskIds = [],
        ?array $requestPayload = null,
        ?array $responsePayload = null,
        ?string $notes = null
    ): ChannexCertificationLog {
        $resolvedRequestPayload = $requestPayload ?? [];

        if ($propertyId && empty($resolvedRequestPayload['property_uuid'])) {
            $propertyUuid = Property::query()
                ->whereKey($propertyId)
                ->value('channex_property_id');

            if ($propertyUuid) {
                $resolvedRequestPayload['property_uuid'] = $propertyUuid;
            }
        }

        return ChannexCertificationLog::create([
            'source' => $source,
            'status' => $status,
            'scenario' => $scenario,
            'property_id' => $propertyId,
            'apartment_id' => $apartmentId,
            'task_ids' => array_values(array_unique(array_filter($taskIds))),
            'request_payload' => ! empty($resolvedRequestPayload) ? $resolvedRequestPayload : null,
            'response_payload' => $responsePayload,
            'notes' => $notes,
        ]);
    }
}
