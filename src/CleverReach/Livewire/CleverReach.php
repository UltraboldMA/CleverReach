<?php

namespace App\Http\Livewire\CleverReach;

use App\Actions\CleverReach\RequestToken;
use App\Models\CleverReachClient;
use Exception;
use Livewire\Component;

class CleverReach extends Component
{
    public CleverReachClient $client;
    public $showForm = false;
    public $showConfirm = false;
    public $editId;

    protected $queryString = [
        'showForm' => ['except' => false],
        'editId' => ['except' => '']
    ];

    protected function rules()
    {
        return [
            'client.name' => 'required',
            'client.client_id' => 'required|unique:clever_reach_clients,client_id,' . $this->client->id,
            'client.client_secret' => 'required',
        ];
    }

    public function mount()
    {
        if ($this->editId) {
            $this->showForm = true;
            $this->client = CleverReachClient::find($this->editId);
        } else {
            $this->client = new CleverReachClient;
        }
    }

    public function render()
    {
        return view('livewire.clever-reach')->with([
            'cleverReachClients' => CleverReachClient::withCount('clever_reach_newsletters')->get()
        ]);
    }

    public function createClient()
    {
        $this->resetErrorBag();
        $this->showForm = true;
        $this->client = new CleverReachClient;
    }

    public function saveClient()
    {
        $this->validate();

        $this->client->save();

        $this->resetExcept('client');
    }

    public function editClient(CleverReachClient $cleverReachClient)
    {
        $this->resetErrorBag();

        $this->client = $cleverReachClient;

        $this->editId = $cleverReachClient->id;

        $this->showForm = true;
    }

    public function updateClient()
    {
        $this->validate();

        $this->client->save();

        $this->resetExcept('client');
    }

    public function deleteConfirmClient(CleverReachClient $cleverReachClient)
    {
        $this->client = $cleverReachClient;

        $this->showConfirm = true;
    }

    public function deleteClient()
    {
        $this->client->delete();

        $this->resetExcept('client');
    }

    public function cancel()
    {
        $this->resetExcept('client');
    }

    public function refreshToken(CleverReachClient $cleverReachClient)
    {
        try {
            $request = new RequestToken();

            $request->handle($cleverReachClient);

            session()->flash('message', 'Token wurde aktualisiert.');
        } catch (Exception $ex) {
            session()->flash('error', 'Token wurde nicht aktualisiert.');
        }
    }
}
