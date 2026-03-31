<?php
if (isset($_GET['roomNumber'])) {
    require 'connect.php';
    $stmt = $conn->prepare("DELETE FROM rooms WHERE roomNumber = :id");
    $stmt->bindParam(':id', $_GET['roomNumber']);
    $stmt->execute();
    header('location:index.php');
}
?>