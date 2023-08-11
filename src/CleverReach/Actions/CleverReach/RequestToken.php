<?php

namespace App\Actions\CleverReach;

use Illuminate\Support\Arr;
use App\Models\CleverReachClient;
use Illuminate\Support\Facades\Http;

class RequestToken
{
    /**
     * Request new token
     *
     * @param  mixed  $user
     * @return void
     */
    public function handle(CleverReachClient $cleverReachClient): void
    {
        $response = Http::acceptJson()
            ->withBasicAuth($cleverReachClient->client_id, $cleverReachClient->client_secret)
            ->post('https://rest.cleverreach.com/oauth/token.php', [
                'grant_type' => 'client_credentials'
            ])->json();
        $cleverReachClient->token = Arr::get($response, 'access_token');
        $cleverReachClient->token_expiration = now()->addSeconds(Arr::get($response, 'expires_in'));
        $cleverReachClient->save();
    }
}
