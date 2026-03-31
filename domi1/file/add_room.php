<?php
require 'connect.php';
$stmt_t = $conn->prepare("SELECT * FROM room_type");
$stmt_t->execute();

if (isset($_POST['submit'])) {
    $sql = "INSERT INTO rooms (roomNumber, typeID, tenantName, status) VALUES (:id, :type, :name, :status)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_POST['roomNumber']);
    $stmt->bindParam(':type', $_POST['typeID']);
    $stmt->bindParam(':name', $_POST['tenantName']);
    $stmt->bindParam(':status', $_POST['status']);

    if($stmt->execute()) {
        header('location:index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>เพิ่มห้องพัก</title>
</head>
<body>
    <div class="container"><div class="row"><div class="col-md-4"><br>
        <h3>ฟอร์มเพิ่มห้องพัก</h3>
        <form action="" method="POST">
            <label>เลขห้อง:</label>
            <input type="text" name="roomNumber" class="form-control" required placeholder="เช่น 101">
            <label>ประเภทห้อง:</label>
            <select name="typeID" class="form-control">
                <?php while($t = $stmt_t->fetch()) { ?>
                    <option value="<?= $t['typeID'] ?>"><?= $t['typeName'] ?></option>
                <?php } ?>
            </select>
            <label>ชื่อผู้เช่า (ถ้ามี):</label>
            <input type="text" name="tenantName" class="form-control">
            <label>สถานะ:</label>
            <select name="status" class="form-control">
                <option value="ว่าง">ว่าง</option>
                <option value="มีคนเช่า">มีคนเช่า</option>
            </select>
            <br><input type="submit" name="submit" value="บันทึก" class="btn btn-primary">
        </form>
    </div></div></div>
</body>
</html>