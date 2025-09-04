@extends('components.layouts.app')

    @section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10 terms-container">
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('products/mbaza_ai.png') }}" alt="Mbaza AI" class="h-40 rounded shadow">
        </div>
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Mbaza AI Terms of Use & Privacy Policy</h1>
        <p class="mb-6 text-gray-700">
            Welcome to Mbaza AI, a service by Kigali Web Artisans designed to assist Rwandans with information and digital services.
        <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">1. Acceptance of Terms</h2>
        <p class="mb-6 text-gray-700">
            By accessing or using Mbaza AI, you agree to comply with these terms. If you do not agree, please do not use the service.
        </p>

        <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">2. Service Description</h2>
        <p class="mb-6 text-gray-700">
            Mbaza AI provides information, guidance, and digital assistance to Rwandan users. The service is intended for lawful use only and should not be relied upon for legal, medical, or emergency advice.<br>
            <strong>Legal Sources:</strong> Mbaza AI uses laws and regulations officially published by the Government of Rwanda, including those available publicly in the Official Gazette. The service downloads and processes legal texts from <a href="https://amategeko.gov.rw" class="text-blue-600 underline" target="_blank">amategeko.gov.rw</a>, which contains Rwandan laws, case law, and internationally signed contracts by Rwanda. These sources are used to train and update the Mbaza AI model.<br>
            I collect data from official Gazette publication, and use amategeko.gov.rw website as a national commission for law amendment in Rwanda. We collect these informations, pre-process it and train Mbaza AI model.
        </p>

        <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">3. User Data & Privacy</h2>
        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
            <li>Mbaza AI collects minimal personal data necessary to provide and improve the service, in accordance with Rwandan data protection law.</li>
            <li>Your data is processed securely and is not shared with third parties without your consent.</li>
            <li>You have the right to access, correct, or request deletion of your personal data. To exercise these rights, email <a href="mailto:mmaudace@gmail.com" class="text-blue-600 underline">mmaudace@gmail.com</a>.</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">4. User Responsibilities</h2>
        <ul class="list-disc list-inside mb-6 text-gray-700 space-y-2">
            <li>Use Mbaza AI for lawful purposes and in accordance with Rwandan law.</li>
            <li>Do not submit false, misleading, or unlawful information.</li>
            <li>Report any misuse or suspicious activity to us for prompt action.</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">5. Limitation of Liability</h2>
        <p class="mb-6 text-gray-700">
            Kigali Web Artisans is not liable for any damages or losses resulting from the use of Mbaza AI. Users are responsible for their actions and should verify information as needed.
        </p>

        <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">6. Changes to Terms</h2>
        <p class="mb-6 text-gray-700">
            We may update these terms to comply with changes in Rwandan law or service improvements. Continued use of Mbaza AI constitutes acceptance of the revised terms.
        </p>

        <h2 class="text-2xl font-semibold mt-8 mb-3 text-gray-800">Disclaimer</h2>
        <p class="mb-6 text-gray-700">
            <strong>Disclaimer:</strong> Mbaza AI is an independent service and is <span class="font-semibold">not affiliated with, endorsed by, or officially connected to the Government of Rwanda</span>. We collect and process laws and regulations that are publicly available and published by the Government of Rwanda, including those on <a href="https://amategeko.gov.rw" class="text-blue-600 underline" target="_blank">amategeko.gov.rw</a>. All legal information provided by Mbaza AI is for informational purposes only and should not be considered as official government communication or legal advice.
        </p>

        <p class="text-gray-700">
            For questions or concerns, contact us at <a href="mailto:mmaudace@gmail.com" class="text-blue-600 underline">mmaudace@gmail.com</a>.
        </p>
    </div>
    @endsection
