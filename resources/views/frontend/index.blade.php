@extends('frontend.layouts.layout')

@section('content')
    <!-- HERO SECTION -->
    @include('frontend.partials.hero')
    
    <!-- About Section -->
    @include('frontend.partials.about')

    <!-- OUR SERVICES -->
    @include('frontend.partials.service')
    

     <!-- WORK PROJECT -->
    @include('frontend.partials.our_project')

    <!-- WORK PROCESS -->
    @include('frontend.partials.working_process')
    @include('frontend.partials.working_second')

    <!-- TECHNOLOGY STACK SECTION -->
    @include('frontend.partials.technology')

    <!-- CONTACT FORM -->
    @include('frontend.partials.contact_us')

@endsection