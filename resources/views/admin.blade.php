<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f5f7f9;
}

/* ===================== LAYOUT ===================== */
.container{
    display:flex;
    min-height:100vh;
}

/* ===================== SIDEBAR ===================== */
.sidebar{
    width:260px;
    background:#24442f;
    color:white;
    padding:25px;
    transition:0.3s ease;
    position:relative;
}

.logo{
    font-size:26px;
    text-align:center;
    margin-bottom:30px;
    font-weight:700;
}

.sidebar ul{
    list-style:none;
}

.sidebar ul li{
    margin-bottom:10px;
}

.sidebar ul li a{
    display:block;
    padding:12px;
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:0.2s;
}

.sidebar ul li a:hover,
.sidebar ul li.active a{
    background:rgba(255,255,255,0.15);
}

/* ===================== MAIN ===================== */
.main{
    flex:1;
    padding:25px;
    min-width:0;
}

/* NAV */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

#menuBtn{
    display:none;
    font-size:24px;
    background:none;
    border:none;
    cursor:pointer;
}

/* ===================== CARDS ===================== */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:15px;
    margin-bottom:25px;
}

.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}

.card h3{
    font-size:13px;
    color:#777;
}

.card h2{
    font-size:26px;
    color:#24442f;
}

/* ===================== TABLE ===================== */
.table-section{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}

/* scroll table */
table{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
}

th{
    background:#24442f;
    color:white;
    padding:12px;
    text-align:left;
    font-size:13px;
    white-space:nowrap;
}

td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:13px;
    word-break:break-word;
}

/* kolom panjang */
.notes, .address{
    max-width:220px;
}

.sidebar-link{
    display:block;
    padding:12px;
    color:white;
    text-decoration:none;
    border-radius:8px;
    background:none;
    border:none;
    width:100%;
    text-align:left;
    font-size:14px;
    cursor:pointer;
    transition:0.2s;
}

.sidebar-link:hover{
    background:rgba(255,255,255,0.15);
}


.logout-link:hover{
    background:rgba(255,0,0,0.2);
}

/* ===================== STATUS ===================== */
.status-pending{color:orange;font-weight:600;}
.status-approved{color:green;font-weight:600;}
.status-rejected{color:red;font-weight:600;}
.status-completed{color:blue;font-weight:600;}

/* ===================== BUTTON ===================== */
.btn{
    padding:6px 10px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-size:12px;
    margin-right:5px;
    display:inline-block;
}

.btn-approve{background:green;}
.btn-reject{background:red;}
.btn-complete{background:blue;}

/* ===================== MOBILE ===================== */
@media (max-width:768px){

    .container{
        flex-direction:column;
    }

    .sidebar{
        position:fixed;
        top:0;
        left:-270px;
        height:100%;
        z-index:999;
        width:260px;
        box-shadow:2px 0 10px rgba(0,0,0,0.2);
    }

    .sidebar.show{
        left:0;
    }

    #menuBtn{
        display:block;
    }

    .main{
        padding:15px;
    }

    table{
        min-width:700px;
    }
}

/* extra small */
@media (max-width:480px){
    td{
        font-size:12px;
    }
}
</style>
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
            
    <aside class="sidebar">
        <h2 class="logo">CLAIRE</h2>

        <ul>
            <li class="active">
                <a href="/admin">Dashboard</a>
            </li>

            <li>
                <a href="#">Treatments</a>
            </li>

            <li>
                <a href="#">Bookings</a>
            </li>

            <li>
                <a href="#">Customers</a>
            </li>

            <li>
                <a href="#">Therapists</a>
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


    <!-- MAIN -->
    <main class="main">

        <div class="navbar">
            <button id="menuBtn">☰</button>
            <h2>Admin Dashboard</h2>
        </div>

        <!-- CARDS -->
        <section class="cards">
            <div class="card">
                <h3>Total Bookings</h3>
                <h2>{{ $bookings->count() }}</h2>
            </div>

            <div class="card">
                <h3>Customers</h3>
                <h2>{{ \App\Models\User::where('role','customer')->count() }}</h2>
            </div>

            <div class="card">
                <h3>Pending</h3>
                <h2>{{ $bookings->where('status','pending')->count() }}</h2>
            </div>

            <div class="card">
                <h3>Completed</h3>
                <h2>{{ $bookings->where('status','completed')->count() }}</h2>
            </div>
        </section>

        <!-- TABLE -->
        <section class="table-section">
            <h3 style="margin-bottom:15px;">Recent Bookings</h3>

            <table>
                <tr>
                    <th>Customer</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Treatment</th>
                    <th>Date</th>
                    <th>Time</th>

                    <!-- ✅ TAMBAHAN GENDER -->
                    <th>Terapis</th>
                    <th>Treatment Location</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name ?? '-' }}</td>
                    <td>{{ $booking->gender ?? '-' }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>{{ $booking->treatment }}</td>
                    <td>{{ $booking->booking_date }}</td>
                    <td>{{ $booking->booking_time }}</td>

                    <!-- AMBAHAN GENDER -->

                    <td class="address">{{ $booking->address ?? '-' }}</td>
                    <td class="notes">{{ $booking->notes ?? '-' }}</td>

                    <td>
                        @if($booking->status == 'pending')
                            <span class="status-pending">Pending</span>
                        @elseif($booking->status == 'approved')
                            <span class="status-approved">Approved</span>
                        @elseif($booking->status == 'rejected')
                            <span class="status-rejected">Rejected</span>
                        @elseif($booking->status == 'completed')
                            <span class="status-completed">Completed</span>
                        @endif
                    </td>

                        <td>
                        <form action="{{ route('booking.assignTherapist', $booking->id) }}" method="POST">
                            @csrf

                            <select name="therapist_id" required>
                                <option value="">Pilih Terapis</option>

                                @foreach($therapists as $therapist)
                                    <option value="{{ $therapist->id }}"
                                        {{ $booking->therapist_id == $therapist->id ? 'selected' : '' }}>
                                        {{ $therapist->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-approve">
                                Simpan
                            </button>
                        </form>
                    </td>

                <td>

                @if($booking->status == 'pending')

                    <a href="/booking/{{ $booking->id }}/approve"
                    class="btn btn-approve">
                        Approve
                    </a>

                    <a href="/booking/{{ $booking->id }}/reject"
                    class="btn btn-reject">
                        Reject
                    </a>

                @elseif($booking->status == 'approved')

                    <a href="/booking/{{ $booking->id }}/complete"
                    class="btn btn-complete">
                        Complete
                    </a>

                @elseif($booking->status == 'completed')

                    <span style="color:blue;font-weight:600;">
                        Completed ✔
                    </span>

                @elseif($booking->status == 'rejected')

                    <span style="color:red;font-weight:600;">
                        Rejected ✖
                    </span>

                @endif

                </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">Belum ada booking</td>
                                </tr>
                                @endforelse
                            </table>
                        </section>

                    </main>
                </div>

            <script>
            const menuBtn = document.getElementById('menuBtn');
            const sidebar = document.querySelector('.sidebar');

            menuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
                if(!sidebar.contains(e.target) && !menuBtn.contains(e.target)){
                    sidebar.classList.remove('show');
                }
            });
            </script>

</body>
</html>