
<?php
require_once ('controllers/base_controller.php');
require_once ('models/donban.php');
class DonBanController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'donban';
    }
    public function  index()
    {
        $donban = DonBan::all();
    $data = array('donban' => $donban);

    // Tính toán các giá trị thống kê
    $tongDonHang = count($donban);
    $tongTien = array_sum(array_column($donban, 'ThanhTien'));
    $soDonDaThanhToan = count(array_filter($donban, function ($item) {
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
        $donban = DonBan::find($_GET['id']);
        $data = array('donban' => $donban);
        $this->render('show', $data);
    }
    public function  print()
    {
        $donban = DonBan::find($_GET['id']);
        $data = array('donban' => $donban);
        $this->render('print', $data);
    }

}
