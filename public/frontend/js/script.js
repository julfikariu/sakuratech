document.addEventListener('DOMContentLoaded', () => {
	const revealObserver = new IntersectionObserver((entries) => {
		entries.forEach((e) => {
			if (e.isIntersecting) {
				e.target.classList.add('reveal-visible');
				revealObserver.unobserve(e.target);
			}
		});
	}, { threshold: 0.15, rootMargin: '0px 0px -10% 0px' });
	document.querySelectorAll('[data-reveal]').forEach((el) => revealObserver.observe(el));
});


// Mobile menu, active link, and form handler
document.addEventListener('DOMContentLoaded', () => {
	// Mobile menu
	const menuToggle = document.getElementById('menuToggle');
	const mobileMenu = document.getElementById('mobileMenu');
	if (menuToggle && mobileMenu) {
		menuToggle.addEventListener('click', () => {
			const isOpen = !mobileMenu.classList.contains('hidden');
			mobileMenu.classList.toggle('hidden');
			menuToggle.setAttribute('aria-expanded', String(!isOpen));
		});
		mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
			mobileMenu.classList.add('hidden');
			menuToggle.setAttribute('aria-expanded', 'false');
		}));
	}
	// Active link highlighting on scroll
	const navLinks = Array.from(document.querySelectorAll('nav a[href^="#"]'));
	const sectionIds = ['home', 'about', 'services', 'projects', 'contact'];
	const setActiveLink = () => {
		const offset = 120;
		let current = 'home';
		for (const id of sectionIds) {
			const el = document.getElementById(id);
			if (!el) continue;
			const rect = el.getBoundingClientRect();
			if (rect.top <= offset && rect.bottom >= offset) { current = id; break; }
		}
		navLinks.forEach(link => {
			const href = (link.getAttribute('href') || '').replace('#', '');
			if (href === current) {
				link.classList.add('text-indigo-700', 'nav-link--active');
				link.classList.remove('text-gray-600');
			} else {
				link.classList.remove('text-indigo-700', 'nav-link--active');
				link.classList.add('text-gray-600');
			}
		});
	};
	setActiveLink();
	window.addEventListener('scroll', setActiveLink, { passive: true });
	// Contact form submit (demo)
	const form = document.getElementById('contactForm');
	const formMessage = document.getElementById('formMessage');
	if (form && formMessage) {
		form.addEventListener('submit', async (e) => {
			e.preventDefault();
			const btn = form.querySelector('button[type="submit"]');
			const original = btn.textContent;
			btn.disabled = true;
			btn.classList.add('opacity-50', 'cursor-not-allowed');
			btn.textContent = 'Sending...';
			try {
				await new Promise(r => setTimeout(r, 1200));
				form.reset();
				formMessage.textContent = 'Thank you! Your message has been sent.';
				formMessage.classList.remove('hidden', 'text-red-600');
				formMessage.classList.add('text-green-600');
			} catch (_) {
				formMessage.textContent = 'Sorry, there was an error. Please try again.';
				formMessage.classList.remove('hidden', 'text-green-600');
				formMessage.classList.add('text-red-600');
			} finally {
				btn.disabled = false;
				btn.classList.remove('opacity-50', 'cursor-not-allowed');
				btn.textContent = original;
				setTimeout(() => formMessage.classList.add('hidden'), 4000);
			}
		});
	}
});


// Function to handle dropdown toggle behavior
function toggleDropdown(userBtnId, dropdownMenuId) {
    const userBtn = document.getElementById(userBtnId);
    const dropdownMenu = document.getElementById(dropdownMenuId);

    // Toggle dropdown visibility on button click
    userBtn.addEventListener('click', function (e) {
        dropdownMenu.classList.toggle('hidden');
    });

    // Close dropdown if clicked outside of the button or the dropdown menu
    document.addEventListener('click', function (e) {
        if (!userBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
}

// Usage:
toggleDropdown('language_btn', 'language_dropdown'); 

