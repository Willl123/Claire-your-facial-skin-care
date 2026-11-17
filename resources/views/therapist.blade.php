
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Dashboard - CLAIRE</title>

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
        }

        /* SIDEBAR */

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 30px 20px;
            background: #24442f;
            color: white;
            z-index: 10;
        }

        .logo {
            margin-bottom: 50px;
            letter-spacing: 4px;
            font-size: 25px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 12px;
        }

        .sidebar a {
            display: block;
            padding: 13px 15px;
            color: #e7eee8;
            text-decoration: none;
            font-size: 14px;
            border-radius: 9px;
            transition: .2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,.13);
            color: white;
        }

        .logout {
            width: 100%;
            padding: 13px 15px;
            border: none;
            background: transparent;
            color: white;
            text-align: left;
            font-size: 14px;
            cursor: pointer;
            border-radius: 9px;
        }

        .logout:hover {
            background: rgba(255,255,255,.13);
        }

        /* MAIN */

        .main {
            margin-left: 240px;
            padding: 35px;
            min-height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #24442f;
            font-size: 26px;
            font-weight: 700;
        }

        .header p {
            margin-top: 6px;
            color: #858b86;
            font-size: 13px;
        }

        /* AVAILABILITY */

        .availability-box {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .availability {
            padding: 9px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        .availability.active {
            background: #dcfce7;
            color: #15803d;
        }

        .availability.inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .availability-button {
            padding: 10px 16px;
            border: none;
            border-radius: 9px;
            background: #24442f;
            color: white;
            font-size: 12px;
            cursor: pointer;
            transition: .2s;
        }

        .availability-button:hover {
            background: #365d40;
        }

        /* STATISTIC CARDS */

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .card {
            padding: 23px;
            background: white;
            border: 1px solid #edf0ed;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,.035);
        }

        .card h3 {
            color: #858b86;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 13px;
        }

        .card h2 {
            color: #24442f;
            font-size: 28px;
            font-weight: 700;
        }

        /* ALERT */

        .alert {
            padding: 13px 17px;
            margin-bottom: 18px;
            border-radius: 9px;
            font-size: 13px;
        }

        .alert.success {
            background: #dcfce7;
            color: #166534;
        }

        .alert.error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* CALENDAR */

        .calendar-card {
            padding: 25px;
            background: white;
            border: 1px solid #edf0ed;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,.035);
        }

        .calendar-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 23px;
        }

        .calendar-top h2 {
            color: #24442f;
            font-size: 19px;
        }

        .month-navigation {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .month-navigation a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border: 1px solid #e5eae5;
            border-radius: 8px;
            color: #24442f;
            text-decoration: none;
            font-size: 19px;
            transition: .2s;
        }

        .month-navigation a:hover {
            background: #24442f;
            color: white;
        }

        .month-name {
            min-width: 125px;
            text-align: center;
            color: #24442f;
            font-size: 14px;
            font-weight: 600;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            border-top: 1px solid #edf0ed;
            border-left: 1px solid #edf0ed;
        }

        .weekday {
            padding: 13px 5px;
            background: #f5f8f5;
            color: #68766b;
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            border-right: 1px solid #edf0ed;
            border-bottom: 1px solid #edf0ed;
        }

        .calendar-day {
            min-width: 0;
            min-height: 145px;
            padding: 9px;
            background: white;
            border-right: 1px solid #edf0ed;
            border-bottom: 1px solid #edf0ed;
        }

        .calendar-day.other-month {
            background: #fafbfa;
        }

        .day-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 27px;
            height: 27px;
            margin-bottom: 8px;
            border-radius: 50%;
            color: #59645b;
            font-size: 11px;
            font-weight: 600;
        }

        .other-month .day-number {
            color: #b9c0ba;
        }

        .day-number.today {
            background: #24442f;
            color: white;
        }

        /* BOOKING EVENT */

        .booking-event {
            padding: 8px;
            margin-bottom: 7px;
            background: #edf4ee;
            border-left: 3px solid #24442f;
            border-radius: 6px;
            overflow: hidden;
        }

        .event-time {
            color: #24442f;
            font-size: 10px;
            font-weight: 700;
        }

        .event-treatment {
            margin-top: 3px;
            color: #344238;
            font-size: 10px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .event-customer {
            margin-top: 3px;
            color: #788078;
            font-size: 9px;
            overflow-wrap: anywhere;
        }

        .event-status {
            display: inline-block;
            margin-top: 6px;
            padding: 3px 6px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 600;
        }

        .event-status.pending {
            background: #fef3c7;
            color: #a16207;
        }

        .event-status.approved {
            background: #dcfce7;
            color: #15803d;
        }

        .event-status.completed {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .event-status.rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* BOOKING DETAILS */

        .booking-details {
            margin-top: 7px;
            padding-top: 6px;
            border-top: 1px solid #dce8dd;
        }

        .booking-details summary {
            color: #24442f;
            font-size: 9px;
            font-weight: 600;
            cursor: pointer;
        }

        .details-content {
            margin-top: 8px;
            color: #58645a;
            font-size: 9px;
            line-height: 1.8;
            overflow-wrap: anywhere;
        }

        .details-content strong {
            color: #344238;
        }

        .btn-complete {
            width: 100%;
            margin-top: 8px;
            padding: 7px 5px;
            border: none;
            border-radius: 6px;
            background: #24442f;
            color: white;
            font-size: 9px;
            cursor: pointer;
        }

        .btn-complete:hover {
            background: #365d40;
        }

        .already-completed {
            display: block;
            margin-top: 7px;
            color: #15803d;
            font-size: 9px;
            font-weight: 600;
        }

        .empty-day {
            color: #c2c9c3;
            font-size: 10px;
        }

        /* LEGEND */

        .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #747e75;
            font-size: 10px;
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
        }

        .legend-pending { background: #f59e0b; }
        .legend-approved { background: #16a34a; }
        .legend-completed { background: #2563eb; }
        .legend-rejected { background: #dc2626; }

        /* RESPONSIVE */

        @media (max-width: 1100px) {
            .main {
                padding: 25px;
            }

            .calendar-day {
                min-height: 130px;
                padding: 6px;
            }

            .booking-event {
                padding: 6px;
            }
        }

        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .main {
                margin-left: 0;
                padding: 22px;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 18px 22px;
            }

            .logo {
                margin-bottom: 18px;
            }

            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                gap: 7px;
            }

            .sidebar li {
                margin: 0;
            }

            .calendar-card {
                overflow-x: auto;
            }

            .calendar-grid {
                min-width: 720px;
            }
        }

        @media (max-width: 600px) {
            .main {
                padding: 16px 12px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header h1 {
                font-size: 22px;
            }

            .cards {
                gap: 10px;
            }

            .card {
                padding: 17px;
            }

            .card h2 {
                font-size: 23px;
            }

            .calendar-card {
                padding: 17px 12px;
            }

            .calendar-top h2 {
                font-size: 16px;
            }

            .month-navigation {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <h2 class="logo">CLAIRE</h2>

        <ul>
            <li>
                <a href="{{ route('therapist.dashboard') }}" class="active">
                    Schedul
                </a>
            </li>

            <li>
                <a href="">
                    chat
                </a>
            </li>

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="logout">
                        Logout
                    </button>
                </form>
            </li>
        </ul>

    </aside>


    <!-- MAIN CONTENT -->

    <main class="main">

        <!-- HEADER -->

        <div class="header">

            <div>
                <h1>Dashboard Terapis</h1>
                <p>Selamat datang, {{ Auth::user()->name }}</p>
            </div>

            <div class="availability-box">

                @if(Auth::user()->is_available)
                    <span class="availability active">
                        ● Aktif
                    </span>
                @else
                    <span class="availability inactive">
                        ● Nonaktif
                    </span>
                @endif

                <form action="{{ route('therapist.toggleAvailability') }}" method="POST">
                    @csrf

                    <button type="submit" class="availability-button">
                        {{ Auth::user()->is_available ? 'Jadikan Nonaktif' : 'Jadikan Aktif' }}
                    </button>
                </form>

            </div>

        </div>


        <!-- SESSION MESSAGE -->

        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif


        <!-- STATISTIC CARDS -->

        <section class="cards">

            <div class="card">
                <h3>Total Booking</h3>
                <h2>{{ $totalBooking }}</h2>
            </div>

            <div class="card">
                <h3>Menunggu</h3>
                <h2>{{ $pendingBooking }}</h2>
            </div>

            <div class="card">
                <h3>Disetujui</h3>
                <h2>{{ $approvedBooking }}</h2>
            </div>

            <div class="card">
                <h3>Selesai</h3>
                <h2>{{ $completedBooking }}</h2>
            </div>

        </section>


        <!-- MY BOOKINGS CALENDAR -->

        <section class="calendar-card" id="bookings">

            <div class="calendar-top">

                <h2>Jadwal Treatment Saya</h2>

                <div class="month-navigation">

                    <a href="{{ route('therapist.dashboard', ['month' => $previousMonth]) }}">
                        &lsaquo;
                    </a>

                    <span class="month-name">
                        {{ $currentMonth->translatedFormat('F Y') }}
                    </span>

                    <a href="{{ route('therapist.dashboard', ['month' => $nextMonth]) }}">
                        &rsaquo;
                    </a>

                </div>

            </div>


            <!-- CALENDAR GRID -->

            <div class="calendar-grid">

                <!-- WEEKDAY -->

                @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $weekday)

                    <div class="weekday">
                        {{ $weekday }}
                    </div>

                @endforeach


                <!-- CALENDAR DAYS -->

                @foreach($calendarDays as $day)

                    @php
                        $dateKey = $day->format('Y-m-d');

                        $dayBookings = $bookings->get($dateKey, collect());

                        $isCurrentMonth = $day->month === $currentMonth->month;

                        $isToday = $day->isToday();
                    @endphp

                    <div class="calendar-day {{ $isCurrentMonth ? '' : 'other-month' }}">

                        <div class="day-number {{ $isToday ? 'today' : '' }}">
                            {{ $day->format('d') }}
                        </div>


                        <!-- BOOKINGS ON THIS DATE -->

                        @forelse($dayBookings as $booking)

                            <div class="booking-event">

                                <div class="event-time">
                                    {{ substr($booking->booking_time, 0, 5) }}
                                </div>

                                <div class="event-treatment">
                                    {{ $booking->treatment }}
                                </div>

                                <div class="event-customer">
                                    {{ $booking->user->name ?? 'Customer' }}
                                </div>

                                <span class="event-status {{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </span>


                                <!-- BOOKING DETAILS -->

                                <details class="booking-details">

                                    <summary>Lihat Detail</summary>

                                    <div class="details-content">

                                        <strong>Customer:</strong>
                                        {{ $booking->user->name ?? 'Customer' }}
                                        <br>

                                        <strong>Gender:</strong>
                                        {{ $booking->gender ?? '-' }}
                                        <br>

                                        <strong>Telepon:</strong>
                                        {{ $booking->phone ?? '-' }}
                                        <br>

                                        <strong>Treatment:</strong>
                                        {{ $booking->treatment }}
                                        <br>

                                        <strong>Waktu:</strong>
                                        {{ substr($booking->booking_time, 0, 5) }}
                                        <br>

                                        <strong>Lokasi:</strong>
                                        {{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}
                                        <br>

                                        @if($booking->place === 'home')
                                            <strong>Alamat:</strong>
                                            {{ $booking->address ?? '-' }}
                                            <br>
                                        @endif

                                        <strong>Pembayaran:</strong>
                                        {{ $booking->payment_method ?? '-' }}
                                        <br>

                                        <strong>Harga Treatment:</strong>
                                        Rp{{ number_format($booking->price ?? 0, 0, ',', '.') }}
                                        <br>

                                        <strong>Biaya Layanan:</strong>
                                        Rp{{ number_format($booking->service_fee ?? 0, 0, ',', '.') }}
                                        <br>

                                        <strong>Total:</strong>
                                        Rp{{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                                        <br>

                                        <strong>Catatan:</strong>
                                        {{ $booking->notes ?: '-' }}

                                    </div>

                                </details>


                                <!-- COMPLETE BOOKING -->

                                @if($booking->status === 'approved')

                                    <form
                                        action="{{ route('therapist.booking.complete', $booking->id) }}"
                                        method="POST">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn-complete"
                                            onclick="return confirm('Apakah treatment ini sudah selesai?')">

                                            Tandai Selesai

                                        </button>

                                    </form>

                                @elseif($booking->status === 'completed')

                                    <span class="already-completed">
                                        ✓ Sudah Selesai
                                    </span>

                                @endif

                            </div>

                        @empty

                            <span class="empty-day">-</span>

                        @endforelse

                    </div>

                @endforeach

            </div>


            <!-- STATUS LEGEND -->

            <div class="calendar-legend">

                <div class="legend-item">
                    <span class="legend-dot legend-pending"></span>
                    Menunggu
                </div>

                <div class="legend-item">
                    <span class="legend-dot legend-approved"></span>
                    Disetujui
                </div>

                <div class="legend-item">
                    <span class="legend-dot legend-completed"></span>
                    Selesai
                </div>

                <div class="legend-item">
                    <span class="legend-dot legend-rejected"></span>
                    Ditolak
                </div>

            </div>

        </section>

    </main>

</body>
</html>
