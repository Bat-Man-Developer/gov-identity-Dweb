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
            <input type="hidden" id="firstName" value="<?php echo $_GET['firstName']; ?>">
            <input type="hidden" id="lastName" value="<?php echo $_GET['lastName']; ?>">
            <input type="hidden" id="dob" value="<?php echo $_GET['dob']; ?>">
            <input type="hidden" id="pob" value="<?php echo $_GET['pob']; ?>">
            <input type="hidden" id="gender" value="<?php echo $_GET['gender']; ?>">
            <input type="hidden" id="nationality" value="<?php echo $_GET['nationality']; ?>">
            <input type="hidden" id="address" value="<?php echo $_GET['address']; ?>">
            <input type="hidden" id="fatherName" value="<?php echo $_GET['fatherName']; ?>">
            <input type="hidden" id="motherName" value="<?php echo $_GET['motherName']; ?>">
            <input type="hidden" id="maritalStatus" value="<?php echo $_GET['maritalStatus']; ?>">
            <input type="hidden" id="occupation" value="<?php echo $_GET['occupation']; ?>">
            <input type="hidden" id="documentType" value="<?php echo $_GET['documentType']; ?>">
            <input type="hidden" id="applicationStatus" value="<?php echo $_GET['applicationStatus']; ?>">
            <input type="hidden" id="signaturePath" value="<?php echo $_GET['signaturePath']; ?>">
        </div>
    </main>
    <script src="js/register_id_photo.js"></script>
<?php 
    include("includes/footer.php");
?>