<?php

namespace App\Http\Livewire\CleverReach;

use App\Models\CleverReachClient;
use Livewire\Component;
use App\Models\CleverReachForm;
use App\Models\CleverReachGroup;
use App\Models\CleverReachNewsletter;

class CleverReachNewsletters extends Component
{
    public $editId;
    public $showForm = false;
    public CleverReachNewsletter $cleverReachNewsletter;
    public $attributes = [];
    public $globalAttributes = [];

    protected $queryString = [
        'editId' => ['except' => ''],
        'showForm' => ['except' => false]
    ];

    protected $rules = [
        'cleverReachNewsletter.name' => 'required|min:3',
        'cleverReachNewsletter.clever_reach_client_id' => 'required',
        'cleverReachNewsletter.key' => 'required',
        'cleverReachNewsletter.form_id' => 'required',
        'cleverReachNewsletter.group_id' => 'required',
        'cleverReachNewsletter.language' => 'required',
        'cleverReachNewsletter.double_opt_in' => 'required',
    ];

    public function mount()
    {
        if ($this->editId) {
            $this->showForm = true;
            $this->cleverReachNewsletter = CleverReachNewsletter::find($this->editId);
        } elseif ($this->showForm) {
            $this->cleverReachNewsletter = new CleverReachNewsletter;
            $this->cleverReachNewsletter->double_opt_in = true;
            $this->cleverReachNewsletter->key = uniqid();
            $this->cleverReachNewsletter->clever_reach_client_id = CleverReachClient::first()?->id;
        }
    }

    public function render()
    {
        return view('livewire.clever-reach.clever-reach-newsletters')->with([
            'newsletters' => CleverReachNewsletter::all(),
            'groups' => CleverReachGroup::with('clever_reach_client')->get(),
            'forms' => CleverReachForm::with('clever_reach_client')->get(),
            'clients' => CleverReachClient::all(),
        ]);
    }

    public function create()
    {
        $this->showForm = true;
        $this->cleverReachNewsletter = new CleverReachNewsletter;
        $this->cleverReachNewsletter->double_opt_in = true;
        $this->cleverReachNewsletter->key = uniqid();
        $this->cleverReachNewsletter->clever_reach_client_id = CleverReachClient::first()?->id;
    }

    public function edit(CleverReachNewsletter $cleverReachNewsletter)
    {
        $this->editId = $cleverReachNewsletter->id;
        $this->showForm = true;
        $this->cleverReachNewsletter = $cleverReachNewsletter;
        //dd($this->cleverReachNewsletter->toArray());
        $this->attributes = $cleverReachNewsletter->cl_attributes ?? [];
        $this->globalAttributes = $cleverReachNewsletter->cl_global_attributes ?? [];
    }

    public function save()
    {
        $this->validate();

        $this->cleverReachNewsletter->cl_attributes = $this->attributes;
        $this->cleverReachNewsletter->cl_global_attributes = $this->globalAttributes;

        $this->cleverReachNewsletter->save();

        $this->resetExcept('cleverReachNewsletter');
    }

    public function cancel()
    {
        $this->resetExcept('cleverReachNewsletter');
    }

    public function delete(CleverReachNewsletter $cleverReachNewsletter)
    {
        $cleverReachNewsletter->delete();
    }

    public function addGlobalAttribute()
    {
        $this->globalAttributes[] = '';
    }

    public function deleteGlobalAttribute($attribute_index)
    {
        unset($this->globalAttributes[$attribute_index]);
    }

    public function addAttribute()
    {
        $this->attributes[] = '';
    }

    public function deleteAttribute($attribute_index)
    {
        unset($this->attributes[$attribute_index]);
    }
}
