<?php

namespace App\Http\Livewire\CleverReach;

use App\Actions\CleverReach\GetGroups;
use App\Models\CleverReachClient;
use App\Models\CleverReachGroup;
use Livewire\Component;

class CleverReachGroups extends Component
{
    public $groups = [];
    public $selectedClient;
    public $clients;

    protected $queryString = [
        'selectedClient' => ['except' => '']
    ];

    public function mount()
    {
        if ($this->selectedClient) {
            $this->loadGroups();
        }
        if (config('clever-reach.singleClient')) {
            $this->selectedClient = CleverReachClient::first()?->id;
        } else {
            $this->clients = CleverReachClient::all();
        }
    }

    public function render()
    {
        $this->groups = CleverReachGroup::all();
        return view('livewire.clever-reach.clever-reach-groups');
    }

    public function refreshGroups(GetGroups $getGroups)
    {
        if (!is_numeric($this->selectedClient)) {
            $this->reset('groups');
            return;
        }

        $client = CleverReachClient::find($this->selectedClient);
        $this->groups = $getGroups->handle($client);
    }

    public function loadGroups()
    {
        $this->groups = CleverReachGroup::where('clever_reach_client_id', $this->selectedClient)->get();
    }
}
