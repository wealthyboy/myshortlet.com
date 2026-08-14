@php
   $savedPlans = isset($apartment)
      ? $apartment->channexRatePlans->values()
      : collect();

   $defaultPlans = collect([
      ['name' => 'Best Available Rate', 'default_rate' => isset($apartment) ? $apartment->price : old('room_price', 100), 'meal_type' => 'room_only', 'is_default' => true],
      ['name' => 'Bed & Breakfast Rate', 'default_rate' => 120, 'meal_type' => 'bed_and_breakfast', 'is_default' => false],
   ]);

   $plans = $savedPlans->isNotEmpty() ? $savedPlans : $defaultPlans;
@endphp

<div class="col-md-12" style="margin-top: 25px;">
   <h4>Channex Rate Plans</h4>
   <p class="text-muted">Each plan is created under this room type. The selected default plan always uses the apartment's Price per/night; other plans use the rates entered below.</p>

   <div class="table-responsive">
      <table class="table table-striped">
         <thead>
            <tr>
               <th>Default</th>
               <th>Plan name</th>
               <th>Default rate (USD)</th>
               <th>Meal type</th>
               <th>Channex ID</th>
            </tr>
         </thead>
         <tbody>
            @for($i = 0; $i < max(4, $plans->count()); $i++)
               @php $plan = $plans->get($i); @endphp
               <tr>
                  <td>
                     <input type="radio" name="rate_plan_default" value="{{ $i }}"
                        {{ ($plan && data_get($plan, 'is_default')) || (!$plan && $i === 0) ? 'checked' : '' }}>
                  </td>
                  <td>
                     <input type="hidden" name="rate_plans[{{ $i }}][id]" value="{{ data_get($plan, 'id') }}">
                     <input type="text" name="rate_plans[{{ $i }}][name]" class="form-control"
                        value="{{ old('rate_plans.'.$i.'.name', data_get($plan, 'name')) }}"
                        placeholder="e.g. Best Available Rate">
                  </td>
                  <td>
                     <input type="number" min="0" step="0.01" name="rate_plans[{{ $i }}][default_rate]" class="form-control"
                        value="{{ old('rate_plans.'.$i.'.default_rate', data_get($plan, 'default_rate')) }}">
                  </td>
                  <td>
                     @php $mealType = old('rate_plans.'.$i.'.meal_type', data_get($plan, 'meal_type', 'room_only')); @endphp
                     <select name="rate_plans[{{ $i }}][meal_type]" class="form-control">
                        <option value="room_only" {{ $mealType === 'room_only' ? 'selected' : '' }}>Room only</option>
                        <option value="bed_and_breakfast" {{ $mealType === 'bed_and_breakfast' ? 'selected' : '' }}>Bed & breakfast</option>
                        <option value="breakfast" {{ $mealType === 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                        <option value="none" {{ $mealType === 'none' ? 'selected' : '' }}>None</option>
                     </select>
                  </td>
                  <td><small>{{ data_get($plan, 'channex_rate_plan_id') ?: 'Not synced' }}</small></td>
               </tr>
            @endfor
         </tbody>
      </table>
   </div>
</div>
