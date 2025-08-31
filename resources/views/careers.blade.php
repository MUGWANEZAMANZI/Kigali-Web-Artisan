<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Data Entry Work Guidelines</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="color-scheme" content="light dark">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html { font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji"; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-900 dark:text-slate-100">
<div class="max-w-5xl mx-auto p-6">
    <!-- Header -->
    <header class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Data Entry Work Guidelines</h1>
            <p class="text-sm text-slate-500">For Kinyarwanda law data transcription (PDF → Excel)</p>
        </div>
        <div class="text-right">
            <a href="https://kigali-web-artisans.up.railway.app" target="_blank" class="inline-flex items-center gap-2">
    <span>
        <img src="/logo/logo.jpg" alt="Kigali Web Artisans Logo" class="h-10 w-10 rounded-full border border-slate-200 dark:border-slate-700 shadow-sm object-cover" />
    </span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-indigo-600 dark:text-indigo-400">
                    <path d="M13.5 3.75a.75.75 0 000 1.5h4.19l-8.72 8.72a.75.75 0 101.06 1.06l8.72-8.72v4.19a.75.75 0 001.5 0V3.75a.75.75 0 00-.75-.75h-6.94z"/>
                    <path d="M5.25 6A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V12a.75.75 0 00-1.5 0v6.75a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V8.25a.75.75 0 01.75-.75H12a.75.75 0 000-1.5H5.25z"/>
                </svg>
            </a>

        </div>
    </header>

    <!-- Alert / Key Hours -->
    <div class="mb-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-5 shadow-sm">
        <div class="flex items-start gap-3">
            <div class="shrink-0 mt-0.5">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white">⏰</span>
            </div>
            <div>
                <p class="font-semibold">Working Hours</p>
                <p class="text-slate-600 dark:text-slate-300">Every day from <span class="font-semibold">09:00</span> to <span class="font-semibold">12:00</span>. After the work period, there is a <span class="font-semibold">1-hour supervision</span> to verify data consistency. Payments are processed after successful review. <span class="font-semibold">No payment</span> is made for work under <span class="font-semibold">300 pages</span>.</p>
            </div>
        </div>
    </div>

    <!-- Two-column content: English / Kinyarwanda -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- EN card -->
        <section class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <h2 class="text-xl font-semibold mb-4">English</h2>
            <div class="space-y-4">
                <p><span class="font-semibold">Start Date:</span> Work begins after individual agreement and contract signing.</p>

                <div>
                    <h3 class="font-semibold mb-2">Daily Checklist</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Arrive on site and create a new Excel file.</li>
                        <li>Start your <span class="font-medium">assigned section</span>.</li>
                        <li>Follow the <span class="font-medium">file naming conventions</span> below.</li>
                        <li>When your time (09:00–12:00) is done, write your <span class="font-medium">name once</span> in today’s Excel file to report attendance.</li>
                        <li>Submit for the <span class="font-medium">1-hour supervision test</span> (data consistency check).</li>
                        <li>Payment is queued after approval. No payment for fewer than <span class="font-medium">300 pages</span>.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Sections Available</h3>
                    <ul class="list-disc pl-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                        <li>Administrative Laws (275)</li>
                        <li>Business Laws (452)</li>
                        <li>Civil Laws (258)</li>
                        <li>Criminal Laws (84)</li>
                        <li>Diplomatic & Consular Laws (34)</li>
                        <li>Fundamental Laws (42)</li>
                        <li>Human Rights Related Laws (17)</li>
                        <li>Judicial Laws (62)</li>
                        <li>Security Laws (67)</li>
                        <li>Taxation Laws (69)</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">File Naming Conventions</h3>
                    <p class="mb-2">Save files using this pattern:</p>
                    <div class="rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-4 text-sm font-mono">
                        <p><span class="font-bold">Section</span>_<span class="font-bold">Date</span>_<span class="font-bold">YourName</span>.xlsx</p>
                        <p class="mt-2 text-slate-500">Example: <span class="font-semibold">BusinessLaws_2025-08-31_JustinMuhirwa.xlsx</span></p>
                    </div>
                    <ul class="list-disc pl-5 mt-3 space-y-1 text-sm">
                        <li>Use ISO date format <span class="font-mono">YYYY-MM-DD</span>.</li>
                        <li>Remove spaces in section names, or use dashes (e.g., <span class="font-mono">Human-Rights</span>).</li>
                        <li>One day → one file per worker.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Payments</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li><span class="font-medium">2,000 RWF</span> after completing <span class="font-medium">300 pages</span>.</li>
                        <li><span class="font-medium">5,000 RWF</span> if you complete one whole section within <span class="font-medium">2 days</span>.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Payment Methods & Contract</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Onsite workers will receive <span class="font-medium">cash payments</span>.</li>
                        <li>Remote workers will receive payment via <span class="font-medium">MTN Mobile Money</span> accounts registered under their own names only.</li>
                        <li>To request contract signing, send your <span class="font-medium">CV</span> and <span class="font-medium">signed contract</span> to <a href="mailto:mmaudace@gmail.com" class="text-indigo-600 hover:underline">mmaudace@gmail.com</a>.</li>
                        <li>The contract can be downloaded here: <a href="https://docs.google.com/document/d/1DP23FFm4Fz3RXWJSKK7OW_6fpERe9dWr3IQYgKlSjPA/edit?usp=sharing" target="_blank" class="text-indigo-600 hover:underline">Contract Link</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- RW card -->
        <section class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <h2 class="text-xl font-semibold mb-4">Kinyarwanda</h2>
            <div class="space-y-4">
                <p><span class="font-semibold">Itangira ry’Akazi:</span> Akazi gatangira nyuma yo kumvikana no gusinya amasezerano ku muntu ku giti cye.</p>

                <div>
                    <h3 class="font-semibold mb-2">Urutonde rw’Imirimo ya buri munsi</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Gerayo aho akazi gakorerwa, ukore idosiye nshya ya Excel.</li>
                        <li>Tangira ku <span class="font-medium">gice wahawe</span> gukora.</li>
                        <li>Kurikiza <span class="font-medium">amabwiriza yo kwita ku madokumeti</span> (file naming) akurikira.</li>
                        <li>Nyuma yo kurangiza igihe cyawe (09:00–12:00), andika <span class="font-medium">izina ryawe rimwe gusa</span> muri Excel y’uwo munsi nk’ikimenyetso cyo kwitabira.</li>
                        <li>Tanga umurimo mu <span class="font-medium">isaha 1 y’igenzura</span> (gusuzuma ko amakuru yinjijwe yuzuye kandi yanditswe neza).</li>
                        <li>Kwishyurwa gukorwa nyuma yo kwemezwa. Nta kwishyura ku kazi kari munsi ya <span class="font-medium">paji 300</span>.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Ibyiciro Bihari</h3>
                    <ul class="list-disc pl-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                        <li>Amategeko y’Ubutegetsi (275)</li>
                        <li>Amategeko y’Ubucuruzi (452)</li>
                        <li>Amategeko y’Imibereho Rusange (258)</li>
                        <li>Amategeko y’Urubanza (84)</li>
                        <li>Amategeko ya Dipolomasi n’Ubuhagarike (34)</li>
                        <li>Amategeko Shingiro (42)</li>
                        <li>Amategeko y’Uburenganzira bwa Muntu (17)</li>
                        <li>Amategeko y’Ubucamanza (62)</li>
                        <li>Amategeko y’Umutekano (67)</li>
                        <li>Amategeko y’Imisoro (69)</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Uko Dosiye Zigomba Kwitwa</h3>
                    <p class="mb-2">Bika dosiye ukoresheje iri sanzure:</p>
                    <div class="rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-4 text-sm font-mono">
                        <p><span class="font-bold">Igice</span>_<span class="font-bold">Italiki</span>_<span class="font-bold">IzinaRyawe</span>.xlsx</p>
                        <p class="mt-2 text-slate-500">Urugero: <span class="font-semibold">AmategekoY’Ubucuruzi_2025-08-31_LindaBurume.xlsx</span></p>
                    </div>
                    <ul class="list-disc pl-5 mt-3 space-y-1 text-sm">
                        <li>Koresha italiki ya <span class="font-mono">YYYY-MM-DD</span>.</li>
                        <li>Siba ibihebe mu mazina y’ibice, cyangwa ukoreshe udusomi (<span class="font-mono">-</span>).</li>
                        <li>Umunsi umwe → dosiye imwe kuri buri mukozi.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Kwishyurwa</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li><span class="font-medium">2,000 RWF</span> nyuma yo kurangiza <span class="font-medium">paji 300</span>.</li>
                        <li><span class="font-medium">5,000 RWF</span> niba urangije igice kimwe mu <span class="font-medium">minsi 2</span>.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Uko Kwishyurwa & Amasezerano</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Abo bakora <span class="font-medium">ahakorerwa akazi</span> bazishyurwa mu <span class="font-medium">mafaranga ako kanya (cash)</span>.</li>
                        <li>Abo bakora <span class="font-medium">kuri internet (remote)</span> bazishyurwa kuri <span class="font-medium">MTN Mobile Money</span> izanditse ku mazina yabo gusa.</li>
                        <li>Kugira ngo usabe <span class="font-medium">gusinya amasezerano</span>, ohereza <span class="font-medium">CV</span> yawe n’<span class="font-medium">amasezerano yasinywe</span> kuri <a href="mailto:mmaudace@gmail.com" class="text-indigo-600 hover:underline">mmaudace@gmail.com</a>.</li>
                        <li>Amasezerano arashobora gukurwa hano: <a href="https://docs.google.com/document/d/1DP23FFm4Fz3RXWJSKK7OW_6fpERe9dWr3IQYgKlSjPA/edit?usp=sharing" target="_blank" class="text-indigo-600 hover:underline">Link ya Contract</a></li>
                    </ul>
                </div>

            </div>
        </section>
    </div>

    <!-- Footer / Signature -->
    <footer class="mt-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-sm text-slate-500">
        <div>
            <p class="font-medium text-slate-700 dark:text-slate-300">Coordinator: MUGWANEZA MANZI Audace</p>
            <p>Email will include sample PDF & Excel templates for reference.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-700">PDF → Excel</span>
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-700">Kinyarwanda Data</span>
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-700">Quality Review</span>
        </div>
    </footer>
</div>
</body>
</html>
