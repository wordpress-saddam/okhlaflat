<x-public-layout>
    <x-slot name="title">Contact Us - Jamia Nagar Rental Flats</x-slot>

    <!-- Header Section -->
    <section class="bg-gradient-to-r from-indigo-950 via-slate-900 to-indigo-905 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">
                Contact Our Office
            </h1>
            <p class="mt-4 text-lg text-slate-300 max-w-2xl leading-relaxed">
                Have questions or want to list your flat? Reach out to us or visit our physical office.
            </p>
        </div>
    </section>

    <!-- Contact Form & Info -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="space-y-6">
                <h2 class="text-2xl font-extrabold text-slate-950">Get in Touch</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Our team is here to assist you with flat tours, agreement documentation, and verification.
                </p>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                            <!-- Phone icon -->
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Call Us</h4>
                            <p class="text-xs text-slate-500 mt-1">+91 98765 43210</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                            <!-- Mail icon -->
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Email Address</h4>
                            <p class="text-xs text-slate-500 mt-1">info@okhlaflat.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                            <!-- Map Pin icon -->
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Physical Office</h4>
                            <p class="text-xs text-slate-500 mt-1">Jamia Nagar, Okhla, New Delhi - 110025</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 lg:p-8">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Send Message</h3>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Name</label>
                        <input type="text" name="name" id="name" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" id="email" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3">
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Message</label>
                        <textarea name="message" id="message" rows="4" required class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3"></textarea>
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg duration-200">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-public-layout>
