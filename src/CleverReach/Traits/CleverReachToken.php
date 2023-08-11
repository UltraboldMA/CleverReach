<?php

namespace UltraboldMA\CleverReach\Traits;

use App\Models\CleverReachClient;
use App\Actions\CleverReach\RequestToken;

trait CleverReachToken
{
    public function tokenValid(CleverReachClient $cleverReachClient): void
    {
        if ($cleverReachClient->token_expiration < now()) {
            $this->requestToken($cleverReachClient);
        }
    }

    public function requestToken(CleverReachClient $cleverReachClient): void
    {
        $tokenRequest = new RequestToken;
        $tokenRequest->handle($cleverReachClient);
    }
}
