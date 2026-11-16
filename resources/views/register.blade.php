<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#fdf7f3,#f7ebe5);
    padding:20px;
}

.card{
    width:100%;
    max-width:500px;
    background:#fff;
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.logo{
    text-align:center;
    font-size:32px;
    font-weight:700;
    color:#24442f;
    margin-bottom:25px;
}

.progress{
    width:100%;
    height:8px;
    background:#eee;
    border-radius:10px;
    margin-bottom:30px;
}

.progress-bar{
    width:33%;
    height:100%;
    background:#24442f;
    border-radius:10px;
    transition:.3s;
}

.step{
    display:none;
}

.step.active{
    display:block;
}

h2{
    margin-bottom:10px;
}

p{
    color:#777;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:14px;
    border:1px solid #ddd;
    border-radius:12px;
    margin-bottom:20px;
}

input:focus{
    outline:none;
    border-color:#24442f;
}

.btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    background:#24442f;
    color:white;
    cursor:pointer;
    font-size:16px;
}

.btn:hover{
    opacity:.9;
}

.error{
    color:red;
    margin-bottom:15px;
}

</style>
</head>
<body>

<div class="card">

    <div class="logo">
        CLAIRE
    </div>

    <div class="progress">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/register">

        @csrf

        <!-- STEP 1 -->

        <div class="step active">

            <h2>What's your name?</h2>

            <p>Let's start with your full name.</p>

            <input
                type="text"
                name="name"
                id="name"
                placeholder="Full Name"
                required>

            <button
                type="button"
                class="btn"
                onclick="nextStep()">

                Continue

            </button>

        </div>

        <!-- STEP 2 -->

        <div class="step">

            <h2>What's your email?</h2>

            <p>We'll use it for your account.</p>

            <input
                type="email"
                name="email"
                id="email"
                placeholder="Email Address"
                required>

            <button
                type="button"
                class="btn"
                onclick="nextStep()">

                Continue

            </button>

        </div>

        <!-- STEP 3 -->

        <div class="step">

            <h2>Create Password</h2>

            <p>Minimum 6 characters.</p>

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Password"
                required>

            <button
                type="submit"
                class="btn">

                Create Account

            </button>

        </div>

    </form>

</div>

<script>

const steps =
document.querySelectorAll(".step");

const progressBar =
document.getElementById("progressBar");

let currentStep = 0;

function nextStep(){

    if(currentStep === 0){

        const name =
        document.getElementById("name").value;

        if(name.trim()===""){

            alert("Please enter your name");

            return;
        }

    }

    if(currentStep === 1){

        const email =
        document.getElementById("email").value;

        if(email.trim()===""){

            alert("Please enter your email");

            return;
        }

    }

    steps[currentStep]
    .classList.remove("active");

    currentStep++;

    steps[currentStep]
    .classList.add("active");

    progressBar.style.width =
    ((currentStep + 1) * 33.33) + "%";

}

</script>

</body>
</html>