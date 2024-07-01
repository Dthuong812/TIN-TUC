<?php
// Kiểm tra xem đã có dữ liệu trong localStorage hay chưa
$userData = isset($_COOKIE['userData']) ? json_decode($_COOKIE['userData'], true) : array('user' => '', 'email' => '');
?>
<?php
get_header();
?>
<?php
get_menu('user');
?>
    <section class="home-sec" id="home">
        <div class="container">
            <div class="home-content">
                <div class="row">
                    <div class="col-lg-8 align-item-center">
                        <div class="home-info">
                        </div>
                        <div id="mapCanvas"></div>
                    </div>
                    <div class="col-lg-4 order-first order-lg-last">
                        <h2>Địa điểm trao đổi áo quần và rác nhựa</h2>
                        <p>"Vì tương lai, hãy bảo vệ môi trường từ hôm nay"</p>
                        <div class="img-sec">
                            <img src="./static/img/artboard-4-1@2x.png" alt="home-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="don-sec" id="donation">
        <div class="container">
            <div class="heading">
                <h2>Hãy tham gia cùng chúng tôi để chung tay vì môi trường...</h2>
            </div>
            <div class="row">
                <?php 
                $conn = sqlsrv_connect($serverName, $connectionOptions);
                $sql = "SELECT * FROM Category";
                $stmt = sqlsrv_query($conn, $sql);
                if ($stmt === false) {
                    // Nếu truy vấn không thành công, in ra thông tin lỗi
                    die(print_r(sqlsrv_errors(), true));
                } else {
                    // Tạo một mảng để lưu trữ kết quả
                    $result = array();
                    
                    // Lấy tất cả các bản ghi
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $result[] = $row;
                    }
                
                    // Duyệt qua các bản ghi và hiển thị thông tin
                    foreach ($result as $item) {?>
                    <div class="col-lg-4">
                        <div class="don-box">
                        <img src="<?php echo $item['category_img'] ?>" alt="img">
                        <h3><?php echo $item['category'] ?></h3>
                        <p><?php echo $item['title'] ?></p>
                        <a href="?mod=page&act=main&id=<?php echo $item['id'] ?>" class="btn1">Xem</a>
                        </div>
                    </div>
                   <?php }
                }
                ?>
            </div>
        </div>
    </section>

    <section class="about-sec" id="about">
        <div class="container">
            <div class="heading">
                <h2>Sứ mệnh của chúng tôi</h2>
                <p>Chúng tôi thu nhận <span>chai nhựa</span> và <span>giấy báo</span> và <span>áo quần còn sử dụng được </span>để kiến tạo cho tương lai.</p>
            </div>
            <div class="gallery-sec">
                <div class="container">
                    <div class="image-container">
                        <div class="image"><img src="./static/img/miss/1.jpg" alt="img"></div>
                        <div class="image"><img src="./static/img/miss/2.jpg" alt="img"></div>
                        <div class="image"><img src="./static/img/miss/3.jpg" alt="img"></div>
                        <div class="image"><img src="./static/img/miss/7.jpg" alt="img"></div>
                        <div class="image"><img src="./static/img/miss/4.jpg" alt="img"></div>
                        <div class="image"><img src="./static/img/miss/1.png" alt="img"></div>
                    </div>
                </div>
                <div class="pop-image">
                    <span>&times;</span>
                    <img src="./static/img/gallery/1.jpg" alt="gallery-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <?php
    // Kiểm tra kết nối và xác nhận tồn tại của biến $conn
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    // Kiểm tra xem trang đã được gửi dữ liệu POST chưa
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ form
        $user = $_POST['user'];
        $email = $_POST['email'];

        // Thực hiện truy vấn kiểm tra xem email đã tồn tại hay không
        $sql_check_email = "SELECT * FROM Users WHERE email = ?";
        $params = array($email);
        $stmt_check_email = sqlsrv_query($conn, $sql_check_email, $params);

        // Kiểm tra xem truy vấn đã được thực hiện thành công hay không
        if ($stmt_check_email === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Kiểm tra xem có kết quả từ truy vấn không
        if (sqlsrv_has_rows($stmt_check_email)) {
            $message = "Email đã tồn tại. Vui lòng nhập email khác.";
        } else {
            // Thực hiện truy vấn để thêm người dùng mới
            $sql_insert_user = "INSERT INTO Users (username, email) VALUES (?, ?)";
            $params_insert = array($user, $email);
            $stmt_insert_user = sqlsrv_query($conn, $sql_insert_user, $params_insert);

            // Kiểm tra xem truy vấn đã được thực hiện thành công hay không
            if ($stmt_insert_user === false) {
                die("Lỗi khi thêm người dùng: " . print_r(sqlsrv_errors(), true));
            } else {
                $message = "Đăng ký thành công";
            }
        }

        // Giải phóng tài nguyên
        if (isset($stmt_check_email)) {
            sqlsrv_free_stmt($stmt_check_email);
        }

        if (isset($stmt_insert_user)) {
            sqlsrv_free_stmt($stmt_insert_user);
        }
    }
?>

<section class="contact-section" id="contact">
    <div class="container">
        <div class="heading">
            <h2>Mời bạn nhận thông tin tại đây</h2>
            <p>Nhập thông tin <span>họ tên</span>, <span>email</span>, và <span>mật khẩu</span></p>
        </div>
        <div class="row">
            <div class="col-lg-12 mt-5">
                <div class="contact-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form method="POST" action="" onsubmit="return validateForm()">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="text" name="user" id="user" class="form-control" placeholder="Họ và tên">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu">
                                            </div>
                                        </div>
                                        <span id="email-error" class="error-message" style="display: <?php echo isset($message) ? 'block' : 'none'; ?>;">
                                            <?php echo isset($message) ? $message : ''; ?>
                                        </span>
                                        <button style="width: 150px; margin-left: 10px;border: none;background-color: #2eb873;padding: 5px;border-radius: 5px;" type="submit">Nhận thông tin</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function validateForm() {
        var user = document.getElementById("user").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        // Lưu thông tin đăng ký vào localStorage
        var userData = {
            user: user,
            email: email,
            password: password
        };
        localStorage.setItem('userData', JSON.stringify(userData));
        return true;
    }
</script>

<?php
get_footer();
?>
