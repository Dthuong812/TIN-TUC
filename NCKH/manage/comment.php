<?php
require 'C:\xampp\htdocs\NCKH\NCKH\db\connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kết nối tới CSDL
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (isset($_POST['add'])) {
        // Xử lý thêm bình luận
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $date_comment = isset($_POST['date_comment']) ? $_POST['date_comment'] : '';
        $id_user = isset($_POST['id_user']) ? $_POST['id_user'] : '';
        $id_article = isset($_POST['id_article']) ? $_POST['id_article'] : '';


        // Chuyển đổi timestamp thành định dạng datetime của SQL Server
        $timestamp = strtotime($date_comment);
        $sql_date = date('Y-m-d H:i:s', $timestamp);

        // Kiểm tra xem id_user có tồn tại trong bảng Users không
        $sql = "SELECT COUNT(*) AS count FROM Users WHERE id = ?";
        $params = array($id_user);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            echo "<div class='alert error'>Lỗi khi kiểm tra người dùng: ";
            foreach (sqlsrv_errors() as $error) {
                echo $error['message'] . "<br/>";
            }
            echo "</div>";
        } else {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if ($row['count'] == 0) {
                echo "<div class='alert error'>ID Người Dùng không tồn tại. Vui lòng kiểm tra lại.</div>";
            } else {
                // Chuẩn bị câu truy vấn với các tham số
                $sql = "INSERT INTO Comment (content, date_comment, id_user, id_article) VALUES (?, ?, ?, ?)";
                $params = array($content, $sql_date, $id_user, $id_article);

                // Thực hiện truy vấn với sqlsrv_query
                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    echo "<div class='alert error'>Lỗi khi thực hiện truy vấn: ";
                    foreach (sqlsrv_errors() as $error) {
                        echo $error['message'] . "<br/>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='alert success'>Đã thêm bình luận thành công.</div>";
                }
            }
        }
    } elseif (isset($_POST['update'])) {
        // Xử lý cập nhật bình luận
        $id = $_POST['id'];
        $content = htmlspecialchars($_POST['content']);
        $date_comment = $_POST['date_comment'];
        $id_user = $_POST['id_user'];
        $id_article = $_POST['id_article'];

        // Chuyển đổi timestamp thành định dạng datetime của SQL Server
        $timestamp = strtotime($date_comment);
        $sql_date = date('Y-m-d H:i:s', $timestamp);

        $sql = "UPDATE Comment SET content = ?, date_comment = ?, id_user = ?, id_article = ? WHERE id = ?";
        $params = array($content, $sql_date, $id_user, $id_article, $id);

        // Thực hiện truy vấn với sqlsrv_query
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            echo "<div class='alert error'>Lỗi khi thực hiện cập nhật: ";
            foreach (sqlsrv_errors() as $error) {
                echo $error['message'] . "<br/>";
            }
            echo "</div>";
        } else {
            echo "<div class='alert success'>Đã cập nhật bình luận thành công.</div>";
        }
    } elseif (isset($_POST['delete'])) {
        // Xử lý xóa bình luận
        $id = $_POST['id'];

        $sql = "DELETE FROM Comment WHERE id = ?";
        $params = array($id);

        // Thực hiện truy vấn với sqlsrv_query
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            echo "<div class='alert error'>Lỗi khi thực hiện xóa: ";
            foreach (sqlsrv_errors() as $error) {
                echo $error['message'] . "<br/>";
            }
            echo "</div>";
        } else {
            echo "<div class='alert success'>Đã xóa bình luận thành công.</div>";
        }
    }

    // Đóng kết nối
    sqlsrv_close($conn);
}


// Lấy dữ liệu từ bảng Comment
$conn = sqlsrv_connect($serverName, $connectionOptions);
$sql = "SELECT * FROM Comment";
$result = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Bình Luận</title>
    <link rel="stylesheet" href="../static/css/manage.css"> <!-- Thêm đường dẫn đến file CSS nếu có -->
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
        <h1>Quản Lý Bình Luận</h1>
        <h2><?php echo isset($_POST['edit']) ? 'Sửa' : 'Thêm Mới'; ?> Bình Luận</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>">
            <label for="content">Nội Dung:</label>
            <textarea id="content" name="content"><?php echo isset($_POST['content']) ? $_POST['content'] : ''; ?></textarea>
            <label for="date_comment">Ngày Bình Luận:</label>
            <input type="datetime-local" id="date_comment" name="date_comment" value="<?php echo isset($_POST['date_comment']) ? $_POST['date_comment'] : ''; ?>">
            <label for="id_user">ID Người Dùng:</label>
            <input type="number" id="id_user" name="id_user" value="<?php echo isset($_POST['id_user']) ? $_POST['id_user'] : ''; ?>">
            <label for="id_article">ID Tin Nhanh:</label>
            <input type="number" id="id_article" name="id_article" value="<?php echo isset($_POST['id_article']) ? $_POST['id_article'] : ''; ?>">
            <input type="submit" name="<?php echo isset($_POST['edit']) ? 'update' : 'add'; ?>" value="<?php echo isset($_POST['edit']) ? 'Cập Nhật' : 'Thêm'; ?> Bình Luận">
        </form>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nội Dung</th>
                <th>Ngày Bình Luận</th>
                <th>ID Người Dùng</th>
                <th>ID Tin Nhanh</th>
                <th>Thao Tác</th>
            </tr>
            <?php
        if ($result === false) {
            // Xử lý lỗi khi truy vấn thất bại
            echo "Lỗi: " . print_r(sqlsrv_errors(), true);
        } else {
            // Xử lý dữ liệu khi truy vấn thành công
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $date_comment = isset($row['date_comment']) ? $row['date_comment']->format('Y-m-d H:i:s') : '';
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['content']}</td>
                            <td>{$row['date_comment']}</td>
                            <td>{$row['id_user']}</td>
                            <td>{$row['id_article']}</td>
                            <td>
                                <form action='' method='POST' style='display:inline-block'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='hidden' name='content' value='{$row['content']}'>
                                    <input type='hidden' name='date_comment' value='{$row['date_comment']}'>
                                    <input type='hidden' name='id_user' value='{$row['id_user']}'>
                                    <input type='hidden' name='id_article' value='{$row['id_article']}'>
                                    <input type='submit' name='edit' value='Sửa'>
                                </form>
                                <form action='' method='POST' style='display:inline-block'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='submit' name='delete' value='Xóa'>
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
