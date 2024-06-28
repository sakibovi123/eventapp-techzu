@extends("Layouts.base")

@section('content')
    <div class="w-[30%] h-[50%] bg-white rounded shadow-xl my-[5rem] container mx-auto">
        <h1 class="text-3xl border-b-2 p-3">Sign in</h1>
        <form action="{{ route('login.post') }}" class="flex flex-col justify-center p-5" method="POST">
            @csrf
            <label for="email">Email</label>
            <input type="email" required name="email" placeholder="example@gmail.com" class="border p-2 my-2">
            @error('email')
                <p class="text-md text-red-500">{{ $message }}</p>
            @enderror
            <label for="password">Password</label>
            <input type="password" required name="password" placeholder="********" class="border p-2 my-2">
            @error('password')
                <p class="text-md text-red-500">{{ $message }}</p>
            @enderror
            <button type="submit" class="bg-green-100 p-2 my-2">Sign in</button>
            <small>Don't have an account <a href="" class="text-blue-500 my-2">Sign up</a></small>
            
        </form>
    </div>
@endsection