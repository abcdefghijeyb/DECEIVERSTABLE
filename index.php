<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login_register";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
    if(!$conn){
        die("Something went wrong.");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.jpg">
    <title>Cards of Chaos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #111827;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        header {
            padding: 20px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background-color: #111827;
            z-index: 10;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            position: sticky;
            top: 70px;
            z-index: 10;
            background-color: #111827;
            padding-top: 20px;
            padding-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        nav ul {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            scroll-snap-type: x mandatory;
            padding-left: 20px;
            padding-right: 20px;
        }

        nav ul li {
            margin-right: 20px;
            scroll-snap-align: start;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            display: block;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #6ee7b7;
        }

        nav ul li a.active {
            color: #6ee7b7;
            border-bottom: 2px solid #6ee7b7;
            padding-bottom: 2px;
        }

        .connect-button {
            background-color: #f59e0b;
            color: #111827;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .connect-button:hover {
            background-color: #d97706;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start; 
            padding: 20px;
            text-align: center;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: y mandatory;
            padding-top: 140px;
        }

        main > section {
            scroll-snap-align: start;
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero-title {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #ffffff;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1s ease, pulse 2s infinite alternate;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            from { transform: scale(1); }
            to { transform: scale(1.06); }
        }

        .hero-subtitle {
            font-size: 18px;
            color: #cbd5e0;
            margin-bottom: 30px;
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
            animation: fadeIn 1s ease, slideIn 1s ease 0.5s forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .play-now-button {
            background-color: #6ee7b7;
            color: #111827;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 20px;
            transition: background-color 0.3s ease;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            animation: fadeIn 1s ease, moveIn 1s ease 0.8s forwards;
            opacity: 0;
            transform: translateX(-20px);
        }
        @keyframes moveIn {
            from{
                transform: translateX(-20px);
                opacity: 0;
            }
            to{
                transform: translateX(0);
                opacity: 1;
            }
        }

        .play-now-button:hover {
            background-color: #14b8a6;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .how-to-play-button {
            background-color: transparent;
            color: #ffffff;
            padding: 15px 30px;
            border: 2px solid #ffffff;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 20px;
            transition: background-color 0.3s ease;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease, scaleIn 1s ease 1s forwards;
            opacity: 0;
            transform: scale(0.8);
        }
        @keyframes scaleIn{
            from{
                transform: scale(0.8);
                opacity: 0;
            }
            to{
                 transform: scale(1);
                opacity: 1;
            }
        }

        .how-to-play-button:hover {
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        
        
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }
            nav ul {
                flex-direction: row;
                overflow-x: auto;
                white-space: nowrap;
            }
            nav ul li {
                margin-right: 20px;
                margin-bottom: 0;
            }
            main {
                padding: 10px;
            }
            .hero-title {
                font-size: 36px;
            }
            .hero-subtitle {
                font-size: 16px;
            }
            header h1 {
                margin-bottom: 10px;
            }
             .button-container {
                flex-direction: column;
                align-items: center;
            }
            .play-now-button, .how-to-play-button {
                margin-right: 0;
                margin-bottom: 20px;
                 width: 100%;
                max-width: 300px;
            }
        }

        #home {
            background-image: url('your-image-url.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            position: relative;
            z-index: 1;
            transition: background-size 0.5s ease-out;
        }

        #home::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        #cards {
            padding-top: 80px;
            padding-bottom: 80px;
            text-align: center;
            background-color: #1f2937;
        }
        #cards h2{
             font-size: 36px;
             margin-bottom: 40px;
             animation: fadeIn 1s ease;
        }

        .card-grid {
            display: flex;
            flex-display: row;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }

        .card-item {
            background-image: url('empress.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 450px;
            width: 100%;
            max-width: 300px;
            color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 1s ease, tiltCard 0.5s ease infinite alternate;
        }
        .card-item1 {
            background-image: url('emperor.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 450px;
            width: 100%;
            max-width: 300px;
            color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 1s ease, tiltCard 0.5s ease infinite alternate;
        }.card-item2 {
            background-image: url('high_priestess.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 450px;
            width: 100%;
            max-width: 300px;
            color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 1s ease, tiltCard 0.5s ease infinite alternate;
        }
        .card-item3 {
            background-image: url('hierophant.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 450px;
            width: 100%;
            max-width: 300px;
            color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 1s ease, tiltCard 0.5s ease infinite alternate;
        }
        
        @keyframes tiltCard {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(3deg);
            }
        }

        .card-item:hover {
            transform: translateY(-10px) rotate(0deg);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .card-item h3 {
            font-size: 24px;
            margin-bottom: 450px;
            color:rgb(0, 0, 0);
        }
        .card-item1:hover {
            transform: translateY(-10px) rotate(0deg);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .card-item1 h3 {
            font-size: 24px;
            margin-bottom: 450px;
            color:rgb(0, 0, 0);
        }  
        .card-item2:hover {
            transform: translateY(-10px) rotate(0deg);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .card-item2 h3 {
            font-size: 24px;
            margin-bottom: 450px;
            color:rgb(0, 0, 0);
        }
        .card-item3:hover {
            transform: translateY(-10px) rotate(0deg);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .card-item3 h3 {
            font-size: 24px;
            margin-bottom: 450px;
            color:rgb(0, 0, 0);
        }
        #updates {
            padding-top: 80px;
            padding-bottom: 80px;
            text-align: center;
            background-color: #111827;
        }
        #updates h2{
            font-size: 36px;
            margin-bottom: 40px;
            animation: fadeIn 1s ease;
        }

        .update-list {
            list-style: none;
            padding: 0;
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .update-item {
            background-color: #374151;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: left;
            animation: slideInLeft 0.5s ease forwards;
            opacity: 0;
        }
        @keyframes slideInLeft {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .update-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .update-item h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #6ee7b7;
        }
        .update-item p{
            color: #d1d5db;
            line-height: 1.6;
        }

        #about {
            padding-top: 80px;
            padding-bottom: 80px;
            text-align: center;
            background-color: #1f2937;
        }
        #about h2{
            font-size: 36px;
            margin-bottom: 40px;
             animation: fadeIn 1s ease;
        }

        #about p {
            font-size: 18px;
            color: #d1d5db;
            line-height: 1.7;
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
            animation: fadeIn 1s ease, expandIn 1s ease 0.5s forwards;
            opacity: 0;
            transform: scale(0.9);
        }
        @keyframes expandIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        #forum {
            padding-top: 80px;
            padding-bottom: 80px;
            text-align: center;
            background-color: #111827;
        }
        #forum h2{
            font-size: 36px;
            margin-bottom: 40px;
            animation: fadeIn 1s ease;
        }
        #forum p{
            color: #d1d5db;
            line-height: 1.7;
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 30px;
            animation: fadeIn 1s ease, pulseText 2s infinite alternate;
        }
        @keyframes pulseText {
            from { color: #d1d5db; }
            to { color: #ffffff; }
        }

        #forum a {
            background-color: #6ee7b7;
            color: #111827;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 20px;
            transition: background-color 0.3s ease;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: inline-block;
            animation: fadeIn 1s ease, bounce 1s ease 1s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        #forum a:hover {
            background-color: #14b8a6;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #374151;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 80%;
            position: relative;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            text-align: center;
        }

        .modal-content h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .modal-content p {
            font-size: 18px;
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .modal-content ul {
            list-style: disc;
            padding-left: 40px;
            margin-bottom: 20px;
            text-align: left;
        }

        .modal-content li {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .modal-button {
            background-color: #6ee7b7;
            color: #111827;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            display: inline-block;
        }

        .modal-button:hover {
            background-color: #14b8a6;
        }
        .close-modal-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #fff;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .close-modal-button:hover {
            opacity: 1;
        }
        #mySidenav a {
        position: fixed;
        right: -80px;
        transition: 0.3s;
        padding: 15px;
        width: 100px;
         text-decoration: none;
         font-size: 12px;
        color: white;
        border-radius: 0 5px 5px 0;
        }

#mySidenav a:hover {
  right: 0;
}


#minigame {
  top: 150px;
  background-color: red;
}
footer {
            padding: 20px;
            text-align: center;
            color: #9ca3af;
            border-top: 1px solid #374151;
        }
        .social-icons {
            display: flex;
            justify-content: center; 
            align-items: center; 
            gap: 15px; 
        }

        .social-icons a {
            display: inline-block; 
        }

        .social-icons img {
             width: 24px; 
            height: 24px; 
            display: block; 
            opacity: 0.7; 
            transition: opacity 0.3s ease-in-out; 
        }

        .social-icons a:hover img {
            opacity: 1;
        }
        .social-icons img.facebook {
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body>
    <header>
        <h1>Cards of Chaos</h1>
        <nav>
            <ul>
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="#cards">Cards</a></li>
                <li><a href="#updates">Updates</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#forum">Forum</a></li>
            </ul>
        </nav>
        <button class="connect-button" id="login-register-button" onclick="window.location.href='auth.php';">Login / Register</button> </header>   

    <main>
        <section id="home">
            <div class="hero-content">
                <h2 class="hero-title">Cards of Chaos</h2>
                <p class="hero-subtitle">
                "Strategic card battles await! 🃏 Are you ready for the challenge?"
                </p>
                <div class="button-container">
                    <button class="play-now-button" onclick="window.location.href='auth.php';">Play Now</button>
                    </script> <button class="how-to-play-button">How to Play</button>
                </div>
            </div>
        </section>

        <section id="cards">
            <h2>Explore the Cards</h2>
            <div class="card-grid">
            <div class="card-item">
                    <h3>--------------------</h3>
                </div>
                <div class="card-item1">
                    <h3>--------------------</h3>
                </div>
                <div class="card-item2">
                    <h3>--------------------</h3>
                </div>
                 <div class="card-item3">
                    <h3>--------------------</h3>
                </div>
            </div>
        </section>

        <section id="updates">
            <h2>Latest Updates</h2>
            <ul class="update-list">
                <li class="update-item">
                    <h3>Update Website Layout</h3>
                    <p>Website Redesign for Better Experience.</p>
                </li>
                <li class="update-item">
                    <h3>Fix Game Mechanics</h3>
                    <p>Fix the Flow of the Game.</p>
                </li>
                <li class="update-item">
                    <h3>New Feature: Mini Game</h3>
                    <p>We put in a mini game in the Upper Right of the screen. </p>
                </li>
            </ul>
        </section>

        <section id="about">
            <h2>About Cards of Chaos</h2>
            <p>
            The Idea Behind Card of Chaos:  Bombahey started as a group of friends with a shared passion for card games.  
            We wanted to create something unique and challenging, and that's how Card of Chaos was born.  
            From initial concept to final release, we've poured our hearts into every aspect of the game's development.  
            We hope you appreciate the effort and enjoy the result.
            </p>
        </section>

        <section id="forum">
            <h2>Join the Community</h2>
            <p>
                Connect with other players, discuss strategies, and stay up-to-date
                on the latest news and updates.  Your voice matters!
            </p>
            <a href="https://discord.gg/d7s8939Cjv">Join The Community!</a>
        </section>
    </main>

  

    <div id="how-to-play-modal" class="modal">
        <div class="modal-content">
            <h2>How to Play</h2>
            <p>
                Welcome to Cards of Chaos! Here's a quick guide to get you started:
            </p>
            <ul>
                <li><strong>Objective:</strong> Be the first player to get rid of all your cards.</li>
                <li><strong>Setup:</strong> Each player starts with 7 cards.</li>
                <li><strong>Playing:</strong> Players take turns matching the top card of the discard pile by color, number, or symbol.</li>
                <li><strong>Card Types:</strong> Number Cards (0-9), Reverse, Skip, Wild +4</li>
                <li><strong>Winning:</strong> The first player to play their last card wins the game.</li>
            </ul>
            <p>
                For a more detailed guide, please visit our forum.
            </p>
            <button class="modal-button" id="confirm-how-to-play-modal">Got it!</button>
        </div>
    </div>
    <div id="mySidenav" class="sidenav">
 
  <a href="minigame.php" id="minigame"> < Mini Game</a>
</div>
<footer>
        
        <div class="social-icons">

    <a href="https:www.facebook.com/jvlovebritney" target="_blank" aria-label="Facebook">
        <img src="fb.jpg" alt="Facebook">
    <a href="https://www.facebook.com/jaysonperocho22/" target="_blank" aria-label="Facebook">
        <img src="fb.jpg" alt="Facebook">
    <a href="https://www.facebook.com/deideikyot" target="_blank" aria-label="Facebook">
        <img src="fb.jpg" alt="Facebook">
    <a href="https://www.facebook.com/joyberii" target="_blank" aria-label="Facebook">
        <img src="fb.jpg" alt="Facebook">
    <a href="https://www.facebook.com/jezryl.paclauna.94" target="_blank" aria-label="Facebook">
        <img src="fb.jpg" alt="Facebook">
    </div>
    <br>
            <p>&copy; 2023 Cards of Chaos. All rights reserved.</p>
</footer>
              

    <script>
        const navLinks = document.querySelectorAll('nav ul li a');
        const sections = document.querySelectorAll('main > section');
        const howToPlayButton = document.querySelector('.how-to-play-button');
        const modal = document.getElementById('how-to-play-modal');
        const confirmButton = document.getElementById('confirm-how-to-play-modal');
        const closeModalButton = document.getElementById('close-how-to-play-modal');

        function updateActiveNavLink() {
            let currentSectionId = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= sectionTop - 100 && window.scrollY < sectionTop + sectionHeight - 100) {
                    currentSectionId = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').slice(1) === currentSectionId) {
                    link.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', updateActiveNavLink);

        document.addEventListener('DOMContentLoaded', () => {
             const homeSection = document.getElementById('home');
              if (homeSection) {
                setTimeout(() => {
                    homeSection.style.backgroundImage = "url('your-image-url.jpg')";
                    homeSection.style.backgroundSize = '110%';
                }, 1000);

                setTimeout(()=> {
                     homeSection.style.transition = 'background-size 0.5s ease-in-out';
                     homeSection.style.backgroundSize = '100%';
                }, 2000)
             }


            const cardItems = document.querySelectorAll('.card-item');
            cardItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.2}s`;
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    item.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 500 + index * 200);
            });

            const updateItems = document.querySelectorAll('.update-item');
            updateItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.2}s`;
                item.style.opacity = '0';
                item.style.transform = 'translateX(-50px)';
                setTimeout(() => {
                    item.style.transition = `transform 0.5s ease ${index * 0.2}s, opacity 0.5s ease ${index * 0.2}s`;
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, 500);
            });

            const aboutSection = document.getElementById('about');
            if(aboutSection){
                 const aboutParagraph = aboutSection.querySelector('p');
                  if(aboutParagraph){
                        aboutParagraph.style.animationDelay = '0.5s';
                        aboutParagraph.style.opacity = '0';
                        aboutParagraph.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            aboutParagraph.style.transition = 'transform 1s ease, opacity 1s ease 0.5s';
                            aboutParagraph.style.opacity = '1';
                            aboutParagraph.style.transform = 'scale(1)';
                        }, 500);
                 }
            }

            const forumSection = document.getElementById('forum');
            if(forumSection){
                const forumParagraph = forumSection.querySelector('p');
                if(forumParagraph){
                     forumParagraph.style.animationDelay = '0s';
                    forumParagraph.style.opacity = '0';
                    setTimeout(() => {
                        forumParagraph.style.transition = 'color 2s ease infinite alternate, opacity 1s ease';
                        forumParagraph.style.opacity = '1';
                    }, 500);
                }
            }

            const forumButton = forumSection.querySelector('a');
             if(forumButton){
                forumButton.style.animationDelay = '1s';
                forumButton.style.opacity = '0';
                forumButton.style.transform = 'translateY(0)';
                setTimeout(() => {
                    forumButton.style.transition = 'transform 1s ease 1s infinite, opacity 1s ease 1s';
                    forumButton.style.opacity = '1';
                    forumButton.style.transform = 'translateY(0)';
                }, 500);
             }
        });

        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        howToPlayButton.addEventListener('click', () => {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        confirmButton.addEventListener('click', () => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        });

    </script>
</body>
</html>
