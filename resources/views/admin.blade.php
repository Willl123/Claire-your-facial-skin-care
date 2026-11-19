<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CLAIRE</title>

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
                    <span class="badge">{{ $bookings->where('status', 'pending')->count() }}</span>
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
            </div>

            <div class="admin-label">
                Administrator
            </div>

        </div>





        <!-- STATISTIC CARDS -->
        <section class="cards">

            <div class="card">
                <h3>Total Bookings</h3>
                <h2>{{ $bookings->count() }}</h2>
                <div class="card-line"></div>
            </div>

            <div class="card">
                <h3>Total Customers</h3>
                <h2>{{ \App\Models\User::where('role', 'customer')->count() }}</h2>
                <div class="card-line"></div>
            </div>

            <div class="card">
                <h3>Pending Bookings</h3>
                <h2>{{ $bookings->where('status', 'pending')->count() }}</h2>
                <div class="card-line"></div>
            </div>

            <div class="card">
                <h3>Completed Bookings</h3>
                <h2>{{ $bookings->where('status', 'completed')->count() }}</h2>
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

                    <tbody id="bookingRows">

                        @forelse($bookings as $booking)

                        @php
                        $latestAssignment = $booking->assignments
                        ->sortByDesc('id')
                        ->first();

                        $canAssign = $booking->status === 'pending' && (
                        !$latestAssignment ||
                        $latestAssignment->status === 'rejected' ||
                        $latestAssignment->status === 'reassigned' ||
                        (
                        $latestAssignment->status === 'accepted' &&
                        $latestAssignment->admin_status === 'rejected'
                        )
                        );

                        $statusLabel = 'Belum Ditugaskan';
                        $statusClass = 'status-pending';
                        $filterStatus = 'pending';

                        if ($booking->status === 'rejected') {
                            $statusLabel = 'Pesanan Ditolak';
                            $statusClass = 'status-rejected';
                            $filterStatus = 'rejected';
                        } elseif ($booking->status === 'completed' || ($latestAssignment && $latestAssignment->status === 'completed')) {
                            $statusLabel = 'Selesai';
                            $statusClass = 'status-completed';
                            $filterStatus = 'completed';
                        } elseif ($latestAssignment) {
                            if ($latestAssignment->status === 'pending' || $latestAssignment->status === 'reassigned') {
                                $statusLabel = $latestAssignment->status === 'reassigned' ? 'Ditugaskan Ulang' : 'Menunggu Terapis';
                                $statusClass = 'status-pending';
                                $filterStatus = 'pending';
                            } elseif ($latestAssignment->status === 'rejected') {
                                $statusLabel = 'Ditolak Terapis';
                                $statusClass = 'status-rejected';
                                $filterStatus = 'rejected';
                            } elseif ($latestAssignment->status === 'accepted') {
                                if ($latestAssignment->admin_status === 'pending') {
                                    $statusLabel = 'Menunggu Persetujuan Admin';
                                    $statusClass = 'status-pending';
                                    $filterStatus = 'pending';
                                } elseif ($latestAssignment->admin_status === 'approved') {
                                    $statusLabel = 'Disetujui';
                                    $statusClass = 'status-approved';
                                    $filterStatus = 'approved';
                                } elseif ($latestAssignment->admin_status === 'rejected') {
                                    $statusLabel = 'Ditolak Admin';
                                    $statusClass = 'status-rejected';
                                    $filterStatus = 'rejected';
                                }
                            }
                        }
                        @endphp

                        <tr
                            data-status="{{ $filterStatus }}"
                            data-place="{{ $booking->place === 'home' ? 'home' : 'clinic' }}"
                            data-search="{{ strtolower(($booking->user->name ?? '') . ' ' . $booking->treatment . ' ' . ($booking->phone ?? '')) }}">

                            <!-- CUSTOMER + DETAIL LENGKAP (muncul di panel) -->
                            <td>
                                <b>{{ $booking->user->name ?? '-' }}</b>
                                <small>{{ $booking->phone ?? '-' }}</small>

                                <template class="detail">

                                    @if($statusLabel)
                                    <span class="status {{ $statusClass }}">{{ $statusLabel }}</span>
                                    @endif

                                    <h2>{{ $booking->user->name ?? '-' }}</h2>
                                    <p class="sub">{{ $booking->treatment }}</p>

                                    <!-- TREATMENT & HARGA -->
                                    <div class="detail-group">
                                        <h3>Treatment</h3>

                                        <div class="detail-row">
                                            <span>Treatment</span>
                                            <span>{{ $booking->treatment }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span>Treatment Price</span>
                                            <span>Rp{{ number_format($booking->price ?? 0, 0, ',', '.') }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span>Service Fee</span>
                                            <span>Rp{{ number_format($booking->service_fee ?? 0, 0, ',', '.') }}</span>
                                        </div>

                                        <div class="detail-row total">
                                            <span>Total Price</span>
                                            <span>Rp{{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <!-- CUSTOMER -->
                                    <div class="detail-group">
                                        <h3>Customer</h3>

                                        <div class="detail-row">
                                            <span>Customer</span>
                                            <span>{{ $booking->user->name ?? '-' }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span>Gender</span>
                                            <span>{{ $booking->gender ?? '-' }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span>Phone</span>
                                            <span>{{ $booking->phone ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <!-- JADWAL & LOKASI -->
                                    <div class="detail-group">
                                        <h3>Jadwal &amp; Lokasi</h3>

                                        <div class="detail-row">
                                            <span>Date</span>
                                            <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span>Time</span>
                                            <span>{{ substr($booking->booking_time, 0, 5) }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span>Location</span>
                                            <span>{{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span>Address</span>
                                            <span>{{ $booking->place === 'home' ? ($booking->address ?? '-') : 'Klinik CLAIRE' }}</span>
                                        </div>
                                    </div>

                                    <!-- PAYMENT -->
                                    <div class="detail-group">
                                        <h3>Payment</h3>

                                        <div class="detail-row">
                                            <span>Payment</span>
                                            <span>{{ $booking->payment_method ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <!-- NOTES -->
                                    <div class="detail-group">
                                        <h3>Notes</h3>
                                        <div class="note-box">{{ $booking->notes ?? '-' }}</div>
                                    </div>

                                    <!-- ASSIGN THERAPIST -->
                                    <div class="detail-group">
                                        <h3>Terapis</h3>

                                        @if($canAssign)

                                        <form
                                            action="{{ route('booking.assignTherapist', $booking->id) }}"
                                            method="POST"
                                            class="assign-form">

                                            @csrf

                                            <select name="therapist_id" required>

                                                <option value="">Pilih Terapis</option>

                                                @foreach($therapists as $therapist)

                                                <option
                                                    value="{{ $therapist->id }}"
                                                    {{ $booking->therapist_id == $therapist->id ? 'selected' : '' }}
                                                    {{ !$therapist->is_available ? 'disabled' : '' }}>

                                                    {{ $therapist->name }}
                                                    {{ !$therapist->is_available ? '(Nonaktif)' : '' }}

                                                </option>

                                                @endforeach

                                            </select>

                                            <button type="submit" class="btn btn-approve">
                                                {{ $latestAssignment ? 'Tugaskan Ulang' : 'Simpan' }}
                                            </button>

                                        </form>

                                        @elseif($latestAssignment && $latestAssignment->status === 'pending')

                                        <span>Menunggu respons terapis</span>

                                        @elseif(
                                        $latestAssignment &&
                                        $latestAssignment->status === 'accepted' &&
                                        $latestAssignment->admin_status === 'pending'
                                        )

                                        <span>Menunggu keputusan admin</span>

                                        @else

                                        -

                                        @endif
                                    </div>

                                    <!-- RIWAYAT PENUGASAN TERAPIS -->
                                    <div class="detail-group">
                                        <h3>Riwayat Penugasan Terapis</h3>

                                        @if($booking->assignments && $booking->assignments->count() > 0)
                                            @foreach($booking->assignments->sortBy('id') as $assignmentHistory)
                                                @php
                                                    $historyStatusLabel = match($assignmentHistory->status) {
                                                        'pending' => 'Menunggu respons terapis',
                                                        'accepted' => $assignmentHistory->admin_status === 'approved' ? 'Disetujui admin' : ($assignmentHistory->admin_status === 'rejected' ? 'Ditolak admin' : 'Diterima, menunggu admin'),
                                                        'rejected' => 'Terapis menolak tugas',
                                                        'reassigned' => 'Penugasan ulang',
                                                        'completed' => 'Selesai',
                                                        default => ucfirst($assignmentHistory->status ?? 'Tidak diketahui'),
                                                    };
                                                    $historyStatusClass = $assignmentHistory->status === 'rejected' || $assignmentHistory->admin_status === 'rejected' ? 'status-rejected' : (($assignmentHistory->status === 'accepted' && $assignmentHistory->admin_status === 'approved') || $assignmentHistory->status === 'completed' ? 'status-approved' : 'status-pending');
                                                @endphp


                                                <div class="detail-row" style="align-items:flex-start; gap:12px; padding:10px 0; border-bottom:1px solid var(--border, #eee);">
                                                    <div style="flex:1; min-width:0;">
                                                        <strong>{{ $assignmentHistory->therapist->name ?? 'Nama terapis tidak tersedia' }}</strong>
                                                        <small style="display:block; margin-top:4px;">Penugasan #{{ $assignmentHistory->id }}</small>
                                                        @if($assignmentHistory->created_at)
                                                            <small style="display:block; margin-top:3px;">{{ $assignmentHistory->created_at->format('d M Y, H:i') }}</small>
                                                        @endif
                                                    </div>
                                                    <span class="status {{ $historyStatusClass }}">{{ $historyStatusLabel }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span>Belum ada penugasan terapis.</span>
                                        @endif
                                    </div>


                                    <!-- ASSIGN THERAPIST / ACTION PENUGASAN -->
                                    <div class="detail-group">
                                        <h3>Assign Therapist</h3>

                                        @if($booking->status === 'rejected')

                                        <span class="t-bad t-bold">
                                            Pesanan Ditolak
                                        </span>

                                        @elseif($booking->status === 'completed')

                                        <span class="t-done t-bold">
                                            Selesai
                                        </span>

                                        @elseif($booking->status === 'pending')

                                        @if($latestAssignment)

                                        @if($latestAssignment->status === 'pending')

                                        <span class="t-wait">
                                            Menunggu respons terapis
                                        </span>

                                        @elseif($latestAssignment->status === 'rejected')

                                        <span class="t-bad">
                                            Terapis menolak tugas
                                        </span>

                                        @elseif($latestAssignment->status === 'accepted')

                                        @if($latestAssignment->admin_status === 'pending')

                                        <form
                                            action="{{ route('booking.approve', $booking->id) }}"
                                            method="POST"
                                            style="display:inline;">

                                            @csrf

                                            <button type="submit" class="btn btn-approve">
                                                Approve Penugasan
                                            </button>

                                        </form>

                                        <form
                                            action="{{ route('booking.rejectAssignment', $booking->id) }}"
                                            method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Yakin ingin menolak penugasan terapis ini? Customer tetap berstatus Menunggu.');">

                                            @csrf

                                            <button type="submit" class="btn btn-reject">
                                                Reject Penugasan
                                            </button>

                                        </form>

                                        @elseif($latestAssignment->admin_status === 'approved')

                                        <span class="t-ok t-bold">
                                            Disetujui Admin
                                        </span>

                                        @elseif($latestAssignment->admin_status === 'rejected')

                                        <span class="t-bad">
                                            Ditolak Admin
                                        </span>

                                        @endif

                                        @endif

                                        @else

                                        <span class="t-wait">
                                            Belum ada terapis
                                        </span>

                                        @endif

                                        <form
                                            action="{{ route('booking.reject', $booking->id) }}"
                                            method="POST"
                                            style="margin-top:6px;"
                                            onsubmit="return confirm('Yakin ingin menolak pesanan customer ini?');">

                                            @csrf

                                            <button type="submit" class="btn btn-reject">
                                                Tolak Pesanan
                                            </button>

                                        </form>

                                        @elseif($booking->status === 'approved')

                                        <span class="t-ok t-bold">
                                            Disetujui
                                        </span>

                                        @endif
                                    </div>

                                    <!-- ACTION / STATUS INFO -->
                                    <div class="detail-group">
                                        <h3>Action</h3>
                                        @if($booking->status === 'rejected')
                                            <span class="t-bad t-bold">Pesanan customer ditolak.</span>
                                        @elseif($booking->status === 'completed' || ($latestAssignment && $latestAssignment->status === 'completed'))
                                            <span class="t-done t-bold">Treatment telah selesai.</span>
                                        @elseif($latestAssignment && $latestAssignment->status === 'accepted' && $latestAssignment->admin_status === 'approved')
                                            <span class="t-ok t-bold">Terapis disetujui. Treatment menunggu pelaksanaan.</span>
                                        @elseif($latestAssignment && $latestAssignment->status === 'accepted' && $latestAssignment->admin_status === 'pending')
                                            <span class="t-wait">Menunggu keputusan admin atas penugasan.</span>
                                        @elseif($latestAssignment && $latestAssignment->status === 'accepted' && $latestAssignment->admin_status === 'rejected')
                                            <span class="t-bad">Penugasan ditolak admin. Silakan tugaskan ulang.</span>
                                        @elseif($latestAssignment && $latestAssignment->status === 'rejected')
                                            <span class="t-bad">Terapis menolak penugasan. Silakan tugaskan ulang.</span>
                                        @else
                                            <span class="t-wait">Booking belum memiliki penugasan terapis.</span>
                                        @endif
                                    </div>
                                </template>
                            </td>

                            <td>
                                {{ $booking->treatment }}
                                <small>Rp{{ number_format($booking->price ?? 0, 0, ',', '.') }}</small>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                <small>{{ substr($booking->booking_time, 0, 5) }}</small>
                            </td>

                            <td>
                                {{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}
                                <small>{{ $booking->payment_method ?? '-' }}</small>
                            </td>

                            <td>
                                @if($statusLabel)
                                <span class="status {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                                @endif
                            </td>

                            <td>
                                @if($latestAssignment && $latestAssignment->therapist)
                                    @if($latestAssignment->status === 'rejected')
                                        <small class="status status-rejected">Terapis menolak tugas</small>
                                    @else
                                       
                                        @if($latestAssignment->status === 'pending')
                                            <small class="status status-pending">Menunggu respons</small>
                                        @elseif($latestAssignment->status === 'accepted')
                                            <small class="status {{ $latestAssignment->admin_status === 'approved' ? 'status-approved' : ($latestAssignment->admin_status === 'rejected' ? 'status-rejected' : 'status-pending') }}">
                                                {{ $latestAssignment->admin_status === 'approved' ? 'Disetujui Admin' : ($latestAssignment->admin_status === 'rejected' ? 'Ditolak Admin' : 'Menunggu Admin') }}
                                            </small>
                                        @elseif($latestAssignment->status === 'completed')
                                            <small class="status status-completed">Selesai</small>
                                        @else
                                            <small>{{ ucfirst($latestAssignment->status) }}</small>
                                        @endif
                                    @endif
                                @else
                                    <span>-</span>
                                @endif
                            </td>


                            <td class="num price">
                                Rp{{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                            </td>

                        </tr>

                        @empty

                        <tr>
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
        const rows = Array.from(document.querySelectorAll('#bookingRows tr[data-status]'));
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
            const keyword = searchInput.value.toLowerCase();
            const place = filterPlace.value;
            let visible = 0;

            rows.forEach(function(row) {
                const cocokStatus = activeFilter === 'all' || row.dataset.status === activeFilter;
                const cocokLokasi = !place || row.dataset.place === place;
                const cocokCari = row.dataset.search.includes(keyword);

                const tampil = cocokStatus && cocokLokasi && cocokCari;

                row.classList.toggle('hidden', !tampil);

                if (tampil) visible++;
            });

            emptyMessage.classList.toggle('hidden', visible > 0 || rows.length === 0);
        }

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