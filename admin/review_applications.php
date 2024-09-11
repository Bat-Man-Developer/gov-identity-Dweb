<?php
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs Admin: Review Applications</h1>
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="view_users.php">View Users</a>
        <a href="logs.php">Logs</a>
        <a><button onclick="logout()">Logout</button></a>
    </nav>
    <main>
        <h2>Application List</h2>
        <table>
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>User Name</th>
                    <th>Application Type</th>
                    <th>Submission Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>101</td>
                    <td>John Doe</td>
                    <td>Passport</td>
                    <td>2023-08-01</td>
                    <td>Pending</td>
                    <td>
                        <a href="approve_application.html?id=101" class="action-button">Approve</a>
                        <a href="deny_application.html?id=101" class="action-button">Deny</a>
                    </td>
                </tr>
                <tr>
                    <td>102</td>
                    <td>Jane Smith</td>
                    <td>ID Card</td>
                    <td>2023-08-05</td>
                    <td>Under Review</td>
                    <td>
                        <a href="approve_application.html?id=102" class="action-button">Approve</a>
                        <a href="deny_application.html?id=102" class="action-button">Deny</a>
                    </td>
                </tr>
                <tr>
                    <td>103</td>
                    <td>Miriam Anozie</td>
                    <td>Birth Certificate</td>
                    <td>2023-08-10</td>
                    <td>Approved</td>
                    <td>
                        <a href="view_application.html?id=103" class="action-button">View</a>
                    </td>
                </tr>
                <tr>
                    <td>104</td>
                    <td>Kay Gundo</td>
                    <td>Marriage Certificate</td>
                    <td>2023-08-15</td>
                    <td>Denied</td>
                    <td>
                        <a href="view_application.html?id=104" class="action-button">View</a>
                    </td>
                </tr>
                <!-- Add more application rows as needed -->
            </tbody>
        </table>
    </main>
</body>
<?php
include("includes/footer.php");
?>
