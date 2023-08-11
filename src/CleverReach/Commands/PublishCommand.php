<?php

namespace UltraboldMA\CleverReach\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'clever-reach:publish';

    protected $description = 'Publish CleverReach boiler plate files';

    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'clever-reach-config']);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-migrations']);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-models']);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-routes']);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-actions']);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-livewire']);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-views']);
    }
}
