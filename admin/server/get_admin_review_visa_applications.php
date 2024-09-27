<?php
  include('admin_connection.php');
  
  //1.determine page number
  if(isset($_GET['pagenumber']) && $_GET['pagenumber'] != ""){
    //if user has already entered page then page number is the one that they selected
    $pagenumber = $_GET['pagenumber'];
  }
  else{
    //if user just entered the page then default page is 1
    $pagenumber = 1;
  }

  //2. return number of applications
  $stmt = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM visa_applications");
  $stmt->execute();
  $stmt->bind_result($totalrecords);
  $stmt->store_result();
  $stmt->fetch();

  //3. determine a specific number of applications to display per page
  $totalrecordsperpage = 10;
  $offset = ($pagenumber - 1) * $totalrecordsperpage;
  $previouspage = $pagenumber - 1;
  $nextpage = $pagenumber + 1;
  $adjacents = "2";
  $totalnumberofpages = ceil($totalrecords / $totalrecordsperpage);

  //4. get all applications
  $stmt1 = $conn->prepare("SELECT * FROM visa_applications LIMIT $offset,$totalrecordsperpage");
  $stmt1->execute();
  $applications = $stmt1->get_result();// This is an array

  $log_action = "admin view visa applications";
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