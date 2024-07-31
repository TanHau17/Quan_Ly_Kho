<?php

$controllers = array(
    'trangchu' => ['home', 'error','logout'],
    'nhacungcap'=> ['index','insert','delete','edit'],
    'donvitinh' => ['index','insert','edit'],
    'sanpham'   =>['index','insert','edit','dpsp'],
    'donban' =>['index','insert','edit','show','print'],
    'chitietban' =>['index','insert','edit'],
    'donmua' =>['index','insert','edit','show','print','p_excel'],
    'chitietmua' =>['index','insert','edit'],
    'kho_sp'=> ['index','insert','delete','edit','show','thongke'],
); // Các controllers trong hệ thống và các action có thể gọi ra từ controller đó.

// Nếu các tham số nhận được từ URL không hợp lệ (không thuộc list controller và action có thể gọi
// thì trang báo lỗi sẽ được gọi ra.
 if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'trangchu';
    $action = 'error';
}

// Nhúng file định nghĩa controller vào để có thể dùng được class định nghĩa trong file đó
include_once('controllers/' . $controller . '_controller.php');
// Tạo ra tên controller class từ các giá trị lấy được từ URL sau đó gọi ra để hiển thị trả về cho người dùng.
$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
$controller = new $klass;
$controller->$action();