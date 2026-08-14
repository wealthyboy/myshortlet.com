@extends('admin.layouts.app')

@section('pagespecificstyles')
<style>
    .ari-table-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .ari-table {
        min-width: 1620px;
        margin-bottom: 0;
    }

    .ari-table th,
    .ari-table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    .ari-table .form-control {
        min-width: 110px;
        padding-left: 8px;
        padding-right: 8px;
    }

    .ari-table .cell-apartment .form-control {
        min-width: 190px;
    }

    .ari-table .cell-bool .form-control {
        min-width: 80px;
    }

    .ari-table .cell-date .form-control {
        min-width: 142px;
        padding-right: 34px;
        cursor: pointer;
    }

    .ari-date-field {
        position: relative;
    }

    .ari-date-field .material-icons {
        position: absolute;
        top: 50%;
        right: 8px;
        z-index: 2;
        color: #9c27b0;
        font-size: 19px;
        pointer-events: none;
        transform: translateY(-50%);
    }

    body > .bootstrap-datetimepicker-widget {
        z-index: 1060;
    }

    @media (max-width: 767px) {
        .ari-table .form-control {
            font-size: 12px;
            min-width: 96px;
        }

        .ari-table .cell-apartment .form-control {
            min-width: 170px;
        }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('admin.channex.certification.logs') }}" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">assignment</i>
                View Certification Logs
            </a>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="rose">
                <i class="material-icons">event_available</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Rates, Availability & Restrictions</h4>
                <p class="category">Manage daily PMS inventory, prices and booking restrictions. Saved changes are persisted locally and synchronized to connected channels.</p>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.channex.ari_updates.queue') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label>Change reference (optional)</label>
                        <input type="text" name="scenario" value="{{ old('scenario') }}" class="form-control" placeholder="e.g. Weekend pricing update">
                    </div>

                    <div class="ari-table-wrap">
                        <table class="table table-striped table-no-bordered ari-table">
                            <thead>
                                <tr>
                                    <th>Apartment</th>
                                    <th>Rate Plan</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Rate</th>
                                    <th>Availability</th>
                                    <th>Min Stay Arr.</th>
                                    <th>Min Stay Thr.</th>
                                    <th>Max Stay</th>
                                    <th>CTA</th>
                                    <th>CTD</th>
                                    <th>Stop Sell</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < 8; $i++)
                                    <tr>
                                        <td class="cell-apartment">
                                            <select name="updates[{{ $i }}][apartment_id]" class="form-control ari-apartment-select">
                                                <option value="">Select</option>
                                                @foreach($apartments as $apartment)
                                                    <option value="{{ $apartment->id }}" {{ old('updates.'.$i.'.apartment_id') == $apartment->id ? 'selected' : '' }}>
                                                        {{ $apartment->name }} ({{ optional($apartment->property)->name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="cell-apartment">
                                            <select name="updates[{{ $i }}][rate_plan_id]" class="form-control ari-rate-plan-select">
                                                <option value="">None (availability only)</option>
                                                @foreach($apartments as $apartment)
                                                    @foreach($apartment->channexRatePlans as $plan)
                                                        <option value="{{ $plan->id }}" data-apartment-id="{{ $apartment->id }}" {{ old('updates.'.$i.'.rate_plan_id') == $plan->id ? 'selected' : '' }}>
                                                            {{ $apartment->name }} — {{ $plan->name }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="cell-date">
                                            <div class="ari-date-field">
                                                <input type="date" name="updates[{{ $i }}][date_from]" value="{{ old('updates.'.$i.'.date_from') }}" class="form-control ari-date-from">
                                                <i class="material-icons" aria-hidden="true">date_range</i>
                                            </div>
                                        </td>
                                        <td class="cell-date">
                                            <div class="ari-date-field">
                                                <input type="date" name="updates[{{ $i }}][date_to]" value="{{ old('updates.'.$i.'.date_to') }}" class="form-control ari-date-to">
                                                <i class="material-icons" aria-hidden="true">date_range</i>
                                            </div>
                                        </td>
                                        <td><input type="number" step="0.01" min="0" name="updates[{{ $i }}][rate]" value="{{ old('updates.'.$i.'.rate') }}" class="form-control" placeholder="e.g. 333"></td>
                                        <td><input type="number" min="0" name="updates[{{ $i }}][availability]" value="{{ old('updates.'.$i.'.availability') }}" class="form-control" placeholder="e.g. 7"></td>
                                        <td><input type="number" min="0" name="updates[{{ $i }}][min_stay_arrival]" value="{{ old('updates.'.$i.'.min_stay_arrival') }}" class="form-control"></td>
                                        <td><input type="number" min="0" name="updates[{{ $i }}][min_stay_through]" value="{{ old('updates.'.$i.'.min_stay_through') }}" class="form-control"></td>
                                        <td><input type="number" min="0" name="updates[{{ $i }}][max_stay]" value="{{ old('updates.'.$i.'.max_stay') }}" class="form-control"></td>
                                        <td class="cell-bool">
                                            <select name="updates[{{ $i }}][closed_to_arrival]" class="form-control">
                                                <option value="">-</option>
                                                <option value="1" {{ old('updates.'.$i.'.closed_to_arrival') === '1' ? 'selected' : '' }}>true</option>
                                                <option value="0" {{ old('updates.'.$i.'.closed_to_arrival') === '0' ? 'selected' : '' }}>false</option>
                                            </select>
                                        </td>
                                        <td class="cell-bool">
                                            <select name="updates[{{ $i }}][closed_to_departure]" class="form-control">
                                                <option value="">-</option>
                                                <option value="1" {{ old('updates.'.$i.'.closed_to_departure') === '1' ? 'selected' : '' }}>true</option>
                                                <option value="0" {{ old('updates.'.$i.'.closed_to_departure') === '0' ? 'selected' : '' }}>false</option>
                                            </select>
                                        </td>
                                        <td class="cell-bool">
                                            <select name="updates[{{ $i }}][stop_sell]" class="form-control">
                                                <option value="">-</option>
                                                <option value="1" {{ old('updates.'.$i.'.stop_sell') === '1' ? 'selected' : '' }}>true</option>
                                                <option value="0" {{ old('updates.'.$i.'.stop_sell') === '0' ? 'selected' : '' }}>false</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-rose">Save & Sync Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('inline-scripts')
$(document).ready(function () {
    $('.ari-table tbody tr').each(function () {
        var $row = $(this);
        var $from = $row.find('.ari-date-from');
        var $to = $row.find('.ari-date-to');
        var $apartment = $row.find('.ari-apartment-select');
        var $ratePlan = $row.find('.ari-rate-plan-select');

        function filterRatePlans() {
            var apartmentId = $apartment.val();
            $ratePlan.find('option[data-apartment-id]').each(function () {
                $(this).prop('disabled', !apartmentId || $(this).data('apartment-id').toString() !== apartmentId);
            });

            var selectedApartmentId = $ratePlan.find('option:selected').data('apartment-id');
            if (selectedApartmentId && selectedApartmentId.toString() !== apartmentId) {
                $ratePlan.val('');
            }
        }

        function syncDateLimits() {
            $to.attr('min', $from.val() || null);
            $from.attr('max', $to.val() || null);
        }

        syncDateLimits();
        filterRatePlans();

        $apartment.on('change', filterRatePlans);

        $from.on('change', function () {
            if ($from.val() && (!$to.val() || $to.val() < $from.val())) {
                $to.val($from.val());
            }

            syncDateLimits();
        });

        $to.on('change', syncDateLimits);
    });
});
@endsection
