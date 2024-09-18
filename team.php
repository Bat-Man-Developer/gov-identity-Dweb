<?php 
include("includes/header.php");
?>
<body>
    <header>      
        <h1>Home Affairs: Team</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <?php if(isset($_SESSION['email'])){ ?>
            <form id="logout-form" method="POST" action="server/get_logout.php">
                <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
            </form>
            <?php } else { ?>
            <form id="login-form" method="POST" action="login.php">
                <a><button type="submit" id="loginBtn" name="loginBtn">Login</button></a>
            </form>
            <form id="reg-form" method="POST" action="register.php">
                <a><button type="submit" irB="registerBtn" name="registerBtn">Register</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <div class="team-container">
            <div class="team-member">
                <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Miriam Anozie">
                <h3>Miriam Anozie</h3>
                <p>Project Manager</p>
                <p class="qualification">MBA, PMP Certified</p>
                <p class="info">Miriam has over 10 years of experience in project management, leading cross-functional teams to success.</p>
                <p class="quote">"Success is not just about what you accomplish in your life, it's about what you inspire others to do."</p>
            </div>
            <div class="team-member">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Kay Mudau">
                <h3>Kay Mudau</h3>
                <p>Software Developer</p>
                <p class="qualification">BSc in Computer Science</p>
                <p class="info">Kay specializes in full-stack development, creating seamless user experiences and robust backend solutions.</p>
                <p class="quote">"Code is like humor. When you have to explain it, it’s bad."</p>
            </div>
            <div class="team-member">
                <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Fulufhelo Shavhani">
                <h3>Fulufhelo Shavhani</h3>
                <p>UX/UI Designer</p>
                <p class="qualification">BA in Graphic Design</p>
                <p class="info">Fulufhelo is passionate about creating intuitive designs that enhance user interaction and satisfaction.</p>
                <p class="quote">"Design is not just what it looks like and feels like. Design is how it works."</p>
            </div>
            <div class="team-member">
                <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Tyebakazi Madiba">
                <h3>Tyebakazi Madiba</h3>
                <p>Quality Assurance Engineer</p>
                <p class="qualification">BEng in Software Engineering</p>
                <p class="info">Tyebakazi ensures the highest quality standards are met, conducting thorough testing and analysis.</p>
                <p class="quote">"Quality means doing it right when no one is looking."</p>
            </div>
        </div>
    </main>
</body>
<?php 
include("includes/footer.php");
?>