<?php
require 'C:\xampp\htdocs\NCKH\NCKH\db\connect.php';
// Xử lý biểu mẫu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $id_new = $_POST['id_new'];
        $id_user = $_POST['id_user'];
        $date_favorite = $_POST['date_favorite'];

        $sql = "INSERT INTO Favorite (id_new, id_user, date_favorite) VALUES ('$id_new', '$id_user', '$date_favorite')";
        if ($conn->query($sql) === TRUE) {
            echo "Đã thêm yêu thích mới.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $id_new = $_POST['id_new'];
        $id_user = $_POST['id_user'];
        $date_favorite = $_POST['date_favorite'];

        $sql = "UPDATE Favorite SET id_new='$id_new', id_user='$id_user', date_favorite='$date_favorite' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Đã cập nhật yêu thích.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM Favorite WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Đã xóa yêu thích.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Lấy dữ liệu từ bảng Favorite
$conn = sqlsrv_connect($serverName, $connectionOptions);
$sql = "SELECT * FROM Favorite";
$result = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Yêu Thích</title>
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
        <h1>Quản Lý Yêu Thích</h1>
        <h2><?php echo isset($_POST['edit']) ? 'Sửa' : 'Thêm Mới'; ?> Yêu Thích</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>">
            <label for="id_new">ID Tin Nhanh:</label>
            <input type="number" id="id_new" name="id_new" value="<?php echo isset($_POST['id_new']) ? $_POST['id_new'] : ''; ?>">
            <label for="id_user">ID Người Dùng:</label>
            <input type="number" id="id_user" name="id_user" value="<?php echo isset($_POST['id_user']) ? $_POST['id_user'] : ''; ?>">
            <label for="date_favorite">Ngày Yêu Thích:</label>
            <input type="datetime-local" id="date_favorite" name="date_favorite" value="<?php echo isset($_POST['date_favorite']) ? $_POST['date_favorite'] : ''; ?>">
            <input type="submit" name="<?php echo isset($_POST['edit']) ? 'update' : 'add'; ?>" value="<?php echo isset($_POST['edit']) ? 'Cập Nhật' : 'Thêm'; ?> Yêu Thích">
        </form>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>ID Tin Nhanh</th>
                <th>ID Người Dùng</th>
                <th>Ngày Yêu Thích</th>
                <th>Thao Tác</th>
            </tr>
            <?php
            if ($result === false) {
                // Xử lý lỗi khi truy vấn thất bại
                echo "Lỗi: " . print_r(sqlsrv_errors(), true);
            } else {
                // Xử lý dữ liệu khi truy vấn thành công
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['id_new']}</td>
                            <td>{$row['id_user']}</td>
                            <td>{$row['date_favorite']}</td>
                            <td>
                                <form action='' method='POST' style='display:inline-block'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='hidden' name='id_new' value='{$row['id_new']}'>
                                    <input type='hidden' name='id_user' value='{$row['id_user']}'>
                                    <input type='hidden' name='date_favorite' value='{$row['date_favorite']}'>
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
    </div>


   

    <!-- Biểu mẫu thêm hoặc sửa yêu thích -->
    
</body>
</html>
