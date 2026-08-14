<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng Điểm Sinh Viên</title>
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #e984c4;
            color: white;
        }
        .dat { color: green; font-weight: bold; }
        .truot { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Danh Sách Kết Quả Học Tập</h2>

    <?php
  
    $students = [
        ["name" => "Nguyễn Văn Hạnh", "midterm" => 8.0, "final" => 8.0],
        ["name" => "Hoàng Văn Ánh", "midterm" => 4.0, "final" => 9.0],
        ["name" => "Phạm Văn Linh", "midterm" => 3.0, "final" => 4.5]
    ];

    function calculateAverage($diem_gk, $diem_ck) {
        $trung_binh = ($diem_gk + $diem_ck) / 2;
        return $trung_binh;
    }
    ?>

    <table>
        <tr>
            <th>Tên Sinh Viên</th>
            <th>Giữa Kỳ</th>
            <th>Cuối Kỳ</th>
            <th>Điểm TB</th>
            <th>Kết Quả</th>
        </tr>

        <?php
        foreach ($students as $sv) {
            
            $dtb = calculateAverage($sv['midterm'], $sv['final']);
            
            if ($dtb >= 5) {
                $ket_qua = "<span class='dat'>Đạt</span>";
            } else {
                $ket_qua = "<span class='truot'>Chưa đạt</span>";
            }

            $ten_an_toan = htmlspecialchars($sv['name']);

            echo "<tr>";
                echo "<td>" . $ten_an_toan . "</td>";
                echo "<td>" . $sv['midterm'] . "</td>";
                echo "<td>" . $sv['final'] . "</td>";
                echo "<td>" . $dtb . "</td>";
                echo "<td>" . $ket_qua . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>