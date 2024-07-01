<?php
$serverName = "LAPTOP-93D5P4SA";
$connectionOptions = array(
    "Uid" => "sa", 
    "PWD" => "123456", 
    "Database" => "CSDL" ,
    "CharacterSet" => "UTF-8" 
);
$conn = sqlsrv_connect($serverName, $connectionOptions);
function getPosts($conn, $start, $number_page) {
    $sql = "SELECT * FROM New ORDER BY date OFFSET $start ROWS FETCH NEXT $number_page ROWS ONLY";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $result = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$number_page = 4;
$start = ($page - 1) * $number_page;


?>
<div class="sec-content">
            <div class="event">
                <div class="layout">
                    <h1 class="event-title">Tin tức sự kiện và tuyển tình nguyện viên</h1>
                <div class="achievement">
                        <div class="ac-item1">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" class="img-ac">
                            <div class="ac-content">
                                <a href="">
                                    <p class="ac-desc">Chủ nhật xanh cùng Team cộng đồng</p>
                                </a>
                            </div>
                        </div>
                        <div class="ac-item2">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" class="img-ac">
                            <div class="ac-content">
                                <a href="">
                                    <p class="ac-desc">Đổi pin lấy cây xanh bảo vệ môi trường tháng 4</p>
                                </a>
                            </div>
                        </div>
                        <div class="ac-item3">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" class="img-ac">
                            <div class="ac-content">
                            <div class="">
                                <a href="">
                                    <p class="ac-desc">Đổi chai nhựa lấy cây xanh tháng 4</p>
                                </a>
                            </div>
                            </div>
                        </div>
                        <div class="ac-item4">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" class="img-ac">
                            <div class="ac-content">
                                <a href="">
                                    <p class="ac-desc">Tuyển tình nguyện viên truyền thông cho page </p>
                                </a>
                            </div>
                        </div>
                        <div class="ac-item5">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" class="img-ac">
                            <div class="ac-content">
                            <a href=""> 
                                <p class="ac-desc">Ngày trái đất tiết kiện năng lượng điện</p></a>
                            </div>
                        </div>
                        <div class="ac-item6">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" class="img-ac">
                            <div class="ac-content">
                                <a href="">
                                    <p class="ac-desc">Tham gia cuộc thi hành động vẽ tranh về bảo vệ môi trường tổ chuawsc ở Hồ Hoàn Kiếm</p>
                                </a>
                            </div>
                        </div>
                </div>
                </div>
                <?php
                    $sql_count = "SELECT COUNT(*) AS total FROM New";
                    $stmt_count = sqlsrv_query($conn, $sql_count);
                    if ($stmt_count === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }
                    $row = sqlsrv_fetch_array($stmt_count, SQLSRV_FETCH_ASSOC);
                    $total_rows = $row['total'];
                    $num_page = ceil($total_rows / $number_page);
                    echo get_pagging($num_page, $page, $base_url = "?mod=page&act=main&id=4&page")
                    ?>
                </div>
            </div>
          </div>