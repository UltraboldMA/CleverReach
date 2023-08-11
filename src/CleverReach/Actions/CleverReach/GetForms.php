<?php

namespace App\Actions\CleverReach;

use App\Models\CleverReachForm;
use App\Models\CleverReachClient;
use Illuminate\Support\Facades\Http;
use UltraboldMA\CleverReach\Traits\CleverReachToken;

class GetForms
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

        $jsonForms = Http::acceptJson()
            ->withToken($cleverReachClient->token)
            ->get(config('clever-reach.baseUrl') . '/forms.json')->json();

        $forms = [];
        foreach ($jsonForms as $form) {
            $form['external_id'] = $form['id'];
            $form['clever_reach_client_id'] = $cleverReachClient->id;
            unset($form['id']);
            $forms[] = CleverReachForm::updateOrCreate(['external_id' => $form['external_id']], $form);
        }
        return $forms;
    }
}
