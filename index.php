<?php 
include("includes/header.php");
?>
</head>
<body>
    <header>
        <h1>Home Affairs: Home</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
        <?php if(isset($_SESSION['email'])){ ?>
            <form id="logout-form" method="POST" action="index.php">
                <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    
    <main style="margin-top: 5%; margin-bottom: 5%">
        <div style="display: flex; flex: wrap; justify-content: center">
            <button style="margin: 20px"><a href="login.php">Login</a></button>
            <button style="margin: 20px"><a href="register.php">Register</a></button>
        </div>
    </main>
<?php 
    include("includes/footer.php");
?>