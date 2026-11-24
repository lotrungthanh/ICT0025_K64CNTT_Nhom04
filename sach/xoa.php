<?php
require_once '../config/db.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM sach WHERE id=$id");
header("Location: index.php");
?>