<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลห้องพัก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    require 'connect.php';
    if (isset($_GET['roomNumber'])) {
        $stmt = $conn->prepare("SELECT * FROM rooms WHERE roomNumber = ?");
        $stmt->execute([$_GET['roomNumber']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) { die("ไม่พบข้อมูลห้องนี้ในระบบ"); }
    }
    $stmt_c = $conn->prepare("SELECT * FROM room_type");
    $stmt_c->execute();
?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 card shadow p-4">
                <h3 class="fw-bold mb-4">📝 แก้ไขข้อมูลห้องพัก</h3>
                <form action="update_room.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="roomNumber" value="<?= $result['roomNumber'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">เลขห้อง:</label>
                        <input type="text" class="form-control bg-light" value="<?= $result['roomNumber'] ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ชื่อผู้เช่า:</label>
                        <input type="text" name="tenantName" class="form-control" required value="<?= $result['tenantName'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ประเภทห้อง:</label>
                        <select name="typeID" class="form-select">
                            <?php while ($t = $stmt_c->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?= $t['typeID'] ?>" <?= ($t['typeID'] == $result['typeID']) ? 'selected' : '' ?>>
                                    <?= $t['typeName'] ?> (<?= number_format($t['price']) ?> บาท)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">สถานะ:</label>
                        <select name="status" class="form-select">
                            <option value="ว่าง" <?= ($result['status'] == 'ว่าง') ? 'selected' : '' ?>>ว่าง</option>
                            <option value="มีคนเช่า" <?= ($result['status'] == 'มีคนเช่า') ? 'selected' : '' ?>>มีคนเช่า</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">รูปผู้เช่าปัจจุบัน:</label><br>
                        <?php if(!empty($result['image'])): ?>
                            <img src="../image/<?= $result['image'] ?>" width="120" class="img-thumbnail mb-2">
                        <?php else: ?>
                            <p class="text-muted small">ยังไม่มีรูปภาพ</p>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control">
                        <div class="form-text">แนบไฟล์ใหม่หากต้องการเปลี่ยนรูป</div>
                    </div>

                    <div class="d-grid gap-2 d-md-block">
                        <button type="submit" class="btn btn-primary px-4">บันทึกการแก้ไข</button>
                        <a href="index.php" class="btn btn-secondary px-4">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>