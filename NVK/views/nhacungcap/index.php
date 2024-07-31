<?php
require_once ('models/nhacungcap.php');

$records_per_page = 4;

// Tính tổng số trang
$total_pages = ceil(count($nhacungcap) / $records_per_page);

// Lấy trang hiện tại từ tham số truyền vào URL, mặc định là trang 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Xác định vị trí bắt đầu của mỗi trang trong mảng đơn hàng
$start_index = ($current_page - 1) * $records_per_page;

// Lấy danh sách đơn hàng cho trang hiện tại
$nhacungcap_page = array_slice($nhacungcap, $start_index, $records_per_page);
//?>

<script>
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xóa mục này không?');
    }
</script>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-center text-gray-800 ">Nhà Cung Cấp</h1>
<!--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.-->
<!--    For more information about DataTables, please visit the <a target="_blank"-->
<!--                                                               href="https://datatables.net">official DataTables documentation</a>.</p>-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Nhà cung cấp</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=nhacungcap&action=insert" class="btn btn-primary mb-3">Thêm</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Nhà cung cấp</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>STT</th>
                    <th>Nhà cung cấp</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>

                <?php
                $stt = $start_index + 1; // Bắt đầu từ số 1
                foreach ($nhacungcap_page as $item){

                    ?>
                    <form method="post">
                        <tr>
                        <td><?= $stt++; ?></td> <!-- Tăng giá trị của STT và hiển thị -->
                            <td><?= $item->TenNCC?></td>
                            <td><?= $item->DienThoai?></td>
                            <td><?= $item->Email?></td>
                            <td><?= $item->DiaChi?></td>
                            <td>
                                <!--                       <a  href="index.php?controller=khachhangs&action=showPost&id=--><!--"  class='btn btn-primary mr-3'>Details</a>-->
                                <a  href="index.php?controller=nhacungcap&action=edit&id=<?= $item->Id?>"  class='btn btn-primary mr-3'>Edit</a>
                                <button type="submit" name="dele" value="<?= $item->Id ?>" onclick="return confirmDelete()"    class='btn btn-danger'>Delete</button>
                    </form>
                    </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
             <!-- Hiển thị phân trang -->
             <nav aria-label="Page navigation">
    <ul class="pagination justify-content-end">
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?controller=nhacungcap&action=index&page=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
        </div>
    </div>
</div>
<?php
    if (isset($_POST['dele'])) {
        $id = $_POST['dele'];
    
        // Gọi phương thức xóa và kiểm tra xác nhận
        $confirmation = NhaCungCap::delete($id);
    
        if ($confirmation) {
            // Người dùng đã xác nhận, chuyển hướng tới trang danh sách
            header('location:index.php?controller=nhacungcap&action=index');
        } else {
            // Người dùng chưa xác nhận, hiển thị thông báo hoặc thực hiện các xử lý khác
            echo "<script>alert('Bạn đã hủy xóa.')</script>";
        }
    }

    
?>


