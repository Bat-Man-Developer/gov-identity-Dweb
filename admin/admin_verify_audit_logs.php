<?php
include("includes/admin_header.php");
//if admin is not logged in then take admin to login page
if(!isset($_SESSION['adminID'])){
    $log_action = "admin view audit logs";
    $log_status = "failed";
    $log_location = $_SERVER['REMOTE_ADDR'];
    $log_date = date('Y-m-d H:i:s');

    // Prepare SQL statement for audit log
    $stmt1 = $conn->prepare("INSERT INTO audit_logs (log_action, log_status, log_location, log_date)
    VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssss", $log_action, $log_status, $log_location, $log_date);

    if ($stmt1->execute()) {
        $stmt1->close();
    }

    header("Location: ../index.php?error=Unauthorised Access. Trespassers will be prosecuted. Activity has been logged."); // Redirect to index
    exit();
}
else{
    $adminID = $_SESSION['adminID'];
    $log_action = "admin view audit logs";
    $log_status = "success";
    $log_location = $_SERVER['REMOTE_ADDR'];
    $log_date = date('Y-m-d H:i:s');

    // Prepare SQL statement for audit log
    $stmt1 = $conn->prepare("INSERT INTO audit_logs (admin_id, log_action, log_status, log_location, log_date)
    VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssss", $adminID, $log_action, $log_status, $log_location, $log_date);

    if ($stmt1->execute()) {
        $stmt1->close();
    }
}
?>
<body>
    <div class="container">
        <header>
            <h1>Home Affairs Admin: Verify Audit Logs</h1>
            <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
        </header>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_review_citizenship_applications.php">Review Citizenship Applications</a>
            <a href="admin_review_visa_applications.php">Review Visa Applications</a>
            <a href="admin_review_civil_registrations.php">Review Civil Registrations</a>
            <a href="admin_review_id_applications.php">Review ID Applications</a>
            <a href="admin_view_users.php">View Users</a>
            <?php if(isset($_SESSION['adminEmail'])){ ?>
                <form id="admin-logout-form" method="POST" action="admin_audit_logs.php">
                    <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
                </form>
            <?php } ?>
        </nav>
        <main>
            <h2>Verify Activity Logs</h2>
            <p id="responseMessage">Loading Results...</p><br>
            <a href="admin_audit_logs.php"><button>Go back</button></a>

            <div class="container">
                <div class="plot-container">
                    <div class="plot">
                        <h2>Confusion Matrix</h2>
                        <img id="confusion-matrix" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Model Weights</h2>
                        <img id="model-weights" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Feature Importance</h2>
                        <img id="feature-importance" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Performance Metrics</h2>
                        <img id="performance-metrics" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>ROC Curve</h2>
                        <img id="roc-curve" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Precision-Recall Curve</h2>
                        <img id="precision-recall-curve" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Calibration Plot</h2>
                        <img id="calibration-plot" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Boxplots Predictions</h2>
                        <img id="boxplots-predictions" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Accuracy Comparison</h2>
                        <img id="accuracy-comparison" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Precision Comparison</h2>
                        <img id="precision-comparison" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Recall Comparison</h2>
                        <img id="recall-comparison" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>F1-Score Comparison</h2>
                        <img id="f1score-comparison" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Bias - Variance Tradeoff</h2>
                        <img id="bias-variance-tradeoff" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Learning Curves</h2>
                        <img id="learning-curves" alt="Loading Image...">
                    </div>
                </div>
            </div>
            <div class="page-btn">
                <span class="page-item <?php if($pagenumber <= 1){ echo 'disabled';} ?>"><a class="page-link" href="<?php if($pagenumber <= 1){ echo '#';}else{ echo "?pagenumber=".($pagenumber - 1);} ?>">Prev</a></span>

                <span class="page-item"><a class="page-link" href="?pagenumber=1">1</a></span>
                <span class="page-item"><a class="page-link" href="?pagenumber=2">2</a></span>

                <?php if($pagenumber >= 3) { ?>
                    <span class="page-item"><a class="page-link" href="#">...</a></span>
                    <span class="page-item"><a class="page-link" href="<?php echo "?pagenumber=".$pagenumber; ?>"><?php echo $pagenumber; ?></a></span>
                <?php } ?>

                <span class="page-item <?php if($pagenumber >= $totalnumberofpages){ echo 'disabled';} ?>"><a class="page-link" href="<?php if($pagenumber >= $totalnumberofpages){ echo '#';}else{ echo "?pagenumber=".($pagenumber + 1);} ?>">Next</a></span>
            </div>
        </main>
    </div>
</body>
<script src="js/admin_verify_audit_logs.js"></script>
<?php
include("includes/admin_footer.php");
?>