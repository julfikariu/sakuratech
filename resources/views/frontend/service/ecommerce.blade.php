@extends('frontend.layouts.layout')

@section('content')

<section class="bg-white pt-24 pb-16">

    <div class="container mx-auto px-6 max-w-7xl">

        <!-- TOP SECTION -->
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- LEFT CONTENT -->
            <div>
                <span class="px-4 py-1.5 bg-purple-100 text-purple-700 text-sm font-semibold rounded-full">
                    Helpdesk Ticketing System
                </span>

                <h1 class="mt-4 text-4xl font-bold text-gray-900 leading-snug">
                    A Complete Ticketing & Support Automation Platform
                </h1>

                <p class="mt-4 text-gray-600 leading-relaxed text-lg">
                    A modern helpdesk solution for teams to manage support tickets, automate workflows,
                    track SLAs, assign agents, analyze performance, and deliver exceptional customer service.
                    Built with Laravel, Vue.js, TailwindCSS, and REST APIs.
                </p>

                <div class="mt-8 flex gap-4">
                    <a href="#demo"
                       class="px-6 py-3 rounded-xl bg-purple-600 text-white font-medium text-sm hover:bg-purple-700 transition-all">
                        View Live Demo
                    </a>
                    <a href="#contact"
                       class="px-6 py-3 rounded-xl bg-white text-gray-900 border border-gray-300 font-medium text-sm hover:bg-gray-50 transition-all">
                        Start a Similar Project
                    </a>
                </div>
            </div>

            <!-- RIGHT ILLUSTRATION -->
            <div class="relative">
                <div class="absolute inset-0 blur-3xl bg-purple-300/40 rounded-full"></div>
                <img src="https://illustrations.popsy.co/white/customer-support.svg"
                     class="relative w-full h-auto drop-shadow-xl" alt="Helpdesk Illustration">
            </div>

        </div>

    </div>
</section>




<!-- FEATURES SECTION -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6 max-w-7xl">

        <h2 class="text-3xl font-bold text-gray-900 text-center">Core Features</h2>
        <p class="mt-2 text-gray-600 text-center max-w-2xl mx-auto">
            Designed to improve workflow, reduce response times and increase customer satisfaction.
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10 mt-14">

            <!-- Feature Card -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                <i class="fa-solid fa-ticket text-purple-600 text-3xl mb-4"></i>
                <h3 class="font-semibold text-gray-900 text-lg">Smart Ticket Management</h3>
                <p class="mt-2 text-gray-600">Automatic ticket routing, status tracking, priorities & tags.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                <i class="fa-solid fa-users-gear text-purple-600 text-3xl mb-4"></i>
                <h3 class="font-semibold text-gray-900 text-lg">Agent & Team Access</h3>
                <p class="mt-2 text-gray-600">Role & permission-based access for teams, supervisors & admins.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                <i class="fa-solid fa-chart-line text-purple-600 text-3xl mb-4"></i>
                <h3 class="font-semibold text-gray-900 text-lg">Analytics Dashboard</h3>
                <p class="mt-2 text-gray-600">Real-time insights: ticket load, SLA breaches, agent performance.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                <i class="fa-solid fa-clock text-purple-600 text-3xl mb-4"></i>
                <h3 class="font-semibold text-gray-900 text-lg">SLA Policies</h3>
                <p class="mt-2 text-gray-600">Configure response time, resolution time, and violation alerts.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                <i class="fa-solid fa-envelope-open-text text-purple-600 text-3xl mb-4"></i>
                <h3 class="font-semibold text-gray-900 text-lg">Email Piping</h3>
                <p class="mt-2 text-gray-600">Convert emails into tickets automatically with IMAP/SMTP sync.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                <i class="fa-solid fa-puzzle-piece text-purple-600 text-3xl mb-4"></i>
                <h3 class="font-semibold text-gray-900 text-lg">3rd Party Integrations</h3>
                <p class="mt-2 text-gray-600">Slack, WhatsApp, CRM systems, payment platforms and more.</p>
            </div>

        </div>

    </div>
</section>

<!-- Image Gallery Section -->
<section id="gallery" class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 max-w-7xl">
        <h2 class="text-3xl font-bold mb-8 text-center">Project Screenshots</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Gallery Item -->
            <div class="rounded-xl overflow-hidden shadow hover:scale-105 transition">
                <img src="{{ asset('frontend/img/ecommerce.png') }}" alt="Screenshot 1" class="w-full h-56 object-cover">
            </div>

            <div class="rounded-xl overflow-hidden shadow hover:scale-105 transition">
                <img src="{{ asset('frontend/img/ecom_front.png') }}" alt="Screenshot 2" class="w-full h-56 object-cover">
            </div>

            <div class="rounded-xl overflow-hidden shadow hover:scale-105 transition">
                <img src="{{ asset('frontend/img/ecom_admin.png') }}" alt="Screenshot 3" class="w-full h-56 object-cover">
            </div>

           
        </div>
    </div>
</section>



<!-- TECH STACK SECTION -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6 max-w-7xl text-center">

        <h2 class="text-3xl font-bold text-gray-900">Technology Stack</h2>
        <p class="text-gray-600 mt-2 mb-12">Modern, secure & scalable technologies</p>

        <div class="flex flex-wrap justify-center gap-6 text-gray-700 text-sm">
            <span class="px-5 py-2 bg-gray-100 rounded-xl">Laravel</span>
            <span class="px-5 py-2 bg-gray-100 rounded-xl">Vue.js</span>
            <span class="px-5 py-2 bg-gray-100 rounded-xl">TailwindCSS</span>
            <span class="px-5 py-2 bg-gray-100 rounded-xl">REST API</span>
            <span class="px-5 py-2 bg-gray-100 rounded-xl">MySQL</span>
            <span class="px-5 py-2 bg-gray-100 rounded-xl">Redis</span>
            <span class="px-5 py-2 bg-gray-100 rounded-xl">Docker</span>
        </div>

    </div>
</section>




<!-- CTA SECTION -->
<section class="py-20 bg-purple-600 text-white">
    <div class="container mx-auto px-6 max-w-3xl text-center">
        <h2 class="text-3xl font-bold">Start Your Custom Project Today</h2>
        <p class="mt-3 text-purple-200">
            Whether it's HRM, ERP, Helpdesk, eCommerce or a unique SaaS platform —
            we can build a scalable, modern application tailored to your needs.
        </p>
        <a href="#contact"
           class="inline-block mt-8 px-8 py-3 bg-white text-purple-700 font-semibold rounded-xl hover:bg-gray-100 transition-all">
            Contact Us →
        </a>
    </div>
</section>


    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-7xl">

            <!-- Page Title -->
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-900">eCommerce Solutions</h1>
                <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">
                    Custom carts, payments, subscriptions, marketplace systems & seamless customer experience.
                </p>
            </div>

            <!-- Hero Section -->
            <div class="grid lg:grid-cols-2 gap-14 items-center">

                <!-- Left Content -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                        Build scalable and conversion-focused eCommerce systems
                    </h2>

                    <p class="text-gray-600 leading-relaxed mb-4">
                        We develop fully customized eCommerce platforms that deliver a smooth shopping experience,
                        from browsing products to checkout. Whether you need a custom shop, marketplace, subscription model,
                        or multi-vendor system — we design everything with performance, security and scalability in mind.
                    </p>

                    <p class="text-gray-600 leading-relaxed mb-6">
                        Integrated with payment gateways, inventory systems, analytics, automation and CRM tools for your
                        business growth.
                    </p>

                    <!-- Key Points -->
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-purple-600 mt-1"></i>
                            <span class="text-gray-700">Custom carts, products, categories & attributes.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-purple-600 mt-1"></i>
                            <span class="text-gray-700">Secure checkout, coupons, shipping & taxation.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-purple-600 mt-1"></i>
                            <span class="text-gray-700">Multi-vendor marketplace support.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-purple-600 mt-1"></i>
                            <span class="text-gray-700">Payment integrations (Stripe, PayPal, SSLCommerz, Mobile
                                Banking).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-purple-600 mt-1"></i>
                            <span class="text-gray-700">Admin dashboards & business analytics.</span>
                        </li>
                    </ul>

                    <a href="#contact"
                        class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl mt-8 transition-all">
                        Start Your Project
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Right Image -->
                <div class="overflow-hidden rounded-3xl shadow-md">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e" alt="Ecommerce Solutions"
                        class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

@endsection