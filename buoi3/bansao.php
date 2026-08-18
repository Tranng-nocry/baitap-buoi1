<?php

// ================================
// KHỞI TẠO DỮ LIỆU
// ================================

$idBanSao = "";
$idDauSach = "";
$maBanSao = "";
$trangThai = "Đã trả";
$ngayNhap = "";


// Biến lưu lỗi
$loiIdBanSao = "";
$loiIdDauSach = "";
$loiMaBanSao = "";
$loiTrangThai = "";
$loiNgayNhap = "";


// Kiểm tra form có hợp lệ không
$hopLe = false;


// Mảng lưu danh sách bản sao
$danhSachBanSao = [];


// ================================
// HÀM TRẠNG THÁI MƯỢN TRẢ
// ================================

function trangThaiMuonTra($trangThai)
{
    if ($trangThai == "Đã trả") {
        return "Đã trả";
    }

    if ($trangThai == "Đang mượn") {
        return "Đang mượn";
    }

    return "Chưa trả";
}


// ================================
// XỬ LÝ FORM
// ================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lấy dữ liệu và loại bỏ khoảng trắng thừa
    $idBanSao = trim($_POST["id_ban_sao"] ?? "");
    $idDauSach = trim($_POST["id_dau_sach"] ?? "");
    $maBanSao = trim($_POST["ma_ban_sao"] ?? "");
    $trangThai = trim($_POST["trang_thai"] ?? "");
    $ngayNhap = trim($_POST["ngay_nhap"] ?? "");


    // ================================
    // KIỂM TRA ID BẢN SAO
    // Ví dụ đúng: B01, A12, S123
    // ================================

    if ($idBanSao == "") {

        $loiIdBanSao = "Vui lòng nhập ID bản sao.";

    } elseif (!preg_match('/^[A-Z][0-9]+$/', $idBanSao)) {

        $loiIdBanSao =
            "ID bản sao phải gồm 1 chữ IN HOA ở đầu và số ở sau. Ví dụ: B01.";
    }


    // ================================
    // KIỂM TRA ID ĐẦU SÁCH
    // ================================

    if ($idDauSach == "") {

        $loiIdDauSach = "Vui lòng nhập ID đầu sách.";

    } elseif (!preg_match('/^[A-Z][0-9]+$/', $idDauSach)) {

        $loiIdDauSach =
            "ID đầu sách phải gồm 1 chữ IN HOA ở đầu và số ở sau. Ví dụ: D01.";
    }


    // ================================
    // KIỂM TRA MÃ BẢN SAO
    // ================================

    if ($maBanSao == "") {

        $loiMaBanSao = "Vui lòng nhập mã bản sao.";

    } elseif (!preg_match('/^[A-Z][0-9]+$/', $maBanSao)) {

        $loiMaBanSao =
            "Mã bản sao phải gồm 1 chữ IN HOA ở đầu và số ở sau. Ví dụ: M01.";
    }


    // ================================
    // KIỂM TRA TRẠNG THÁI
    // ================================

    $danhSachTrangThai = [
        "Đã trả",
        "Đang mượn",
        "Chưa trả"
    ];

    if (!in_array($trangThai, $danhSachTrangThai)) {

        $loiTrangThai = "Trạng thái không hợp lệ.";
    }


    // ================================
    // KIỂM TRA NGÀY NHẬP
    // ================================

    if ($ngayNhap == "") {

        $loiNgayNhap = "Vui lòng chọn ngày nhập.";

    } else {

        $ngay = DateTime::createFromFormat("Y-m-d", $ngayNhap);

        if (!$ngay || $ngay->format("Y-m-d") != $ngayNhap) {

            $loiNgayNhap = "Ngày nhập không hợp lệ.";
        }
    }


    // ================================
    // KIỂM TRA TOÀN BỘ FORM
    // ================================

    if (
        $loiIdBanSao == "" &&
        $loiIdDauSach == "" &&
        $loiMaBanSao == "" &&
        $loiTrangThai == "" &&
        $loiNgayNhap == ""
    ) {

        $hopLe = true;


        // Tạo mảng chứa thông tin bản sao
        $banSao = [

            "id_ban_sao" => $idBanSao,

            "id_dau_sach" => $idDauSach,

            "ma_ban_sao" => $maBanSao,

            "trang_thai" => $trangThai,

            "ngay_nhap" => $ngayNhap
        ];


        // Thêm vào danh sách
        $danhSachBanSao[] = $banSao;
    }
}

?>


<!DOCTYPE html>

<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Quản lý bản sao sách</title>


    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background-color: #eef5ff;
        }


        h1 {
            text-align: center;
            color: #23558d;
            margin-bottom: 30px;
        }


        form {
            width: 520px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }


        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }


        input,
        select {
            width: 100%;
            padding: 11px;
            box-sizing: border-box;
            border: 2px solid #c5c5c5;
            border-radius: 6px;
            font-size: 15px;
            transition: 0.2s;
        }


        input:focus,
        select:focus {
            border-color: #2f80c0;
            outline: none;
        }


        /* Ô nhập bị sai */
        .input-loi {
            border: 2px solid red !important;
            background-color: #ffeaea !important;
        }


        /* Chữ báo lỗi */
        .loi {
            color: red;
            font-size: 13px;
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 5px;
        }


        button {
            display: block;
            width: 180px;
            margin: 25px auto 0;
            padding: 12px;
            border: none;
            border-radius: 7px;
            background-color: #2f80c0;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }


        button:hover {
            background-color: #1e6295;
        }


        .thanh-cong {
            width: 520px;
            margin: 25px auto;
            padding: 13px;
            text-align: center;
            background-color: #e9f9ee;
            color: green;
            border: 1px solid green;
            border-radius: 7px;
            font-weight: bold;
        }


        .ket-qua {
            width: 95%;
            margin: 35px auto;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12);
        }


        .ket-qua h2 {
            color: #23558d;
            text-align: center;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }


        th {
            background-color: #4383bd;
            color: white;
            padding: 12px;
        }


        td {
            border: 1px solid #ddd;
            padding: 11px;
            text-align: center;
        }


        /* Trạng thái đã trả */
        .da-tra {
            color: green;
            font-weight: bold;
        }


        /* Trạng thái đang mượn */
        .dang-muon {
            color: #d89400;
            font-weight: bold;
        }


        /* Trạng thái chưa trả */
        .chua-tra {
            color: red;
            font-weight: bold;
        }

    </style>

</head>


<body>


<h1>QUẢN LÝ BẢN SAO SÁCH</h1>


<form method="post">


    <!-- ID BẢN SAO -->

    <label for="id_ban_sao">
        ID bản sao:
    </label>


    <input
        type="text"
        id="id_ban_sao"
        name="id_ban_sao"
        placeholder="Ví dụ: B01"
        value="<?php echo htmlspecialchars($idBanSao); ?>"
        class="<?php echo $loiIdBanSao != "" ? "input-loi" : ""; ?>"
    >


    <?php if ($loiIdBanSao != "") { ?>

        <p class="loi">

            <?php echo htmlspecialchars($loiIdBanSao); ?>

        </p>

    <?php } ?>



    <!-- ID ĐẦU SÁCH -->

    <label for="id_dau_sach">
        ID đầu sách:
    </label>


    <input
        type="text"
        id="id_dau_sach"
        name="id_dau_sach"
        placeholder="Ví dụ: D01"
        value="<?php echo htmlspecialchars($idDauSach); ?>"
        class="<?php echo $loiIdDauSach != "" ? "input-loi" : ""; ?>"
    >


    <?php if ($loiIdDauSach != "") { ?>

        <p class="loi">

            <?php echo htmlspecialchars($loiIdDauSach); ?>

        </p>

    <?php } ?>



    <!-- MÃ BẢN SAO -->

    <label for="ma_ban_sao">
        Mã bản sao:
    </label>


    <input
        type="text"
        id="ma_ban_sao"
        name="ma_ban_sao"
        placeholder="Ví dụ: M01"
        value="<?php echo htmlspecialchars($maBanSao); ?>"
        class="<?php echo $loiMaBanSao != "" ? "input-loi" : ""; ?>"
    >


    <?php if ($loiMaBanSao != "") { ?>

        <p class="loi">

            <?php echo htmlspecialchars($loiMaBanSao); ?>

        </p>

    <?php } ?>



    <!-- TRẠNG THÁI -->

    <label for="trang_thai">
        Trạng thái:
    </label>


    <select
        id="trang_thai"
        name="trang_thai"
        class="<?php echo $loiTrangThai != "" ? "input-loi" : ""; ?>"
    >


        <option
            value="Đã trả"
            <?php if ($trangThai == "Đã trả") echo "selected"; ?>
        >
            Đã trả
        </option>


        <option
            value="Đang mượn"
            <?php if ($trangThai == "Đang mượn") echo "selected"; ?>
        >
            Đang mượn
        </option>


        <option
            value="Chưa trả"
            <?php if ($trangThai == "Chưa trả") echo "selected"; ?>
        >
            Chưa trả
        </option>


    </select>


    <?php if ($loiTrangThai != "") { ?>

        <p class="loi">

            <?php echo htmlspecialchars($loiTrangThai); ?>

        </p>

    <?php } ?>



    <!-- NGÀY NHẬP -->

    <label for="ngay_nhap">
        Ngày nhập:
    </label>


    <input
        type="date"
        id="ngay_nhap"
        name="ngay_nhap"
        value="<?php echo htmlspecialchars($ngayNhap); ?>"
        class="<?php echo $loiNgayNhap != "" ? "input-loi" : ""; ?>"
    >


    <?php if ($loiNgayNhap != "") { ?>

        <p class="loi">

            <?php echo htmlspecialchars($loiNgayNhap); ?>

        </p>

    <?php } ?>



    <button type="submit">

        Xác nhận

    </button>


</form>



<?php if ($hopLe) { ?>


<div class="thanh-cong">

    Thêm bản sao thành công!

</div>



<div class="ket-qua">


    <h2>DANH SÁCH BẢN SAO</h2>


    <table>


        <tr>

            <th>STT</th>

            <th>ID bản sao</th>

            <th>ID đầu sách</th>

            <th>Mã bản sao</th>

            <th>Trạng thái</th>

            <th>Ngày nhập</th>

            <th>Trạng thái mượn trả</th>

        </tr>


        <?php

        $stt = 1;

        foreach ($danhSachBanSao as $banSao) {

            $classTrangThai = "";

            if ($banSao["trang_thai"] == "Đã trả") {

                $classTrangThai = "da-tra";

            } elseif ($banSao["trang_thai"] == "Đang mượn") {

                $classTrangThai = "dang-muon";

            } else {

                $classTrangThai = "chua-tra";
            }

        ?>


        <tr>


            <td>
                <?php echo $stt; ?>
            </td>


            <td>
                <?php
                echo htmlspecialchars(
                    $banSao["id_ban_sao"]
                );
                ?>
            </td>


            <td>
                <?php
                echo htmlspecialchars(
                    $banSao["id_dau_sach"]
                );
                ?>
            </td>


            <td>
                <?php
                echo htmlspecialchars(
                    $banSao["ma_ban_sao"]
                );
                ?>
            </td>


            <td>
                <?php
                echo htmlspecialchars(
                    $banSao["trang_thai"]
                );
                ?>
            </td>


            <td>
                <?php
                echo htmlspecialchars(
                    $banSao["ngay_nhap"]
                );
                ?>
            </td>


            <td class="<?php echo $classTrangThai; ?>">

                <?php
                echo htmlspecialchars(
                    trangThaiMuonTra(
                        $banSao["trang_thai"]
                    )
                );
                ?>

            </td>


        </tr>


        <?php

            $stt++;
        }

        ?>


    </table>


</div>


<?php } ?>


</body>

</html>