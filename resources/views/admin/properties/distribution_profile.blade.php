@php($channelProfile = isset($property) ? (array) ($property->distribution_profile ?? []) : [])
<div class="row" id="property-distribution-profile">
    <div class="col-md-12">
        <h4>Channel distribution details</h4>
        <p class="text-muted">Maintain these details here. ChannexPro imports them from this property's inventory feed; you do not need to enter them again there. Complete them before connecting sales channels. Your existing address and description are also exported.</p>
    </div>
    @foreach([
        'email' => ['Contact email', 'email', 255],
        'phone' => ['Contact phone', 'tel', 32],
        'country_code' => ['Country code (2-letter ISO)', 'text', 2],
        'state' => ['State / region', 'text', 255],
        'city' => ['Distribution city', 'text', 255],
        'zip_code' => ['Postal / ZIP code', 'text', 32],
        'website' => ['Property website (full URL)', 'url', 255],
        'latitude' => ['Latitude (optional)', 'text', 30],
        'longitude' => ['Longitude (optional)', 'text', 30],
    ] as $field => $definition)
        <div class="col-md-6">
            <div class="form-group">
                <label for="channel-profile-{{ $field }}">{{ $definition[0] }}</label>
                <input id="channel-profile-{{ $field }}" name="distribution_profile[{{ $field }}]" type="{{ $definition[1] }}" maxlength="{{ $definition[2] }}" class="form-control"
                    value="{{ old('distribution_profile.'.$field, array_key_exists($field, $channelProfile) ? $channelProfile[$field] : (isset($property) && in_array($field, ['state', 'city'], true) ? $property->$field : '')) }}">
                @error('distribution_profile.'.$field)<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>
    @endforeach
    <div class="col-md-6">
        <div class="form-group">
            <label for="channel-profile-timezone">Property timezone</label>
            <select id="channel-profile-timezone" name="distribution_profile[timezone]" class="form-control">
                <option value="">Select the property's timezone</option>
                @foreach(\DateTimeZone::listIdentifiers() as $zone)
                    <option value="{{ $zone }}" {{ old('distribution_profile.timezone', $channelProfile['timezone'] ?? '') === $zone ? 'selected' : '' }}>{{ $zone }}</option>
                @endforeach
            </select>
            @error('distribution_profile.timezone')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="channel-profile-information">Important guest information (optional)</label>
            <textarea id="channel-profile-information" name="distribution_profile[important_information]" class="form-control" rows="3" maxlength="5000">{{ old('distribution_profile.important_information', $channelProfile['important_information'] ?? '') }}</textarea>
            @error('distribution_profile.important_information')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
</div>
