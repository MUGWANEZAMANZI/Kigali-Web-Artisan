<div class="relative">
    <!-- Trigger Button -->
    <button
        wire:click="$set('isClicked', true)"
        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white shadow-lg transition hover:scale-[1.02] hover:bg-blue-700 hover:shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-transparent">
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
            <path fill-rule="evenodd" d="M1.5 4.5A2.25 2.25 0 013.75 2.25h4.5c.995 0 1.88.63 2.2 1.574l.776 2.329a2.25 2.25 0 01-.84 2.518l-1.253.94a.75.75 0 00-.239.9 10.51 10.51 0 005.65 5.65.75.75 0 00.9-.239l.94-1.253a2.25 2.25 0 012.518-.84l2.329.776A2.25 2.25 0 0121.75 19.75v.5A2.25 2.25 0 0119.5 22.5h-1.25C8.268 22.5 1.5 15.732 1.5 7.75V4.5z" clip-rule="evenodd" />
        </svg>
        Let's Talk
    </button>

    <!-- Overlay & Left-side Modal -->
    <div
        wire:show="isClicked"
        wire:cloak
        x-on:keydown.window.escape="$wire.set('isClicked', false)"
        wire:transition.opacity.duration.500ms
        class="fixed inset-0 z-50 hidden md:block">
        <!-- Radial Gradient Backdrop -->
        <div class="absolute inset-0" style="background:radial-gradient(ellipse at 30% 40%,rgba(34,211,238,0.25) 0%,rgba(59,130,246,0.18) 40%,rgba(30,41,59,0.85) 100%);backdrop-filter:blur(6px);" wire:click="$set('isClicked', false)"></div>

        <!-- Slide-in Panel (Left) with animated transition and blueprint-inspired background -->
        <section
            aria-modal="true"
            role="dialog"
            class="fixed left-0 top-0 flex h-full w-full max-w-[520px] flex-col overflow-hidden shadow-2xl transition-transform duration-500 ease-[cubic-bezier(.77,0,.18,1.01)] will-change-transform bg-white/90 dark:bg-slate-900/90"
            style="background-image:radial-gradient(ellipse at 60% 20%,rgba(59,130,246,0.18) 0%,rgba(34,211,238,0.12) 60%,rgba(30,41,59,0.85) 100%),url('/logo/logo.jpg');background-size:cover;background-blend-mode:overlay;box-shadow:0 8px 32px 0 rgba(31,38,135,0.37);"
            wire:transition.scale.origin.left.duration.500ms>
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200/70 bg-gradient-to-r from-blue-700/90 via-cyan-600/80 to-blue-400/80 px-5 py-4 text-white dark:border-slate-800 shadow-lg">
                <div>
                    <p class="text-xs leading-5 opacity-90">We’ll reach out to you soon</p>
                    <h2 class="mt-0.5 text-lg font-bold">Talk to an Expert</h2>
                </div>
                <button
                    aria-label="Close"
                    wire:click="$set('isClicked', false)"
                    class="rounded-full p-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="flex-1 overflow-y-auto px-6 py-5">
                <form wire:submit.prevent="save" class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Your Name</label>
                        <input
                            id="name"
                            type="text"
                            wire:model.live="name"
                            name="name"
                            placeholder="Tell us your name"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400 dark:focus:border-blue-400 dark:focus:ring-blue-900/40"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Email</label>
                        <input
                            id="email"
                            type="email"
                            wire:model.live="email"
                            name="email"
                            placeholder="you@example.com"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400 dark:focus:border-blue-400 dark:focus:ring-blue-900/40"
                        />
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">How can we help?</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            wire:model.live="message"
                            placeholder="Briefly tell us about your needs"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400 dark:focus:border-blue-400 dark:focus:ring-blue-900/40"></textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-1">
                        <button
                            type="submit"
                            wire:target="save"
                            wire:loading.attr="disabled"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 font-semibold text-white shadow-md transition hover:scale-[1.01] hover:bg-blue-700 hover:shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-70 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Mobile: Fullscreen takeover for better UX -->
    <div
        wire:show="isClicked"
        wire:cloak
        x-on:keydown.window.escape="$wire.set('isClicked', false)"
        wire:transition.opacity.duration.500ms
        class="fixed inset-0 z-50 md:hidden">
        <!-- Radial Gradient Backdrop -->
        <div class="absolute inset-0" style="background:radial-gradient(ellipse at 60% 60%,rgba(34,211,238,0.22) 0%,rgba(59,130,246,0.15) 40%,rgba(30,41,59,0.85) 100%);backdrop-filter:blur(8px);" wire:click="$set('isClicked', false)"></div>

        <section
            aria-modal="true"
            role="dialog"
            class="fixed inset-x-0 bottom-0 top-0 flex h-full w-full flex-col overflow-hidden shadow-2xl transition-transform duration-500 ease-[cubic-bezier(.77,0,.18,1.01)] will-change-transform bg-white/90 dark:bg-slate-900/90"
            style="background-image:radial-gradient(ellipse at 40% 80%,rgba(59,130,246,0.18) 0%,rgba(34,211,238,0.12) 60%,rgba(30,41,59,0.85) 100%),url('/logo/logo.jpg');background-size:cover;background-blend-mode:overlay;box-shadow:0 8px 32px 0 rgba(31,38,135,0.37);"
            wire:transition.scale.origin.bottom.duration.500ms>
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200/70 bg-gradient-to-r from-blue-600 to-cyan-600 px-5 py-4 text-white dark:border-slate-800">
                <div>
                    <p class="text-xs leading-5 opacity-90">We’ll reach out to you soon</p>
                    <h2 class="mt-0.5 text-lg font-bold">Talk to an Expert</h2>
                </div>
                <button
                    aria-label="Close"
                    wire:click="$set('isClicked', false)"
                    class="rounded-full p-2 transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-6 py-5">
                <form wire:submit.prevent="save" class="space-y-5">
                    <div>
                        <label for="m-name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Your Name</label>
                        <input id="m-name" type="text" wire:model.live="name" name="name" placeholder="Tell us your name" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400 dark:focus:border-blue-400 dark:focus:ring-blue-900/40" />
                        @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="m-email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Email</label>
                        <input id="m-email" type="email" wire:model.live="email" name="email" placeholder="you@example.com" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400 dark:focus:border-blue-400 dark:focus:ring-blue-900/40" />
                        @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="m-message" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">How can we help?</label>
                        <textarea id="m-message" name="message" rows="4" wire:model.live="message" placeholder="Briefly tell us about your needs" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400 dark:focus:border-blue-400 dark:focus:ring-blue-900/40"></textarea>
                        @error('message') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="pt-1">
                        <button type="submit" wire:target="save" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 font-semibold text-white shadow-md transition hover:scale-[1.01] hover:bg-blue-700 hover:shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-70 disabled:cursor-not-allowed">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
