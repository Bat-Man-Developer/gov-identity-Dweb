<?php
include("includes/header.php");
?>
<body>
    <div class="container">
        <header>
            <h1>Home Affairs Admin: Logs</h1>
            <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
        </header>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="review_applications.php">Review Applications</a>
            <a href="view_users.php">View Users</a>
            <a><button onclick="logout()">Logout</button></a>
        </nav>
        <section class="logs-section">
            <h2>Activity Logs</h2>
            <p>View and review user activity for compliance and security.</p>

            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-09-04</td>
                        <td>john.doe</td>
                        <td>Login</td>
                        <td>Success</td>
                    </tr>
                    <tr>
                        <td>2024-09-03</td>
                        <td>jane.smith</td>
                        <td>Password Change</td>
                        <td>Success</td>
                    </tr>
                    <!-- Add more log entries as needed -->
                </tbody>
            </table>
        </section>
    </div>
</body>
<?php
include("includes/footer.php");
?>
