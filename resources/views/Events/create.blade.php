@extends("Layouts.base")
@include('Layouts.header')

@section('content')
    <div class="w-[70%] h-[50%] bg-white rounded shadow-xl my-[5rem] container mx-auto">
        <div class="flex items-center justify-between border-b-2 p-2">
            <h1 class="text-3xl">Post Event</h1>
            <a href="{{ route('events.index') }}" class="text-blue-400">< back</a>
        </div>

        <form action="{{ route('events.store') }}" class="flex flex-col justify-center p-5" method="POST">
            @csrf
            <label for="email">Event Name</label>
            <input type="text" required name="event_name" placeholder="example" class="border p-2 my-2">
            @error('event_name')
                <p class="text-md text-red-500">{{ $message }}</p>
            @enderror
            <label for="title">Title</label>
            <input type="text" required name="title" placeholder="Enter title...." class="border p-2 my-2">
            @error('title')
                <p class="text-md text-red-500">{{ $message }}</p>
            @enderror

            <label for="description">Description</label>
            <textarea type="text" required name="description" class="border p-2 my-2">Enter description</textarea>
            @error('description')
                <p class="text-md text-red-500">{{ $message }}</p>
            @enderror
            <label for="start date">Startiing Time</label>
            <input type="datetime-local" required name="start_time" class="border p-2 my-2">
            @error('start_time')
                <p class="text-md text-red-500">{{ $message }}</p>
            @enderror
            <label for="end date">Ending Time</label>
            <input type="datetime-local" required name="end_time" placeholder="" class="border p-2 my-2">
            @error('end_time')
                <p class="text-md text-red-500">{{ $message }}</p>
            @enderror
            <button type="submit" class="bg-green-100 p-2 my-2 transition-all hover:bg-green-50">Post now</button>


        </form>
    </div>
@endsection
