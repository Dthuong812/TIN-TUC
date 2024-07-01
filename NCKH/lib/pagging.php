<?php
function get_pagging($num_page, $page, $base_url = "")
{
    $str_pagging = "<ul class ='pagination'>";
    if ($page > 1){
        $page_prev = $page - 1;
        $str_pagging .= "<li class=\"pagination__item\"><a class=\"pagination__link\" href=\"{$base_url}=$page_prev\">Trước</a></li>";
    }
    for ($i = 1; $i <= $num_page; $i++) {
        $active = "";
        if($i == $page )
            $active ="class='active'";
        $str_pagging .= "<li class=\"pagination__item\" {$active}><a class=\"pagination__link\" href=\"{$base_url}={$i}\">{$i}</a></li>";
    };
    if ($page < $num_page){
        $page_next = $page + 1;
        $str_pagging .= "<li class=\"pagination__item\"><a class=\"pagination__link\" href=\"{$base_url}=$page_next\">Sau</a></li>";
    }
    $str_pagging .= "</ul>";
    return $str_pagging;
};
?>
