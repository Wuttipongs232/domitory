<?php
require 'connect.php';

if (isset($_POST['roomNumber'])) {
    $roomNumber = $_POST['roomNumber'];
    $tenantName = $_POST['tenantName'];
    $typeID = $_POST['typeID'];
    $status = $_POST['status'];

    //จัดการเรื่องรูปภาพ
    $uploadFile = $_FILES['image']['name'];
    $tmpFile = $_FILES['image']['tmp_name'];
    
    if (!empty($uploadFile)) {
        // กรณีเลือกรูปใหม่
        $fullpath = "../image/" . $uploadFile;
        move_uploaded_file($tmpFile, $fullpath);
        
        $sql = "UPDATE rooms SET tenantName=:name, typeID=:type, status=:status, image=:img WHERE roomNumber=:id";
        $params = [
            ':name' => $tenantName,
            ':type' => $typeID,
            ':status' => $status,
            ':img' => $uploadFile,
            ':id' => $roomNumber
        ];
    } else {
        // กรณีไม่ได้เลือกรูปใหม่ ให้ใช้ข้อมูลเดิม (ไม่แก้คอลัมน์ image)
        $sql = "UPDATE rooms SET tenantName=:name, typeID=:type, status=:status WHERE roomNumber=:id";
        $params = [
            ':name' => $tenantName,
            ':type' => $typeID,
            ':status' => $status,
            ':id' => $roomNumber
        ];
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    header('Location: index.php');
}
?>