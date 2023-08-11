<?php

namespace App\Actions\CleverReach;

use Exception;
use Illuminate\Support\Arr;
use App\Models\CleverReachClient;
use Illuminate\Support\Facades\Http;
use UltraboldMA\CleverReach\Traits\CleverReachToken;

class DeleteSubscriber
{
    use CleverReachToken;

    public function handle(CleverReachClient $cleverReachClient, int $subscriberId): bool
    {
        $this->tokenValid($cleverReachClient);

        $url = config('clever-reach.baseUrl') . '/receivers.json/' . $subscriberId;

        $response = Http::acceptJson()
            ->withToken($cleverReachClient->token)
            ->delete($url);
        if ($response->status() !== 200) {
            throw new Exception(Arr::get($response->json(), 'error.message'));
        }
        return $response->json();
    }
}
