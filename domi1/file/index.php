<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>ระบบจัดการหอพัก</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12"> <br>
                <h3>รายการห้องพัก <a href="add_room.php" class="btn btn-info float-end">+เพิ่มห้องพัก</a> </h3>
                <table class="table table-striped table-hover table-bordered">
                    <thead align="center">
    <tr>
            <th width="10%">รูปผู้เช่า</th>
            <th width="10%">เลขห้อง</th>
            <th width="20%">ประเภท</th>
            <th width="15%">ราคา</th>
            <th width="20%">ชื่อผู้เช่า</th>
            <th width="10%">สถานะ</th>
            <th width="7%">แก้ไข</th>
            <th width="7%">ลบ</th>
        </tr>
</thead>
                    <tbody>
                        <?php
                        require 'connect.php';
                        $sql = "SELECT rooms.*, room_type.typeName, room_type.price 
                                FROM rooms 
                                JOIN room_type ON rooms.typeID = room_type.typeID 
                                ORDER BY roomNumber";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $statusColor = ($r['status'] == 'ว่าง') ? 'text-success' : 'text-danger';
    ?>
        <tr>
            <td align="center">
                <?php if (!empty($r['image'])): ?>
                    <img src="../image/<?= $r['image'] ?>" width="50" height="60" style="object-fit: cover; border-radius: 5px;">
                <?php else: ?>
                    <small class="text-muted">ไม่มีรูป</small>
                <?php endif; ?>
            </td>

            <td align="center"><?= $r['roomNumber'] ?></td>

            <td><?= $r['typeName'] ?></td>

            <td align="right"><?= number_format($r['price'], 2) ?></td>

            <td><?= !empty($r['tenantName']) ? $r['tenantName'] : '-' ?></td>

            <td align="center" class="fw-bold <?= $statusColor ?>"><?= $r['status'] ?></td>
            
            <td align="center">
                <a href="edit_form.php?roomNumber=<?= $r['roomNumber'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
            </td>

            <td align="center">
                <a href="delete_room.php?roomNumber=<?= $r['roomNumber'] ?>" 
                   class="btn btn-danger btn-sm" 
                   onclick="return confirm('ยืนยันการลบ?');">ลบ</a>
            </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>