<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs: Contact Us</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
        <?php if(isset($_SESSION['email'])){ ?>
            <form id="logout-form" method="POST" action="contact.php">
                <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <h2>Home Affairs Offices in Provinces</h2>
        <div class="address-list">
            <h3>Gauteng</h3>
            <p>Department of Home Affairs, Pretoria<br>1234 Home Affairs St, Pretoria, 0001<br>Office Number: 012-345-6789</p>
            <h3>Western Cape</h3>
            <p>Department of Home Affairs, Cape Town<br>5678 Home Affairs Rd, Cape Town, 8001<br>Office Number: 021-987-6543</p>
            <h3>KwaZulu-Natal</h3>
            <p>Department of Home Affairs, Durban<br>9101 Home Affairs Ave, Durban, 4001<br>Office Number: 031-456-7890</p>
            <h3>Eastern Cape</h3>
            <p>Department of Home Affairs, Bhisho<br>1213 Home Affairs Blvd, Bhisho, 5601<br>Office Number: 040-123-4567</p>
            <h3>Limpopo</h3>
            <p>Department of Home Affairs, Polokwane<br>1415 Home Affairs Dr, Polokwane, 0700<br>Office Number: 015-876-5432</p>
            <h3>Mpumalanga</h3>
            <p>Department of Home Affairs, Mbombela<br>1617 Home Affairs Way, Mbombela, 1200<br>Office Number: 013-234-5678</p>
            <h3>Free State</h3>
            <p>Department of Home Affairs, Bloemfontein<br>1819 Home Affairs Cir, Bloemfontein, 9300<br>Office Number: 051-345-6789</p>
            <h3>North West</h3>
            <p>Department of Home Affairs, Mahikeng<br>2021 Home Affairs Pl, Mahikeng, 2745<br>Office Number: 018-456-7890</p>
        </div>

        <h2>Send Us a Message</h2>
        <form class="contact-form" action="submit_message.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" class="contact-button">Send Message</button>
        </form>

        <h2>Find Us on the Map</h2>
        <div id="map"></div>
    </main>
</body>

<script>
    function initMap() {
        const locations = [
            {lat: -25.746, lng: 28.188}, // Pretoria
            {lat: -33.9249, lng: 18.4241}, // Cape Town
            {lat: -29.8587, lng: 31.0218}, // Durban
            {lat: -32.9792, lng: 26.0315}, // Bhisho
            {lat: -23.9008, lng: 29.4486}, // Polokwane
            {lat: -25.4591, lng: 30.9837}, // Mbombela
            {lat: -29.1138, lng: 26.2041}, // Bloemfontein
            {lat: -25.8602, lng: 25.6701}  // Mahikeng
        ];

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 6,
            center: {lat: -30.5595, lng: 22.9375}, // Center of South Africa
        });

        locations.forEach(location => {
            new google.maps.Marker({
                position: location,
                map: map,
                title: 'Home Affairs Office',
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 10,
                    fillColor: "red",
                    fillOpacity: 1,
                    strokeWeight: 0
                }
            });
        });
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>
<?php 
    include("includes/footer.php");
?>