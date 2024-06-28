@extends("Layouts.base")

{{-- @section('title', 'Dashboard') --}}

@section('content')
    <div class="flex items-center justify-end my-4">
        <a href="{{ route('events.create') }}" class="text-sm font-normal bg-green-400 hover:bg-green-300 transition-all p-2 rounded cursor-pointer">Create Event</a>
    </div>
    @if( $events )
    @foreach ($events as $event)
    <div class="bg-slate-100 border-1 rounded p-5 my-5">
        <h1>{{ $event->title }}</h1>
        <p>{{ $event->description }}</p>
        @if ($event->followers->contains('user_id', auth()->id()))
            <form action="{{ route('unfollow', $event->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-300 p-2 rounded shadow-md my-3">Unfollow</button>
            </form>
        @else
            <form action="{{ route('follow', $event->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-300 p-2 rounded shadow-md my-3">Follow</button>
            </form>
        @endif
        
        
    </div>
    @endforeach
    
    @else
    <div class="bg-white border-1 rounded p-5 my-5">
        No Events found!
    </div>
    @endif

@endsection
