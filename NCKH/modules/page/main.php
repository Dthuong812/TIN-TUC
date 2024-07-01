<?php
get_header();
?>
<?php
get_menu('user');
?>
<?php
$mod = isset($_GET['mod']) ? $_GET['mod'] : null;
$act = isset($_GET['act']) ? $_GET['act'] : null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($mod === 'page' && $act === 'main') {
    switch ($id) {
        case 1:
            get_classify();
            break;
        case 2:
            get_solutions();
            break;
        case 3:
            get_about();
            break;
        case 4:
            get_volunteer();
            break;
        case 5:
            get_collect();
            break;
        default:
            get_ogn();
            break;
    }
} else {
    echo "Giá trị mod hoặc act không hợp lệ.";
    // Mã xử lý cho các giá trị mod hoặc act không mong đợi
}
?>


<?php
get_footer();
?>