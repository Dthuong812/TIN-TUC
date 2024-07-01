<?php
require 'C:\xampp\htdocs\NCKH\NCKH\db\connect.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $category = $_POST['category'];
        $title = $_POST['title'];
        $category_img = $_POST['category_img'];

        $sql = "INSERT INTO Category (category, title, category_img) VALUES ('$category', '$title', '$category_img')";
        if ($conn->query($sql) === TRUE) {
            echo "New category added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $category = $_POST['category'];
        $title = $_POST['title'];
        $category_img = $_POST['category_img'];

        $sql = "UPDATE Category SET category='$category', title='$title', category_img='$category_img' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Category updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM Category WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Category deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch categories
$conn = sqlsrv_connect($serverName, $connectionOptions);
$sql = "SELECT * FROM Category";
$result = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý danh mục</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../static/css/manage.css"> 
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
        <h1>Quản lý danh mục</h1>
        <h2><?php echo isset($_POST['edit']) ? 'Edit' : 'Thêm mới'; ?> Danh mục</h2>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" value="<?php echo isset($_POST['category']) ? $_POST['category'] : ''; ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>">
                <label for="category_img">Image URL:</label>
                <input type="text" id="category_img" name="category_img" value="<?php echo isset($_POST['category_img']) ? $_POST['category_img'] : ''; ?>">
                <input type="submit" name="<?php echo isset($_POST['edit']) ? 'update' : 'add'; ?>" value="<?php echo isset($_POST['edit']) ? 'Update' : 'Add'; ?> Category">
            </form>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Actions</th>
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
                                <td>{$row['category']}</td>
                                <td>{$row['title']}</td>
                                <td>{$row['category_img']}</td>
                                <td>
                                    <form action='' method='POST' style='display:inline-block'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <input type='hidden' name='category' value='{$row['category']}'>
                                        <input type='hidden' name='title' value='{$row['title']}'>
                                        <input type='hidden' name='category_img' value='{$row['category_img']}'>
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
