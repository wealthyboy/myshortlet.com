<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannexCertificationLog extends Model
{
    protected $fillable = [
        'source',
        'scenario',
        'property_id',
        'apartment_id',
        'task_ids',
        'request_payload',
        'response_payload',
        'status',
        'notes',
    ];

    protected $casts = [
        'task_ids' => 'array',
    ];

    public function getRequestPayloadAttribute($value): array
    {
        return $this->decodePayload($value);
    }

    public function setRequestPayloadAttribute($value): void
    {
        $this->attributes['request_payload'] = $value === null
            ? null
            : json_encode($this->decodePayload($value));
    }

    public function getResponsePayloadAttribute($value): array
    {
        return $this->decodePayload($value);
    }

    public function setResponsePayloadAttribute($value): void
    {
        $this->attributes['response_payload'] = $value === null
            ? null
            : json_encode($this->decodePayload($value));
    }

    protected function decodePayload($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        $decoded = json_decode($value, true);

        // Historical records were JSON encoded before being assigned to an
        // Eloquent JSON cast. Decode the second layer so those logs remain useful.
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }

        return is_array($decoded) ? $decoded : [];
    }
}
