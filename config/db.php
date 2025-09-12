<?php
    // db.php

    // Database credentials
    $host = "localhost";        // Usually localhost
    $user = "root";             // Your MySQL username
    $password = "";             // Your MySQL password
    $dbname = "db_etec_sys";    // Your database name

    // Create connection
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Optional: set charset to utf8
    $conn->set_charset("utf8");

    // Now $conn can be used in other PHP files
?>
