<?php

namespace App\Actions\CleverReach;

use App\Traits\CleverReachToken;
use Illuminate\Support\Arr;
use App\Models\CleverReachClient;
use App\Models\CleverReachGroup;
use Illuminate\Support\Facades\Http;

class GetGroups
{
    use CleverReachToken;
    /**
     * Request new token
     *
     * @param  mixed  $user
     * @return void
     */
    public function handle(CleverReachClient $cleverReachClient): array
    {
        $this->tokenValid($cleverReachClient);

        $jsonGroups = Http::acceptJson()
            ->withToken($cleverReachClient->token)
            ->get(config('clever-reach.baseUrl') . '/groups.json')->json();

        $groups = [];
        foreach ($jsonGroups as $group) {
            $group['external_id'] = $group['id'];
            $group['clever_reach_client_id'] = $cleverReachClient->id;
            unset($group['id']);
            $groups[] = CleverReachGroup::updateOrCreate(['external_id' => $group['external_id']], $group);
        }
        return $groups;
    }
}
