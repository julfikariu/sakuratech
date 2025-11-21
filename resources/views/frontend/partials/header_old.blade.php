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
                <div class="h-6 w-px bg-gray-200 mx-2"></div>
                @php
                    $locale = session('locale', 'en');
                @endphp
                <!-- Language Dropdown -->
                <div class="relative">
                    <button id="language_btn" type="button"
                        class="inline-flex items-center gap-2 text-sm text-gray-700 hover:text-indigo-700 font-medium focus:outline-none rounded-md py-1 focus-visible:ring-2 focus-visible:ring-indigo-500"
                        aria-haspopup="menu" aria-expanded="false" aria-label="Select language">

                        {{-- Current flag --}}
                        @if ($locale === 'ja')
                            {{-- Japan Flag --}}
                            <svg class="h-3.5 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12">
                                <rect width="16" height="12" fill="#fff" />
                                <circle cx="8" cy="6" r="3" fill="#BC002D" />
                            </svg>
                            <span>JA</span>
                        @elseif ($locale === 'bn')
                            {{-- Bangladesh Flag --}}
                            <svg class="h-3.5 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12">
                                <rect width="16" height="12" fill="#006a4e" />
                                <circle cx="7" cy="6" r="3.2" fill="#F42A41" />
                            </svg>
                            <span>BN</span>
                        @else
                            {{-- Default English Flag --}}
                            <svg class="h-3 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12">
                                <rect width="16" height="12" fill="#fff" />
                                <g fill="#B22234">
                                    <rect width="16" height="1.2" y="0" />
                                    <rect width="16" height="1.2" y="2.4" />
                                    <rect width="16" height="1.2" y="4.8" />
                                    <rect width="16" height="1.2" y="7.2" />
                                    <rect width="16" height="1.2" y="9.6" />
                                </g>
                                <rect width="7" height="4.8" fill="#3C3B6E" />
                            </svg>
                            <span>EN</span>
                        @endif

                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>

                    {{-- Dropdown menu --}}
                    <div id="language_dropdown"
                        class="absolute right-0 top-12 w-20 bg-white border border-gray-100 rounded-md shadow-lg py-1 hidden overflow-hidden"
                        role="menu" aria-label="Language menu">

                        @if ($locale !== 'ja')
                            <a href="{{ route('change.language', 'ja') }}"
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                                role="menuitem">
                                <svg class="h-3.5 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12">
                                    <rect width="16" height="12" fill="#fff" />
                                    <circle cx="8" cy="6" r="3" fill="#BC002D" />
                                </svg>
                                <span>JA</span>
                            </a>
                        @endif

                        @if ($locale !== 'bn')
                            <a href="{{ route('change.language', 'bn') }}"
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                                role="menuitem">
                                <svg class="h-3.5 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12">
                                    <rect width="16" height="12" fill="#006a4e" />
                                    <circle cx="7" cy="6" r="3.2" fill="#F42A41" />
                                </svg>
                                <span>BN</span>
                            </a>
                        @endif

                        @if ($locale !== 'en')
                            <a href="{{ route('change.language', 'en') }}"
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                                role="menuitem">
                                <svg class="h-3 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12">
                                    <rect width="16" height="12" fill="#fff" />
                                    <g fill="#B22234">
                                        <rect width="16" height="1.2" y="0" />
                                        <rect width="16" height="1.2" y="2.4" />
                                        <rect width="16" height="1.2" y="4.8" />
                                        <rect width="16" height="1.2" y="7.2" />
                                        <rect width="16" height="1.2" y="9.6" />
                                    </g>
                                    <rect width="7" height="4.8" fill="#3C3B6E" />
                                </svg>
                                <span>EN</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <a href="#contact" class="get-started-btn text-white">
                <span>Get Started</span>
                <i class="fas fa-arrow-right"></i>
            </a>
            <button id="menuToggle" class="md:hidden text-gray-600 hover:text-indigo-700" aria-expanded="false"
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
            <div class="pt-2">
                <label for="langSelectMobile" class="sr-only">Language</label>
                <!-- Mobile Language Dropdown (design only) -->
                <div class="relative group mt-2">
                    <button type="button"
                        class="w-full justify-between inline-flex items-center gap-3 text-gray-700 hover:text-indigo-700 font-medium focus:outline-none rounded-md px-3 py-2 border border-gray-200 focus-visible:ring-2 focus-visible:ring-indigo-500"
                        aria-haspopup="menu" aria-expanded="false" aria-label="Select language">
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-3.5 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12"
                                aria-hidden="true">
                                <rect width="16" height="12" fill="#fff" />
                                <g fill="#B22234">
                                    <rect width="16" height="1.2" y="0" />
                                    <rect width="16" height="1.2" y="2.4" />
                                    <rect width="16" height="1.2" y="4.8" />
                                    <rect width="16" height="1.2" y="7.2" />
                                    <rect width="16" height="1.2" y="9.6" />
                                </g>
                                <rect width="7" height="4.8" fill="#3C3B6E" />
                            </svg>
                            <span>English</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-md shadow-lg py-1 hidden group-hover:block group-focus-within:block"
                        role="menu" aria-label="Language menu">
                        <a href="#" data-lang="en"
                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                            role="menuitem">
                            <svg class="h-3.5 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12"
                                aria-hidden="true">
                                <rect width="16" height="12" fill="#fff" />
                                <g fill="#B22234">
                                    <rect width="16" height="1.2" y="0" />
                                    <rect width="16" height="1.2" y="2.4" />
                                    <rect width="16" height="1.2" y="4.8" />
                                    <rect width="16" height="1.2" y="7.2" />
                                    <rect width="16" height="1.2" y="9.6" />
                                </g>
                                <rect width="7" height="4.8" fill="#3C3B6E" />
                            </svg>
                            <span>English</span>
                        </a>
                        <a href="#" data-lang="ja"
                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                            role="menuitem">
                            <svg class="h-3.5 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12"
                                aria-hidden="true">
                                <rect width="16" height="12" fill="#fff" />
                                <circle cx="8" cy="6" r="3" fill="#BC002D" />
                            </svg>
                            <span>Japanese</span>
                        </a>
                        <a href="#" data-lang="bn"
                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700"
                            role="menuitem">
                            <svg class="h-3.5 w-5 rounded-sm ring-1 ring-gray-200" viewBox="0 0 16 12"
                                aria-hidden="true">
                                <rect width="16" height="12" fill="#006a4e" />
                                <circle cx="7" cy="6" r="3.2" fill="#F42A41" />
                            </svg>
                            <span>Bangla</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
