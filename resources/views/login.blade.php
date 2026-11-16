<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Claire Beauty Login</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    min-height:100vh;
    background:#f8f5f2;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
}

.container{
    width:100%;
    max-width:1200px;
    min-height:700px;
    display:flex;
    background:#fff;
    border-radius:35px;
    overflow:hidden;
    box-shadow:
    0 25px 60px rgba(0,0,0,.08);
}

/* LEFT */

.left{
    flex:1;
    position:relative;
    background:
    linear-gradient(
    rgba(0,0,0,.35),
    rgba(0,0,0,.35)
    ),
    url("https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=1400&q=80");

    background-size:cover;
    background-position:center;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px;
}

.overlay{
    color:white;
    max-width:450px;
}

.brand{
    font-size:18px;
    letter-spacing:8px;
    margin-bottom:25px;
}

.overlay h1{
    font-size:58px;
    line-height:1.1;
    margin-bottom:25px;
}

.overlay p{
    line-height:1.9;
    font-size:17px;
    opacity:.9;
}

/* RIGHT */

.right{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px;
}

.login-box{
    width:100%;
    max-width:420px;
}

.logo{
    font-size:34px;
    font-weight:700;
    margin-bottom:10px;
    color:#1f1f1f;
}

.subtitle{
    color:#777;
    margin-bottom:40px;
}

.input-group{
    margin-bottom:20px;
}

.input-group label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:500;
}

.input-group input{
    width:100%;
    padding:16px;
    border:1px solid #ddd;
    border-radius:14px;
    font-size:15px;
    outline:none;
    transition:.3s;
}

.input-group input:focus{
    border-color:#d7a86e;
    box-shadow:
    0 0 0 5px
    rgba(215,168,110,.15);
}

.option{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    font-size:14px;
}

.option a{
    color:#c18a4d;
    text-decoration:none;
}

.btn-login{
    width:100%;
    padding:18px;
    border:none;
    border-radius:14px;
    background:#111;
    color:white;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn-login:hover{
    transform:translateY(-2px);
}

.divider{
    text-align:center;
    margin:30px 0;
    color:#888;
    position:relative;
}

.divider::before,
.divider::after{
    content:"";
    position:absolute;
    top:50%;
    width:40%;
    height:1px;
    background:#ddd;
}

.divider::before{
    left:0;
}

.divider::after{
    right:0;
}

.social{
    display:flex;
    gap:15px;
}

.social button{
    flex:1;
    padding:15px;
    border:1px solid #ddd;
    border-radius:14px;
    background:white;
    cursor:pointer;
}

.register{
    margin-top:35px;
    text-align:center;
    color:#666;
}

.register a{
    color:#c18a4d;
    text-decoration:none;
    font-weight:600;
}

@media(max-width:900px){

.container{
    flex-direction:column;
}

.left{
    min-height:300px;
}

.overlay h1{
    font-size:42px;
}

}

</style>

</head>

<body>

<div class="container">

    <div class="left">

        <div class="overlay">

            <div class="brand">
                CLAIRE
            </div>

            <h1>
                Reveal Your Natural Beauty
            </h1>

            <p>
                Experience premium beauty treatments designed to enhance confidence, elegance, and wellness.
            </p>

        </div>

    </div>

    <div class="right">

        <div class="login-box">

            <div class="logo">
                Welcome Back
            </div>

            <p class="subtitle">
                Sign in to access your appointments and beauty journey.
            </p>

            <form method="POST" action="/login">

                @csrf

                <div class="input-group">

                    <label>Email Address</label>

                    <input
                    type="email"
                    name="email"
                    placeholder="Enter your email">

                </div>

                <div class="input-group">

                    <label>Password</label>

                    <input
                    type="password"
                    name="password"
                    placeholder="Enter your password">

                </div>

                <div class="option">

                    <label>

                        <input type="checkbox">

                        Remember Me

                    </label>

                    <a href="#">
                        Forgot Password?
                    </a>

                </div>

                <button
                type="submit"
                class="btn-login">

                    Login

                </button>

            </form>

            <div class="divider">
                OR
            </div>

            <div class="social">

                <button>
                    Google
                </button>

                <button>
                    Apple
                </button>

            </div>

            <div class="register">

                Don't have an account?

                <a href="/register">
                    Register
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>