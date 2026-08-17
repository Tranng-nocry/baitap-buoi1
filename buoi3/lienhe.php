<?php
$hoten = "";
$email = "";
$chude = "";
$noidung = "";

$loi_hoten = "";
$loi_email = "";
$loi_noidung = "";
$loi_anh = "";

$thanhcong = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Đọc dữ liệu từ form
    $hoten = trim($_POST["hoten"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $chude = $_POST["chude"] ?? "";
    $noidung = trim($_POST["noidung"] ?? "");

    // 1. Kiểm tra họ tên không được rỗng
    if ($hoten == "") {
        $loi_hoten = "Họ tên không được để trống.";
    }

    // 2. Kiểm tra email đúng định dạng
    if ($email == "") {
        $loi_email = "Email không được để trống.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $loi_email = "Email không đúng định dạng.";
    }

    // 3. Kiểm tra nội dung từ 10 đến 500 ký tự
    $dodai = mb_strlen($noidung);

    if ($noidung == "") {
        $loi_noidung = "Nội dung không được để trống.";
    } elseif ($dodai < 10 || $dodai > 500) {
        $loi_noidung = "Nội dung phải từ 10 đến 500 ký tự.";
    }

    // Kiểm tra ảnh nếu người dùng có chọn ảnh
    if (isset($_FILES["anh"]) && $_FILES["anh"]["error"] == 0) {

        $tenAnh = $_FILES["anh"]["name"];
        $tmpAnh = $_FILES["anh"]["tmp_name"];
        $kichThuoc = $_FILES["anh"]["size"];

        $duoiAnh = strtolower(pathinfo($tenAnh, PATHINFO_EXTENSION));

        $dinhDangChoPhep = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($duoiAnh, $dinhDangChoPhep)) {
            $loi_anh = "Chỉ được chọn ảnh JPG, JPEG, PNG hoặc GIF.";
        } elseif ($kichThuoc > 2 * 1024 * 1024) {
            $loi_anh = "Ảnh không được lớn hơn 2MB.";
        }
    }

    // Nếu không có lỗi
    if (
        $loi_hoten == "" &&
        $loi_email == "" &&
        $loi_noidung == "" &&
        $loi_anh == ""
    ) {

        // Nếu có ảnh thì lưu ảnh
        if (isset($_FILES["anh"]) && $_FILES["anh"]["error"] == 0) {

            if (!is_dir("uploads")) {
                mkdir("uploads");
            }

            $tenMoi = time() . "_" . basename($_FILES["anh"]["name"]);

            move_uploaded_file(
                $_FILES["anh"]["tmp_name"],
                "uploads/" . $tenMoi
            );
        }

        $thanhcong = "Gửi liên hệ thành công!";

        // Xóa dữ liệu sau khi gửi thành công
        $hoten = "";
        $email = "";
        $chude = "";
        $noidung = "";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Liên hệ</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fa;
            margin: 0;
            padding: 30px;
        }

        .container {
            width: 650px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #1d3c5c;
            margin-bottom: 10px;
        }

        .mota {
            text-align: center;
            color: #777;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 5px;
        }

        textarea {
            resize: vertical;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background: #3978b9;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #285f99;
        }
    </style>

</head>

<body>

<div class="container">

    <h1>Liên hệ</h1>

    <p class="mota">
        Vui lòng nhập đầy đủ thông tin bên dưới.
    </p>

    <?php if ($thanhcong != "") { ?>
        <div class="success">
            <?php echo $thanhcong; ?>
        </div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">

            <label>Họ tên</label>

            <input
                type="text"
                name="hoten"
                placeholder="Nhập họ tên"
                value="<?php echo htmlspecialchars($hoten); ?>"
            >

            <div class="error">
                <?php echo $loi_hoten; ?>
            </div>

        </div>


        <div class="form-group">

            <label>Email</label>

            <input
                type="text"
                name="email"
                placeholder="Nhập email"
                value="<?php echo htmlspecialchars($email); ?>"
            >

            <div class="error">
                <?php echo $loi_email; ?>
            </div>

        </div>


        <div class="form-group">

            <label>Chủ đề</label>

            <select name="chude">

                <option value="">
                    -- Chọn chủ đề --
                </option>

                <option
                    value="Hỗ trợ kỹ thuật"
                    <?php
                    if ($chude == "Hỗ trợ kỹ thuật") {
                        echo "selected";
                    }
                    ?>
                >
                    Hỗ trợ kỹ thuật
                </option>

                <option
                    value="Góp ý"
                    <?php
                    if ($chude == "Góp ý") {
                        echo "selected";
                    }
                    ?>
                >
                    Góp ý
                </option>

                <option
                    value="Khác"
                    <?php
                    if ($chude == "Khác") {
                        echo "selected";
                    }
                    ?>
                >
                    Khác
                </option>

            </select>

        </div>


        <div class="form-group">

            <label>Nội dung</label>

            <textarea
                name="noidung"
                rows="7"
                placeholder="Nhập nội dung liên hệ..."
            ><?php echo htmlspecialchars($noidung); ?></textarea>

            <div class="error">
                <?php echo $loi_noidung; ?>
            </div>

        </div>


        <div class="form-group">

            <label>Ảnh đại diện</label>

            <input
                type="file"
                name="anh"
                accept=".jpg,.jpeg,.png,.gif"
            >

            <div class="error">
                <?php echo $loi_anh; ?>
            </div>

        </div>


        <button type="submit">
            Gửi liên hệ
        </button>

    </form>

</div>

</body>

</html>