<x-layouts::app :title="__('Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-6 w-full">
            <div class="flex">
                <div class="flex flex-col">
                    <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
                    <flux:subheading size="lg" class="mb-6">{{ __('Manage users') }}</flux:subheading>
                </div>
                <div class="flex my-auto ms-auto gap-2">
                    <flux:button href="{{ route('dashboard') }}" variant="subtle" class="my-auto ms-auto" wire:navigate>
                        Show Deleted Users</flux:button>
                    <flux:button href="{{ route('dashboard') }}" class="my-auto ms-auto" variant="primary"
                        wire:navigate>New</flux:button>
                </div>
            </div>
            <flux:separator variant="subtle" />
        </div>

        <div class="w-full">
            <livewire:users-table />
        </div>
    </div>
</x-layouts::app>