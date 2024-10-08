<?php 
include("includes/header.php");
?>
<body>
    <header>      
        <h1>Home Affairs: Team</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="login.php"><button type="submit"  name="loginBtn">Login</button></a>
        <a href="register.php"><button type="submit" id="registerBtn" name="registerBtn">Register</button></a>
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