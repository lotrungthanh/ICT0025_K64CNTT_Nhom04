<?php
require_once '../config/db.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM the_loai WHERE id=$id");
header("Location: index.php");
?>