<?php 
include("includes/header.php");
?>
</head>
<body>
    <header>
        <h1>Home Affairs: Home</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
    </nav>
    
    <main style="margin-top: 5%; margin-bottom: 5%">
        <div style="display: flex; flex: wrap; justify-content: center">
            <button id="loginBtn"><a id="loginTxt" href="login.php">Login</a></button>
            <button id="registerBtn"><a id="registerTxt" href="register.php">Register</></button>
        </div>
    </main>
<?php 
    include("includes/footer.php");
?>