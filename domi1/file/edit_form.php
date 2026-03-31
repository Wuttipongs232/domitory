<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>แก้ไขข้อมูลห้องพัก</title>
</head>
<body>
<?php
    require 'connect.php';

    if (isset($_GET['roomNumber'])) {
        $stmt = $conn->prepare("SELECT * FROM rooms WHERE roomNumber = ?");
        $stmt->execute([$_GET['roomNumber']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            die("ไม่พบข้อมูลห้องนี้ในระบบ");
        }
    }

    $stmt_c = $conn->prepare("SELECT * FROM room_type");
    $stmt_c->execute();
?>

    <div class="container">
        <div class="row">
            <div class="col-md-5"> <br>
                <h3>ฟอร์มแก้ไขข้อมูลห้องพัก</h3>
                <form action="update_room.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="roomNumber" value="<?= $result['roomNumber'] ?>">
                    
                    <label>เลขห้อง (แก้ไขไม่ได้):</label>
                    <input type="text" class="form-control" value="<?= $result['roomNumber'] ?>" disabled>
                    <input type="hidden" name="roomNumber" value="<?= $result['roomNumber'] ?>">
                    
                    <br>
                    <label>ชื่อผู้เช่า:</label>
                    <input type="text" name="tenantName" class="form-control" required value="<?= $result['tenantName'] ?>">

                    <br>
                    <label>ประเภทห้อง:</label>
                    <select name="typeID" class="form-control">
                        <?php while ($t = $stmt_c->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $t['typeID'] ?>" <?= ($t['typeID'] == $result['typeID']) ? 'selected' : '' ?>>
                                <?= $t['typeName'] ?> (ราคา <?= number_format($t['price']) ?> บาท)
                            </option>
                        <?php } ?>
                    </select>

                    <br>
                    <label>สถานะ:</label>
                    <select name="status" class="form-control">
                        <option value="ว่าง" <?= ($result['status'] == 'ว่าง') ? 'selected' : '' ?>>ว่าง</option>
                        <option value="มีคนเช่า" <?= ($result['status'] == 'มีคนเช่า') ? 'selected' : '' ?>>มีคนเช่า</option>
                    </select>

                    
    <?php if(!empty($result['image'])): ?>
        <img src="../image/<?= $result['image'] ?>" width="150" class="mb-2">
    <?php else: ?>
        <p class="text-muted">ยังไม่มีรูปภาพ</p>
    <?php endif; ?>
    
    <input type="file" name="image" class="form-control">
    <br>
    
    <label>ชื่อผู้เช่า:</label>
    <input type="text" name="tenantName" class="form-control" value="<?= $result['tenantName'] ?>">
<br>
                    <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                    <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
                    <label>รูปผู้เช่าปัจจุบัน:</label><br>
</form>
                </form>
            </div>
        </div>
    </div>
</body>
</html>