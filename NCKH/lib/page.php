<?php
/**
 * Trả về mảng thông tin trang tương ứng
 */
function get_page_by_id($id) {
    // Sử dụng file kết nối cơ sở dữ liệu
    global $conn;

    // Truy vấn dữ liệu trang theo ID
    $query = "SELECT * FROM Category WHERE id = ?";
    
    // Chuẩn bị truy vấn sử dụng mysqli
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Gán tham số ID vào truy vấn
    $stmt->bind_param('i', $id);
    
    // Thực hiện truy vấn
    $stmt->execute();
    
    // Lấy kết quả truy vấn
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Trả về mảng thông tin trang nếu tìm thấy
        return $result->fetch_assoc();
    } else {
        // Trả về FALSE nếu không tìm thấy trang
        return FALSE;
    }

    // Đóng tài nguyên
    $stmt->close();
}

?>