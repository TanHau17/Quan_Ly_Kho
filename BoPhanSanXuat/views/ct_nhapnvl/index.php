
<?php
require_once ('models/ct_nhapnvl.php');
?>

<h1 class="h3 mb-2 text-center text-gray-800 ">Chi tiết phiếu nhập</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách chi tiết phiếu nhập</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=sanpham&action=insert" class="btn btn-primary mb-3">Thêm</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Phiếu</th>
                    <th>Tên NVL</th>
                    <th>ĐƠn vị tính</th>
                    <th>Sô lượng</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>ID Đơn hàng</th>
                    <th>Tên Sản phẩm</th>
                    <th>ĐƠn vị tính</th>
                    <th>Sô lượng</th>
                    <th>Hành động</th>

                </tr>
                </tfoot>
                <tbody>

                <?php
                foreach ($ct_nhapnvl as $item){

                    ?>
                    <form method="post">
                        <tr>
                            <td><?= $item->Id   ?></td>
                            <td><?= $item->IdPhieuNhap ?></td>
                            <td><?= $item->IdNVL ?></td>
                            <td><?= $item->IdDVT ?></td>
                            <td><?= $item->SoLuong?></td>
                            <td><?= number_format($item->ThanhTien, 2,"." , ",") . ' vnđ'?></td>
                            <td><!--<a  href="index.php?controller=khachhangs&action=showPost&id=--><!--"  class='btn btn-primary mr-3'>Details</a>-->
                                <a  href="index.php?controller=sanpham&action=edit&id=<?= $item->Id?>"  class='btn btn-primary mr-3'>Sửa </a>
                                <button type="submit" name="dele" value="<?= $item->Id ?>"    class='btn btn-danger'>Xóa</button>
                    </form>
                    </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    SanPham::delete($id);
}
?>


