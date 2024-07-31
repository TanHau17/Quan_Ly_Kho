<?php
require_once ('models/pkk.php');
//?>
<h1 class="h3 mb-2 text-center text-gray-800 ">Kiểm Kê </h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách phiếu kiểm kê</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=pkk&action=add" class="btn btn-primary mb-3">Tạo phiếu</a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày KK</th>
                    <th>Tên Sản phẩm </th>
                    <th>Số Lượng</th>
                    <th>Kho sản phẩm</th>
                    <th>Ghi chú</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Ngày KK</th>
                    <th>Tên Sản phẩm </th>
                    <th>Số Lượng</th>
                    <th>Kho sản phẩm</th>
                    <th>Ghi chú</th>
                    <th>Hành động</th>
                </tr>
                </tfoot>
                <tbody>

                <?php
                foreach ($pkk as $item){

                    ?>
                    <form method="post">
                        <tr>
                            <td><?= $item->Id   ?></td>
                            <td><?= $item->ngayKK   ?></td>
                            <td><?= $item->IdSP ?></td>
                            <td><?= $item->id_kho_sp ?></td>
                            <td><?= $item->ghichu ?></td>
                            <td><?= $item->ghichu ?></td>

                            <td>
                                <button type="submit" name="dele" value="<?= $item->Id ?>"    class='btn btn-danger'>Xóa</button>
                                <a href="index.php?controller=pkk&action=print&id=<?= $item->Id ?>"class='btn btn-primary mr-3'>Print</a>
                    </form>
                    </td>
                    
                    </tr>
                    <?php
                }
                ?>
                </tbody>
        <a  href="index.php?controller=kho_sp&action=show&id_kho_sp=0"  class='btn btn-danger mb-3'>Chi Tiết</a>

            </table>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $Id =$_POST['dele'];
    pkk::delete($Id);
}
?>


