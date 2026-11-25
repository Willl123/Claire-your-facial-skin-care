<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CLAIRE</title>
    @vite('resources/js/app.js')

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f4f1ea;
            --surface: #fcfaf6;
            --line: #e6e1d6;
            --ink: #1d2a22;
            --muted: #76786d;
            --brand: #24442f;
            --brand-ink: #f4f1ea;
            --accent: #b8794e;
            --wait: #9a6a12;
            --wait-bg: #f6ead0;
            --ok: #24442f;
            --ok-bg: #dfe9dc;
            --done: #36526b;
            --done-bg: #e1e8ee;
            --bad: #9b3a2e;
            --bad-bg: #f3dcd7;
            --sans: "Instrument Sans", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
            --serif: "Fraunces", Georgia, "Times New Roman", serif;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #121712;
                --surface: #1a211b;
                --line: #2a332b;
                --ink: #e9e6dc;
                --muted: #8e9488;
                --brand: #8fc19d;
                --brand-ink: #12190f;
                --accent: #d29a72;
                --wait: #e3b765;
                --wait-bg: #3a2f16;
                --ok: #9fd0ac;
                --ok-bg: #1f3325;
                --done: #9db8d0;
                --done-bg: #1f2b36;
                --bad: #e49a8d;
                --bad-bg: #3b1f1a;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--sans);
            font-size: 14px;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 232px 1fr;
        }

        button,
        select,
        input {
            font-family: inherit;
            font-size: inherit;
            color: inherit;
        }

        button {
            cursor: pointer;
        }

        .hidden {
            display: none !important;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            border-right: 1px solid var(--line);
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .logo {
            font-family: var(--serif);
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.2em;
        }

        .logo small {
            display: block;
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: 6px;
        }

        .sidebar ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sidebar ul li a,
        .sidebar-link {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 9px 12px;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: var(--muted);
            text-decoration: none;
            text-align: left;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar ul li a:hover,
        .sidebar-link:hover {
            color: var(--ink);
        }

        .sidebar ul li.active a {
            background: var(--surface);
            color: var(--ink);
            box-shadow: inset 0 0 0 1px var(--line);
        }

        .logout-link:hover {
            color: var(--bad);
        }

        .admin-info {
            margin-top: auto;
            font-size: 13px;
            color: var(--muted);
            border-top: 1px solid var(--line);
            padding-top: 16px;
        }

        .admin-info b {
            display: block;
            color: var(--ink);
            font-weight: 600;
        }

        .badge {
            font-size: 11px;
            font-weight: 600;
            background: var(--wait-bg);
            color: var(--wait);
            border-radius: 999px;
            padding: 1px 8px;
        }

        /* ================= MAIN ================= */

        .main {
            padding: 32px 40px 48px;
            min-width: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .navbar h1 {
            font-family: var(--serif);
            font-weight: 500;
            font-size: 34px;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .navbar p {
            color: var(--muted);
            margin-top: 6px;
        }

        .admin-label {
            border: 1px solid var(--line);
            background: var(--surface);
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 600;
        }

        /* ================= CARDS ================= */

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--surface);
            margin-bottom: 24px;
        }

        .card {
            padding: 18px 20px;
            border-right: 1px solid var(--line);
        }

        .card:last-child {
            border-right: none;
        }

        .card h3 {
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .card h2 {
            font-family: var(--serif);
            font-weight: 500;
            font-size: 30px;
            margin-top: 6px;
            letter-spacing: -0.02em;
        }

        .card-line {
            width: 28px;
            height: 3px;
            border-radius: 3px;
            background: var(--accent);
            margin-top: 12px;
        }

        /* ================= TABLE SECTION ================= */

        .table-header h2 {
            font-family: var(--serif);
            font-weight: 500;
            font-size: 24px;
            letter-spacing: -0.01em;
        }

        .table-header p {
            font-size: 13px;
            color: var(--muted);
            margin: 4px 0 18px;
        }

        .toolbar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 14px;
        }

        .chips {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .chip {
            border: 1px solid var(--line);
            background: transparent;
            border-radius: 999px;
            padding: 6px 14px;
            color: var(--muted);
            font-weight: 500;
        }

        .chip.active {
            background: var(--ink);
            color: var(--bg);
            border-color: var(--ink);
        }

        .toolbar input,
        .toolbar select {
            border: 1px solid var(--line);
            background: var(--surface);
            border-radius: 8px;
            padding: 8px 12px;
        }

        .toolbar input {
            width: 220px;
            margin-left: auto;
        }

        .table-scroll {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--surface);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            min-width: 780px;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 14px 18px;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        tbody td {
            padding: 15px 18px;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr[data-status] {
            cursor: pointer;
        }

        tbody tr:hover {
            background: var(--bg);
        }

        td small {
            display: block;
            color: var(--muted);
            margin-top: 2px;
            font-size: 12.5px;
        }

        th.num,
        td.num {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .price {
            font-weight: 600;
            color: var(--brand);
        }

        .empty {
            padding: 40px;
            text-align: center;
            color: var(--muted);
        }

        /* ================= STATUS ================= */

        .status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending {
            background: var(--wait-bg);
            color: var(--wait);
        }

        .status-approved {
            background: var(--ok-bg);
            color: var(--ok);
        }

        .status-rejected {
            background: var(--bad-bg);
            color: var(--bad);
        }

        .status-completed {
            background: var(--done-bg);
            color: var(--done);
        }

        /* warna teks aksi (pengganti style inline) */

        .t-wait {
            color: var(--wait);
        }

        .t-bad {
            color: var(--bad);
        }

        .t-ok {
            color: var(--ok);
        }

        .t-done {
            color: var(--done);
        }

        .t-bold {
            font-weight: 600;
        }

        /* ================= BUTTON ================= */

        .btn {
            display: inline-block;
            padding: 9px 14px;
            margin: 2px 2px 2px 0;
            border: 1px solid transparent;
            border-radius: 8px;
            color: var(--brand-ink);
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 600;
            white-space: nowrap;
            transition: 0.2s;
        }

        .btn:hover {
            opacity: 0.88;
        }

        .btn-approve {
            background: var(--brand);
        }

        .btn-complete {
            background: var(--done);
            color: var(--surface);
        }

        .btn-reject {
            background: transparent;
            color: var(--bad);
            border-color: var(--line);
        }

        .btn-reject:hover {
            background: var(--bad-bg);
            opacity: 1;
        }

        /* ================= ASSIGN THERAPIST ================= */

        .assign-form select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--bg);
            outline: none;
            margin-bottom: 8px;
        }

        .assign-form select:focus {
            border-color: var(--brand);
        }

        /* ================= ALERT ================= */

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 14px;
            border-left: 3px solid;
        }

        .success-message {
            color: var(--ok);
            background: var(--ok-bg);
            border-color: var(--ok);
        }

        .error-message {
            color: var(--bad);
            background: var(--bad-bg);
            border-color: var(--bad);
        }

        /* ================= PANEL DETAIL ================= */

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            opacity: 0;
            pointer-events: none;
            transition: 0.2s;
            z-index: 50;
        }

        .overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .drawer {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: min(480px, 100%);
            background: var(--surface);
            border-left: 1px solid var(--line);
            transform: translateX(100%);
            transition: transform 0.25s;
            overflow-y: auto;
            padding: 28px;
            z-index: 60;
        }

        .drawer.show {
            transform: none;
        }

        .btn-close {
            float: right;
            background: none;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 4px 10px;
            color: var(--muted);
        }

        .drawer h2 {
            font-family: var(--serif);
            font-weight: 500;
            font-size: 26px;
            letter-spacing: -0.01em;
            margin-top: 12px;
        }

        .drawer .sub {
            color: var(--muted);
            margin-top: 2px;
        }

        .detail-group {
            margin: 24px 0;
        }

        .detail-group h3 {
            font-size: 11.5px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 9px 0;
            border-bottom: 1px dashed var(--line);
        }

        .detail-row span:first-child {
            color: var(--muted);
            flex-shrink: 0;
        }

        .detail-row span:last-child {
            text-align: right;
            font-weight: 500;
            overflow-wrap: anywhere;
        }

        .detail-row.total {
            border-bottom: none;
            border-top: 1px solid var(--ink);
            margin-top: 6px;
            padding-top: 12px;
            font-family: var(--serif);
            font-size: 20px;
        }

        .detail-row.total span:first-child {
            color: var(--ink);
        }

        .detail-row.total span:last-child {
            color: var(--brand);
        }

        .note-box {
            background: var(--bg);
            border-radius: 8px;
            padding: 12px 14px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }



        .navbar p.today {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--brand);
        }

        .navbar p.today::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 1000px) {
            .main {
                padding: 24px;
            }

            .cards {
                grid-template-columns: 1fr 1fr;
            }

            .card:nth-child(2) {
                border-right: none;
            }

            .card:nth-child(-n+2) {
                border-bottom: 1px solid var(--line);
            }
        }

        @media (max-width: 900px) {
            body {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                height: auto;
                flex-direction: row;
                align-items: center;
                padding: 16px 20px;
                gap: 16px;
                overflow-x: auto;
            }

            .sidebar ul {
                flex-direction: row;
                align-items: center;
            }

            .sidebar ul li a,
            .sidebar-link {
                white-space: nowrap;
                gap: 8px;
            }

            .admin-info {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .main {
                padding: 18px 16px 40px;
            }

            .navbar h1 {
                font-size: 26px;
            }

            .admin-label {
                display: none;
            }

            .toolbar input {
                width: 100%;
                margin-left: 0;
            }

            .drawer {
                padding: 22px 18px;
            }
        }

        @media (max-width: 380px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .card {
                border-right: none;
                border-bottom: 1px solid var(--line);
            }

            .card:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>

<body>

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar" id="sidebar">

        <h2 class="logo">
            CLAIRE
            <small>Beauty &amp; Treatment</small>
        </h2>

        <ul>
            <li class="active">
                <a href="/admin">Dashboard</a>
            </li>

            <li>
                <span class="sidebar-link" aria-disabled="true" title="Menu belum tersedia">Treatments</span>
            </li>

            <li>
                <a href="#bookings">
                    Bookings

                    @if($bookings->where('status', 'pending')->count() > 0)
                    <span class="badge" id="pendingBookingBadge">
                        {{ $bookings->where('status', 'pending')->count() }}
                    </span>
                    @else
                    <span class="badge" id="pendingBookingBadge" style="display: none;">
                        0
                    </span>
                    @endif
                </a>
            </li>

            <li>
                <span class="sidebar-link" aria-disabled="true" title="Menu belum tersedia">Customers</span>
            </li>

            <li>
                <a href="{{ route('admin.therapistSchedules') }}">
                    Kalender Terapis
                </a>
            </li>

            <li>
                <span class="sidebar-link" aria-disabled="true" title="Menu belum tersedia">Messages</span>
            </li>

            <li>
                <span class="sidebar-link" aria-disabled="true" title="Menu belum tersedia">Reviews</span>
            </li>

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link logout-link">
                        Logout
                    </button>
                </form>
            </li>
        </ul>

        <div class="admin-info">
            <b>Administrator</b>
            CLAIRE Admin
        </div>

    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="main">

        <!-- NAVBAR -->
        <div class="navbar">

            <div>
                <h1>Admin Dashboard</h1>
                <p>Selamat datang di dashboard CLAIRE</p>
                <p class="today" id="todayText"></p>
                <a href="{{ route('admin.profile') }}">
                    Profil Saya
                </a>
            </div>

            <div class="admin-label">
                Administrator
            </div>

        </div>





        <!-- STATISTIC CARDS -->
        <section class="cards">

            <div class="card">
                <h3>Total Bookings</h3>
                <h2 id="totalBookingsCount">{{ $bookings->count() }}</h2>
                <div class="card-line"></div>
            </div>

            <div class="card">
                <h3>Total Customers</h3>
                <h2 id="totalCustomersCount">
                    {{ \App\Models\User::where('role', 'customer')->count() }}
                </h2>
                <div class="card-line"></div>
            </div>

            <div class="card">
                <h3>Pending Bookings</h3>
                <h2 id="pendingBookingsCount">
                    {{ $bookings->where('status', 'pending')->count() }}
                </h2>
                <div class="card-line"></div>
            </div>

            <div class="card">
                <h3>Completed Bookings</h3>
                <h2 id="completedBookingsCount">
                    {{ $bookings->where('status', 'completed')->count() }}
                </h2>
                <div class="card-line"></div>
            </div>

        </section>

        <!-- BOOKING TABLE -->
        <section class="table-section" id="bookings">

            <div class="table-header">
                <h2>Recent Bookings</h2>
                <p>Informasi dan pengelolaan pemesanan treatment CLAIRE</p>
            </div>

            @if(session('success'))
            <div class="alert success-message">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert error-message">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert error-message">
                @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <!-- FILTER -->
            <div class="toolbar">

                <div class="chips" id="chips">
                    <button type="button" class="chip active" data-filter="all">Semua</button>
                    <button type="button" class="chip" data-filter="pending">Pending</button>
                    <button type="button" class="chip" data-filter="approved">Approved</button>
                    <button type="button" class="chip" data-filter="rejected">Rejected</button>
                    <button type="button" class="chip" data-filter="completed">Completed</button>
                </div>

                <select id="filterPlace">
                    <option value="">Semua lokasi</option>
                    <option value="clinic">Klinik</option>
                    <option value="home">Home Service</option>
                </select>

                <input type="search" id="searchInput" placeholder="Cari nama, treatment, telepon...">

            </div>

            <div class="table-scroll">

                <table>

                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Treatment</th>
                            <th>Jadwal</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Terapis</th>
                            <th class="num">Total Price</th>
                        </tr>
                    </thead>

                    <tbody
                        id="bookingRows"
                        data-row-url="{{ route('admin.bookings.row', ['booking' => '__ID__']) }}">

                        @forelse($bookings as $booking)

                        @include('partials-booking-row', [
                        'booking' => $booking,
                        'therapists' => $therapists
                        ])

                        @empty

                        <tr id="emptyBookingRow">
                            <td colspan="7" style="text-align:center;padding:30px;">
                                Belum ada booking.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="empty hidden" id="emptyMessage">
                    Tidak ada pesanan yang cocok.
                </div>

            </div>

        </section>

    </main>

    <!-- ================= PANEL DETAIL BOOKING ================= -->
    <div class="overlay" id="overlay"></div>

    <aside class="drawer" id="drawer">
        <button type="button" class="btn-close" id="btnClose">Tutup</button>
        <div id="drawerBody"></div>
    </aside>

    <script>
        function getBookingRows() {
            return Array.from(
                document.querySelectorAll('#bookingRows tr[data-status]')
            );
        }
        const chips = document.getElementById('chips');
        const filterPlace = document.getElementById('filterPlace');
        const searchInput = document.getElementById('searchInput');
        const emptyMessage = document.getElementById('emptyMessage');

        const drawer = document.getElementById('drawer');
        const drawerBody = document.getElementById('drawerBody');
        const overlay = document.getElementById('overlay');
        const btnClose = document.getElementById('btnClose');

        let activeFilter = 'all';


        // ================= FILTER =================

        function applyFilter() {
            const rows = getBookingRows();

            const keyword = searchInput.value.toLowerCase();
            const place = filterPlace.value;
            let visible = 0;

            rows.forEach(function(row) {
                const cocokStatus =
                    activeFilter === 'all' ||
                    row.dataset.status === activeFilter;

                const cocokLokasi = !place || row.dataset.place === place;

                const cocokCari =
                    row.dataset.search.includes(keyword);

                const tampil = cocokStatus && cocokLokasi && cocokCari;

                row.classList.toggle('hidden', !tampil);

                if (tampil) visible++;
            });

            emptyMessage.classList.toggle(
                'hidden',
                visible > 0 || rows.length === 0
            );
        }

        window.applyBookingFilter = applyFilter;

        if (chips) chips.addEventListener('click', function(event) {
            const chip = event.target.closest('.chip');
            if (!chip) return;

            activeFilter = chip.dataset.filter;

            chips.querySelectorAll('.chip').forEach(function(item) {
                item.classList.toggle('active', item === chip);
            });

            applyFilter();
        });

        if (filterPlace) filterPlace.addEventListener('change', applyFilter);
        if (searchInput) searchInput.addEventListener('input', applyFilter);


        // ================= PANEL DETAIL =================

        function openDrawer(row) {
            const detail = row.querySelector('template.detail');
            if (!detail) return;

            drawerBody.innerHTML = detail.innerHTML;
            drawer.scrollTop = 0;

            drawer.classList.add('show');
            overlay.classList.add('show');
        }

        function closeDrawer() {
            drawer.classList.remove('show');
            overlay.classList.remove('show');
        }

        document.getElementById('bookingRows').addEventListener('click', function(event) {
            if (event.target.closest('button, a, form, select, input, textarea, label')) return;
            const row = event.target.closest('tr[data-status]');
            if (row) openDrawer(row);
        });

        btnClose.addEventListener('click', closeDrawer);
        overlay.addEventListener('click', closeDrawer);

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') closeDrawer();
        });


        // ================= TANGGAL HARI INI =================

        const todayText = document.getElementById('todayText');

        function updateToday() {
            todayText.textContent = new Date().toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        updateToday();

        // Perbarui setiap menit supaya tanggal ikut berganti saat lewat tengah malam
        setInterval(updateToday, 60000);
    </script>

</body>

</html>