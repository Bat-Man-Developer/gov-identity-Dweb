<?php 
include("includes/admin_header.php");
?>
<body>
    <header>
        <h1>Home Affairs: Registration</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav></nav>
    <main id="reg-login-form">
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <p class="text-center" id="message"></p>
        <form id="reg-form">
            <label for="firstName">First Name(s)</label>
            <input type="text" id="adminFirstName" placeholder="Enter First Name(s)" required>

            <label for="surname">Surname</label>
            <input type="text" id="adminSurname" placeholder="Enter Surname" required>

            <label for="email">Email</label>
            <input type="email" id="adminEmail" placeholder="Enter Email" required>

            <label for="password">Password</label>
            <input type="password" id="adminPassword"  placeholder="Enter Password" required>

            <label for="rePassword">Re-enter Password</label>
            <input type="password" id="adminRePassword" placeholder="Re-enter Password" required>

            <button type="submit" class="registerBtn" id="adminRegisterBtn">Submit</button>
        </form>
        <p>Already have an Admin account? <a href="admin_login.php">Login here</a></p>
    </main>
</body>
<script src="js/admin_register.js"></script>
<?php 
include("includes/admin_footer.php");
?>