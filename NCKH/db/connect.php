<?php
// Thiết lập thông tin kết nối
$serverName = "LAPTOP-93D5P4SA";
$connectionOptions = array(
    "Uid" => "sa", // Tên đăng nhập
    "PWD" => "123456", // Mật khẩu
    "Database" => "CSDL" ,// Tên cơ sở dữ liệu
    "CharacterSet" => "UTF-8" // Thiết lập mã hóa ký tự
);

// Kết nối đến SQL Server
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Kiểm tra kết nối
if ($conn === false) {
    // Nếu kết nối không thành công, in ra thông tin lỗi
    die(print_r(sqlsrv_errors(), true));
} else {
    // Nếu kết nối thành công, in ra thông báo thành công
    // echo "Kết nối thành công.<br>";
}

// Đóng kết nối
sqlsrv_close($conn);
?>
