<?php
if (isset($_GET['roomNumber'])) {
    require 'connect.php';
    $roomNumber = $_GET['roomNumber'];

    //ดึงชื่อไฟล์ภาพจาก Database มาเก็บไว้ก่อน
    $stmt_img = $conn->prepare("SELECT image FROM rooms WHERE roomNumber = :id");
    $stmt_img->execute([':id' => $roomNumber]);
    $row = $stmt_img->fetch(PDO::FETCH_ASSOC);

    if (!empty($row['image'])) {
        $filepath = "../image/" . $row['image'];
        if (file_exists($filepath)) {
            unlink($filepath); // ลบไฟล์รูปออกจากโฟลเดอร์
        }
    }

    //ลบข้อมูลออกจาก Database
    $stmt = $conn->prepare("DELETE FROM rooms WHERE roomNumber = :id");
    $stmt->bindParam(':id', $roomNumber);
    
    if ($stmt->execute()) {
        header('location:index.php');
        exit();
    }
}
?>