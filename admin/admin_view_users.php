<?php
include("includes/admin_header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['adminEmail'])){
  header('location: admin_login.php?error=Unauthorised Access. Please Login.');
  exit;
}
include('server/get_admin_logout.php');
?>
<script>
    function verifyUser(button, userId) {
        // Simulate verification logic (you can replace this with actual verification logic)
        const isVerified = Math.random() > 0.5; // Randomly verify for demo
        const statusCell = button.closest('tr').querySelector('.status-cell');

        if (isVerified) {
            button.innerText = 'Verified';
            button.disabled = true;
            statusCell.innerHTML = '✔️ Verified';
            statusCell.style.color = 'green';
        } else {
            button.innerText = 'Not Verified';
            button.disabled = true;
            statusCell.innerHTML = '❌ Not Verified';
            statusCell.style.color = 'red';
        }
    }
</script>
<body>
    <header>
        <h1>Home Affairs Admin: View Users</h1>
    </header>  
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_review_applications.php">Review Applications</a>
        <a href="admin_logs.php">Logs</a>
        <?php if(isset($_SESSION['adminEmail'])){ ?>
            <form id="admin-logout-form" method="POST" action="server/get_admin_logout.php">
                <a><button type="submit" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <h2>User List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Home Affairs ID</th>
                    <th>Registration Date</th>
                    <th>Phone Number</th>
                    <th>Verification Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>john.doe@example.com</td>
                    <td>1234567890123</td>
                    <td>2023-01-15</td>
                    <td>123-456-7890</td>
                    <td class="status-cell">Pending</td>
                    <td>
                        <button class="verify-button" onclick="verifyUser(this, 1)">Verify</button>
                        <a href="edit_user.html?id=1" class="action-button">Edit</a>
                        <a href="delete_user.html?id=1" class="action-button">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>jane.smith@example.com</td>
                    <td>9876543210123</td>
                    <td>2023-02-20</td>
                    <td>098-765-4321</td>
                    <td class="status-cell">Pending</td>
                    <td>
                        <button class="verify-button" onclick="verifyUser(this, 2)">Verify</button>
                        <a href="edit_user.html?id=2" class="action-button">Edit</a>
                        <a href="delete_user.html?id=2" class="action-button">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Miriam Anozie</td>
                    <td>miriam.anozie@example.com</td>
                    <td>1122334455667</td>
                    <td>2023-03-10</td>
                    <td>555-123-4567</td>
                    <td class="status-cell">Pending</td>
                    <td>
                        <button class="verify-button" onclick="verifyUser(this, 3)">Verify</button>
                        <a href="edit_user.html?id=3" class="action-button">Edit</a>
                        <a href="delete_user.html?id=3" class="action-button">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Kay Gundo</td>
                    <td>kay.gundo@example.com</td>
                    <td>6677889900112</td>
                    <td>2023-04-05</td>
                    <td>555-765-4321</td>
                    <td class="status-cell">Pending</td>
                    <td>
                        <button class="verify-button" onclick="verifyUser(this, 4)">Verify</button>
                        <a href="edit_user.html?id=4" class="action-button">Edit</a>
                        <a href="delete_user.html?id=4" class="action-button">Delete</a>
                    </td>
                </tr>
                <!-- Add more user rows as needed -->
            </tbody>
        </table>
    </main>
</body>
<?php
include("includes/admin_footer.php");
?>
