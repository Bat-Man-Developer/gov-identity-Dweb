<?php 
include("includes/header.php");
include("server/get_register.php");
?>
<body>
    <header>
        <h1>Home Affairs: Registration</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <form id="reg-form" method="POST" action="register.php">
            <label for="firstName">First Name(s)</label>
            <input type="text" id="firstName" name="firstName" placeholder="Enter First Name(s)" required>

            <label for="surname">Surname</label>
            <input type="text" id="surname" name="surname" placeholder="Enter Surname" required>

            <label for="country">Country of Origin</label>
            <input type="text" id="country" name="country" placeholder="Enter Country of Origin" required>

            <label for="dob">DOB (mm/dd/yyyy)</label>
            <input type="date" id="dob" name="dob" required>

            <label for="sex">Sex</label>
            <select id="sex" name="sex" required>
                <option value="" disabled selected>Select Sex</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="cellNumber">Cell Number</label>
            <input type="tel" id="cellNumber" name="cellNumber" placeholder="Enter Cell Number" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>

            <label for="rePassword">Re-enter Password</label>
            <input type="password" id="rePassword" name="rePassword" placeholder="Re-enter Password" required>

            <button type="submit" id="registerBtn" name="registerBtn">Submit</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </main>
</body>
<?php 
include("includes/footer.php");
?>