<?php
require 'C:\xampp\htdocs\NCKH\NCKH\db\connect.php';

// Xử lý biểu mẫu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $title_new = $_POST['title_new'];
        $image_new = $_POST['image_new'];
        $describe = $_POST['describe'];
        $author = $_POST['author'];
        $image_author = $_POST['image_author'];
        $date = $_POST['date'];
    
        // Chuyển đổi ngày tháng từ chuỗi thành timestamp
        $timestamp = strtotime($date);
        
        // Chuyển đổi timestamp thành định dạng datetime của SQL Server
        $sql_date = date('Y-m-d H:i:s', $timestamp);
    
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    
        // Sử dụng dấu '?' để đại diện cho các tham số và truyền các giá trị tương ứng vào mảng tham số
        $sql = "INSERT INTO New (title_new, image_new, describe, author, image_author, date) VALUES (?, ?, ?, ?, ?, ?)";
        $params = array($title_new, $image_new, $describe, $author, $image_author, $sql_date);
    
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            echo "Lỗi khi thực hiện truy vấn: ";
            foreach(sqlsrv_errors() as $error) {
                echo $error['message'] . "<br/>";
            }
        } else {
            //echo "Đã thêm tin mới.";
        }
    }
    
     elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title_new = $_POST['title_new'];
        $image_new = $_POST['image_new'];
        $describe = $_POST['describe'];
        $author = $_POST['author'];
        $image_author = $_POST['image_author'];
        $date = $_POST['date'];

        $timestamp = strtotime($date);

        $sql_date = date('Y-m-d H:i:s', $timestamp);
    
        // Kết nối CSDL
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    
        // Sử dụng tham số truy vấn để tránh lỗ hổng bảo mật SQL injection
        $sql = "UPDATE New SET title_new=?, image_new=?, describe=?, author=?, image_author=?, date=? WHERE id=?";
        $params = array($title_new, $image_new, $describe, $author, $image_author, $sql_date, $id);
    
        // Thực hiện truy vấn
        $stmt = sqlsrv_query($conn, $sql, $params);
    
        // Kiểm tra kết quả
        if ($stmt === false) {
            echo "Lỗi khi thực hiện truy vấn: ";
            foreach(sqlsrv_errors() as $error) {
                echo $error['message'] . "<br/>";
            }
        } else {
            //echo "Đã cập nhật tin.";
        }
    }
    
     elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $sql = "DELETE FROM New WHERE id=$id";
        $result = sqlsrv_query($conn, $sql);
        if ($result === false) {
            echo "Lỗi: " . $sql . "<br>" .  sqlsrv_errors();
        } else {
            //echo "Đã xóa tin.";  
        }
    }
}

// Lấy dữ liệu từ bảng New
$conn = sqlsrv_connect($serverName, $connectionOptions);
$sql = "SELECT * FROM New";
$result = sqlsrv_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Tin Nhanh</title>
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
        <h1>Quản Lý Tin Nhanh</h1>
            <h2><?php echo isset($_POST['edit']) ? 'Sửa' : 'Thêm Mới'; ?> Tin Nhanh</h2>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>">
                <label for="title_new">Tiêu Đề:</label>
                <input type="text" id="title_new" name="title_new" value="<?php echo isset($_POST['title_new']) ? $_POST['title_new'] : ''; ?>">
                <label for="image_new">URL Hình Ảnh:</label>
                <input type="text" id="image_new" name="image_new" value="<?php echo isset($_POST['image_new']) ? $_POST['image_new'] : ''; ?>">
                <label for="describe">Mô Tả:</label>
                <textarea id="describe" name="describe"><?php echo isset($_POST['describe']) ? $_POST['describe'] : ''; ?></textarea>
                <label for="author">Tác Giả:</label>
                <input type="text" id="author" name="author" value="<?php echo isset($_POST['author']) ? $_POST['author'] : ''; ?>">
                <label for="image_author">URL Ảnh Tác Giả:</label>
                <input type="text" id="image_author" name="image_author" value="<?php echo isset($_POST['image_author']) ? $_POST['image_author'] : ''; ?>">
                <label for="date">Ngày:</label>
                <input type="datetime-local" id="date" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
                <input type="submit" name="<?php echo isset($_POST['edit']) ? 'update' : 'add'; ?>" value="<?php echo isset($_POST['edit']) ? 'Cập Nhật' : 'Thêm'; ?> Tin Nhanh">
            </form>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Tiêu Đề</th>
                    <th>Hình Ảnh</th>
                    <th>Mô Tả</th>
                    <th>Tác Giả</th>
                    <th>Ảnh Tác Giả</th>
                    <th>Ngày</th>
                    <th>Thao Tác</th>
                </tr>
                <?php
                if ($result === false) {
                    // Xử lý lỗi khi truy vấn thất bại
                    echo "Lỗi: " . print_r(sqlsrv_errors(), true);
                } else {
                    // Xử lý dữ liệu khi truy vấn thành công
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $date = isset($row['date']) ? $row['date']->format('Y-m-d H:i:s') : ''; 
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['title_new']}</td>
                            <td><img src='{$row['image_new']}' alt='image' style='width:100px;'></td>
                            <td>{$row['describe']}</td>
                            <td>{$row['author']}</td>
                            <td><img src='{$row['image_author']}' alt='image' style='width:100px;'></td>
                            <td>{$date}</td>
                            <td>
                                <form action='' method='POST' style='display:inline-block'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='hidden' name='title_new' value='{$row['title_new']}'>
                                    <input type='hidden' name='image_new' value='{$row['image_new']}'>
                                    <input type='hidden' name='describe' value='{$row['describe']}'>
                                    <input type='hidden' name='author' value='{$row['author']}'>
                                    <input type='hidden' name='image_author' value='{$row['image_author']}'>
                                    <input type='hidden' name='date' value='{$date}'>
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
    
    
</body>
</html>
