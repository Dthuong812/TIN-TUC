<?php
$serverName = "LAPTOP-93D5P4SA";
$connectionOptions = array(
    "Uid" => "sa",
    "PWD" => "123456",
    "Database" => "CSDL",
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
$sql_count = "SELECT COUNT(*) AS total FROM New";
$stmt_count = sqlsrv_query($conn, $sql_count);
if ($stmt_count === false) {
    die(print_r(sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($stmt_count, SQLSRV_FETCH_ASSOC);
$total_rows = $row['total'];
$num_page = ceil($total_rows / $number_page);
?>
<div class="sec-content">
    <form method="GET" action="?mod=page&act=search" id="searchForm" class="box-search">
        <input type="text" name="keyword" class="search" placeholder="Tìm kiếm ở đây...">
        <button type="submit" class="btn_search">Tìm kiếm</button>
    </form>
    <div id="searchResults"></div>
    <div id="postContainer">
        <div class="post">
            <div class="post__left">
                <?php 
                $left_posts = getPosts($conn, $start, 1);
                foreach ($left_posts as $item) {?>
                    <div class="post__media">
                        <img src="<?php echo $item['image_new'] ?>" alt="" class="post__img">
                        <span class="post__category">Tái chế</span>
                        <span class="post__icon"><i class="fa fa-home"></i></span>
                    </div>
                    <div class="post__author">
                        <img src="<?php echo $item['image_auther'] ?>" alt="" class="post__author-avata">
                        <span class="post__author-name"><?php echo $item['author'] ?></span>   
                    </div>
                    <h4 class="post__title">
                        <a href="?mod=page&act=detail&id=<?php echo $item['id'] ?>"><?php echo $item['title_new'] ?></a>
                    </h4>
                    <p class="post__page"><?php echo $item['describe'] ?></p>
                <?php } ?>
            </div>
            <div class="post__right">
                <?php 
                $right_posts = getPosts($conn, $start , 4);
                foreach ($right_posts as $item) {?>
                    <div class="post__item">
                        <img src="<?php echo $item['image_new']?>" alt="" class="post__img--small">
                        <div class="post__content">
                            <h6 class="post__text">
                                <a href="?mod=page&act=detail&id=<?php echo $item['id'] ?>"><?php echo $item['title_new']?></a>
                            </h6>
                            <span class="post__date">Tác giả : <?php echo $item['author']?> </span>
                            <br>
                            <br>
                            <span class="post__date"><?php 
                            if ($item['date'] instanceof DateTime) {
                                echo htmlspecialchars($item['date']->format('d/m/Y')); 
                            } ?></span>
                        </div>       
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
        echo get_pagging($num_page, $page, $base_url = "?mod=page&act=main&id=2&page")
        ?>
    </div>
</div>
<script>
document.getElementById("searchForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu mặc định

    var form = event.target;
    var keyword = form.querySelector("[name='keyword']").value;

    // Gửi yêu cầu AJAX để lấy kết quả tìm kiếm
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "?mod=page&act=search&keyword=" + encodeURIComponent(keyword), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var searchResultsDiv = document.getElementById("searchResults");
            searchResultsDiv.innerHTML = xhr.responseText;
            loadSearchResults(keyword, 1);
            window.location.href = "?mod=page&act=search&keyword=" + encodeURIComponent(keyword) + "&page=1";
            // Cập nhật các liên kết phân trang với bộ lắng nghe sự kiện cho phân trang động
            var paginationLinks = searchResultsDiv.querySelectorAll(".pagination-link");
            paginationLinks.forEach(function(link) {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    var page = this.dataset.page;
                    loadSearchResults(keyword, page);
                });
            });
        }
    };
    xhr.send();
});

function loadSearchResults(keyword, page) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "?mod=page&act=search&keyword=" + encodeURIComponent(keyword) + "&page=" + page, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var searchResultsDiv = document.getElementById("searchResults");
            searchResultsDiv.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>
