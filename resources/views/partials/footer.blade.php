    <!-- Footer -->
    <footer class="om-background text-pure-white">
        <div class="container max-w-7xl mx-auto px-6 py-12">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Brand Column -->
                <div class="lg:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/logo-divine-raksha.webp') }}" alt="Divine Raksha Logo" class="h-16 w-auto mr-3">
                       
                    </div>
                    <p class="text-pure-white/80 mb-6 max-w-md leading-relaxed">
                        {{ setting('site_description', 'Rooted in the sacred traditions of Sanatana Dharma, Divine Raksha offers authentic spiritual protection, divine guidance, and sacred artifacts to nurture your spiritual journey with timeless wisdom.') }}
                    </p>
                    <div class="flex space-x-4">
                        <a href="{{ setting('social_facebook', '#') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300" target="_blank">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="{{ setting('social_instagram', '#') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300" target="_blank">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="{{ setting('social_youtube', '#') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300" target="_blank">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Shop By -->
                <div>
                    <h3 class="text-lg font-venlury font-semibold text-sacred-gold mb-4">Shop By</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('shop.purpose') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">Shop by Purpose</a></li>
                        <li><a href="{{ route('shop.raashi') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">Shop by Raashi</a></li>
                        <li><a href="{{ route('shop.numerology') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">Shop by Numerology</a></li>
                        <li><a href="{{ route('shop.bestsellers') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">Bestsellers</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">All Products</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h3 class="text-lg font-venlury font-semibold text-sacred-gold mb-4">Company</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">About Us</a></li>
                        <li><a href="{{ route('blogs.index') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">Blog</a></li>
                        <li><a href="{{ route('contact') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">Contact Us</a></li>
                    </ul>

                    <h3 class="text-lg font-venlury font-semibold text-sacred-gold mb-4 mt-6">Help</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('order.track') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">Track My Order</a></li>

                        <li><a href="{{ route('faq') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">FAQ</a></li>
                        <li><a href="{{ route('care-instructions') }}" class="text-pure-white/80 hover:text-sacred-gold transition-colors duration-300">Care Instructions</a></li>
                    </ul>
                </div>
            </div>

      

            <!-- Bottom Footer -->
            <div class="border-t border-pure-white/20 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-pure-white/60 text-sm">
                        <p>© {{ date('Y') }} {{ setting('site_name', 'Divine Raksha') }}. All rights reserved. | Rooted in Sanatana Dharma</p>
                        <p class="mt-1">Powered with devotion by <a href="https://www.obiikriationz.com" target="_blank" class="text-sacred-gold hover:text-white transition-colors duration-300">Obii Kriationz Web LLP</a></p>
                    </div>
                    <div class="flex flex-wrap justify-center md:justify-end gap-x-6 gap-y-2 text-sm">
                        <a href="{{ route('privacy') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300">Privacy Policy</a>
                        <a href="{{ route('terms') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300">Terms of Use</a>
                        <a href="{{ route('return-policy') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300">Return Policy</a>
                        <a href="{{ route('disclaimer') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300">Disclaimer</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Slide-out Menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeMenuBtn = document.getElementById('close-menu-btn');
            const menuBackdrop = document.getElementById('menu-backdrop');
            
            function openMenu() {
                // Show overlay
                mobileMenuOverlay.classList.remove('hidden');
                
                // Trigger slide animation
                setTimeout(() => {
                    mobileMenu.classList.remove('translate-x-full');
                    mobileMenu.classList.add('translate-x-0');
                }, 10);
                
                // Prevent body scroll
                document.body.style.overflow = 'hidden';
                
                // Update button icon to X
                mobileMenuButton.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                `;
            }
            
            function closeMenu() {
                // Hide menu with animation
                mobileMenu.classList.remove('translate-x-0');
                mobileMenu.classList.add('translate-x-full');
                
                // Hide overlay after animation
                setTimeout(() => {
                    mobileMenuOverlay.classList.add('hidden');
                }, 300);
                
                // Restore body scroll
                document.body.style.overflow = '';
                
                // Reset button icon to hamburger
                mobileMenuButton.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                `;
            }
            
            // Open menu when hamburger button is clicked
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (mobileMenuOverlay.classList.contains('hidden')) {
                        openMenu();
                    } else {
                        closeMenu();
                    }
                });
            }
            
            // Close menu when X button is clicked
            if (closeMenuBtn) {
                closeMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeMenu();
                });
            }
            
            // Close menu when backdrop is clicked
            if (menuBackdrop) {
                menuBackdrop.addEventListener('click', function() {
                    closeMenu();
                });
            }
            
            // Close menu when clicking on navigation links
            if (mobileMenu) {
                const menuLinks = mobileMenu.querySelectorAll('nav a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        closeMenu();
                    });
                });
            }
            
            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !mobileMenuOverlay.classList.contains('hidden')) {
                    closeMenu();
                }
            });
            
            // Handle window resize - close menu if screen becomes large
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024 && !mobileMenuOverlay.classList.contains('hidden')) {
                    closeMenu();
                }
            });
        });
    </script>
    <!-- Cart Toast Notification -->
    <div id="cart-toast" class="fixed top-6 right-6 z-[9999] pointer-events-none" style="max-width:360px; transform: translateX(120%); transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 flex items-center gap-4 pointer-events-auto">
            <div id="cart-toast-img" class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                <img src="" alt="" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-0.5">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-xs font-semibold text-green-600">Added to Cart</span>
                </div>
                <p id="cart-toast-title" class="text-sm font-semibold text-gray-900 truncate"></p>
                <p id="cart-toast-meta" class="text-xs text-gray-500"></p>
            </div>
            <a href="{{ route('cart.index') }}" class="flex-shrink-0 px-3 py-1.5 bg-royal-blue text-white text-xs font-semibold rounded-full hover:bg-deep-royal transition-colors">
                View Cart
            </a>
        </div>
    </div>

    <script>
        function updateCartBadge(count) {
            const badge = document.getElementById('cart-count');
            if (!badge) return;

            badge.textContent = count;
            badge.style.display = 'flex';
            badge.classList.remove('hidden');
            badge.style.animation = 'none';
            void badge.offsetHeight;
            badge.style.animation = 'badgePop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards';
        }

        function bounceCartIcon() {
            const icon = document.getElementById('header-cart-icon');
            if (!icon) return;

            icon.style.animation = 'none';
            void icon.offsetHeight;
            icon.style.animation = 'cartBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)';
            icon.classList.add('cart-glow');
            setTimeout(() => icon.classList.remove('cart-glow'), 800);
        }

        // Burst of sparkle particles at a position
        function spawnParticles(x, y, count) {
            const colors = ['#d4af37', '#1e3a8a', '#22c55e', '#f59e0b', '#ffffff'];
            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                const size = Math.random() * 6 + 3;
                const angle = (Math.PI * 2 * i) / count + (Math.random() - 0.5) * 0.5;
                const dist = Math.random() * 50 + 30;
                const tx = Math.cos(angle) * dist;
                const ty = Math.sin(angle) * dist;
                p.style.cssText = `
                    position:fixed; z-index:10001; pointer-events:none;
                    left:${x - size/2}px; top:${y - size/2}px;
                    width:${size}px; height:${size}px;
                    background:${colors[i % colors.length]};
                    border-radius:50%;
                    opacity:1;
                `;
                document.body.appendChild(p);
                p.animate([
                    { transform: 'translate(0,0) scale(1)', opacity: 1 },
                    { transform: `translate(${tx}px,${ty}px) scale(0)`, opacity: 0 }
                ], { duration: 600 + Math.random() * 300, easing: 'cubic-bezier(0,.9,.3,1)', fill: 'forwards' });
                setTimeout(() => p.remove(), 1000);
            }
        }

        // Ripple ring at a position
        function spawnRipple(x, y) {
            const ring = document.createElement('div');
            ring.style.cssText = `
                position:fixed; z-index:10001; pointer-events:none;
                left:${x - 20}px; top:${y - 20}px;
                width:40px; height:40px;
                border: 3px solid #d4af37;
                border-radius:50%;
            `;
            document.body.appendChild(ring);
            ring.animate([
                { transform: 'scale(0.5)', opacity: 0.8 },
                { transform: 'scale(3.5)', opacity: 0 }
            ], { duration: 600, easing: 'ease-out', fill: 'forwards' });
            setTimeout(() => ring.remove(), 650);
        }

        function showCartToast(title, image, qty, count) {
            const toast = document.getElementById('cart-toast');
            const toastImg = document.querySelector('#cart-toast-img img');
            const toastTitle = document.getElementById('cart-toast-title');
            const toastMeta = document.getElementById('cart-toast-meta');

            toastTitle.textContent = title;
            toastMeta.textContent = 'Qty: ' + qty + ' · ' + count + ' item' + (count > 1 ? 's' : '') + ' in cart';
            if (image) toastImg.src = image;

            // Delay badge + bounce so it syncs with flying image landing
            setTimeout(() => {
                updateCartBadge(count);
                bounceCartIcon();

                // Particles + ripple at cart icon
                const cartIcon = document.getElementById('header-cart-icon');
                if (cartIcon) {
                    const r = cartIcon.getBoundingClientRect();
                    const cx = r.left + r.width / 2;
                    const cy = r.top + r.height / 2;
                    spawnParticles(cx, cy, 12);
                    spawnRipple(cx, cy);
                }
            }, 600);

            // Slide toast in
            toast.style.transform = 'translateX(0)';
            clearTimeout(window._cartToastTimer);
            window._cartToastTimer = setTimeout(() => {
                toast.style.transform = 'translateX(120%)';
            }, 3500);
        }

        function flyToCart(buttonEl, imgSrc) {
            const cartIcon = document.getElementById('header-cart-icon');
            if (!cartIcon || !buttonEl) return;

            const btnRect = buttonEl.getBoundingClientRect();
            const cartRect = cartIcon.getBoundingClientRect();

            const startX = btnRect.left + btnRect.width / 2 - 30;
            const startY = btnRect.top - 5;
            const endX = cartRect.left + cartRect.width / 2 - 10;
            const endY = cartRect.top + cartRect.height / 2 - 10;

            // --- Sparkles at button origin ---
            spawnParticles(btnRect.left + btnRect.width / 2, btnRect.top + btnRect.height / 2, 8);

            // --- Flying product thumbnail ---
            const flyer = document.createElement('div');
            flyer.style.cssText = `
                position:fixed; z-index:10000; pointer-events:none;
                left:${startX}px; top:${startY}px;
                width:60px; height:60px;
                border-radius:14px; overflow:hidden;
                box-shadow: 0 10px 40px rgba(30,58,138,0.5), 0 0 0 3px #d4af37;
            `;
            if (imgSrc) {
                const img = document.createElement('img');
                img.src = imgSrc;
                img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
                flyer.appendChild(img);
            } else {
                flyer.style.background = '#1e3a8a';
                flyer.innerHTML = '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center"><svg width="28" height="28" fill="#d4af37" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.17 14.75l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0020 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.45A2 2 0 007 16h12v-2H7.42c-.14 0-.25-.11-.25-.25z"/></svg></div>';
            }
            document.body.appendChild(flyer);

            // --- Trail dots behind the flyer ---
            const dx = endX - startX;
            const dy = endY - startY;
            const duration = 700;
            let trailInterval = setInterval(() => {
                const cur = flyer.getBoundingClientRect();
                const dot = document.createElement('div');
                const s = Math.random() * 5 + 2;
                dot.style.cssText = `
                    position:fixed; z-index:9999; pointer-events:none;
                    left:${cur.left + cur.width/2 - s/2}px;
                    top:${cur.top + cur.height/2 - s/2}px;
                    width:${s}px; height:${s}px;
                    background:#d4af37; border-radius:50%; opacity:0.7;
                `;
                document.body.appendChild(dot);
                dot.animate([
                    { opacity: 0.7, transform: 'scale(1)' },
                    { opacity: 0, transform: 'scale(0)' }
                ], { duration: 400, fill: 'forwards' });
                setTimeout(() => dot.remove(), 450);
            }, 40);

            // --- Curved flight path ---
            flyer.animate([
                {
                    left: startX + 'px', top: startY + 'px',
                    width: '60px', height: '60px',
                    opacity: 1, borderRadius: '14px',
                    offset: 0
                },
                {
                    left: (startX + dx * 0.25) + 'px',
                    top: (Math.min(startY, endY) - 100) + 'px',
                    width: '50px', height: '50px',
                    opacity: 1, borderRadius: '50%',
                    offset: 0.35
                },
                {
                    left: (startX + dx * 0.7) + 'px',
                    top: (endY - 40) + 'px',
                    width: '35px', height: '35px',
                    opacity: 0.8, borderRadius: '50%',
                    offset: 0.7
                },
                {
                    left: endX + 'px', top: endY + 'px',
                    width: '20px', height: '20px',
                    opacity: 0, borderRadius: '50%',
                    offset: 1
                }
            ], {
                duration: duration,
                easing: 'cubic-bezier(0.22, 1, 0.36, 1)',
                fill: 'forwards'
            });

            setTimeout(() => {
                clearInterval(trailInterval);
                flyer.remove();
            }, duration + 50);
        }
    </script>
</body>
</html>
