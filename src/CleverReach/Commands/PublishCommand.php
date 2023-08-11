<?php

namespace UltraboldMA\CleverReach\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'clever-reach:publish {--force : Overwrite all previously published assets}';

    protected $description = 'Publish CleverReach boiler plate files';

    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'clever-reach-config', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-migrations', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-models', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-routes', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-actions', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-livewire', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'clever-reach-views', '--force' => $this->option('force')]);
    }
}
