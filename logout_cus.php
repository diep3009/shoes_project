<?php
    // Xóa tất cả các biến session
    session_start();
    session_unset();
    session_destroy();

    // Chuyển hướng đến trang đăng nhập
    header("Location: ../../views/customer/login_customer.php");
exit();
?>