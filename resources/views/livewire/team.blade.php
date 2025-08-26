@extends('components.layouts.app')

    @section('content')

<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="mb-10">
        <h2 class="text-4xl font-extrabold mb-3 text-center text-blue-800 tracking-tight">Our Team</h2>
        <p class="text-lg text-gray-600 text-center">Meet the talented individuals behind our success.</p>
    </div>
    <div class="flex flex-col md:flex-row gap-8 justify-center items-stretch">
        <!-- Team Member 1 -->
        <div class="flex flex-col items-center bg-white rounded-2xl shadow-lg p-8 w-full md:w-1/2 hover:shadow-2xl transition">
            <img src="{{ asset('team/manzi.jpg') }}" alt="MUGWANEZA MANZI Audace" class="w-32 h-32 rounded-full mb-4 border-4 border-blue-200 shadow">
            <h3 class="text-2xl font-bold text-blue-700 mb-1">MUGWANEZA MANZI Audace</h3>
            <p class="text-gray-500 mb-2">Managing Director</p>
            <div class="flex flex-col items-center text-gray-700 text-sm mb-2">
                <span class="flex items-center gap-1"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.48 19h9.04a2 2 0 0 0 1.83-2.3L17 13M7 13V6a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v7"/></svg>250787652137</span>
                <span class="flex items-center gap-1"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0a4 4 0 1 0-8 0 4 4 0 0 0 8 0zm-8 0v1a4 4 0 0 0 8 0v-1"/></svg>mmaudace@gmail.com</span>
            </div>
        </div>
        <!-- Team Member 2 -->
        <div class="flex flex-col items-center bg-white rounded-2xl shadow-lg p-8 w-full md:w-1/2 hover:shadow-2xl transition">
            <img src="{{ asset('team/liliane.jpg') }}" alt="MNEZERO Liliane" class="w-32 h-32 rounded-full mb-4 border-4 border-blue-200 shadow">
            <h3 class="text-2xl font-bold text-blue-700 mb-1">MNEZERO Liliane</h3>
            <p class="text-gray-500 mb-2">Marketing Executive</p>
            <div class="flex flex-col items-center text-gray-700 text-sm mb-2">
                <span class="flex items-center gap-1"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 0 0 7.48 19h9.04a2 2 0 0 0 1.83-2.3L17 13M7 13V6a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v7"/></svg>250788706386</span>
                <span class="flex items-center gap-1"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0a4 4 0 1 0-8 0 4 4 0 0 0 8 0zm-8 0v1a4 4 0 0 0 8 0v-1"/></svg>lilianemuneza8@gmail.com</span>
            </div>
        </div>
    </div>
</div>

@endsection