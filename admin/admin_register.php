<?php 
include("includes/admin_header.php");
include("server/get_admin_register.php");
?>
<body>
    <header>
        <h1>Home Affairs: Registration</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav></nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <form id="reg-form" method="POST" action="admin_register.php">
            <label for="firstName">First Name(s)</label>
            <input type="text" id="adminFirstName" name="adminFirstName" placeholder="Enter First Name(s)" required>

            <label for="surname">Surname</label>
            <input type="text" id="adminSurname" name="adminSurname" placeholder="Enter Surname" required>

            <label for="email">Email</label>
            <input type="email" id="adminEmail" name="adminEmail" placeholder="Enter Email" required>

            <label for="password">Password</label>
            <input type="password" id="adminPassword" name="adminPassword" placeholder="Enter Password" required>

            <label for="rePassword">Re-enter Password</label>
            <input type="password" id="adminRePassword" name="adminRePassword" placeholder="Re-enter Password" required>

            <button type="submit" id="adminRegisterBtn" name="adminRegisterBtn">Submit</button>
        </form>
        <p>Already have an Admin account? <a href="admin_login.php">Login here</a></p>
    </main>
</body>
<?php 
include("includes/admin_footer.php");
?>