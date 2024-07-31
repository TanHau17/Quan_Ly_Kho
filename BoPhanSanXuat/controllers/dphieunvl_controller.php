
<?php
require_once ('controllers/base_controller.php');
require_once ('models/dphieunvl.php');
class dphieunvlController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'dphieunvl';
    }
    public function  index()
    {
        $dphieunvl = dphieunvl::all();
    $data = array('dphieunvl' => $dphieunvl);

    // Tính toán các giá trị thống kê
    $tongDonHang = count($dphieunvl);
    $tongTien = array_sum(array_column($dphieunvl, 'ThanhTien'));
    $soDonDaThanhToan = count(array_filter($dphieunvl, function ($item) {
        return $item->TrangThai == "1";
    }));
    $soDonChuaThanhToan = $tongDonHang - $soDonDaThanhToan;

    // Truyền dữ liệu vào view
    $data['tongDonHang'] = $tongDonHang;
    $data['tongTien'] = $tongTien;
    $data['soDonDaThanhToan'] = $soDonDaThanhToan;
    $data['soDonChuaThanhToan'] = $soDonChuaThanhToan;

    // Gọi hàm render
    $this->render('index', $data);
    }
    public function  insert()
    {
        $this->render('insert');
    }
    public function  show()
    {
        $dphieunvl = dphieunvl::find($_GET['id']);
        $data = array('dphieunvl' => $dphieunvl);
        $this->render('show', $data);
    }
    public function  print()
    {
        $dphieunvl = dphieunvl::find($_GET['id']);
        $data = array('dphieunvl' => $dphieunvl);
        $this->render('print', $data);
    }

}
