<?php

namespace App\Http\Livewire\CleverReach;

use Exception;
use Livewire\Component;
use Illuminate\Support\Arr;
use App\Models\CleverReachGroup;
use App\Models\CleverReachNewsletter;
use App\Actions\CleverReach\GetSubscribers;
use App\Actions\CleverReach\DeleteSubscriber;

class CleverReachSubscribers extends Component
{

    public $selectedNewsletter, $selectedGroup;
    public $availableNewsletters, $availableGroups;
    public $subscribers = [];
    public $currentSubscriber;
    public $page = 0;
    public $pageSize = 25;
    public $showConfirm = false;

    protected $queryString = [
        'selectedNewsletter' => ['except' => ''],
        'selectedGroup' => ['except' => ''],
        'page' => ['except' => 0]
    ];

    public function mount()
    {
        $this->availableNewsletters = CleverReachNewsletter::with('clever_reach_client', 'clever_reach_group')->get();
        $this->availableGroups = CleverReachGroup::with('clever_reach_client')->get();
        if ($this->selectedGroup || $this->selectedNewsletter) {
            $this->loadSubscribers();
        }
    }

    public function render()
    {
        return view('livewire.clever-reach.clever-reach-subscribers');
    }

    public function loadSubscribers()
    {
        if ($this->selectedNewsletter) {
            $selectedNewsletter = $this->availableNewsletters->where('key', $this->selectedNewsletter)->first();
            $client = $selectedNewsletter->clever_reach_client;
            $groupId = $selectedNewsletter->clever_reach_group->external_id;
        }
        if ($this->selectedGroup) {
            $group = $this->availableGroups->where('external_id', $this->selectedGroup)->first();
            $client = $group->clever_reach_client;
            $groupId = $this->selectedGroup;
        }

        $subscriberRequest = new GetSubscribers();
        $this->subscribers = $subscriberRequest->handle($client, $groupId, [
            'page' => $this->page,
            'pagesize' => $this->pageSize
        ]);
    }

    public function updatedSelectedGroup()
    {
        $this->reset('selectedNewsletter', 'subscribers', 'page');
    }

    public function updatedSelectedNewsletter()
    {
        $this->reset('selectedGroup', 'subscribers', 'page');
    }

    public function nextPage()
    {
        $this->page++;
        $this->loadSubscribers();
    }

    public function previousPage()
    {
        $this->page--;
        $this->loadSubscribers();
    }

    public function showSubscriber(int $subscriberIndex)
    {
        $this->currentSubscriber = $this->subscribers[$subscriberIndex];
    }

    public function closeSubscriber()
    {
        $this->reset('currentSubscriber');
    }

    public function deleteConfirmSubscriber(int $subscriberIndex)
    {
        $this->currentSubscriber = $this->subscribers[$subscriberIndex];
        $this->showConfirm = true;
    }

    public function deleteSubscriber()
    {
        //Get client
        if ($this->selectedNewsletter) {
            $selectedNewsletter = $this->availableNewsletters->where('key', $this->selectedNewsletter)->first();
            $client = $selectedNewsletter->clever_reach_client;
        }
        if ($this->selectedGroup) {
            $group = $this->availableGroups->where('external_id', $this->selectedGroup)->first();
            $client = $group->clever_reach_client;
        }
        //Delete subscriber
        try {
            $deleteRequest = new DeleteSubscriber;
            $deleteRequest->handle($client, Arr::get($this->currentSubscriber, 'id'));
            //Refresh list
            $this->loadSubscribers();
            //Reset
            $this->reset('showConfirm', 'currentSubscriber');
            //success message
            session()->flash('message', __('Subscriber deleted successfully'));
        } catch (Exception $ex) {
            session()->flash('error', $ex->getMessage());
            //Reset
            $this->reset('showConfirm', 'currentSubscriber');
        }
    }

    public function cancel()
    {
        $this->reset('showConfirm', 'currentSubscriber');
    }
}
