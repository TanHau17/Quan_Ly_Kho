
<?php
require_once ('controllers/base_controller.php');
require_once ('models/dphieutp.php');
class dphieutpController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'dphieutp';
    }
    public function  index()
    {
        $dphieutp = dphieutp::all();
    $data = array('dphieutp' => $dphieutp);

    // Tính toán các giá trị thống kê
    $tongDonHang = count($dphieutp);
    $tongTien = array_sum(array_column($dphieutp, 'ThanhTien'));
    $soDonDaThanhToan = count(array_filter($dphieutp, function ($item) {
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
        $dphieutp = dphieutp::find($_GET['id']);
        $data = array('dphieutp' => $dphieutp);
        $this->render('show', $data);
    }
    public function  print()
    {
        $dphieutp = dphieutp::find($_GET['id']);
        $data = array('dphieutp' => $dphieutp);
        $this->render('print', $data);
    }

}
