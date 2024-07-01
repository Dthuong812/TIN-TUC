<?php
function get_header(){
    $path_header ="./inc/header.php";
    if(file_exists($path_header)){
        require  $path_header;
    }else{
        echo "Không tồn tại";
    }
    
    
};
function get_menu($version = ''){
    if(!empty($version)){
        $path_menu ="./inc/menu_{$version}.php";
    }else{
        $path_menu ="./inc/menu.php";
    }
    if(file_exists($path_menu)){
        require  $path_menu;
    }else{
        echo "Không tồn tại";
    }
    
};

function get_footer(){
    $path_footer ="./inc/footer.php";
    if(file_exists($path_footer)){
        require  $path_footer;
    }else{
        echo "Không tồn tại";
    }
    
    
};
function get_classify(){
    $path_classify ="./inc/classify.php";
    if(file_exists($path_classify)){
        require  $path_classify;
    }else{
        echo "Không tồn tại";
    }
    
    
};
function get_solutions(){
    $path_solutions ="./inc/solutions.php";
    if(file_exists($path_solutions)){
        require  $path_solutions;
    }else{
        echo "Không tồn tại";
    }
    
    
};
function get_about(){
    $path_about ="./inc/about.php";
    if(file_exists($path_about)){
        require  $path_about;
    }else{
        echo "Không tồn tại";
    }  
};
function get_volunteer(){
    $path_volunteer ="./inc/volunteer.php";
    if(file_exists($path_volunteer)){
        require  $path_volunteer;
    }else{
        echo "Không tồn tại";
    }  
};
function get_collect(){
    $path_collect ="./inc/collect.php";
    if(file_exists($path_collect)){
        require  $path_collect;
    }else{
        echo "Không tồn tại";
    }  
};
function get_ogn(){
    $path_ogn ="./inc/ogn.php";
    if(file_exists($path_ogn)){
        require  $path_ogn;
    }else{
        echo "Không tồn tại";
    }  
};
?>
