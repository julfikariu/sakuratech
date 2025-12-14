<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sakura IT Solutions')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
      <!-- AOS for scroll animations (lightweight and easy) -->
    <link rel="preload" href="https://unpkg.com/aos@next/dist/aos.css" as="style">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Optional: Font Awesome (consider replacing with inline SVGs/icons for best performance) -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Performance hints -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.15.1/devicon.min.css">
    <link href="{{ asset('frontend/css/style.css')}}" rel="stylesheet" />

    <style>
    :root {
        --primary-color: #5e17eb; /* Deep Purple */
        --secondary-color: #9f6ae7; /* Light Purple */
        --accent-color: #f4a8b3; /* Soft Sakura Pink */
        --background-color: #f9f9f9; /* Soft White Background */
        --text-color-light: #ffffff; /* White Text */
        --text-color-dark: #333333; /* Dark Text for readability */
    }

    /* Custom scrollbar for a nicer look */

    ::-webkit-scrollbar {
        width: 4px;
        height: 4px
    }

    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px var(--secondary-color);
        border-radius: 5px
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 10px
    }
       
   
    /* Hero Section Background */
    .hero-background {
        background: var(--primary-color);
    }

    /* Button Styles */
    .btn-primary {
        background-color: var(--primary-color);
        color: var(--text-color-light);
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background-color: var(--accent-color);
        color: var(--text-color-dark);
        padding: 12px 24px;
        border-radius: 50px;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: var(--primary-color);
        color: var(--text-color-light);
    }

    /* Section Text */
    .section-heading {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--text-color-light);
        margin-bottom: 20px;
    }

    .section-subheading {
        font-size: 1.25rem;
        color: var(--text-color-light);
        margin-bottom: 40px;
    }

    .text-light {
        color: var(--text-color-light);
    }

    .text-dark {
        color: var(--text-color-dark);
    }


    /* project */

    
  
</style>

    {{-- Page styles --}}
    @stack('styles')

</head>

<body class="antialiased thin-scrollbar">


    {{-- Header --}}
    @includeIf('frontend.partials.header')

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @includeIf('frontend.partials.footer')


    <script src="{{ asset('frontend/js/script.js')}}"></script>
    {{-- Page scripts --}}
    @stack('scripts')
</body>

</html>
