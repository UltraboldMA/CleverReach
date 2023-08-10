<?php

namespace App\Actions\CleverReach;

use App\Traits\CleverReachToken;
use App\Models\CleverReachClient;
use Illuminate\Support\Facades\Http;
use App\Models\CleverReachSubscriber;

class GetSubscribers
{
    use CleverReachToken;

    public function handle(CleverReachClient $cleverReachClient, int $groupId, array $params = []): array
    {
        $this->tokenValid($cleverReachClient);

        $url = config('clever-reach.baseUrl') . '/groups.json/' . $groupId . '/receivers?' . http_build_query($params);

        $jsonSubscribers = Http::acceptJson()
            ->withToken($cleverReachClient->token)
            ->get($url)->json();
        //dd($jsonSubscribers);
        $subscribers = [];

        foreach ($jsonSubscribers as $subscriber) {
            $subscribers[] = new CleverReachSubscriber($subscriber);
        }

        return $subscribers;
    }
}
