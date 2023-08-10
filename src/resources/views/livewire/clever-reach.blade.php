<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('CleverReach') }}

        </h2>
    </x-slot>
    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="p-5 overflow-hidden bg-white shadow-xl sm:rounded-lg">
            @if (!$showForm)
                @if (session()->has('message'))
                    <div class="px-2 py-1 my-5 text-white bg-green-600 rounded">{{ session()->get('message') }}</div>
                @elseif(session()->has('error'))
                    <div class="px-2 py-1 my-5 text-white bg-red-600 rounded">{{ session()->get('error') }}</div>
                @endif
                @if ($cleverReachClients->isEmpty() && config('clever-reach.singleClient'))
                    <button type="button" class="float-right" wire:click="createClient">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                @endif
                <table class="w-full">
                    <thead>
                        <th class="py-1 text-left">Name</th>
                        <th class="py-1 text-left">Client ID</th>
                        <th class="py-1 text-left">Newsletters</th>
                        <th class="py-1 text-left">Token Expires</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($cleverReachClients as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->client_id }}</td>
                                <td>{{ $client->clever_reach_newsletters_count }}</td>
                                <td>{{ $client->tokenValid }}</td>
                                <td class="text-right">
                                    <x-button-success type="button" wire:click="refreshToken({{ $client->id }})">
                                        <div wire:loading.remove>Token</div>
                                        <div wire:loading>Loading</div>
                                    </x-button-success>
                                    <x-jet-button type="button" wire:click="editClient({{ $client->id }})">Edit</x-jet-button>
                                    <x-jet-danger-button type="button" wire:click="deleteConfirmClient({{ $client->id }})">Delete</x-jet-danger-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <!-- create/edit client -->
            @if ($showForm)
                <div class="grid grid-cols-12 gap-4 py-5">
                    <div class="col-span-12 py-2 sm:col-span-6">
                        <x-jet-label for="client.name" value="{{ __('Name') }}" />
                        <x-jet-input id="client.name" type="text" class="block w-full mt-1" wire:model.defer="client.name" autofocus />
                        <x-jet-input-error for="client.name" class="mt-2" />
                    </div>
                    <div class="col-span-12 py-2 sm:col-span-6">
                        <x-jet-label for="client.client_id" value="{{ __('Client ID') }}" />
                        <x-jet-input id="client.client_id" type="text" class="block w-full mt-1" wire:model.defer="client.client_id" />
                        <x-jet-input-error for="client.client_id" class="mt-2" />
                    </div>
                    <div class="col-span-12 py-2">
                        <x-jet-label for="client.client_secret" value="{{ __('Secret') }}" />
                        <x-jet-input id="client.client_secret" type="text" class="block w-full mt-1" wire:model.defer="client.client_secret" />
                        <x-jet-input-error for="client.client_secret" class="mt-2" />
                    </div>
                    <div class="col-span-6 col-start-1 text-left">
                        <x-jet-danger-button wire:click="cancel">Cancel</x-jet-danger-button>
                    </div>
                    <div class="col-span-6 text-right">
                        <x-jet-button wire:click="saveClient">Save</x-jet-button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-jet-dialog-modal wire:model="showConfirm">
        <x-slot name="title">
            {{ __('Delete Client: ') }} {{ $client->name }}
        </x-slot>

        <x-slot name="content">
            <div>
                {{ __('Are you sure you want to delete this client.') }}
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between w-full">
                <x-jet-danger-button wire:click="cancel">
                    {{ __('Cancel') }}
                </x-jet-danger-button>
                <x-jet-button wire:click="deleteClient">
                    {{ __('Delete') }}
                </x-jet-button>
            </div>

        </x-slot>
    </x-jet-dialog-modal>
</div>
