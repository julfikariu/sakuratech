<!-- Navigation -->
<nav class="bg-white backdrop-blur-md shadow-lg fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto py-3">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-indigo-800 to-purple-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-code text-white text-lg"></i>
                </div>
                <span class="text-2xl font-bold text-gray-800">Sakura SoftTech</span>
            </div>
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#home"
                    class="nav-link text-gray-600 hover:text-indigo-700 font-medium transition-colors duration-300"
                    data-i18n="nav.home">Home</a>
                <a href="#about"
                    class="nav-link text-gray-600 hover:text-indigo-700 font-medium transition-colors duration-300"
                    data-i18n="nav.about">About</a>
                <a href="#services"
                    class="nav-link text-gray-600 hover:text-indigo-700 font-medium transition-colors duration-300"
                    data-i18n="nav.services">Services</a>
                <a href="#projects"
                    class="nav-link text-gray-600 hover:text-indigo-700 font-medium transition-colors duration-300"
                    data-i18n="nav.projects">Projects</a>
                <a href="#contact"
                    class="nav-link text-gray-600 hover:text-indigo-700 font-medium transition-colors duration-300"
                    data-i18n="nav.contact">Contact</a>
                
            </div>
            <a href="{{ route('login') }}" class="get-started-btn text-white">
                <span>Get Started</span>
                <i class="fas fa-arrow-right"></i>
            </a>
            <button id="menuToggle" class="md:hidden text-gray-600 hover:text-red-700" aria-expanded="false"
                aria-controls="mobileMenu">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden mt-4 pb-4 hidden">
            <a href="#home"
                class="nav-link block text-gray-600 hover:text-indigo-700 font-medium py-2 transition-colors duration-300"
                data-i18n="nav.home">Home</a>
            <a href="#about"
                class="nav-link block text-gray-600 hover:text-indigo-700 font-medium py-2 transition-colors duration-300"
                data-i18n="nav.about">About</a>
            <a href="#services"
                class="nav-link block text-gray-600 hover:text-indigo-700 font-medium py-2 transition-colors duration-300"
                data-i18n="nav.services">Services</a>
            <a href="#projects"
                class="nav-link block text-gray-600 hover:text-indigo-700 font-medium py-2 transition-colors duration-300"
                data-i18n="nav.projects">Projects</a>
            <a href="#contact"
                class="nav-link block text-gray-600 hover:text-indigo-700 font-medium py-2 transition-colors duration-300"
                data-i18n="nav.contact">Contact</a>
        </div>
    </div>
</nav>
