<?php 
include("includes/header.php");
?>
</head>
<body>
    <header>
        <h1>Home Affairs: Register ID Photo</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav></nav>
    <main style="margin-top: 5%; margin-bottom: 5%">
        <div class="photo_container">
            <video id="video" autoplay playsinline></video>
            <canvas id="canvas" style="display:none;"></canvas>
            <button id="takePhotoBtn">Take Photo</button>
            <input type="hidden" id="userID" value="<?php if (isset($_GET['userID'])) { 
                echo $_GET['userID'] } else {
                    header("Location: register.php?error=Unauthorised access. User activity has been logged.");
                } ?>">Save Photo/>
            <div id="message"></div>
        </div>
    </main>
    <script src="js/register_id_photo.js"></script>
<?php 
    include("includes/footer.php");
?>