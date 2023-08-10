<?php

namespace App\Http\Livewire\CleverReach;

use Livewire\Component;
use App\Models\CleverReachClient;
use App\Actions\CleverReach\GetForms;
use App\Models\CleverReachForm;

class CleverReachForms extends Component
{
    public $forms = [];
    public $selectedClient;
    public $clients;

    protected $queryString = [
        'selectedClient' => ['except' => '']
    ];

    public function mount()
    {
        if ($this->selectedClient) {
            $this->loadForms();
        }
        if (config('clever-reach.singleClient')) {
            $this->selectedClient = CleverReachClient::first()?->id;
        } else {
            $this->clients = CleverReachClient::all();
        }
    }

    public function render()
    {
        $this->forms = CleverReachForm::all();
        return view('livewire.clever-reach-forms');
    }

    public function refreshForms(GetForms $getForms)
    {
        //dd(is_numeric($this->selectedClient));
        if (!is_numeric($this->selectedClient)) {
            $this->reset('forms');
            return;
        }

        $client = CleverReachClient::find($this->selectedClient);
        $this->forms = $getForms->handle($client);
    }

    public function loadForms()
    {
        $this->forms = CleverReachForm::where('clever_reach_client_id', $this->selectedClient)->get();
    }
}
