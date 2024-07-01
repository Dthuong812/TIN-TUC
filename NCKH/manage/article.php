<?php
require 'C:\xampp\htdocs\NCKH\NCKH\db\connect.php';

// Xử lý biểu mẫu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $title_article = $_POST['title_article'];
        $image_article = $_POST['image_article'];
        $content = $_POST['content'];
        $date_article = $_POST['date_article'];
        $date_new = $_POST['date_new'];
        $author_article = $_POST['author_article'];
        $id_cate = $_POST['id_cate'];

        $sql = "INSERT INTO Article (title_article, image_article, content, date_article, date_new, author_article, id_cate) VALUES ('$title_article', '$image_article', '$content', '$date_article', '$date_new', '$author_article', '$id_cate')";
        if ($conn->query($sql) === TRUE) {
            echo "Đã thêm bài viết mới.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title_article = $_POST['title_article'];
        $image_article = $_POST['image_article'];
        $content = $_POST['content'];
        $date_article = $_POST['date_article'];
        $date_new = $_POST['date_new'];
        $author_article = $_POST['author_article'];
        $id_cate = $_POST['id_cate'];

        $sql = "UPDATE Article SET title_article='$title_article', image_article='$image_article', content='$content', date_article='$date_article', date_new='$date_new', author_article='$author_article', id_cate='$id_cate' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Đã cập nhật bài viết.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM Article WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Đã xóa bài viết.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Lấy dữ liệu từ bảng Article
$conn = sqlsrv_connect($serverName, $connectionOptions);
$sql = "SELECT * FROM Article";
$result = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Bài Viết</title>
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
        <h1>Quản Lý Bài Viết</h1>
        <h2><?php echo isset($_POST['edit']) ? 'Sửa' : 'Thêm Mới'; ?> Bài Viết</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>">
            <label for="title_article">Tiêu Đề:</label>
            <input type="text" id="title_article" name="title_article" value="<?php echo isset($_POST['title_article']) ? $_POST['title_article'] : ''; ?>">
            <label for="image_article">URL Hình Ảnh:</label>
            <input type="text" id="image_article" name="image_article" value="<?php echo isset($_POST['image_article']) ? $_POST['image_article'] : ''; ?>">
            <label for="content">Nội Dung:</label>
            <textarea id="content" name="content"><?php echo isset($_POST['content']) ? $_POST['content'] : ''; ?></textarea>
            <label for="date_article">Ngày Bài Viết:</label>
            <input type="datetime-local" id="date_article" name="date_article" value="<?php echo isset($_POST['date_article']) ? $_POST['date_article'] : ''; ?>">
            <label for="date_new">Ngày Tin Nhanh:</label>
            <input type="datetime-local" id="date_new" name="date_new" value="<?php echo isset($_POST['date_new']) ? $_POST['date_new'] : ''; ?>">
            <label for="author_article">Tác Giả:</label>
            <input type="text" id="author_article" name="author_article" value="<?php echo isset($_POST['author_article']) ? $_POST['author_article'] : ''; ?>">
            <label for="id_cate">ID Danh Mục:</label>
            <input type="number" id="id_cate" name="id_cate" value="<?php echo isset($_POST['id_cate']) ? $_POST['id_cate'] : ''; ?>">
            <input type="submit" name="<?php echo isset($_POST['edit']) ? 'update' : 'add'; ?>" value="<?php echo isset($_POST['edit']) ? 'Cập Nhật' : 'Thêm'; ?> Bài Viết">
        </form>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Hình Ảnh</th>
                <th>Nội Dung</th>
                <th>Ngày Bài Viết</th>
                <th>Ngày Tin Nhanh</th>
                <th>Tác Giả</th>
                <th>ID Danh Mục</th>
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
                            <td>{$row['title_article']}</td>
                            <td><img src='{$row['image_article']}' alt='image' style='width:100px;'></td>
                            <td>{$row['content']}</td>
                            <td>{$row['date_article']}</td>
                            <td>{$row['date_new']}</td>
                            <td>{$row['author_article']}</td>
                            <td>{$row['id_cate']}</td>
                            <td>
                                <form action='' method='POST' style='display:inline-block'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='hidden' name='title_article' value='{$row['title_article']}'>
                                    <input type='hidden' name='image_article' value='{$row['image_article']}'>
                                    <input type='hidden' name='content' value='{$row['content']}'>
                                    <input type='hidden' name='date_article' value='{$row['date_article']}'>
                                    <input type='hidden' name='date_new' value='{$row['date_new']}'>
                                    <input type='hidden' name='author_article' value='{$row['author_article']}'>
                                    <input type='hidden' name='id_cate' value='{$row['id_cate']}'>
                                    <button type='submit' name='edit' class='icon-button'>
                                    <i class='fas fa-edit'></i> 
                                    </button>
                                </form>
                                <form action='' method='POST' style='display:inline-block'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    class='icon-button'>
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
