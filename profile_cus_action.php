<?php
session_start();

if (isset($_SESSION["HoTen"]) && isset($_SESSION["CusID"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy thông tin từ biểu mẫu
        $idCus = $_POST["cusid"];
        $hoTen = $_POST["hoten"];
        $email = $_POST["email"];
        $soDienThoai = $_POST["sodienthoai"];
        $diaChi = $_POST["diachi"];
        $anhcus = $_FILES["anhcus"]["name"];

        // Kiểm tra tệp tải lên
        if (isset($_FILES["anhcus"]) && $_FILES["anhcus"]["error"] == UPLOAD_ERR_OK) {
            //$targetDir = "./image/customer/".$;
            $targetFile = "../../../public/image/customer/". $anhcus;
            // Di chuyển tệp tải lên vào thư mục đích
            if (move_uploaded_file($_FILES["anhcus"]["tmp_name"], $targetFile)) {
                // Lưu tên tệp vào cơ sở dữ liệu hoặc xử lý theo yêu cầu của bạn
                // Ví dụ: cập nhật tên tệp vào cơ sở dữ liệu khách hàng
                require_once('../../controllers/connect.php');

                $update_sql = "UPDATE khachhang SET HoTen = '$hoTen', Email = '$email', SoDienThoai = '$soDienThoai', DiaChi = '$diaChi', AnhCus = '$anhcus' WHERE CusID = $idCus";
                $result = mysqli_query($conn, $update_sql);

                if ($result) {
                    $_SESSION["update_success"] = true;
                } else {
                    $_SESSION["update_error"] = mysqli_error($conn);
                }
            } else {
                $_SESSION["update_error"] = "Đã xảy ra lỗi khi tải lên ảnh.";
            }
        } else {
            // Không có tệp tải lên, chỉ cập nhật thông tin cá nhân
            require_once('../../controllers/connect.php');

            $update_sql = "UPDATE khachhang SET HoTen = '$hoTen', Email = '$email', SoDienThoai = '$soDienThoai', DiaChi = '$diaChi' WHERE CusID = $idCus";
            $result = mysqli_query($conn, $update_sql);

            if ($result) {
                $_SESSION["update_success"] = true;
            } else {
                $_SESSION["update_error"] = mysqli_error($conn);
            }
        }
    }
    
    header("Location: http://localhost/shoes_Project/app/views/customer/profile_cus.php");
    exit();
}
?>
