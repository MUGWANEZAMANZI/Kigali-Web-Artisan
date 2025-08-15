<div class="fixed bottom-8 right-8 z-50">
    <button class="flex items-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-200" wire:click="toggleForm">
        <!-- Chat Icon SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 10.5h.008v.008H7.5V10.5zm3.75 0h.008v.008h-.008V10.5zm3.75 0h.008v.008h-.008V10.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 0 1-4.2-.9l-4.3 1.3 1.3-4.3A8.96 8.96 0 0 1 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        Talk to us
    </button>

    <!-- Modal Overlay and Centered Form -->
    <div class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-1 backdrop-blur-sm transition-opacity duration-300 {{ $showForm ? '' : 'hidden' }} z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md relative animate-fadeIn">
            <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-700" wire:click="toggleForm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-2xl font-bold mb-4 text-center text-blue-700">Talk to Us</h2>
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded">
                    <ul class="list-disc list-inside text-left">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (strlen($email_received) > 5)
                <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">
                    <p class="text-black">{{ $email_received }}</p>
                </div>
            @endif
            <form class="flex flex-col gap-4" wire:submit.prevent="submitForm">
                <div>
                    <input type="text" wire:model="name" placeholder="Your Name" class="border rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input type="text" wire:model="phone" placeholder="Your Phone" class="border rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    @error('phone')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input type="email" wire:model="email" placeholder="Your Email" class="border rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input type="text" wire:model="company" placeholder="Your Company" class="border rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    @error('company')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <textarea wire:model="message" placeholder="Your Message" class="border rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none" rows="4"></textarea>
                    @error('message')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" wire:click="submitForm" class="bg-blue-600 text-white rounded-lg px-4 py-2 font-semibold hover:bg-blue-700 transition">Send</button>
            </form>
        </div>
    </div>
</div>
