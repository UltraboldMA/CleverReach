<?php

namespace App\Actions\CleverReach;

use App\Traits\CleverReachToken;
use App\Models\CleverReachClient;
use Illuminate\Support\Facades\Http;
use App\Models\CleverReachSubscriber;

class ShowSubscriber
{
    use CleverReachToken;

    public function handle(CleverReachClient $cleverReachClient, int $subscriberId): array
    {
        $this->tokenValid($cleverReachClient);

        $url = config('clever-reach.baseUrl') . '/receivers.json/' . $subscriberId;

        return  Http::acceptJson()
            ->withToken($cleverReachClient->token)
            ->get($url)->json();
    }
}
