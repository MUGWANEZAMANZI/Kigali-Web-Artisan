@extends('components.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10 terms-container">
    <div class="flex flex-col items-center mb-8">
        <img src="{{ asset('products/dorm_link.jpg') }}" alt="Dorm Link" class="h-40 rounded shadow">
    </div>
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Terms and Conditions</h1>
    <p class="mb-6 text-gray-700">
        Welcome to Dorm Link, a service provided by Kigali Web Artisans. Please read these terms and conditions carefully before using our platform.
    </p>

    <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">1. Acceptance of Terms</h2>
    <p class="mb-6 text-gray-700">
        By accessing or using Dorm Link, you agree to be bound by these terms. If you do not agree with any part of these terms, please do not use the service.
    </p>

    <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">2. Service Description</h2>
    <p class="mb-6 text-gray-700">
        Dorm Link helps users find and list dorm accommodations. The service uses your GPS location to suggest nearby dorms and provides navigation to selected properties.
    </p>

    <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">3. User Data and Privacy</h2>
    <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
        <li>Your location data is used solely to improve your experience on Dorm Link.</li>
        <li>Your personal data is not accessed by our team or shared with third parties.</li>
        <li>If you wish to delete your data from our systems, please email <a href="mailto:mmaudace@gmail.com" class="text-blue-600 underline">mmaudace@gmail.com</a>.</li>
    </ul>

    <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">4. User Responsibilities</h2>
    <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
        <li>Only use Dorm Link for finding or listing dorm accommodations.</li>
        <li>Do not post false or misleading information.</li>
        <li>Report any fake listings or suspicious activity to us for prompt action.</li>
    </ul>

    <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">5. Limitation of Liability</h2>
    <p class="mb-6 text-gray-700">
        Kigali Web Artisans is not responsible for any issues, disputes, or damages that may arise from the use of Dorm Link. Users are encouraged to exercise caution and report any concerns.
    </p>

    <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">6. Changes to Terms</h2>

    <p class="mb-6 text-gray-700">
        We may update these terms from time to time. Continued use of Dorm Link constitutes acceptance of the revised terms.
    </p>

    <p class="text-gray-700">
        If you have any questions or concerns, please contact us at <a href="mailto:mmaudace@gmail.com" class="text-blue-600 underline">mmaudace@gmail.com</a>.
    </p>
</div>
@endsection
