<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการหอพัก</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold m-0">รายการห้องพัก</h2>
                    <a href="add_room.php" class="btn btn-info text-white">+ เพิ่มห้องพัก</a> 
                </div>

                <table class="table table-hover shadow-sm">
                    <thead class="table-dark">
                        <tr align="center">
                            <th width="10%">รูปผู้เช่า</th>
                            <th width="10%">เลขห้อง</th>
                            <th width="20%">ประเภท</th>
                            <th width="12%">ราคา</th>
                            <th width="22%">ชื่อผู้เช่า</th>
                            <th width="12%">สถานะ</th>
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
                            $statusBadge = ($r['status'] == 'ว่าง') ? 'bg-success' : 'bg-danger';
                        ?>
                            <tr>
                                <td align="center">
                                    <?php if (!empty($r['image'])): ?>
                                        <img src="../image/<?= $r['image'] ?>" width="45" height="55" class="img-zoom rounded">
                                    <?php else: ?>
                                        <small class="text-muted">ไม่มีรูป</small>
                                    <?php endif; ?>
                                </td>
                                <td align="center" class="fw-bold"><?= $r['roomNumber'] ?></td>
                                <td><?= $r['typeName'] ?></td>
                                <td align="right" class="fw-bold"><?= number_format($r['price'], 2) ?></td>
                                <td><?= !empty($r['tenantName']) ? $r['tenantName'] : '<span class="text-muted">-</span>' ?></td>
                                <td align="center">
                                    <span class="badge rounded-pill <?= $statusBadge ?> px-3">
                                        <?= $r['status'] ?>
                                    </span>
                                </td>
                                <td align="center">
                                    <a href="edit_form.php?roomNumber=<?= $r['roomNumber'] ?>" class="btn btn-warning btn-sm w-100">แก้ไข</a>
                                </td>
                                <td align="center">
                                    <a href="delete_room.php?roomNumber=<?= $r['roomNumber'] ?>" 
                                       class="btn btn-danger btn-sm w-100" 
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