{{-- Footer --}}
<footer class="bg-gray-900 text-gray-300 pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- Company Info -->
            <div>
                <h3 class="text-2xl font-bold text-white mb-4">Sakura SoftTech</h3>
                <p class="text-gray-400 text-sm">
                    We craft high-performance web solutions with Laravel, PHP, and modern DevOps practices.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="hover:text-indigo-500"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-indigo-500"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-indigo-500"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="hover:text-indigo-500"><i class="fab fa-github"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="#home" class="hover:text-indigo-500">Home</a></li>
                    <li><a href="#about" class="hover:text-indigo-500">About</a></li>
                    <li><a href="#services" class="hover:text-indigo-500">Services</a></li>
                    <li><a href="#projects" class="hover:text-indigo-500">Projects</a></li>
                    <li><a href="#contact" class="hover:text-indigo-500">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Our Services</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-indigo-500">Laravel Development</a></li>
                    <li><a href="#" class="hover:text-indigo-500">PHP Solutions</a></li>
                    <li><a href="#" class="hover:text-indigo-500">DevOps & Deployment</a></li>
                    <li><a href="#" class="hover:text-indigo-500">UI/UX Design</a></li>
                    <li><a href="#" class="hover:text-indigo-500">Cloud Hosting</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Get in Touch</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-map-marker-alt mt-1 text-indigo-500"></i>
                        <span>123 Sakura Street, Dhaka, Bangladesh</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-phone-alt mt-1 text-indigo-500"></i>
                        <span>+880 1234 567 890</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-envelope mt-1 text-indigo-500"></i>
                        <span>info@sakurait.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-500">
            <p>© <span id="year">{{ date('Y')}}</span> Sakura SoftTech. All rights reserved.</p>
        </div>
    </div>
</footer>