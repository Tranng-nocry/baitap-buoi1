<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sách thư viện</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h1 {
            color: #333;
        }

        form {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ddd;
        }
    </style>
</head>

<body>

<h1>QUẢN LÝ SÁCH THƯ VIỆN</h1>

<form method="post">
    <label>Tên sách:</label>
    <input type="text" name="ten_sach" required>

    <label>Tác giả:</label>
    <input type="text" name="tac_gia" required>

    <label>Thể loại:</label>
    <input type="text" name="the_loai" required>

    <label>Năm xuất bản:</label>
    <input type="number" name="nam_xuat_ban" required>

    <button type="submit" name="them_sach">Thêm sách</button>
</form>

<?php

// Hàm tự định nghĩa để phân loại sách
function phanLoaiSach($nam)
{
    $namHienTai = date("Y");

    if ($nam < $namHienTai - 10) {
        return "Sách cũ";
    } elseif ($nam <= $namHienTai) {
        return "Sách mới";
    } else {
        return "Năm không hợp lệ";
    }
}

// Mảng lưu danh sách sách
$danhSachSach = [];

// Kiểm tra khi người dùng nhập dữ liệu
if (isset($_POST["them_sach"])) {

    $tenSach = $_POST["ten_sach"];
    $tacGia = $_POST["tac_gia"];
    $theLoai = $_POST["the_loai"];
    $namXuatBan = $_POST["nam_xuat_ban"];

    // Tạo một sách bằng mảng
    $sach = [
        "ten_sach" => $tenSach,
        "tac_gia" => $tacGia,
        "the_loai" => $theLoai,
        "nam_xuat_ban" => $namXuatBan
    ];

    // Thêm sách vào danh sách
    $danhSachSach[] = $sach;

    echo "<h2>Thông tin sách vừa nhập</h2>";

    echo "<table>";
    echo "<tr>";
    echo "<th>Tên sách</th>";
    echo "<th>Tác giả</th>";
    echo "<th>Thể loại</th>";
    echo "<th>Năm xuất bản</th>";
    echo "<th>Phân loại</th>";
    echo "</tr>";

    // Dùng vòng lặp để hiển thị dữ liệu
    foreach ($danhSachSach as $sach) {

        echo "<tr>";

        echo "<td>" . htmlspecialchars($sach["ten_sach"]) . "</td>";
        echo "<td>" . htmlspecialchars($sach["tac_gia"]) . "</td>";
        echo "<td>" . htmlspecialchars($sach["the_loai"]) . "</td>";
        echo "<td>" . htmlspecialchars($sach["nam_xuat_ban"]) . "</td>";

        // Sử dụng hàm tự định nghĩa
        echo "<td>" . phanLoaiSach($sach["nam_xuat_ban"]) . "</td>";

        echo "</tr>";
    }

    echo "</table>";
}

?>

</body>
</html>