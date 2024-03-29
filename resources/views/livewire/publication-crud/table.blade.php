<div>
    <table class="table table-auto border-2 w-full bg-gray-100">
        <thead class="font-bold">
            <tr>
                <td class="border px-4 py-2">
                    Id
                </td>
                <td class="border px-4 py-2">
                    Title / Abstract
                </td>
                <td class="border px-4 py-2">
                    Updated at
                </td>
                <td class="border px-4 py-2">
                    Actions
                </td>
            </tr>
        </thead>
        <tbody>
            @forelse($publications as $publication)
            <tr>
                <td class="border px-4 py-2">{{ $publication->id }}</td>
                <td class="border px-4 py-2 text-justify">
                    <b>{{ $publication->title }}</b> <br>
                    {{ $publication->excerpt }}
                    @if($publication->comments()->where('state', 'PENDING')->count() !=0 )
                    <br> New comments: {{$publication->comments()->where('state', 'PENDING')->count()}}
                    @endif
                </td>
                <td class="border px-4 py-2">{{ $publication->updated_at->diffForHumans() }}</td>
                <td class=" border px-4 py-2">
                    <a href="{{ route('user.publication.show', ['user' => auth()->id(), 'id' => $publication->id]) }}" class="text-gray-700 underline">
                        See more
                    </a> <br>
                    <x-jet-button class="mb-1" wire:click="edit({{ $publication->id }})">
                        Edit
                    </x-jet-button> <br>
                    <!-- TODO: Implement better confirmation message -->
                    <x-jet-danger-button onclick="confirm('Are you sure to delete this publication {{ $publication->id }} with {{ $publication->comments->count() }} comments?') || event.stopImmediatePropagation()" wire:click="destroy({{ $publication->id }})">
                        Delete
                    </x-jet-danger-button>
                </td>
            </tr>
            @empty
            <tr>
                <td class="border px-4 py-2 text-center text-red-500" colspan="4">There are not publications</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $publications->render() }}
</div>
