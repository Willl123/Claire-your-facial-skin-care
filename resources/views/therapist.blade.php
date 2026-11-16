
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Dashboard - CLAIRE</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f7f8f5;
            color: #333;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #24442f;
            color: white;
            padding: 30px 20px;
        }

        .logo {
            margin-bottom: 45px;
            letter-spacing: 4px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 25px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .main {
            margin-left: 240px;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px #00000008;
        }

        .card h3 {
            color: #777;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .card h2 {
            color: #24442f;
            font-size: 28px;
        }

        .table-container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
            white-space: nowrap;
        }

        th {
            color: #777;
            font-size: 13px;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .pending {
            background: #fff3cd;
            color: #856404;
        }

        .approved {
            background: #d4edda;
            color: #155724;
        }

        .completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .logout {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 15px;
        }

        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }

            .sidebar li {
                margin: 0;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .cards {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

<aside class="sidebar">

    <h2 class="logo">CLAIRE</h2>

    <ul>
        <li><a href="{{ route('therapist.dashboard') }}">Dashboard</a></li>
        <li><a href="#bookings">My Bookings</a></li>

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

<main class="main">

    <div class="header">
        <div>
            <h1>Dashboard Terapis</h1>
            <p>Selamat datang, {{ Auth::user()->name }}</p>
        </div>
    </div>

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

    <section class="table-container" id="bookings">

        <h2>Jadwal Treatment Saya</h2>

        <table>

            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Treatment</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Telepon</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($bookings as $booking)

                    <tr>
                        <td>
                            {{ $booking->user->name ?? 'Customer' }}
                        </td>

                        <td>{{ $booking->treatment }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                        </td>

                        <td>{{ substr($booking->booking_time, 0, 5) }}</td>

                        <td>{{ $booking->phone ?? '-' }}</td>

                        <td>
                            <span class="status {{ $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" style="text-align:center;">
                            Belum ada booking yang ditugaskan kepada Anda.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </section>

</main>

</body>
</html>
