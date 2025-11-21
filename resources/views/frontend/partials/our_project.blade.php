<!-- OUR PROJECTS -->
<section id="projects" class="py-20 bg-white">
	<div class="max-w-7xl mx-auto px-6 lg:px-8">

		<!-- Heading -->
		<div class="text-center max-w-3xl mx-auto">
			<p class="text-sm uppercase tracking-widest font-semibold" style="color:#5e17eb">
				Our Projects
			</p>
			<h2 class="mt-2 text-3xl md:text-4xl font-extrabold text-gray-900">
				Recent Work by <span style="color:#5e17eb">Sakura SoftTech</span>
			</h2>
			<p class="mt-3 text-gray-600">
				Explore the products we've crafted, engineered, and scaled using Laravel, cutting-edge front-end technologies, and cloud solutions.
			</p>
		</div>

		<!-- Projects Grid -->
		<div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

			<!-- Card -->
			<article class="group rounded-2xl overflow-hidden bg-gray-50 shadow-sm hover:shadow-xl transition-all">
				<a href="#" aria-label="View Project">
					<div class="relative">
						<!-- Image: AVIF/WebP/PNG with lazy load -->
						<picture>
							<source srcset="{{ asset('img/projects/p1.avif') }}" type="image/avif">
							<source srcset="{{ asset('img/projects/p1.webp') }}" type="image/webp">
							<img src="{{ asset('img/projects/p1.jpg') }}" alt="CommerceHub – ecommerce platform"
								loading="lazy" decoding="async" class="w-full h-full object-cover aspect-[16/10]" />
						</picture>

						<!-- Status chip -->
						<span
							class="absolute top-3 left-3 text-xs font-semibold bg-white/90 text-gray-800 px-2.5 py-1 rounded-full">
							Completed
						</span>

						<!-- Hover overlay -->
						<div
							class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
						</div>
					</div>
				</a>

				<div class="p-6">
					<h3 class="text-lg font-semibold text-gray-900">CommerceHub</h3>
					<p class="mt-1 text-sm text-gray-600">Multi-vendor ecommerce with subscriptions and custom checkout.
					</p>

					<!-- tech badges -->
					<div class="mt-4 flex flex-wrap gap-2">
						<span class="badge">Laravel</span>
						<span class="badge">Livewire</span>
						<span class="badge">MySQL</span>
						<span class="badge">Docker</span>
					</div>

					<!-- actions -->
					<div class="mt-5 flex items-center gap-4">
						<a href="#" class="proj-link">Live Demo</a>
						<a href="#" class="proj-link">GitHub</a>
					</div>
				</div>
			</article>

			<!-- Card -->
			<article class="group rounded-2xl overflow-hidden bg-gray-50 shadow-sm hover:shadow-xl transition-all">
				<a href="#" aria-label="View Project">
					<div class="relative">
						<picture>
							<source srcset="{{ asset('img/projects/p2.avif') }}" type="image/avif">
							<source srcset="{{ asset('img/projects/p2.webp') }}" type="image/webp">
							<img src="{{ asset('img/projects/p2.jpg') }}" alt="ClinicPro – appointment & EMR"
								loading="lazy" decoding="async" class="w-full h-full object-cover aspect-[16/10]" />
						</picture>
						<span
							class="absolute top-3 left-3 text-xs font-semibold bg-white/90 text-gray-800 px-2.5 py-1 rounded-full">
							In Progress
						</span>
						<div
							class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
						</div>
					</div>
				</a>
				<div class="p-6">
					<h3 class="text-lg font-semibold text-gray-900">ClinicPro</h3>
					<p class="mt-1 text-sm text-gray-600">Appointments, EMR and billing for multi-branch clinics.</p>
					<div class="mt-4 flex flex-wrap gap-2">
						<span class="badge">Laravel</span>
						<span class="badge">Vue</span>
						<span class="badge">PostgreSQL</span>
						<span class="badge">AWS</span>
					</div>
					<div class="mt-5 flex items-center gap-4">
						<a href="#" class="proj-link">Case Study</a>
					</div>
				</div>
			</article>

			<!-- Card -->
			<article class="group rounded-2xl overflow-hidden bg-gray-50 shadow-sm hover:shadow-xl transition-all">
				<a href="#" aria-label="View Project">
					<div class="relative">
						<picture>
							<source srcset="{{ asset('img/projects/p3.avif') }}" type="image/avif">
							<source srcset="{{ asset('img/projects/p3.webp') }}" type="image/webp">
							<img src="{{ asset('img/projects/p3.jpg') }}" alt="EduFlow – LMS platform" loading="lazy"
								decoding="async" class="w-full h-full object-cover aspect-[16/10]" />
						</picture>
						<span
							class="absolute top-3 left-3 text-xs font-semibold bg-white/90 text-gray-800 px-2.5 py-1 rounded-full">
							Completed
						</span>
						<div
							class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
						</div>
					</div>
				</a>
				<div class="p-6">
					<h3 class="text-lg font-semibold text-gray-900">EduFlow</h3>
					<p class="mt-1 text-sm text-gray-600">Courses, quizzes, payments and instructor dashboards.</p>
					<div class="mt-4 flex flex-wrap gap-2">
						<span class="badge">Laravel</span>
						<span class="badge">Inertia</span>
						<span class="badge">React</span>
						<span class="badge">Stripe</span>
					</div>
					<div class="mt-5 flex items-center gap-4">
						<a href="#" class="proj-link">Live Demo</a>
					</div>
				</div>
			</article>

			<!-- Card -->
			<article class="group rounded-2xl overflow-hidden bg-gray-50 shadow-sm hover:shadow-xl transition-all">
				<a href="#" aria-label="View Project">
					<div class="relative">
						<picture>
							<source srcset="{{ asset('img/projects/p4.avif') }}" type="image/avif">
							<source srcset="{{ asset('img/projects/p4.webp') }}" type="image/webp">
							<img src="{{ asset('img/projects/p4.jpg') }}" alt="LogiTrack – logistics & tracking"
								loading="lazy" decoding="async" class="w-full h-full object-cover aspect-[16/10]" />
						</picture>
						<span
							class="absolute top-3 left-3 text-xs font-semibold bg-white/90 text-gray-800 px-2.5 py-1 rounded-full">
							Completed
						</span>
						<div
							class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
						</div>
					</div>
				</a>
				<div class="p-6">
					<h3 class="text-lg font-semibold text-gray-900">LogiTrack</h3>
					<p class="mt-1 text-sm text-gray-600">Fleet, route optimization and live shipment tracking.</p>
					<div class="mt-4 flex flex-wrap gap-2">
						<span class="badge">Laravel</span>
						<span class="badge">Redis</span>
						<span class="badge">Maps API</span>
						<span class="badge">Docker</span>
					</div>
					<div class="mt-5 flex items-center gap-4">
						<a href="#" class="proj-link">Case Study</a>
					</div>
				</div>
			</article>

			<!-- Card -->
			<article class="group rounded-2xl overflow-hidden bg-gray-50 shadow-sm hover:shadow-xl transition-all">
				<a href="#" aria-label="View Project">
					<div class="relative">
						<picture>
							<source srcset="{{ asset('img/projects/p5.avif') }}" type="image/avif">
							<source srcset="{{ asset('img/projects/p5.webp') }}" type="image/webp">
							<img src="{{ asset('img/projects/p5.jpg') }}" alt="HRSpace – HR & payroll" loading="lazy"
								decoding="async" class="w-full h-full object-cover aspect-[16/10]" />
						</picture>
						<span
							class="absolute top-3 left-3 text-xs font-semibold bg-white/90 text-gray-800 px-2.5 py-1 rounded-full">
							Completed
						</span>
						<div
							class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
						</div>
					</div>
				</a>
				<div class="p-6">
					<h3 class="text-lg font-semibold text-gray-900">HRSpace</h3>
					<p class="mt-1 text-sm text-gray-600">Attendance, payroll and performance management.</p>
					<div class="mt-4 flex flex-wrap gap-2">
						<span class="badge">Laravel</span>
						<span class="badge">Alpine</span>
						<span class="badge">MySQL</span>
						<span class="badge">S3</span>
					</div>
					<div class="mt-5 flex items-center gap-4">
						<a href="#" class="proj-link">Live Demo</a>
					</div>
				</div>
			</article>

			<!-- Card -->
			<article class="group rounded-2xl overflow-hidden bg-gray-50 shadow-sm hover:shadow-xl transition-all">
				<a href="#" aria-label="View Project">
					<div class="relative">
						<picture>
							<source srcset="{{ asset('img/projects/p6.avif') }}" type="image/avif">
							<source srcset="{{ asset('img/projects/p6.webp') }}" type="image/webp">
							<img src="{{ asset('img/projects/p6.jpg') }}" alt="Eventix – ticketing platform"
								loading="lazy" decoding="async" class="w-full h-full object-cover aspect-[16/10]" />
						</picture>
						<span
							class="absolute top-3 left-3 text-xs font-semibold bg-white/90 text-gray-800 px-2.5 py-1 rounded-full">
							Completed
						</span>
						<div
							class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
						</div>
					</div>
				</a>
				<div class="p-6">
					<h3 class="text-lg font-semibold text-gray-900">Eventix</h3>
					<p class="mt-1 text-sm text-gray-600">Event pages, seat maps and QR-based check-ins.</p>
					<div class="mt-4 flex flex-wrap gap-2">
						<span class="badge">Laravel</span>
						<span class="badge">Vue</span>
						<span class="badge">Stripe</span>
						<span class="badge">Redis</span>
					</div>
					<div class="mt-5 flex items-center gap-4">
						<a href="#" class="proj-link">Case Study</a>
					</div>
				</div>
			</article>

		</div>

		<!-- CTA -->
		<div class="text-center mt-12">
			<a href="#contact"
				class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-white font-semibold shadow-lg transition hover:-translate-y-0.5"
				style="background:#5e17eb">
				Start Your Project <i class="fas fa-arrow-right text-sm"></i>
			</a>
		</div>
	</div>
</section>
