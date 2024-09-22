<?php 
include("includes/header.php");
include("server/get_visa_application.php");
?>
<body>
    <header>
        <h1>Home Affairs: Visa Application</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
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
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <form id="visa-form" method="POST" action="visa_applicatiion.php">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" placeholder="Enter Full Name" required>

            <label for="passportNumber">Passport Number</label>
            <input type="text" id="passportNumber" name="passportNumber" placeholder="Enter Passport Number" required>

            <label for="nationality">Nationality</label>
            <input type="text" id="nationality" name="nationality" placeholder="Enter Nationality" required>

            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required>

            <label for="visaType">Visa Type</label>
            <select id="visaType" name="visaType" required>
                <option value="" disabled selected>Select Visa Type</option>
                <option value="tourist">Tourist</option>
                <option value="business">Business</option>
                <option value="student">Student</option>
                <option value="work">Work</option>
            </select>

            <label for="entryDate">Intended Date of Entry</label>
            <input type="date" id="entryDate" name="entryDate" required>

            <label for="stayDuration">Duration of Stay (days)</label>
            <input type="number" id="stayDuration" name="stayDuration" placeholder="Enter Duration of Stay" required>

            <label for="purpose">Purpose of Visit</label>
            <textarea id="purpose" name="purpose" placeholder="Enter Purpose of Visit" required></textarea>

            <label for="accommodation">Accommodation Details</label>
            <input type="text" id="accommodation" name="accommodation" placeholder="Enter Accommodation Details" required>

            <label for="financialMeans">Proof of Financial Means</label>
            <input type="file" id="financialMeans" name="financialMeans" required>

            <button type="submit" id="submitVisa" name="submitVisa">Submit Application</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>