<div class="flex w-full min-h-screen bg-gray-50">
	<!-- Main Chat Area -->
	<main class="flex-1 flex flex-col relative max-w-full">
		<!-- Chat Messages -->
		<div class="flex-1 overflow-y-auto p-8 space-y-6 mb-28" id="chat-messages">
			<!-- Example messages, replace with dynamic content as needed -->
			<div class="flex flex-col items-start">
				<div class="bg-blue-100 text-blue-900 rounded-lg px-4 py-2 max-w-xl mb-2">How can I register a business in Rwanda?</div>
				<span class="text-xs text-gray-400 ml-2">You</span>
			</div>
			<div class="flex flex-col items-end">
				<div class="bg-white border border-blue-200 text-gray-800 rounded-lg px-4 py-2 max-w-xl mb-2">To register a business in Rwanda, you need to visit the RDB website, fill out the registration form, and submit the required documents. The process is usually completed within 6 hours.</div>
				<span class="text-xs text-gray-400 mr-2">Mbaza AI</span>
			</div>
		</div>

		<!-- Prompt Input (sticky at bottom) -->
		<form class="sticky bottom-0 left-0 w-full flex items-center bg-white border-t border-gray-200 p-4 z-10" wire:submit.prevent="sendPrompt">
			<input type="text" wire:model.defer="prompt" placeholder="Type your question..." class="flex-1 border rounded-lg px-4 py-3 mr-4 focus:outline-none focus:ring-2 focus:ring-blue-400" />
			<button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Send</button>
		</form>
	</main>

	<!-- Sidebar (Sessions) on the right -->
	<aside class="w-64 bg-white border-l border-gray-200 flex flex-col p-4">
		<h2 class="text-xl font-bold text-blue-700 mb-6">Sessions</h2>
		<ul class="flex-1 space-y-3 overflow-y-auto">
			<!-- Example session titles, replace with dynamic content as needed -->
			<li class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer font-medium text-gray-700">Legal Advice</li>
			<li class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer font-medium text-gray-700">Business Registration</li>
			<li class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer font-medium text-gray-700">Tax Inquiry</li>
		</ul>
		<button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">+ New Session</button>
	</aside>
</div>
