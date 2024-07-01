<?php
get_header();
?>
<?php
get_menu('user');
?>
<div class="sec-content">
    <form method="GET" action="?mod=page&act=search" id="searchForm" class="box-search">
        <input type="text" name="keyword" id="keyword" class="search" placeholder="Tìm kiếm ở đây...">
        <button type="submit" class="btn_search">Tìm kiếm</button>
    </form>
    <div id="searchResults"></div>
    <?php
    // Kết nối đến cơ sở dữ liệu
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    // Xử lý dữ liệu tìm kiếm
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];

        // Thực thi stored procedure để tìm kiếm
        $sql = "{CALL SearchNews (?)}";
        $stmt = sqlsrv_prepare($conn, $sql, array(&$keyword));
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            if (sqlsrv_execute($stmt) === false) {
                die(print_r(sqlsrv_errors(), true));
            } else {
                $result = array();
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $result[] = $row;
                }

                // Phân trang cho kết quả tìm kiếm
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Sử dụng tham số 'page' để xác định trang hiện tại
                $numberPerPage = 5;
                $start = ($page - 1) * $numberPerPage;
                $totalRows = count($result);
                $numPages = ceil($totalRows / $numberPerPage);
                $resultPage = array_slice($result, $start, $numberPerPage);
                ?>

                <?php
                // Hiển thị kết quả tìm kiếm cho trang hiện tại
                foreach ($resultPage as $item) {?>
                    <div class="item-search">
                        <div class="post__item">
                            <img src="<?php echo $item['image_new']?>" alt="" class="post__img--small">
                            <div class="post__content">
                                <h6 class="post__text">
                                    <a href="?mod=page&act=detail&id=<?php echo $item['id'] ?>"><?php echo $item['title_new']?></a>
                                </h6>
                                <span class="post__date">Tác giả : <?php echo $item['author']?> 
                                </span>
                                <br>
                                <br>
                                <span class="post__date"><?php 
                                    if ($item['date'] instanceof DateTime) {
                                        echo htmlspecialchars($item['date']->format('d/m/Y')); 
                                    }
                                ?></span>
                            </div>    
                        </div>
                    </div>
                <?php
                }
                // Hiển thị các liên kết phân trang
                echo get_pagging($numPages, $page, "?mod=page&act=search&keyword=" . urlencode($_GET['keyword']) . "&page");
            }
        }

        // Đóng kết nối
        sqlsrv_close($conn);
    }
    ?>
</div>
<script>
document.getElementById("searchForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu mặc định

    var keyword = document.getElementById("keyword").value;

    // Kiểm tra xem từ khóa có trống không trước khi gửi yêu cầu AJAX
    if (keyword.trim() === '') {
        alert("Vui lòng nhập từ khóa tìm kiếm.");
        return;
    }

    // Chuyển hướng đến trang kết quả tìm kiếm
    window.location.href = "?mod=page&act=search&keyword=" + encodeURIComponent(keyword) + "&page=1";
});
</script>
<?php
get_footer();
?>
