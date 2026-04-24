<?php
$conn = new mysqli("localhost", "root", "", "crud2");

if ($conn->connect_error) {
    echo "database not connected";
    die("Connection failed: " . $conn->connect_error);
}
?>