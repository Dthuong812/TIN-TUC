<?php
ob_start();//chạy trươc khi gọi câu lệnh chuyển hướng
session_start();//tạo SesSION
$error = array();

if (isset($_POST['btn_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $error['username'] = 'Vui lòng nhập tên đăng nhập';
    }

    if (empty($password)) {
        $error['password'] = 'Vui lòng nhập mật khẩu';
    }

    if (empty($error)) {
        $list_user = array(
            1 => array(
                'id' =>'1',
                'username' => 'admin',
                'password' => md5('bonie@123'),
            ),
        );

        $is_authenticated = false;

        foreach ($list_user as $user) {
            if ($username == $user['username'] && md5($password) == $user['password']) {
                $is_authenticated = true;
                $_SESSION['is_login'] = true;
                $_SESSION['user_login'] = $username;
                header("Location: ./manage/category.php");
                exit(); 
            }
        }

        if (!$is_authenticated) {
            $error['account'] = 'Thông tin đăng nhập không chính xác';
        }
    }
}
?>
<?php
// session_start();
ob_start();
#dâtbase
require 'db/connect.php';
#thư viện hàm
require "lib/page.php";
require 'lib/data.php';
require 'lib/url.php';
require 'lib/template.php';
require 'lib/pagging.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./static/css/admin.css">
</head>

<body>
    <div class="login">
        <h1>Đăng nhập</h1>
        <form action="" method="POST">
            <label for="username">Tên đăng nhập</label>
            <input type="text" name="username" value="<?php if (!empty($username)) echo $username ?>">
            <p class="error"><?php if (!empty(($error['username']))) echo $error['username'] ?></p>
            <label for="password">Password</label>
            <input type="password" name="password" value="">
            <p class="error"><?php if (!empty($error['password'])) echo $error['password'] ?></p>
            <p class="error"><?php if (!empty(($error['account']))) echo $error['account'] ?></p>
            <input type="submit" name="btn_login" value="Đăng nhập">
        </form>
    </div>
</body>

</html>