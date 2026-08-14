<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Bảng tính tiền tài liệu</title>
</head>

<body>
    <h2>Tính tiền Tài liệu</h2>

    <form method="POST" action="">
        <label for="ten">Tên tài liệu:</label><br>
        <input type="text" name="ten_tai_lieu" id="ten" required><br><br>

        <label for="sl">Số lượng sản phẩm:</label><br>
        <input type="number" name="so_luong" id="sl" min="1" required><br><br>

        <label for="gia">Đơn giá (VNĐ):</label><br>
        <input type="number" name="don_gia" id="gia" min="0" required><br><br>

        <button type="submit" name="btn_tinh">Tổng</button>
    </form>

    <hr>

    <?php
    if (isset($_POST['btn_tinh'])) {


        $ten = $_POST['ten_tai_lieu'];
        $sl = $_POST['so_luong'];
        $gia = $_POST['don_gia'];


        $thanh_tien = $sl * $gia;


        echo "<h3>Chi tiết hóa đơn:</h3>";
        echo "Tên tài liệu: <strong>" . $ten . "</strong><br>";

        echo "Tổng số tiền: <strong style='color: red;'>" . number_format($thanh_tien) . " VNĐ</strong>";
    }
    ?>
</body>

</html>