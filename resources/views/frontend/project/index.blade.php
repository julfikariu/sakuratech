@extends('frontend.layouts.layout')

@section('content')

    <section class="bg-white pt-28 pb-16">
        <div class="container mx-auto px-6 max-w-7xl">

            <!-- Header -->
            <div class="text-center mb-14">
                <h1 class="text-4xl font-bold text-gray-900">Our Completed Projects</h1>
                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                    We design and develop high-quality software solutions for businesses worldwide.
                    Here are some of our delivered projects.
                </p>
            </div>

            <!-- Portfolio Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">

                <!-- Project Card -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition p-4 border border-gray-100">
                    <div class="rounded-xl overflow-hidden">
                        <img src="{{ asset('frontend/img/ecom_admin.png')}}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                            alt="HRM Project">
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">HRM Management System</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Complete HR automation with payroll, attendance, leave, recruitment & workflows.
                    </p>

                    <a href="{{ route('project.details', ['slug' => 'details']) }}"
                    class="inline-flex items-center gap-2 mt-4 text-purple-600 font-medium text-sm">
                        View Details <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Project Card -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition p-4 border border-gray-100">
                    <div class="rounded-xl overflow-hidden">
                        <img src="{{ asset('frontend/img/ecom_admin.png')}}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                            alt="Helpdesk System">
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Helpdesk Ticketing System</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Ticket management, SLA rules, automation, agent management, and analytics.
                    </p>

                    <a href="/portfolio/helpdesk"
                    class="inline-flex items-center gap-2 mt-4 text-purple-600 font-medium text-sm">
                        View Details <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Project Card -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition p-4 border border-gray-100">
                    <div class="rounded-xl overflow-hidden">
                        <img src="/images/projects/ecommerce.png"
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                            alt="eCommerce Project">
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Custom eCommerce Platform</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Product management, checkout, payments, admin analytics & multi-vendor features.
                    </p>

                    <a href="/portfolio/ecommerce"
                    class="inline-flex items-center gap-2 mt-4 text-purple-600 font-medium text-sm">
                        View Details <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Project Card -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition p-4 border border-gray-100">
                    <div class="rounded-xl overflow-hidden">
                        <img src="/images/projects/pos.png"
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                            alt="POS Project">
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">POS & Inventory System</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Cloud-based POS with stock control, invoicing, purchase orders & reporting.
                    </p>

                    <a href="/portfolio/pos"
                    class="inline-flex items-center gap-2 mt-4 text-purple-600 font-medium text-sm">
                        View Details <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Project Card -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition p-4 border border-gray-100">
                    <div class="rounded-xl overflow-hidden">
                        <img src="/images/projects/erp.png"
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                            alt="ERP Project">
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">ERP Business Suite</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Modules for HR, accounts, inventory, CRM, purchase, sales & full automation.
                    </p>

                    <a href="/portfolio/erp"
                    class="inline-flex items-center gap-2 mt-4 text-purple-600 font-medium text-sm">
                        View Details <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Project Card -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition p-4 border border-gray-100">
                    <div class="rounded-xl overflow-hidden">
                        <img src="/images/projects/lms.png"
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                            alt="LMS Platform">
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">LMS Learning Platform</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Online courses, assessments, certificates, roles, and student analytics.
                    </p>

                    <a href="/portfolio/lms"
                    class="inline-flex items-center gap-2 mt-4 text-purple-600 font-medium text-sm">
                        View Details <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

            </div>

        </div>
    </section>
@endsection