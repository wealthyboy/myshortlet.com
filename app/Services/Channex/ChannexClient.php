<?php

namespace App\Services\Channex;

use Illuminate\Support\Facades\Http;

class ChannexClient
{
    protected function client()
    {
        return Http::withHeaders([
            // ✅ CORRECT AUTH HEADER FOR CHANNEX
            'user-api-key' => config('services.channex.key'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);
    }

    protected function get($uri, $params = [])
    {
        $url = config('services.channex.base_url') . $uri;

        $response = $this->client()->get($url, $params);

        if ($response->failed()) {
            logger()->error('CHANNEX API GET ERROR', [
                'url' => $url,
                'params' => $params,
                'status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            $response->throw();
        }

        return $response->json();
    }

    protected function post($uri, $payload = [])
    {
        $url = config('services.channex.base_url') . $uri;

        $response = $this->client()->post($url, $payload);

        if ($response->failed()) {
            logger()->error('CHANNEX API POST ERROR', [
                'url' => $url,
                'headers' => [
                    'user-api-key' => '********',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'request_body' => $payload,
                'status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            $response->throw();
        }

        return $response->json();
    }

    protected function put($uri, $payload = [])
    {
        $url = config('services.channex.base_url') . $uri;

        $response = $this->client()->put($url, $payload);

        if ($response->failed()) {
            logger()->error('CHANNEX API PUT ERROR', [
                'url' => $url,
                'request_body' => $payload,
                'status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            $response->throw();
        }

        return $response->json();
    }

    protected function delete($uri)
    {
        $url = config('services.channex.base_url') . $uri;

        $response = $this->client()->delete($url);

        if ($response->failed()) {
            logger()->error('CHANNEX API DELETE ERROR', [
                'url' => $url,
                'status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            $response->throw();
        }

        return $response->json();
    }
}
