@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Hindura ijambo ry'ibanga</h2>
    @if (session('status'))
        <div class="mb-4 text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ request('token') }}">
        <div class="mb-4">
            <label for="email" class="block mb-1">Imeli</label>
            <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus class="w-full border rounded px-3 py-2">
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-1">Ijambo ry'ibanga rishya</label>
            <input id="password" type="password" name="password" required class="w-full border rounded px-3 py-2">
            @error('password')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block mb-1">Subiramo ijambo ry'ibanga rishya</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Hindura</button>
    </form>
</div>
@endsection

