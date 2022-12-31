<br>
<x-layout>
    @include('partials._hero')
    @include('partials._search')

    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @forelse ($listings as $listing)
            @if (($listing->user->id == auth()->id()) || !auth()->check())
                <x-listing-card :listing="$listing" />
            @endif
        @empty
            <p>No listings found</p>
        @endforelse

    </div>
    {{-- {{ dd(session()->all()) }} --}}
    <div class="mt-6 p-4">
        {{ $listings->links() }}
    </div>
</x-layout>
