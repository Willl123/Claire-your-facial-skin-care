<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CLAIRE | Your Facial Skin Care</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nanum+Myeongjo:wght@700&family=Raleway:wght@300;400;500;700;800&display=swap"
        rel="stylesheet" />
    <!-- Link CSS -->

    <!-- Tambahan: Tailwind CSS CDN untuk mengaktifkan class pop-up modal -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Konfigurasi warna kustom Claire agar sesuai dengan tema brand Anda
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        claireGreen: '#2C4A3E',
                        /* Sesuaikan dengan kode warna hijau utama Anda */
                        claireDark: '#1A2E25',
                        claireGold: '#D4AF37',
                        claireLight: '#F7F9F8',
                    }
                }
            }
        }
    </script>

    <!-- Tailwind pop up  --------------------->


    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    <header>
        <div class="header-container">
            <a href="/">
                <h1 class="nama_brand">CLAIRE</h1>
            </a>
            <nav id="navbar">
                <a href="#">HOME PAGE</a>
                <a href="#new-launch">NEW LAUNCH</a>
                <a href="#treatment-section">TREATMENTS</a>
                <a href="#">OUR BLOGS</a>

                @guest
                <a href="{{ route('login') }}" class="sign-in">Sign In</a>
                @endguest
            </nav>
            <!-- @guest
            <a href="/login" class="sign-in">
                Sign In
            </a>
            @endguest -->

            @auth

            <div class="header-right">

                <div class="icons">

                    <!-- NOTIFICATION -->
                    <i class="fa-solid fa-bell" id="notifBtn"></i>

                    <!-- SEARCH -->
                    <i class="fa-solid fa-magnifying-glass"></i>

                    <!-- PROFILE -->
                    <a href="/profile">
                        <i class="fa-solid fa-user"></i>
                    </a>

                    <!-- CART -->
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>

            </div>
            <!-- SIDEBAR NOTIF -->
            <div class="notif-panel" id="notifPanel">

                <div class="notif-header">
                    <h4>Notifikasi</h4>
                    <i class="fa-solid fa-xmark" id="closeNotif"></i>
                </div>

                <div class="notif-body">

                    @forelse($notifications as $b)
                    <a href="/notifications" class="notif-item">

                        <div>
                            <strong>{{ $b->treatment }}</strong>
                            <p>{{ $b->booking_date }} • {{ $b->booking_time }}</p>
                        </div>

                        <span class="status {{ $b->status }}">
                            {{ ucfirst($b->status) }}
                        </span>

                    </a>

                    @empty
                    <p class="empty">Tidak ada notifikasi</p>
                    @endforelse

                </div>

                <a href="/notifications" class="see-all">
                    Lihat Semua Notifikasi
                </a>

            </div>

            @endauth
            <div class="hamburger" id="hamburger">☰</div>
        </div>
    </header>

    <main>
        <!-- SECTION AWAL / HERO -->
        <section class="awal">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="fitur-group">
                    <div class="badge">
                        <span class="bulat"></span>
                        <span>GLOW WITH CONFIDENCE</span>
                    </div>
                    <div class="badge desktop-only">
                        <span class="bulat"></span>
                        <span>FAST HANDLING</span>
                    </div>
                    <div class="badge desktop-only">
                        <span class="bulat"></span>
                        <span>MORE CONFIDENT</span>
                    </div>
                </div>

                <h2>YOUR FACIAL SKIN CARE</h2>
                <p class="motivasi">Discover our new collection</p>

                <div class="counter-stats">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Treatments</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="stat-number">15,000+</span>
                        <span class="stat-label">Products Sold</span>
                    </div>
                </div>
            </div>

            <div class="hero-image">
                <img src="asset/spa-skincare-beauty-asian-woman-drying-hair-with-towel-head-after-shower-treatment-beautiful-multiracial-young-girl-touching-soft-skin.jpg"
                    alt="Skincare Hero Image" />
            </div>
        </section>

        @auth
        <div class="fab-container">

            <button class="fab-main" onclick="toggleFab()">
                <i class="fa-solid fa-plus"></i>
            </button>

            <a href="/notifications" class="fab-item notification">
                <i class="fa-solid fa-bell"></i>
            </a>

            <a href="/search" class="fab-item search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>

            <a href="/profile" class="fab-item profile">
                <i class="fa-solid fa-user"></i>
            </a>

            <a href="/cart" class="fab-item cart">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>

        </div>
        @endauth

        <!-- Bagian Review Customer -->
        <section class="reviews-section">
            <div class="reviews-container">
                <h2 class="section-title reveal">What Our Customers Say</h2>

                <div class="reviews-grid" id="reviewGrid">
                    <!-- Card 1 -->
                    <div class="review-card reveal">
                        <div class="user-info">
                            <i class="fa-solid fa-circle-user profile-icon"></i>
                            <div>
                                <p class="user-name">Sarah Jenkins</p>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="review-text">"The products are incredible! My skin looks much brighter after only 2
                            weeks of routine use."</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="review-card reveal">
                        <div class="user-info">
                            <i class="fa-solid fa-circle-user profile-icon"></i>
                            <div>
                                <p class="user-name">Amanda Putri</p>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star-half-stroke"></i>
                                </div>
                            </div>
                        </div>
                        <p class="review-text">"The texture is very lightweight and absorbs quickly. It’s perfect for my
                            oily skin type."</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="review-card reveal">
                        <div class="user-info">
                            <i class="fa-solid fa-circle-user profile-icon"></i>
                            <div>
                                <p class="user-name">Rian Hidayat</p>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="review-text">"Bought this as a gift for my wife and she absolutely loves it. The
                            packaging feels very premium."</p>
                    </div>

                    <!-- Card 4 -->
                    <div class="review-card reveal">
                        <div class="user-info">
                            <i class="fa-solid fa-circle-user profile-icon"></i>
                            <div>
                                <p class="user-name">Jessica Lee</p>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="review-text">"Never regret subscribing to Claire. Fast service and the products
                            always arrive in safe condition."</p>
                    </div>

                    <!-- Card 5 -->
                    <div class="review-card reveal">
                        <div class="user-info">
                            <i class="fa-solid fa-circle-user profile-icon"></i>
                            <div>
                                <p class="user-name">Budi Santoso</p>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-regular fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="review-text">"The face wash is very gentle; it doesn't leave my skin feeling dry or
                            tight after washing."</p>
                    </div>

                    <!-- Card 6 -->
                    <div class="review-card reveal">
                        <div class="user-info">
                            <i class="fa-solid fa-circle-user profile-icon"></i>
                            <div>
                                <p class="user-name">Nadia Vega</p>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="review-text">"The serum is the winner! My stubborn old acne scars have finally faded
                            significantly."</p>
                    </div>
                </div>

                <div class="review-dots" id="new-launch">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                </div>
            </div>
        </section>


        <section class="promo">
            <div class="promo-wrapper">
                <div class="image-box left">
                    <img src="asset/pexels-monirathnak-15108320.jpg" alt="Skincare Promo" />
                </div>

                <div class="content">
                    <p class="subtitle">Special Saving</p>
                    <h2>Summer Glow Deals</h2>
                    <p class="desc">Get 50% off - Limited Time Offer!</p>

                    <div class="countdown">
                        <div class="time-unit">
                            <h1 id="days">3</h1>
                            <span>Days</span>
                        </div>
                        <div class="separator">:</div>

                        <div class="time-unit">
                            <h1 id="hours">9</h1>
                            <span>Hours</span>
                        </div>
                        <div class="separator">:</div>

                        <div class="time-unit">
                            <h1 id="minutes">11</h1>
                            <span>Mins</span>
                        </div>
                        <div class="separator">:</div>

                        <div class="time-unit">
                            <h1 id="seconds">02</h1>
                            <span>Secs</span>
                        </div>
                    </div>

                    <button class="btn-promo">MORE INFO</button>
                </div>

                <div class="image-box right">
                    <img src="asset/pexels-monirathnak-15108320.jpg" alt="Skincare Promo" />
                </div>
            </div>
        </section>


        <!-- SECTION TREATMENTS -->
        <!-- SECTION TREATMENTS (KATALOG UTAMA) -->
        <section class="treatment-section" id="treatment-section">
            <div class="treatment-container">
                <h2 class="section-title">Our Signature Treatments</h2>

                <div class="treatment-grid">
                    <!-- Treatment 1: Deep Cleansing Facial -->
                    <div class="treatment-card">
                        <div class="treatment-img">
                            <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=2070"
                                alt="Facial Therapy">
                        </div>
                        <div class="treatment-info">
                            <h3>Deep Cleansing Facial</h3>
                            <p>A deep cleanse to remove impurities and blackheads, leaving your skin refreshed.</p>
                            <button class="btn-treatment" onclick="openModal('deep-cleansing')">MORE INFO</button>
                        </div>
                    </div>

                    <!-- Treatment 2: Glow Brightening -->
                    <div class="treatment-card">
                        <div class="treatment-img">
                            <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=2070"
                                alt="Brightening">
                        </div>
                        <div class="treatment-info">
                            <h3>Glow Brightening</h3>
                            <p>A special treatment to brighten dull skin and even out skin tone instantly.</p>
                            <button class="btn-treatment" onclick="openModal('glow-brightening')">MORE INFO</button>
                        </div>
                    </div>

                    <!-- Treatment 3: Anti-Aging Therapy -->
                    <div class="treatment-card">
                        <div class="treatment-img">
                            <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?q=80&w=2070"
                                alt="Anti Aging">
                        </div>
                        <div class="treatment-info">
                            <h3>Anti-Aging Therapy</h3>
                            <p>Reduce fine lines and improve skin elasticity with our latest technology.</p>
                            <button class="btn-treatment" onclick="openModal('anti-aging')">MORE INFO</button>
                        </div>
                    </div>

                    <!-- Treatment 4: Acne Clear Solution -->
                    <div class="treatment-card">
                        <div class="treatment-img">
                            <img src="https://images.unsplash.com/photo-1596755389378-c31d21fd1273?q=80&w=1976"
                                alt="Acne Care">
                        </div>
                        <div class="treatment-info">
                            <h3>Acne Clear Solution</h3>
                            <p>Intensive care for acne-prone skin that helps fade stubborn acne scars.</p>
                            <button class="btn-treatment" onclick="openModal('acne-clear')">MORE INFO</button>
                        </div>
                    </div>

                    <!-- Treatment 5: Hydro-Boost Therapy -->
                    <div class="treatment-card">
                        <div class="treatment-img">
                            <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=2070"
                                alt="Hydration">
                        </div>
                        <div class="treatment-info">
                            <h3>Hydro-Boost Therapy</h3>
                            <p>Restore your skin's natural moisture for a plump and healthy appearance.</p>
                            <button class="btn-treatment" onclick="openModal('hydro-boost')">MORE INFO</button>
                        </div>
                    </div>

                    <!-- Treatment 6: Laser Rejuvenation -->
                    <div class="treatment-card">
                        <div class="treatment-img">
                            <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?q=80&w=1974"
                                alt="Laser">
                        </div>
                        <div class="treatment-info">
                            <h3>Laser Rejuvenation</h3>
                            <p>Laser technology to improve skin texture and reduce the appearance of large pores.</p>
                            <button class="btn-treatment" onclick="openModal('laser-rejuvenation')">MORE INFO</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- KUMPULAN BOX POP-UP MODAL (AWALNYA TERSEMBUNYI)          -->
        <!-- ======================================================== -->

        <!-- 1. POP-UP: DEEP CLEANSING FACIAL -->
        <div id="modal-deep-cleansing"
            class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
            <div
                class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] overflow-y-auto shadow-2xl relative flex flex-col">
                <button onclick="closeModal('deep-cleansing')"
                    class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur shadow flex items-center justify-center text-gray-600 hover:text-claireDark transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div>
                    <div class="relative h-48 sm:h-56 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=2070"
                            alt="Deep Cleansing Facial" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end p-6">
                            <div>
                                <span
                                    class="inline-block bg-claireGold text-white text-[10px] tracking-widest uppercase px-2.5 py-1 rounded-full font-medium mb-2">Signature
                                    Facial</span>
                                <h3 class="text-2xl sm:text-3xl font-serif text-white">Deep Cleansing Facial</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-5">
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Estimasi
                                    Durasi</span>
                                <span class="text-sm font-medium text-claireGreen flex items-center mt-1 gap-1.5">60
                                    Menit</span>
                            </div>
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Investasi
                                    Layanan</span>
                                <span class="text-sm font-semibold text-claireGreen flex items-center mt-1 gap-1">Rp
                                    250.000</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs uppercase tracking-widest text-claireGold font-semibold mb-2">Tentang
                                Perawatan</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Perawatan esensial mendalam
                                yang dirancang khusus untuk membersihkan pori-pori secara menyeluruh. Sangat efektif
                                untuk mengangkat komedo, mengevakuasi sebum berlebih, dan mengangkat sel kulit mati yang
                                menumpuk akibat polusi sehari-hari.</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl">
                            <h4 class="text-xs uppercase tracking-widest text-claireGreen font-semibold mb-1.5">Sesuai
                                Untuk Jenis Kulit:</h4>
                            <p class="text-xs text-gray-600">Kulit berminyak, rentan berkomedo, pori-pori besar, kulit
                                kusam, dan kombinasi.</p>
                        </div>
                        <a href="/booking" onclick="closeModal('deep-cleansing')"
                            class="block w-full bg-claireGreen text-white text-center text-xs tracking-widest font-medium uppercase py-3.5 rounded-full shadow-lg transition-all duration-300 hover:bg-claireDark">
                            BOOKING
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. POP-UP: GLOW BRIGHTENING -->
        <div id="modal-glow-brightening"
            class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
            <div
                class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] overflow-y-auto shadow-2xl relative flex flex-col">
                <button onclick="closeModal('glow-brightening')"
                    class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur shadow flex items-center justify-center text-gray-600 hover:text-claireDark transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div>
                    <div class="relative h-48 sm:h-56 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=2070"
                            alt="Glow Brightening" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end p-6">
                            <div>
                                <span
                                    class="inline-block bg-claireGold text-white text-[10px] tracking-widest uppercase px-2.5 py-1 rounded-full font-medium mb-2">Radiance
                                    Glow</span>
                                <h3 class="text-2xl sm:text-3xl font-serif text-white">Glow Brightening</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-5">
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Estimasi
                                    Durasi</span>
                                <span class="text-sm font-medium text-claireGreen flex items-center mt-1 gap-1.5">75
                                    Menit</span>
                            </div>
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Investasi
                                    Layanan</span>
                                <span class="text-sm font-semibold text-claireGreen flex items-center mt-1 gap-1">Rp
                                    320.000</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs uppercase tracking-widest text-claireGold font-semibold mb-2">Tentang
                                Perawatan</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Solusi terbaik untuk
                                mentransformasikan kulit kusam menjadi bercahaya seketika. Menggunakan kombinasi infus
                                vitamin C konsentrasi tinggi dan masker antioksidan peel-off premium.</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl">
                            <h4 class="text-xs uppercase tracking-widest text-claireGreen font-semibold mb-1.5">Sesuai
                                Untuk Jenis Kulit:</h4>
                            <p class="text-xs text-gray-600">Kulit kusam, warna kulit tidak merata, flek hitam ringan,
                                dan kulit lelah.</p>
                        </div>
                        <div class="pt-2">
                            <a href="/booking" target="_blank"
                                class="block w-full bg-claireGreen text-white text-center text-xs tracking-widest font-medium uppercase py-3.5 rounded-full shadow-lg transition-all duration-300 hover:bg-claireDark">BOOKING</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. POP-UP: ANTI-AGING THERAPY -->
        <div id="modal-anti-aging"
            class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
            <div
                class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] overflow-y-auto shadow-2xl relative flex flex-col">
                <button onclick="closeModal('anti-aging')"
                    class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur shadow flex items-center justify-center text-gray-600 hover:text-claireDark transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div>
                    <div class="relative h-48 sm:h-56 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?q=80&w=2070"
                            alt="Anti-Aging Therapy" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end p-6">
                            <div>
                                <span
                                    class="inline-block bg-claireGold text-white text-[10px] tracking-widest uppercase px-2.5 py-1 rounded-full font-medium mb-2">Youth
                                    Restore</span>
                                <h3 class="text-2xl sm:text-3xl font-serif text-white">Anti-Aging Therapy</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-5">
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Estimasi
                                    Durasi</span>
                                <span class="text-sm font-medium text-claireGreen flex items-center mt-1 gap-1.5">90
                                    Menit</span>
                            </div>
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Investasi
                                    Layanan</span>
                                <span class="text-sm font-semibold text-claireGreen flex items-center mt-1 gap-1">Rp
                                    450.000</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs uppercase tracking-widest text-claireGold font-semibold mb-2">Tentang
                                Perawatan</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Perawatan premium menggunakan
                                teknologi RF (Radio Frequency) untuk merangsang produksi kolagen alami, mengencangkan
                                kulit wajah yang kendur, serta menyamarkan garis halus di area sekitar mata dan senyum.
                            </p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl">
                            <h4 class="text-xs uppercase tracking-widest text-claireGreen font-semibold mb-1.5">Sesuai
                                Untuk Jenis Kulit:</h4>
                            <p class="text-xs text-gray-600">Kulit dengan tanda penuaan dini, kerutan halus, kendur,
                                dan kulit kering dewasa.</p>
                        </div>
                        <div class="pt-2">
                            <a href="/booking" target="_blank"
                                class="block w-full bg-claireGreen text-white text-center text-xs tracking-widest font-medium uppercase py-3.5 rounded-full shadow-lg transition-all duration-300 hover:bg-claireDark">BOOKING</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. POP-UP: ACNE CLEAR SOLUTION -->
        <div id="modal-acne-clear"
            class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
            <div
                class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] overflow-y-auto shadow-2xl relative flex flex-col">
                <button onclick="closeModal('acne-clear')"
                    class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur shadow flex items-center justify-center text-gray-600 hover:text-claireDark transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div>
                    <div class="relative h-48 sm:h-56 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1596755389378-c31d21fd1273?q=80&w=1976"
                            alt="Acne Clear Solution" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end p-6">
                            <div>
                                <span
                                    class="inline-block bg-claireGold text-white text-[10px] tracking-widest uppercase px-2.5 py-1 rounded-full font-medium mb-2">Blemish
                                    Control</span>
                                <h3 class="text-2xl sm:text-3xl font-serif text-white">Acne Clear Solution</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-5">
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Estimasi
                                    Durasi</span>
                                <span class="text-sm font-medium text-claireGreen flex items-center mt-1 gap-1.5">70
                                    Menit</span>
                            </div>
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Investasi
                                    Layanan</span>
                                <span class="text-sm font-semibold text-claireGreen flex items-center mt-1 gap-1">Rp
                                    280.000</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs uppercase tracking-widest text-claireGold font-semibold mb-2">Tentang
                                Perawatan</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Terapi intensif pembasmi
                                bakteri penyebab jerawat aktif. Dilengkapi teknologi High Frequency Blue Light untuk
                                meredakan inflamasi kemerahan sekaligus membantu mempercepat pengeringan jerawat.</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl">
                            <h4 class="text-xs uppercase tracking-widest text-claireGreen font-semibold mb-1.5">Sesuai
                                Untuk Jenis Kulit:</h4>
                            <p class="text-xs text-gray-600">Kulit berjerawat aktif, papula/pustula, beruntusan parah,
                                dan kulit sangat berminyak.</p>
                        </div>
                        <div class="pt-2">
                            <a href="/booking" target="_blank"
                                class="block w-full bg-claireGreen text-white text-center text-xs tracking-widest font-medium uppercase py-3.5 rounded-full shadow-lg transition-all duration-300 hover:bg-claireDark">BOOKING</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. POP-UP: HYDRO-BOOST THERAPY -->
        <div id="modal-hydro-boost"
            class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
            <div
                class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] overflow-y-auto shadow-2xl relative flex flex-col">
                <button onclick="closeModal('hydro-boost')"
                    class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur shadow flex items-center justify-center text-gray-600 hover:text-claireDark transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div>
                    <div class="relative h-48 sm:h-56 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=2070"
                            alt="Hydro-Boost Therapy" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end p-6">
                            <div>
                                <span
                                    class="inline-block bg-claireGold text-white text-[10px] tracking-widest uppercase px-2.5 py-1 rounded-full font-medium mb-2">Deep
                                    Hydration</span>
                                <h3 class="text-2xl sm:text-3xl font-serif text-white">Hydro-Boost Therapy</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-5">
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Estimasi
                                    Durasi</span>
                                <span class="text-sm font-medium text-claireGreen flex items-center mt-1 gap-1.5">60
                                    Menit</span>
                            </div>
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Investasi
                                    Layanan</span>
                                <span class="text-sm font-semibold text-claireGreen flex items-center mt-1 gap-1">Rp
                                    300.000</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs uppercase tracking-widest text-claireGold font-semibold mb-2">Tentang
                                Perawatan</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Restore your skin's natural
                                moisture for a plump and healthy appearance.</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl">
                            <h4 class="text-xs uppercase tracking-widest text-claireGreen font-semibold mb-1.5">Sesuai
                                Untuk Jenis Kulit:</h4>
                            <p class="text-xs text-gray-600">Semua jenis kulit, terutama kulit dehidrasi dan
                                mengelupas.</p>
                        </div>
                        <div class="pt-2">
                            <a href="/booking" target="_blank"
                                class="block w-full bg-claireGreen text-white text-center text-xs tracking-widest font-medium uppercase py-3.5 rounded-full shadow-lg transition-all duration-300 hover:bg-claireDark">BOOKING</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. POP-UP: LASER REJUVENATION -->
        <div id="modal-laser-rejuvenation"
            class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
            <div
                class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] overflow-y-auto shadow-2xl relative flex flex-col">
                <button onclick="closeModal('laser-rejuvenation')"
                    class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur shadow flex items-center justify-center text-gray-600 hover:text-claireDark transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div>
                    <div class="relative h-48 sm:h-56 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?q=80&w=1974"
                            alt="Laser Rejuvenation" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end p-6">
                            <div>
                                <span
                                    class="inline-block bg-claireGold text-white text-[10px] tracking-widest uppercase px-2.5 py-1 rounded-full font-medium mb-2">Advanced
                                    Laser</span>
                                <h3 class="text-2xl sm:text-3xl font-serif text-white">Laser Rejuvenation</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-5">
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Estimasi
                                    Durasi</span>
                                <span class="text-sm font-medium text-claireGreen flex items-center mt-1 gap-1.5">45
                                    Menit</span>
                            </div>
                            <div class="bg-claireLight p-3 rounded-2xl border border-gray-100">
                                <span
                                    class="block text-[10px] uppercase text-gray-400 tracking-wider font-semibold">Investasi
                                    Layanan</span>
                                <span class="text-sm font-semibold text-claireGreen flex items-center mt-1 gap-1">Rp
                                    600.000</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs uppercase tracking-widest text-claireGold font-semibold mb-2">Tentang
                                Perawatan</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">Laser technology to improve
                                skin texture and reduce the appearance of large pores.</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl">
                            <h4 class="text-xs uppercase tracking-widest text-claireGreen font-semibold mb-1.5">Sesuai
                                Untuk Jenis Kulit:</h4>
                            <p class="text-xs text-gray-600">Pori-pori besar, bekas jerawat bopeng ringan, dan tekstur
                                kulit tidak merata.</p>
                        </div>
                        <div class="pt-2">
                            <a href="/booking" target="_blank"
                                class="block w-full bg-claireGreen text-white text-center text-xs tracking-widest font-medium uppercase py-3.5 rounded-full shadow-lg transition-all duration-300 hover:bg-claireDark">BOOKING</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION PRODUCTS -->
        <section class="product-section">
            <div class="product-container">
                <h2 class="section-title reveal">Our Products</h2>

                <div class="product-grid">
                    <!-- Product 1 -->
                    <div class="product-card reveal">
                        <div class="product-box">
                            <div class="product-img">
                                <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?q=80&w=1974"
                                    alt="Facial Cleanser">
                            </div>
                            <div class="product-info">
                                <p class="product-category">CLEANSER</p>
                                <h3 class="product-name">Gentle Hydrating Wash</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="product-card reveal">
                        <div class="product-box">
                            <div class="product-img">
                                <img src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?q=80&w=1974"
                                    alt="Glow Serum">
                            </div>
                            <div class="product-info">
                                <p class="product-category">SERUM</p>
                                <h3 class="product-name">Vitamin C Glow Serum</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="product-card reveal">
                        <div class="product-box">
                            <div class="product-img">
                                <img src="asset/3323178.jpg" alt="Moisturizer">
                            </div>
                            <div class="product-info">
                                <p class="product-category">MOISTURIZER</p>
                                <h3 class="product-name">Barrier Repair Cream</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="product-card reveal">
                        <div class="product-box">
                            <div class="product-img">
                                <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=1935"
                                    alt="Sunscreen">
                            </div>
                            <div class="product-info">
                                <p class="product-category">SUN CARE</p>
                                <h3 class="product-name">Daily UV Shield SPF 50</h3>
                            </div>
                        </div>
                    </div>

                    <div class="product-card reveal">
                        <div class="product-box">
                            <div class="product-img">
                                <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=1935"
                                    alt="Sunscreen">
                            </div>
                            <div class="product-info">
                                <p class="product-category">SUN CARE</p>
                                <h3 class="product-name">Daily UV Shield SPF 50</h3>
                            </div>
                        </div>
                    </div>

                    <div class="product-card reveal">
                        <div class="product-box">
                            <div class="product-img">
                                <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=1935"
                                    alt="Sunscreen">
                            </div>
                            <div class="product-info">
                                <p class="product-category">SUN CARE</p>
                                <h3 class="product-name">Daily UV Shield SPF 50</h3>
                            </div>
                        </div>
                    </div>

                    <div class="product-card reveal">
                        <div class="product-box">
                            <div class="product-img">
                                <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=1935"
                                    alt="Sunscreen">
                            </div>
                            <div class="product-info">
                                <p class="product-category">SUN CARE</p>
                                <h3 class="product-name">Daily UV Shield SPF 50</h3>
                            </div>
                        </div>
                    </div>

                    <div class="product-card reveal">
                        <div class="product-box">
                            <div class="product-img">
                                <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=1935"
                                    alt="Sunscreen">
                            </div>
                            <div class="product-info">
                                <p class="product-category">SUN CARE</p>
                                <h3 class="product-name">Daily UV Shield SPF 50</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="footer-container">
            <!-- Kolom 1: Brand & Bio -->
            <div class="footer-column brand-info">
                <h2 class="footer-logo">CLA<span>IRE</span></h2>
                <p>Menghadirkan kebaikan alam untuk ritual perawatan tubuh harian Anda. Produk kami 100% organik dan
                    ramah lingkungan.</p>
                <div class="social-links">
                    <a href="#" aria-label="Instagram">Instagram</a>
                    <a href="#" aria-label="Facebook">Facebook</a>
                    <a href="#" aria-label="TikTok">TikTok</a>
                </div>
            </div>

            <!-- Kolom 2: Navigasi -->
            <div class="footer-column">
                <h3>Belanja</h3>
                <ul>
                    <li><a href="#">Semua Produk</a></li>
                    <li><a href="#">Perawatan Wajah</a></li>
                    <li><a href="#">Perawatan Tubuh</a></li>
                    <li><a href="#">Paket Hadiah</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Bantuan -->
            <div class="footer-column">
                <h3>Dukungan</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Kebijakan Pengiriman</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Lokasi & Kontak -->
            <div class="footer-column contact-info">
                <h3>Lokasi & Kontak</h3>
                <p>Jl. Kecantikan No. 123, Jakarta Selatan, Indonesia</p>
                <p>Email: hello@Claire.com</p>
                <p>WhatsApp: +62 812-3456-7890</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 CLAIRE Indonesia. Seluruh hak cipta dilindungi.</p>
        </div>


    </footer>



    <script src="{{ asset('script.js') }}"></script>
</body>

</html>