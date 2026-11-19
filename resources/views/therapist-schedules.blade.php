<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Terapis - CLAIRE</title>

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
            padding: 32px 40px 48px;
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: auto;
        }

        /* ================= HEADER ================= */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .header h1 {
            font-family: var(--serif);
            font-weight: 500;
            font-size: 34px;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .header p {
            margin-top: 6px;
            color: var(--muted);
        }

        .back-button,
        .month-button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-button {
            background: var(--brand);
            color: var(--brand-ink);
        }

        .back-button:hover {
            opacity: 0.88;
        }

        /* ================= KALENDER ================= */

        .calendar-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 24px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .calendar-header h2 {
            font-family: var(--serif);
            font-weight: 500;
            font-size: 26px;
            letter-spacing: -0.01em;
            text-transform: capitalize;
        }

        .month-navigation {
            display: flex;
            gap: 8px;
        }

        .month-button {
            background: transparent;
            color: var(--ink);
            border: 1px solid var(--line);
        }

        .month-button:hover {
            background: var(--bg);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            border-top: 1px solid var(--line);
            border-left: 1px solid var(--line);
            border-radius: 8px;
            overflow: hidden;
        }

        .weekday {
            padding: 13px 6px;
            text-align: center;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--muted);
            background: var(--bg);
            border-right: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        .calendar-day {
            min-height: 145px;
            padding: 8px;
            border-right: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            min-width: 0;
        }

        .calendar-day.other-month {
            background: var(--bg);
            color: var(--muted);
            opacity: 0.7;
        }

        .day-number {
            display: inline-flex;
            width: 27px;
            height: 27px;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 13px;
            font-weight: 500;
            font-variant-numeric: tabular-nums;
            margin-bottom: 7px;
        }

        .day-number.today {
            background: var(--brand);
            color: var(--brand-ink);
            font-weight: 600;
        }

        /* ================= EVENT BOOKING ================= */

        .booking-event {
            background: var(--ok-bg);
            border-left: 3px solid var(--brand);
            padding: 8px 9px;
            margin-bottom: 6px;
            border-radius: 6px;
            font-size: 11.5px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .booking-event strong {
            display: block;
            color: var(--ink);
            font-weight: 600;
            margin-bottom: 2px;
        }

        .booking-event span {
            display: block;
            color: var(--muted);
        }

        .booking-event span.event-status {
            display: inline-block;
            margin-top: 5px;
            padding: 2px 9px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .status-approved {
            background: var(--surface);
            color: var(--ok);
        }

        .status-completed {
            background: var(--done-bg);
            color: var(--done);
        }

        .booking-event:has(.status-completed) {
            background: var(--done-bg);
            border-left-color: var(--done);
        }

        .booking-event:has(.status-completed) .event-status {
            background: var(--surface);
        }

        /* ================= STATUS TERAPIS ================= */

        .therapist-status {
            display: inline-block;
            margin-top: 3px;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 600;
        }

        .therapist-status.active {
            background: var(--ok-bg);
            color: var(--ok);
        }

        .therapist-status.inactive {
            background: var(--bad-bg);
            color: var(--bad);
        }

        .empty-message {
            padding: 36px;
            text-align: center;
            color: var(--muted);
        }

        /* ================= DAFTAR TERAPIS ================= */

        .therapist-list {
            margin-top: 22px;
            padding: 22px;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
        }

        .therapist-list h3 {
            font-family: var(--serif);
            font-weight: 500;
            font-size: 20px;
            margin-bottom: 14px;
        }

        .therapist-items {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .therapist-item {
            padding: 9px 13px;
            border: 1px solid var(--line);
            border-radius: 8px;
            font-size: 13px;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 768px) {
            body {
                padding: 18px 14px 40px;
            }

            .header h1 {
                font-size: 26px;
            }

            .calendar-card {
                padding: 12px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .calendar-grid {
                min-width: 700px;
            }

            .calendar-day {
                min-height: 120px;
            }

            .calendar-header h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- ================= HEADER ================= -->
        <div class="header">
            <div>
                <h1>Kalender Jadwal Terapis</h1>
                <p>Kelola dan pantau jadwal treatment seluruh terapis CLAIRE.</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="back-button">
                Kembali ke Dashboard
            </a>
        </div>




        <!-- ================= KALENDER ================= -->
        <div class="calendar-card">

            <div class="calendar-header">
                <h2>
                    {{ $currentMonth->locale('id')->translatedFormat('F Y') }}
                </h2>

                <div class="month-navigation">
                    <a href="{{ route('admin.therapistSchedules', ['month' => $previousMonth]) }}"
                        class="month-button">
                        &laquo; Sebelumnya
                    </a>

                    <a href="{{ route('admin.therapistSchedules', ['month' => $nextMonth]) }}"
                        class="month-button">
                        Berikutnya &raquo;
                    </a>
                </div>
            </div>

            <div class="calendar-grid">

                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $weekday)
                <div class="weekday">
                    {{ $weekday }}
                </div>
                @endforeach

                @foreach($calendarDays as $day)

                @php
                $dateKey = $day->format('Y-m-d');
                $dayAssignments = $assignments->get($dateKey, collect());
                $isCurrentMonth = $day->month === $currentMonth->month;
                $isToday = $day->isToday();
                @endphp

                <div class="calendar-day {{ $isCurrentMonth ? '' : 'other-month' }}">

                    <div class="day-number {{ $isToday ? 'today' : '' }}">
                        {{ $day->day }}
                    </div>

                    @foreach($dayAssignments as $assignment)

                    @php
                    $booking = $assignment->booking;
                    @endphp

                    @php
                    $latestAssignment = $booking->assignments
                    ->sortByDesc('id')
                    ->first();
                    @endphp

                    <div class="booking-event">

                        <strong>
                            {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                            - {{ $booking->treatment }}
                        </strong>

                        <span>
                            Pelanggan:
                            {{ $booking->user->name ?? 'Tidak tersedia' }}
                        </span>

                        <span>
                            Terapis:
                            {{ $latestAssignment->therapist->name ?? $booking->therapist->name ?? 'Tidak tersedia' }}
                        </span>

                        @if($latestAssignment)
                        @if($latestAssignment->status === 'accepted')
                        <span class="event-status status-approved">
                            Diterima
                        </span>
                        @elseif($latestAssignment->status === 'completed')
                        <span class="event-status status-completed">
                            Selesai
                        </span>
                        @endif
                        @endif

                    </div>

                    @endforeach

                </div>

                @endforeach

            </div>

            @if($assignments->isEmpty())
            <div class="empty-message">
                Belum ada jadwal terapis pada bulan ini.
            </div>
            @endif

        </div>



    </div>

</body>

</html>