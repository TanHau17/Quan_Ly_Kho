<?php
include_once("models/loc_tk_sp.php");
$p = new tmdt();
// Tính tổng số trang
$total_pages = ceil(count($kho_sp) / $records_per_page);

// Lấy trang hiện tại từ tham số truyền vào URL, mặc định là trang 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Xác định vị trí bắt đầu của mỗi trang trong mảng đơn hàng
$start_index = ($current_page - 1) * $records_per_page;

// Lấy danh sách đơn hàng cho trang hiện tại
$donban_page = array_slice($donban, $start_index, $records_per_page);

if (isset($_POST['filterStatus'])) {
    $filterStatus = $_POST['filterStatus'];
    if ($filterStatus !== '') {
        $donban_page = kho_sp::filterByStatus($filterStatus, $start_index, $records_per_page);
    }
}
?>

<h1 class="h3 mb-2 text-center text-gray-800 ">Kho Sản Phẩm</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách kho sản phẩm</h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <?php 
				    $p->loadMenuKho('select * from kho_sp order by ten_kho_sp asc');
			    ?>
                </thead>
                <tfoot>
                <tr>
                <?php
				$id_kho_sp=$_REQUEST['id_kho_sp'];
				if($id_kho_sp>=0)
				{
					$p->xuatsanpham("select * from sanpham where id_kho_sp='$id_kho_sp' order by id asc");
				}
				else
				{
					$p->xuatsanpham("select * from sanpham order by Id asc");
				}
			?>
                </tr>
                </tfoot>
                <tbody>
        
        </div>
       
        	
        </div>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>