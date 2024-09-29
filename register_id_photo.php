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
        <video id="video" autoplay playsinline></video>
        <canvas id="canvas" style="display:none;"></canvas>
        <button id="takePhotoBtn">Take Photo</button>
        <button id="savePhotoBtn">Save Photo</button>
    <div id="message"></div>
    </main>
<?php 
    include("includes/footer.php");
?>