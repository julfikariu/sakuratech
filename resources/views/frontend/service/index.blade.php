@extends('frontend.layouts.layout')

@section('content')

    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6 max-w-7xl">

          
            <!-- Heading -->
            <div class="text-center max-w-3xl mx-auto mt-6 mb-14">
                <p class="text-sm uppercase tracking-widest font-semibold" style="color:#5e17eb">
                    All Our Services
                </p>
                <h2 class="mt-2 text-3xl md:text-4xl font-extrabold text-gray-900">
                    What We Do at
                </h2>
                <p class="mt-3 text-gray-600">
                    From simple APIs to complex enterprise dashboards, we provide end-to-end development services tailored to your business needs.
                </p>
            </div>

            <!-- Grid -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

                <!-- Card -->
                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl 
                        bg-purple-600/10 text-purple-600 text-2xl mb-4">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                        Laravel Web Development
                    </h3>
                    <p class="mt-2 text-gray-600">Secure, scalable and maintainable apps powered by Laravel & PHP 8+.</p>
                </div>

                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl 
                        bg-purple-600/10 text-purple-600 text-2xl mb-4">
                        <i class="fa-solid fa-diagram-project"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                        API Development
                    </h3>
                    <p class="mt-2 text-gray-600">Robust REST APIs that power apps, dashboards, mobile & integrations.</p>
                </div>

                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl 
                        bg-purple-600/10 text-purple-600 text-2xl mb-4">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                        <a href="{{ route('service.details', ['slug' => 'ecommerce']) }}" class="">eCommerce Solutions</a>
                    </h3>
                    <p class="mt-2 text-gray-600">Custom shopping carts, payments, subscriptions and marketplace features.
                    </p>
                </div>

                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl 
                        bg-purple-600/10 text-purple-600 text-2xl mb-4">
                        <i class="fa-solid fa-gauge-high"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                        Admin Dashboards
                    </h3>
                    <p class="mt-2 text-gray-600">Analytics dashboards, permission/role systems, exports & reports.</p>
                </div>

                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl 
                        bg-purple-600/10 text-purple-600 text-2xl mb-4">
                        <i class="fa-solid fa-bug"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                        Quality Assurance
                    </h3>
                    <p class="mt-2 text-gray-600">Functional, performance and automation testing for reliable releases.</p>
                </div>

                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl 
                        bg-purple-600/10 text-purple-600 text-2xl mb-4">
                        <i class="fa-solid fa-pencil-ruler"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                        UI/UX & Front-end
                    </h3>
                    <p class="mt-2 text-gray-600">Vue/Tailwind modern interfaces with smooth, user-friendly experience.</p>
                </div>

                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl 
                        bg-purple-600/10 text-purple-600 text-2xl mb-4">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                        DevOps & CI/CD
                    </h3>
                    <p class="mt-2 text-gray-600">Docker, GitHub Actions, server deploys, monitoring & backups.</p>
                </div>

                <div class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100">
                    <div class="h-14 w-14 flex items-center justify-center rounded-xl 
                        bg-purple-600/10 text-purple-600 text-2xl mb-4">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                        Maintenance & Support
                    </h3>
                    <p class="mt-2 text-gray-600">Bug fixes, upgrades, performance optimization & SLA support.</p>
                </div>

            </div>

        </div>
    </section>


@endsection