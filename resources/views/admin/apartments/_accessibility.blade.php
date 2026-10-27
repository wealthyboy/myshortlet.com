@php($elevatorAccess = old('elevator_access', $apartment->elevator_access ?? ''))
<div class="col-md-3">
    <div class="form-group">
        <label class="control-label" for="elevator-access">Accessibility — elevator access</label>
        <select name="elevator_access" id="elevator-access" class="form-control" aria-describedby="elevator-access-help">
            <option value="" {{ $elevatorAccess === '' || $elevatorAccess === null ? 'selected' : '' }}>Not specified</option>
            <option value="1" {{ (string) $elevatorAccess === '1' ? 'selected' : '' }}>Elevator access</option>
            <option value="0" {{ $elevatorAccess === false || (string) $elevatorAccess === '0' ? 'selected' : '' }}>No elevator access</option>
        </select>
        <small id="elevator-access-help" class="text-muted">Does an elevator serve this apartment's floor? This does not confirm wheelchair accessibility.</small>
        @error('elevator_access')
            <div class="text-danger" role="alert">{{ $message }}</div>
        @enderror
    </div>
</div>
