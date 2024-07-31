<?php
require_once ('controllers/base_controller.php');
require_once ('models/sanpham.php');

class SanPhamController extends BaseController
{
    function __construct()
    {
        $this->folder='sanpham';
    }
    public function index()
    {
        // Lấy danh sách sản phẩm
        $sanpham = SanPham::all();

        // Khởi tạo các biến đếm
        $unapproved_products = 0;
        $approved_products = 0;
        $out_of_stock_products = 0;

        // Duyệt qua danh sách sản phẩm và tính toán các giá trị
        foreach ($sanpham as $item) {
            // Số sản phẩm chưa duyệt và đã duyệt
            if ($item->TrangThai == 0) {
                $unapproved_products++;
            } else {
                $approved_products++;
            }

            // Số sản phẩm hết hàng
            if ($item->SoLuong <= 0) {
                $out_of_stock_products++;
            }
        }

        // Truyền giá trị thống kê vào mảng $data để sử dụng trong view
        $data = array(
            'sanpham' => $sanpham,
            'unapproved_products' => $unapproved_products,
            'approved_products' => $approved_products,
            'out_of_stock_products' => $out_of_stock_products
        );

        // Render view với dữ liệu thống kê
        $this->render('index', $data);
    }
    public function insert()
    {
        $this->render('insert');
    }
    public function edit()
    {
        $sanpham = SanPham::find($_GET['id']);
        $data = array('sanpham'=>$sanpham);
        $this->render('edit', $data);
    }
    
}