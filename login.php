<?php 
include("includes/header.php");
//if user is logged in then take user to dashboard page
if(isset($_SESSION['userID']) && isset($_SESSION['userFirstName']) && isset($_SESSION['userLastName'])){
    header('location: dashboard.php?userID=' . $_SESSION['userID'] . "&userFirstName=" . $_SESSION['userFirstName'] . "&userLastName=" . $_SESSION['userLastName']);
    exit;
}
?>
<body>
    <header>
        <h1>Home Affairs: Login</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        
        <!-- Add video and canvas elements for facial recognition -->
        <div id="facialRecognitionPopup" class="popup">
            <div class="popup-content">
                <span class="close">&times;</span>
                <h2>Facial Recognition</h2>
                <video id="video" width="400" height="300" autoplay playsinline></video>
                <canvas id="canvas" width="400" height="300" style="display: none;"></canvas>
                <button id="takePhotoBtn">Take Photo</button>
                <button id="savePhotoBtn">Verify Photo</button>
            </div>
        </div>
        
        <form id="login-form" method="POST" action="server/get_login.php">
            <input type="hidden" id="face_data" name="face_data">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password">

            <button type="submit" name="loginBtn">Login</button>
        </form>
        
        <!-- facial recognition -->
        <button id="facialRecognitionBtn">Use Facial Recognition</button>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p>Are you an employee? <a href="admin/admin_login.php" target="_blank">Staff Sign in</a></p>
    </main>
    <script src="js/login_facial_recognition.js"></script>
</body>
<?php 
include("includes/footer.php");
?>