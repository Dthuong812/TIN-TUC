<?php
require 'C:\xampp\htdocs\NCKH\NCKH\db\connect.php';

// Xử lý biểu mẫu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (isset($_POST['add'])) {
        // Add new user
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Users (username, email,pass_word) VALUES (?,  ?, ?)";
        $params = array($username,  $email,$hashed_password, $role);

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            echo "Lỗi khi thực hiện truy vấn: ";
            foreach (sqlsrv_errors() as $error) {
                echo $error['message'] . "<br/>";
            }
        }
    } elseif (isset($_POST['update'])) {
        // Update existing user
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $params = array($username, $email, $id);

        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE Users SET username=?, email=?, password=? WHERE id=?";
            array_splice($params, 1, 0, $hashed_password);
        } else {
            $sql = "UPDATE Users SET username=?, email=? WHERE id=?";
        }

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            echo "Error executing query: ";
            foreach (sqlsrv_errors() as $error) {
                echo $error['message'] . "<br/>";
            }
        }
    } elseif (isset($_POST['delete'])) {
        // Delete user
        $id = $_POST['id'];
        $sql = "DELETE FROM Users WHERE id=?";
        $params = array($id);

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            echo "Lỗi: " . print_r(sqlsrv_errors(), true);
        }
    }
}

// Lấy dữ liệu từ bảng Users
$conn = sqlsrv_connect($serverName, $connectionOptions);
$sql = "SELECT * FROM Users";
$result = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../static/css/manage.css"> 
</head>
<body>
<div class="container">
    <div class="nav">
        <h1>Admin BONNIE</h1>
        <ul>
                <li><a href="./category.php">Quản lý danh mục</a></li>
                <li><a href="./new.php">Quản lý tin nhanh</a></li>
                <li><a href="./article.php">Quản lý bài viết</a></li>
                <li><a href="./user.php">Quản lý người dùng</a></li>
                <li><a href="./comment.php">Quản lý bình luận</a></li>
                <li><a href="./favorite.php">Bài viết yêu thích</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Quản Lý Người Dùng</h1>
        <h2><?php echo isset($_POST['edit']) ? 'Sửa' : 'Thêm Mới'; ?> Người Dùng</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>">
            <label for="username">Tên Đăng Nhập:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
            <label for="password">Mật Khẩu:</label>
            <input type="password" id="password" name="password" <?php echo isset($_POST['edit']) ? '' : 'required'; ?>>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
            <input type="submit" name="<?php echo isset($_POST['edit']) ? 'update' : 'add'; ?>" value="<?php echo isset($_POST['edit']) ? 'Cập Nhật' : 'Thêm'; ?> Người Dùng">
        </form>
        <!-- Hiển thị danh sách người dùng -->
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Tên Đăng Nhập</th>
                <th>Email</th>
                <th>Thao Tác</th>
            </tr>
            <?php
            if ($result === false) {
                echo "Lỗi: " . print_r(sqlsrv_errors(), true);
            } else {
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>
                            <form action='' method='POST' style='display:inline-block'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='hidden' name='username' value='{$row['username']}'>
                                <input type='hidden' name='email' value='{$row['email']}'>
                                <button type='submit' name='edit' class='icon-button'>
                                <i class='fas fa-edit'></i> 
                                </button>
                            </form>
                            <form action='' method='POST' style='display:inline-block'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' name='delete' class='icon-button'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                            </form>
                        </td>
                    </tr>";
                }
            }
            ?>
        </table>
    </div>
</body>
</html>
