<?php
    include("admin_connection.php");

    //1. Return number of citizenship applications
    $stmt = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM citizenship_applications");
    $stmt->execute();
    $stmt->bind_result($totalrecords);
    $stmt->store_result();
    $stmt->fetch();
    //1.1 Close the statement
    $stmt->close();
    //1.2 Store the total number of citizenship applications
    $totalCitizenshipApplications = $totalrecords;

    //2. Return number of visa applications
    $stmt1 = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM visa_applications");
    $stmt1->execute();
    $stmt1->bind_result($totalrecords1);
    $stmt1->store_result();
    $stmt1->fetch();
    //2.1 Close the statement
    $stmt1->close();
    //2.2 Store the total number of visa applications
    $totalVisaApplications = $totalrecords1;

    //3. Return number of civil registrations
    $stmt2 = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM civil_registrations");
    $stmt2->execute();
    $stmt2->bind_result($totalrecords2);
    $stmt2->store_result();
    $stmt2->fetch();
    //3.1 Close the statement
    $stmt2->close();
    //3.2 Store the total number of civil registrations
    $totalCivilRegistrations = $totalrecords2;

    //4. Return number of ID applications
    $stmt3 = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM id_applications");
    $stmt3->execute();
    $stmt3->bind_result($totalrecords3);
    $stmt3->store_result();
    $stmt3->fetch();
    //4.1 Close the statement
    $stmt3->close();
    //4.2 Store the total number of ID applications
    $totalIDApplications = $totalrecords3;

    //5. Total applications
    $totalApplications = $totalCitizenshipApplications + $totalVisaApplications + $totalCivilRegistrations + $totalIDApplications;

    //6. Total approved applications
    $totalApprovedApplications = 0;

    //7. Total denied applications
    $totalDeniedApplications = 0;