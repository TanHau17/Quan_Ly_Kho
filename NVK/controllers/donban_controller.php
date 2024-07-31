
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
        // Get all orders
        $donban = DonBan::all();

        // Filter orders placed today
        $donbanToday = array_filter($donban, function ($item) {
            $today = date('Y-m-d');
            $date = date('Y-m-d', strtotime($item->NgayBan));
            return $date == $today;
        });

        // Calculate statistics for today's orders
        $tongDonHang = count($donbanToday);
        $tongTien = array_sum(array_column($donbanToday, 'ThanhTien'));
        $soDonDaThanhToan = count(array_filter($donbanToday, function ($item) {
            return $item->TrangThai == "1";
        }));
        $soDonChuaThanhToan = $tongDonHang - $soDonDaThanhToan;

        // Prepare data for the view
        $data = array(
            'donban' => $donbanToday,
            'tongDonHang' => $tongDonHang,
            'tongTien' => $tongTien,
            'soDonDaThanhToan' => $soDonDaThanhToan,
            'soDonChuaThanhToan' => $soDonChuaThanhToan
        );

        // Render the view
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
