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
<!-- Project Details Page -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">

        <!-- Breadcrumb + Title -->
        <div class="mb-12">
            <nav class="text-sm text-gray-500 mb-2">
                <a href="/" class="hover:text-purple-600">Home</a> /
                <a href="/projects" class="hover:text-purple-600">Projects</a> /
                <span class="text-gray-700 font-medium">E-Commerce Website</span>
            </nav>

            <h1 class="text-4xl font-bold text-gray-900">E-Commerce Website Development</h1>
            <p class="mt-3 text-gray-600 max-w-2xl">
                A full-featured eCommerce platform built with Laravel, Vue 3 & TailwindCSS.
            </p>
        </div>

        <!-- Main Layout -->
        <div class="grid md:grid-cols-2 gap-12 items-center">

            <!-- Left: About Text -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Project Overview</h2>
                <p class="text-gray-600 leading-relaxed mb-6">
                    This eCommerce system includes product listing, stock management, checkout,
                    cart tracking, order history, admin reporting, and secure payment integration.
                </p>

                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check mt-1 text-purple-600"></i>
                        <span>Responsive and mobile-friendly design</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check mt-1 text-purple-600"></i>
                        <span>Advanced product filtering & search</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check mt-1 text-purple-600"></i>
                        <span>Secure checkout & payment gateway integration</span>
                    </li>
                </ul>
            </div>

            <!-- Right: Mockup Image -->
            <div class="rounded-xl overflow-hidden shadow-lg">
                <img src="{{ asset('frontend/img/ecom_admin.png')}}"
                    alt="Project Screenshot"
                    class="w-full h-[380px] object-cover">
            </div>
        </div>

        <!-- Technology Stack -->
        <div class="mt-20">
            <h2 class="text-2xl font-semibold text-gray-900 mb-8">Technology Stack</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="flex items-center gap-3 bg-white p-4 rounded-xl shadow">
                    <i class="fa-brands fa-laravel text-red-600 text-2xl"></i>
                    <span>Laravel</span>
                </div>
                <div class="flex items-center gap-3 bg-white p-4 rounded-xl shadow">
                    <i class="fa-brands fa-vuejs text-green-500 text-2xl"></i>
                    <span>Vue 3</span>
                </div>
                <div class="flex items-center gap-3 bg-white p-4 rounded-xl shadow">
                    <i class="fa-brands fa-css3-alt text-blue-500 text-2xl"></i>
                    <span>Tailwind CSS</span>
                </div>
                <div class="flex items-center gap-3 bg-white p-4 rounded-xl shadow">
                    <i class="fa-solid fa-database text-purple-600 text-2xl"></i>
                    <span>MySQL</span>
                </div>
            </div>
        </div>

        <!-- Screenshot Gallery -->
        <div class="mt-20">
            <h2 class="text-2xl font-semibold text-gray-900 mb-8">Project Screenshots</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="rounded-xl overflow-hidden shadow hover:scale-105 transition">
                    <img src="{{ asset('frontend/img/ecommerce.png')}}" class="w-full h-56 object-cover">
                </div>

                <div class="rounded-xl overflow-hidden shadow hover:scale-105 transition">
                    <img src="{{ asset('frontend/img/helpdesk.png')}}" class="w-full h-56 object-cover">
                </div>

                <div class="rounded-xl overflow-hidden shadow hover:scale-105 transition">
                    <img src="{{ asset('frontend/img/ecom_admin.png')}}" class="w-full h-56 object-cover">
                </div>

            </div>
        </div>

    </div>
</section>

      

    </div>
</section>

@endsection