<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CLAIRE</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f7f5;
            color: #303b32;
            overflow-x: hidden;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 265px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 28px 20px;
            background: #24442f;
            color: white;
            transform: translateX(-100%);
            transition: transform 0.35s ease;
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.12);
            overflow-y: auto;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .logo {
            font-size: 27px;
            letter-spacing: 5px;
            text-align: center;
            margin-bottom: 42px;
            font-weight: 700;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 9px;
        }

        .sidebar ul li a,
        .sidebar-link {
            display: block;
            width: 100%;
            padding: 13px 15px;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 9px;
            background: transparent;
            text-align: left;
            font-size: 14px;
            cursor: pointer;
            transition: 0.25s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li.active a,
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.14);
        }

        .logout-link:hover {
            background: rgba(255, 80, 80, 0.2);
        }

        .sidebar-close {
            display: none;
            position: absolute;
            top: 22px;
            right: 18px;
            background: transparent;
            border: none;
            color: white;
            font-size: 25px;
            cursor: pointer;
        }

        /* Area pemicu sidebar di tepi kiri */

        .sidebar-trigger {
            position: fixed;
            top: 0;
            left: 0;
            width: 14px;
            height: 100vh;
            z-index: 999;
        }

        /* Overlay untuk HP */

        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 998;
        }

        .overlay.show {
            display: block;
        }

        /* ================= MAIN ================= */

        .main {
            width: 100%;
            min-height: 100vh;
            padding: 30px;
            transition: 0.3s ease;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar h1 {
            font-size: 24px;
            font-weight: 600;
            color: #24442f;
        }

        .navbar p {
            font-size: 13px;
            color: #888;
            margin-top: 3px;
        }

        .menu-btn {
            width: 43px;
            height: 43px;
            border: none;
            border-radius: 10px;
            background: #24442f;
            color: white;
            font-size: 21px;
            cursor: pointer;
            transition: 0.2s;
        }

        .menu-btn:hover {
            background: #365d40;
        }

        .admin-label {
            background: #e8efe9;
            color: #24442f;
            padding: 9px 15px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        /* ================= CARDS ================= */

        .cards {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .card {
            background: white;
            padding: 23px;
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            border: 1px solid #edf0ed;
            transition: transform 0.25s, box-shadow 0.25s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            color: #888;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .card h2 {
            font-size: 30px;
            color: #24442f;
            font-weight: 600;
        }

        .card-line {
            width: 35px;
            height: 4px;
            background: #a5bba8;
            border-radius: 5px;
            margin-top: 13px;
        }

        /* ================= TABLE SECTION ================= */

        .table-section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            border: 1px solid #edf0ed;
            width: 100%;
            min-width: 0;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .table-header h2 {
            font-size: 18px;
            color: #24442f;
            font-weight: 600;
        }

        .table-header p {
            font-size: 12px;
            color: #999;
            margin-top: 4px;
        }

        .table-scroll {
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
            border: 1px solid #edf0ed;
            border-radius: 10px;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            min-width: 1900px;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: auto;
        }

        thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #24442f;
            color: white;
            padding: 15px 13px;
            text-align: left;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        tbody td {
            padding: 14px 13px;
            border-bottom: 1px solid #edf0ed;
            font-size: 12px;
            color: #555;
            vertical-align: top;
            white-space: nowrap;
        }

        tbody tr:hover {
            background: #f8faf8;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .address,
        .notes {
            white-space: normal;
            min-width: 160px;
            max-width: 230px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .price {
            white-space: nowrap;
            font-weight: 500;
            color: #24442f;
        }

        /* ================= STATUS ================= */

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3d9;
            color: #a36b00;
        }

        .status-approved {
            background: #e0f2e5;
            color: #24733a;
        }

        .status-rejected {
            background: #fde5e5;
            color: #bd3333;
        }

        .status-completed {
            background: #e1efff;
            color: #2764a4;
        }

        /* ================= BUTTON ================= */

        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            border: none;
            border-radius: 7px;
            color: white;
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            transition: 0.2s;
        }

        .btn-approve {
            background: #27834a;
        }

        .btn-approve:hover {
            background: #1d6639;
        }

        .btn-reject {
            background: #d94b4b;
        }

        .btn-reject:hover {
            background: #b93636;
        }

        .btn-complete {
            background: #3975b9;
        }

        .btn-complete:hover {
            background: #285d98;
        }

        /* ================= ASSIGN THERAPIST ================= */

        .assign-form {
            min-width: 150px;
        }

        .assign-form select {
            width: 150px;
            padding: 9px;
            border: 1px solid #dce3dd;
            border-radius: 7px;
            background: white;
            font-size: 11px;
            outline: none;
            margin-bottom: 5px;
        }

        .assign-form select:focus {
            border-color: #24442f;
        }

        /* ================= ALERT ================= */

        .alert {
            padding: 12px 15px;
            border-radius: 9px;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .success-message {
            color: #155724;
            background: #d4edda;
        }

        .error-message {
            color: #721c24;
            background: #f8d7da;
        }

        /* ================= TABLE SCROLLBAR ================= */

        .table-scroll::-webkit-scrollbar {
            height: 9px;
        }

        .table-scroll::-webkit-scrollbar-track {
            background: #f1f3f1;
            border-radius: 10px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background: #aab9ad;
            border-radius: 10px;
        }

        .table-scroll::-webkit-scrollbar-thumb:hover {
            background: #718b76;
        }

        /* ================= TABLET ================= */

        @media (max-width: 1000px) {
            .main {
                padding: 22px;
            }

            .cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* ================= MOBILE ================= */

        @media (max-width: 600px) {
            .main {
                padding: 16px;
            }

            .navbar {
                margin-bottom: 22px;
            }

            .navbar h1 {
                font-size: 19px;
            }

            .navbar p {
                font-size: 11px;
            }

            .admin-label {
                display: none;
            }

            .cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 11px;
            }

            .card {
                padding: 16px;
                border-radius: 12px;
            }

            .card h3 {
                font-size: 11px;
            }

            .card h2 {
                font-size: 24px;
            }

            .table-section {
                padding: 15px;
            }

            .table-header h2 {
                font-size: 16px;
            }

            .sidebar {
                width: 270px;
            }

            .sidebar-close {
                display: block;
            }

            .sidebar-trigger {
                display: none;
            }

            .menu-btn {
                width: 39px;
                height: 39px;
            }
        }

        @media (max-width: 380px) {
            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- PEMICU SIDEBAR DESKTOP -->
    <div class="sidebar-trigger" id="sidebarTrigger"></div>

    <!-- OVERLAY MOBILE -->
    <div class="overlay" id="overlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <button class="sidebar-close" id="closeSidebar" type="button">
            &times;
        </button>

        <h2 class="logo">CLAIRE</h2>

        <ul>
            <li class="active">
                <a href="/admin">Dashboard</a>
            </li>

            <li>
                <a href="#">Treatments</a>
            </li>

            <li>
                <a href="#bookings">Bookings</a>
            </li>

            <li>
                <a href="#">Customers</a>
            </li>

            <li>
                <a href="{{ route('admin.therapistSchedules') }}">
                    Kalender Terapis
                </a>
            </li>

            <li>
                <a href="#">Messages</a>
            </li>

            <li>
                <a href="#">Reviews</a>
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

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">

        <!-- NAVBAR -->
        <div class="navbar">

            <div class="navbar-left">
                <button class="menu-btn" id="menuBtn" type="button">
                    &#9776;
                </button>

                <div>
                    <h1>Admin Dashboard</h1>
                    <p>Selamat datang di dashboard CLAIRE</p>
                </div>
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
                <div>
                    <h2>Recent Bookings</h2>
                    <p>Informasi dan pengelolaan pemesanan treatment CLAIRE</p>
                </div>
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

            <div class="table-scroll">

                <table>

                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Treatment</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Terapis</th>
                            <th>Location</th>
                            <th>Address</th>
                            <th>Payment</th>
                            <th>Treatment Price</th>
                            <th>Service Fee</th>
                            <th>Total Price</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>Assign Therapist</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($bookings as $booking)

                        <tr>

                            <td>
                                {{ $booking->user->name ?? '-' }}
                            </td>

                            <td>
                                {{ $booking->gender ?? '-' }}
                            </td>

                            <td>
                                {{ $booking->phone ?? '-' }}
                            </td>

                            <td>
                                {{ $booking->treatment }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ substr($booking->booking_time, 0, 5) }}
                            </td>

                            <td>
                                {{ $booking->therapist->name ?? 'Belum ditugaskan' }}
                            </td>

                            <td>
                                {{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}
                            </td>

                            <td class="address">
                                {{ $booking->place === 'home' ? ($booking->address ?? '-') : 'Klinik CLAIRE' }}
                            </td>

                            <td>
                                {{ $booking->payment_method ?? '-' }}
                            </td>

                            <td class="price">
                                Rp{{ number_format($booking->price ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="price">
                                Rp{{ number_format($booking->service_fee ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="price">
                                Rp{{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="notes">
                                {{ $booking->notes ?? '-' }}
                            </td>

                            <td>
                                @if($booking->status === 'pending')
                                <span class="status status-pending">Pending</span>
                                @elseif($booking->status === 'approved')
                                <span class="status status-approved">Approved</span>
                                @elseif($booking->status === 'rejected')
                                <span class="status status-rejected">Rejected</span>
                                @elseif($booking->status === 'completed')
                                <span class="status status-completed">Completed</span>
                                @endif
                            </td>

                            <!-- ASSIGN THERAPIST -->
                            <td>

                                @if($booking->status !== 'rejected' && $booking->status !== 'completed')

                                <form
                                    action="{{ route('booking.assignTherapist', $booking->id) }}"
                                    method="POST"
                                    class="assign-form">

                                    @csrf

                                    <select name="therapist_id" required>
                                        <option value="">Pilih Terapis</option>

                                        @if($booking->therapist && !$therapists->contains('id', $booking->therapist_id))
                                        <option value="{{ $booking->therapist_id }}" selected disabled>
                                            {{ $booking->therapist->name }} (Nonaktif)
                                        </option>
                                        @endif

                                        @foreach($therapists as $therapist)
                                        <option
                                            value="{{ $therapist->id }}"
                                            {{ $booking->therapist_id == $therapist->id ? 'selected' : '' }}>
                                            {{ $therapist->name }}
                                        </option>
                                        @endforeach

                                    </select>

                                    <button type="submit" class="btn btn-approve">
                                        Simpan
                                    </button>

                                </form>

                                @else
                                -
                                @endif

                            </td>

                            <!-- ACTION -->
                            <td>

                                @if($booking->status === 'pending')

                                <a
                                    href="/booking/{{ $booking->id }}/approve"
                                    class="btn btn-approve">
                                    Approve
                                </a>

                                <a
                                    href="/booking/{{ $booking->id }}/reject"
                                    class="btn btn-reject">
                                    Reject
                                </a>

                                @elseif($booking->status === 'approved')

                                <a
                                    href="/booking/{{ $booking->id }}/complete"
                                    class="btn btn-complete">
                                    Complete
                                </a>

                                @elseif($booking->status === 'completed')

                                <span style="color:#2764a4;font-weight:600;">
                                    Completed
                                </span>

                                @elseif($booking->status === 'rejected')

                                <span style="color:#bd3333;font-weight:600;">
                                    Rejected
                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="17" style="text-align:center;padding:30px;">
                                Belum ada booking.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const trigger = document.getElementById('sidebarTrigger');
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeSidebar');
        const overlay = document.getElementById('overlay');

        let sidebarPinned = false;
        let closeTimer;

        function openSidebar() {
            clearTimeout(closeTimer);
            sidebar.classList.add('show');

            if (window.innerWidth <= 600) {
                overlay.classList.add('show');
            }
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            sidebarPinned = false;
        }

        // Tombol menu untuk membuka atau mengunci sidebar
        menuBtn.addEventListener('click', function() {
            if (sidebar.classList.contains('show') && sidebarPinned) {
                closeSidebar();
            } else {
                sidebarPinned = true;
                openSidebar();
            }
        });

        // Sidebar muncul ketika kursor menuju tepi kiri layar
        trigger.addEventListener('mouseenter', function() {
            if (window.innerWidth > 600 && !sidebarPinned) {
                openSidebar();
            }
        });

        // Sidebar menutup ketika kursor meninggalkan sidebar
        sidebar.addEventListener('mouseleave', function() {
            if (window.innerWidth > 600 && !sidebarPinned) {
                closeTimer = setTimeout(closeSidebar, 250);
            }
        });

        sidebar.addEventListener('mouseenter', function() {
            clearTimeout(closeTimer);
        });

        // Tombol tutup
        closeBtn.addEventListener('click', closeSidebar);

        // Klik overlay menutup sidebar di HP
        overlay.addEventListener('click', closeSidebar);

        // Menutup sidebar setelah memilih menu di HP
        sidebar.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 600) {
                    closeSidebar();
                }
            });
        });

        // Menyesuaikan tampilan ketika ukuran layar berubah
        window.addEventListener('resize', function() {
            if (window.innerWidth > 600) {
                overlay.classList.remove('show');
            } else if (sidebar.classList.contains('show')) {
                overlay.classList.add('show');
            }
        });
    </script>

</body>

</html>