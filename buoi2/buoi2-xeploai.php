<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xếp loại điểm học tập</title>
</head>
<body>
    <h2> Xếp loại điểm học sinh</h2>
    
    <form method="POST" action="">
        <label for="diem">Nhập số điểm của bạn:</label>
    
        <input type="number" step="0.1" name="diem_cua_toi" id="diem" required>
        <button type="submit" name="nut_kiem_tra">Xem xếp loại</button>
    </form>

    <hr>

    <?php
    if (isset($_POST['nut_kiem_tra'])) {
        
        $diem = $_POST['diem_cua_toi'];
        
        echo "<strong>Điểm bạn vừa nhập là: " . $diem . "</strong><br>";

        // Chạy lại bộ điều kiện y hệt như cũ
        if ($diem >= 8) {
            echo "Thông báo: Xếp loại Giỏi";
        } elseif ($diem >= 6.5) {
            echo "Thông báo: Xếp loại Khá";
        } elseif ($diem >= 5) {
            echo "Thông báo: Xếp loại Trung bình";
        } else {
            echo "Thông báo: Xếp loại Chưa đạt";
        }
    }
    ?>
</body>
</html>