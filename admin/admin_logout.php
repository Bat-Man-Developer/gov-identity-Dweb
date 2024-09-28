<?php
include("includes/admin_header.php");
?>
<style>
    main p{
        text-align: center;
    }
    .message {
        margin-bottom: 1rem;
        padding: 0.5rem;
        border-radius: 4px;
    }
    .success {
        background-color: #d4edda;
        color: #155724;
        text-align: center;
    }
    .error {
        background-color: #f8d7da;
        color: #721c24;
        text-align: center;
    }
</style>
<body>
    <header>
        <h1>Home Affairs Admin: Logout</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
    </nav>
    <main>
        <div id="logout-form">
            <?php if(isset($_GET['success'])): ?>
                <p class="message success" id="webMessageSuccess"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>
            <?php if(isset($_GET['error'])): ?>
                <p class="message error" id="webMessageError"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
            <p class="message" id="message"></p>
            <p>You have successfully logged out.</p>
            <p>Go to <a href="admin_login.php">Login</a></p>
        </div>
    </main>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const message = document.getElementById('message');
        message.textContent = 'Logout successful!';
        message.classList.add('success');

        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transition = 'opacity 0.5s ease-out';
        }, 3000);
    });
</script>
<?php 
include("includes/admin_footer.php");
?>