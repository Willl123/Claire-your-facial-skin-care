<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

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
    min-height:100vh;
    padding:30px;
}

.container{
    max-width:1000px;
    margin:auto;
}

/* HEADER */

.profile-header{
    background:white;
    border-radius:25px;
    padding:40px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    text-align:center;
    margin-bottom:25px;
}

.profile-image{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:5px solid #24442f;
}

.change-photo{
    display:inline-block;
    margin-top:12px;
    color:#24442f;
    font-weight:600;
    cursor:pointer;
    font-size:14px;
}

.change-photo:hover{
    text-decoration:underline;
}

.name{
    margin-top:20px;
    font-size:28px;
    color:#24442f;
    font-weight:700;
}

.email{
    color:#777;
    margin-top:8px;
}

/* STATS */

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:25px;
}

.stat-card{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.stat-title{
    color:#888;
    font-size:14px;
}

.stat-value{
    margin-top:10px;
    font-size:32px;
    font-weight:700;
    color:#24442f;
}

/* INFO */

.info-section{
    background:white;
    border-radius:25px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.section-title{
    color:#24442f;
    margin-bottom:20px;
}

.info-box{
    background:#f8f9fb;
    border-radius:15px;
    padding:18px;
    margin-bottom:15px;
}

.info-label{
    color:#888;
    font-size:13px;
}

.info-value{
    margin-top:5px;
    font-weight:600;
    color:#333;
}

/* BUTTONS */

.actions{
    margin-top:25px;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.btn{
    flex:1;
    min-width:180px;
    border:none;
    border-radius:14px;
    padding:15px;
    cursor:pointer;
    font-size:15px;
    font-weight:600;
    transition:.3s;
}

.edit-btn{
    background:#24442f;
    color:white;
}

.edit-btn:hover{
    opacity:.9;
}

.logout-btn{
    background:#dc2626;
    color:white;
}

.logout-btn:hover{
    background:#b91c1c;
}

/* RESPONSIVE */

@media(max-width:768px){

    body{
        padding:15px;
    }

    .profile-header{
        padding:25px;
    }

    .name{
        font-size:24px;
    }

    .actions{
        flex-direction:column;
    }

    .btn{
        width:100%;
    }
}

/* BACK BUTTON */
.back-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:#24442f;
    background:#ffffff;
    padding:12px 18px;
    border-radius:12px;
    font-weight:600;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    margin-bottom:20px;
    transition:.3s;
}

.back-btn:hover{
    background:#24442f;
    color:#fff;
    transform:translateX(-3px);
}

.back-btn svg{
    width:20px;
    height:20px;
}

@media(max-width:768px){

    .back-btn{
        width:fit-content;
        padding:10px 15px;
        margin-bottom:15px;
    }

}

/* BACK BUTTON */
.back-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:#24442f;
    background:#ffffff;
    padding:12px 18px;
    border-radius:12px;
    font-weight:600;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    margin-bottom:20px;
    transition:.3s;
}

.back-btn:hover{
    background:#24442f;
    color:#fff;
    transform:translateX(-3px);
}

.back-btn svg{
    width:20px;
    height:20px;
}

@media(max-width:768px){

    .back-btn{
        width:fit-content;
        padding:10px 15px;
        margin-bottom:15px;
    }

}

</style>
</head>
<body>

<div class="container">

    <a href="/dashboard" class="back-btn">

        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 19l-7-7 7-7"/>

        </svg>

        Back

    </a>

    <!-- PROFILE HEADER -->
    <div class="profile-header">

    @php
        $user = Auth::user();
    @endphp

    <img
        id="previewImage"
        src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=24442f&color=fff&size=200' }}"
        class="profile-image"
        alt="Foto Profil"
    >

    <form
        action="{{ route('profile.photo') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <label class="change-photo">
            Change Photo

            <input
                type="file"
                name="photo"
                accept="image/*"
                hidden
                onchange="previewAndSubmit(this)">
        </label>

    </form>

    <h2 class="name">{{ $user->name }}</h2>
    <p class="email">{{ $user->email }}</p>

</div>

    <!-- STATS -->
    <div class="stats">

        <div class="stat-card">
            <div class="stat-title">
                Total Bookings
            </div>

            <div class="stat-value">
                {{ $totalBooking }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-title">
                Completed Treatments
            </div>

            <div class="stat-value">
                {{ $completedBooking }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-title">
                Pending Bookings
            </div>

            <div class="stat-value">
                {{ $pendingBooking }}
            </div>
        </div>

    </div>

    <!-- ACCOUNT INFO -->
    <div class="info-section">

        <h3 class="section-title">
            Account Information
        </h3>

        <div class="info-box">
            <div class="info-label">
                Account Status
            </div>

            <div class="info-value">
                Active Member
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">
                Email Address
            </div>

            <div class="info-value">
                {{ Auth::user()->email }}
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">
                Member Since
            </div>

            <div class="info-value">
                {{ Auth::user()->created_at->format('d M Y') }}
            </div>
        </div>

        <div class="actions">

            <!-- <button class="btn edit-btn">
                Edit Profile
            </button> -->

            <form
            id="logoutForm"
            action="{{ route('logout') }}"
            method="POST"
            style="flex:1;">

                @csrf

                <button
                type="submit"
                class="btn logout-btn">
                    Logout
                </button>

            </form>

        </div>

    </div>

</div>

<script>

function previewAndSubmit(input){

    if(input.files && input.files[0]){

        let reader = new FileReader();

        reader.onload = function(e){

            document
            .getElementById('previewImage')
            .src = e.target.result;

        }

        reader.readAsDataURL(input.files[0]);

        input.form.submit();
    }
}

document
.getElementById("logoutForm")
.addEventListener("submit",function(e){

    if(!confirm("Yakin ingin logout?")){
        e.preventDefault();
    }

});

</script>

</body>
</html>