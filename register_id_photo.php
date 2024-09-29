<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs: Register ID Photo</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav></nav>
    <main style="margin-top: 5%; margin-bottom: 5%">
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <div class="photo_container">
            <video id="video" autoplay playsinline></video>
            <canvas id="canvas" style="display:none;"></canvas>
            <button id="takePhotoBtn">Take Photo</button>
            <button id="savePhotoBtn">Save Photo</button>
            <input type="hidden" id="userID" value="<?php if (isset($_GET['userID'])) {
                echo $_GET['userID'];
            } else {
                header("Location: id_application.php?error=Unauthorised Access. Trespassers will be prosecuted. Activity has been logged.");
            }?>">
        </div>
    </main>
    <script src="js/register_id_photo.js"></script>
<?php 
    include("includes/footer.php");
?>