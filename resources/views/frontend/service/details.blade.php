@extends('frontend.layouts.layout')

@section('content')
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
                    Integrated with payment gateways, inventory systems, analytics, automation and CRM tools for your business growth.
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
                        <span class="text-gray-700">Payment integrations (Stripe, PayPal, SSLCommerz, Mobile Banking).</span>
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
                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e"
                     alt="Ecommerce Solutions" class="w-full h-full object-cover">
            </div>

        </div>

    </div>
</section>

@endsection