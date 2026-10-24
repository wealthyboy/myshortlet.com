<?php

namespace App\Services\ChannexPro;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyDistributionProfile
{
    public function apply(Property $property, Request $request): void
    {
        if (! $request->exists('distribution_profile')) {
            return; // Legacy forms must not erase a previously saved profile.
        }
        $rules = [
            'email' => 'nullable|email|max:255', 'phone' => 'nullable|string|max:32',
            'country_code' => 'nullable|alpha|size:2', 'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255', 'zip_code' => 'nullable|string|max:32',
            'website' => 'nullable|url|regex:/^https?:\/\//i|max:255',
            'timezone' => 'nullable|timezone', 'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180', 'important_information' => 'nullable|string|max:5000',
        ];
        $validation = ['distribution_profile' => 'nullable|array'];
        foreach ($rules as $field => $rule) {
            $validation['distribution_profile.'.$field] = $rule;
        }
        $data = $request->validate($validation);
        $profile = (array) ($property->distribution_profile ?? []);
        foreach (array_keys($rules) as $field) {
            if (array_key_exists($field, $data['distribution_profile'] ?? [])) {
                $value = $data['distribution_profile'][$field];
                $profile[$field] = is_string($value) ? (trim($value) === '' ? null : trim($value)) : $value;
            }
        }
        if (! empty($profile['country_code'])) {
            $profile['country_code'] = strtoupper($profile['country_code']);
        }
        $property->distribution_profile = $profile;
    }
}
