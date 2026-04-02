<?php
require 'connect.php';
$stmt_t = $conn->prepare("SELECT * FROM room_type");
$stmt_t->execute();

if (isset($_POST['submit'])) {
    $uploadFile = $_FILES['image']['name'];
    $tmpFile = $_FILES['image']['tmp_name'];
    $new_file_name = "";

    if (!empty($uploadFile)) {
        // ใส่ time() เพื่อป้องกันกรณีอัปโหลดไฟล์ชื่อเดียวกันซ้ำ
        $new_file_name = time() . "_" . $uploadFile;
        $fullpath = "../image/" . $new_file_name;
        move_uploaded_file($tmpFile, $fullpath);
    }
    
    $sql = "INSERT INTO rooms (roomNumber, typeID, tenantName, status, image) 
            VALUES (:id, :type, :name, :status, :img)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_POST['roomNumber']);
    $stmt->bindParam(':type', $_POST['typeID']);
    $stmt->bindParam(':name', $_POST['tenantName']);
    $stmt->bindParam(':status', $_POST['status']);
    $stmt->bindParam(':img', $new_file_name);

    if($stmt->execute()) {
        header('location:index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มห้องพัก | ระบบจัดการหอพัก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-4">
                    <h3 class="fw-bold mb-4 text-center">🏢 เพิ่มห้องพักใหม่</h3>
                    
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">เลขห้อง:</label>
                            <input type="text" name="roomNumber" class="form-control" required placeholder="เช่น 101, 205">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">ประเภทห้อง:</label>
                            <select name="typeID" class="form-select">
                                <?php while($t = $stmt_t->fetch()) { ?>
                                    <option value="<?= $t['typeID'] ?>"><?= $t['typeName'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">ชื่อผู้เช่า (ถ้ามี):</label>
                            <input type="text" name="tenantName" class="form-control" placeholder="ระบุชื่อ-นามสกุล">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">สถานะห้อง:</label>
                            <select name="status" class="form-select">
                                <option value="ว่าง">ว่าง (พร้อมเช่า)</option>
                                <option value="มีคนเช่า">มีคนเช่าแล้ว</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">รูปภาพผู้เช่า:</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="form-text">ไฟล์รูปภาพนามสกุล .jpg, .png เท่านั้น</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <input type="submit" name="submit" value="บันทึกข้อมูล" class="btn btn-primary py-2 shadow-sm">
                            <a href="index.php" class="btn btn-light border py-2">ยกเลิกและกลับหน้าหลัก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>