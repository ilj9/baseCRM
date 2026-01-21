<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\User;

new class extends Component {
    use Livewire\WithPagination;

    public array $sortableFields = [];
    public string $sortBy = 'name';
    public string $sortDirection = 'asc';

    public function mount()
    {
        $this->sortableFields = [
            'name' => 'Name',
            'email' => 'Email Address',
            'roles.name' => 'Role'
        ];
    }

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function users()
    {
        $query = User::query()
            ->select('users.*', 'roles.name as role')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id', 'inner')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id', 'inner')
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(10);
    }
};
?>

<div>
    <div class="flex flex-col gap-4">
        <div
            class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-400">
                <thead class="bg-zinc-50 text-zinc-900 dark:bg-zinc-800/50 dark:text-zinc-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold">#ID</th>

                        @foreach($this->sortableFields as $field => $label)
                            <th class="px-4 py-3 font-semibold cursor-pointer hover:text-zinc-500 transition-colors"
                                wire:click="sort('{{ $field }}')">
                                <div class="flex items-center gap-2">
                                    {{ $label }}
                                    @if($this->sortBy === $field)
                                        <span>{!! $this->sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                                    @endif
                                </div>
                            </th>
                        @endforeach

                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @foreach ($this->users as $user)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition-colors"
                            wire:key="{{ $user->id }}">
                            <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">{{ $user->id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex items-center rounded-md bg-zinc-100 px-2 py-1 text-xs font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                    {{ $user->roles->first()->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <flux:dropdown>
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />

                                    <flux:menu>
                                        <flux:menu.item variant="default" icon="pencil-square">Edit</flux:menu.item>
                                        <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $this->users->links() }}
        </div>
    </div>
</div>