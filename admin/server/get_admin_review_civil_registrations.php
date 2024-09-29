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
  $stmt = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM civil_registrations");
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
  $stmt1 = $conn->prepare("SELECT * FROM civil_registrations LIMIT $offset,$totalrecordsperpage");
  $stmt1->execute();
  $registrations = $stmt1->get_result();// This is an array

  $log_action = "admin view server civil registrations";
  $log_status = "success";

  // Get the IP address
  $log_ip_address = $_SERVER['REMOTE_ADDR'];

  // Get the location
  $log_location = getLocationFromIP($log_ip_address);

  $log_date = date('Y-m-d H:i:s');

  // Prepare SQL statement for audit log
  $stmt1 = $conn->prepare("INSERT INTO audit_logs (admin_id, log_action, log_status, log_location, log_date)
  VALUES (?, ?, ?, ?, ?)");
  $stmt1->bind_param("sssss", $adminID, $log_action, $log_status, $log_location, $log_date);

  if ($stmt1->execute()) {
      $stmt1->close();
  }

  // Function to get location from IP address
function isPrivateIP($ip) {
  $private_ranges = [
      '10.0.0.0' => '10.255.255.255',
      '172.16.0.0' => '172.31.255.255',
      '192.168.0.0' => '192.168.255.255',
  ];

  foreach ($private_ranges as $start => $end) {
      if (ip2long($ip) >= ip2long($start) && ip2long($ip) <= ip2long($end)) {
          return true;
      }
  }
  return false;
}

function getLocationFromIP($ip) {
  if (isPrivateIP($ip)) {
      return "Private IP Address";
  }

  $url = "http://ip-api.com/json/{$ip}";
  $response = file_get_contents($url);
  $data = json_decode($response, true);

  if ($data['status'] == 'success') {
      return "{$data['city']}, {$data['regionName']}, {$data['country']}";
  } else {
      return "Unknown";
  }
}