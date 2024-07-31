
<?php
require_once ('models/sanpham.php');

// Lấy tham số lọc từ URL, mặc định là "all"
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$records_per_page = 6;

// Lấy trang hiện tại từ tham số truyền vào URL, mặc định là trang 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Xác định vị trí bắt đầu của mỗi trang trong mảng đơn hàng
$start_index = ($current_page - 1) * $records_per_page;

// Lấy dữ liệu sản phẩm dựa trên tham số lọc và phân trang
if ($filter == 'outofstock') {
    // Nếu lọc theo sản phẩm hết hàng
    $sanpham = SanPham::getOutOfStockProductsPaged($start_index, $records_per_page);
} elseif ($filter == 'unapproved') {
    // Nếu lọc theo sản phẩm chưa duyệt
    $sanpham = SanPham::getUnapprovedProductsPaged($start_index, $records_per_page);
}
else {
    // Ngược lại, lấy tất cả sản phẩm
    $sanpham = SanPham::all();
}

// Tính tổng số trang sau khi có dữ liệu
$total_pages = ceil(count($sanpham) / $records_per_page);

// Lấy danh sách đơn hàng cho trang hiện tại
$sanpham_page = array_slice($sanpham, $start_index, $records_per_page);

// Tính tổng số sản phẩm
$total_products = count($sanpham);
?>
<script>
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xóa mục này không?');
    }
</script>


<div class="row mb-3">
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Tổng số sản phẩm</h5>
                <p class="card-text"><?= count($sanpham) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm chưa duyệt</h5>
                <p class="card-text"><?= $unapproved_products ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm đã duyệt</h5>
                <p class="card-text"><?= $approved_products ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm hết hàng</h5>
                <p class="card-text"><?= $out_of_stock_products ?></p>
            </div>
        </div>
    </div>
</div>



<h1 class="h3 mb-2 text-center text-gray-800 ">Sản Phẩm</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Sản Phẩm</h6>
    </div>

    

    <div class="card-body">
    <form method="get" action="index.php?controller=sanpham&action=index" class="form-inline" style="margin-left:10px;margin-bottom:10px;">
    <div class="form-group mr-2">
        <label for="filter" class="mr-2">Lọc sản phẩm:</label>
        <select name="filter" id="filter" class="form-control">
            <option value="all" <?php echo ($filter == 'all') ? 'selected' : ''; ?>>Tất cả</option>
            <option value="outofstock" <?php echo ($filter == 'outofstock') ? 'selected' : ''; ?>>Hết hàng</option>
            <option value="unapproved" <?php echo ($filter == 'unapproved') ? 'selected' : ''; ?>>Chưa duyệt</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lọc</button>
</form>
<?php if ($filter == 'unapproved'): ?>
    <form method="post">
        <button type="submit" name="requestAllApproval" class='btn btn-warning'>Yêu cầu duyệt</button>
    </form>
<?php endif; ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Ngày Nhập</th>
                    <th>Đơn vị</th>
                    <th>Nhà cung cấp</th>
                    <th>Số lượng</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Ngày Nhập</th>
                    <th>Đơn vị</th>
                    <th>Nhà cung cấp</th>
                    <th>Sô lượng</th>
                    <th>Action</th>

                </tr>
                </tfoot>
                <tbody>


<?php 

$stt = $start_index;
foreach ($sanpham_page as $item): ?>
    <form method="post">
        <tr>
            <td><?= ++$stt; // Bắt đầu từ số 1 ?></td>
            <td><?= $item->TenSP ?></td>
            <td><?= $item->NgayNhap ?></td>
            <td><?= $item->IdDVT ?></td>
            <td><?= $item->IdNCC ?></td>
            <td><?= $item->SoLuong ?></td>
            <td>
                <a href="index.php?controller=sanpham&action=edit&id=<?= $item->Id ?>" class='btn btn-primary mr-3'>Edit</a>
                <button type="submit" name="dele" value="<?= $item->Id ?>" onclick="return confirmDelete()" class='btn btn-danger'>Delete</button>
                
            </td>
        </tr>
    </form>
<?php endforeach; ?>

                </tbody>
            </table>

            <!-- Hiển thị phân trang -->
<nav aria-label="Page navigation" class="justify-content-end" style = "float:right;">
<ul class="pagination justify-content-end">
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?controller=sanpham&action=index&page=<?= $i ?>">
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
    $confirmation = SanPham::delete($id);

    if ($confirmation) {
        // Người dùng đã xác nhận, chuyển hướng tới trang danh sách
        header('location:index.php?controller=sanpham&action=index');
    } else {
        // Người dùng chưa xác nhận, hiển thị thông báo hoặc thực hiện các xử lý khác
        echo "<script>alert('Bạn đã hủy xóa.')</script>";
    }
}


if (isset($_POST['requestAllApproval'])) {
    // Thực hiện xử lý yêu cầu duyệt cho tất cả sản phẩm
    // ...
    
    echo "<script>alert('Yêu cầu duyệt đã được gửi cho tất cả sản phẩm.')</script>";
}
?>

