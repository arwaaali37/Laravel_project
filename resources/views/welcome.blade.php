<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Portal</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .cover {
            background-image: url('https://img.freepik.com/free-vector/tiny-people-searching-business-opportunities_74855-19928.jpg'); /* Replace with your cover image URL */
         
    background-size: contain;
    background-position:
    background-repeat: no-repeat; 
    height: 100vh; 
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    position: relative;
}

 
.cover h1::after{
content: "";

animation: typing 3s infinite alternate;
}
@keyframes typing{
    0%{
        content: "W|";
    }
    10%{
        content: "We|";
    }
    20%{
        content: "Wel|";
    }
    30%{
        content: "Welc|";
    }
    40%{
        content: "Welco|";
    }
    50%{
        content: "Welcome|";
    }
    60%{
        content: "Welcome to|";
    }
    70%{
        content: "Welcome to jo|";
    }
    80%{
        content: "Welcome to jobs|";
    }
    90%{
        content: "Welcome to jobs Boa|";
    }
    100%{
        content: "Welcome to jobs Board|";
    }
   
}

        
        .cover h1 {
            font-size: 3rem;
            margin: 0;
            color: #674188;
            
        }
      
        .cover p {
            font-size: 1.2rem;
            margin-top: 10px;
             text:center;
            color:#8967B3;
            font-size:25px;
           
        }
        nav {
            width: 100%; 
            background-color: #624E88; 
            padding: 0.5rem 1rem;
            position: fixed; 
            top: 0;
            left: 0;
            z-index: 1000; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }
        nav:hover {
            background-color: #ffffff; 
        }
      .nav-content {
            max-width: 1200px; 
            margin: 0 auto;
            display: flex;
            justify-content: flex-end; 
            align-items: center;
        }
        nav a {
            display: inline-block;
            margin-left: 1rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
            color: #E6D9A2; 
            border-radius: 0.25rem;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #522258;
        }
    </style>
</head>
<body>
    <div class="cover">
        <nav>
            <div class="nav-content">
            @if (Route::has('login'))
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class=" rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            @endif
            </div>
        </nav>
        <div>
        <h1></h1>
      
    <p>Find your dream job with ease. Start your journey towards a new career today!</p>
   
    </div>
    
</body>
</html>