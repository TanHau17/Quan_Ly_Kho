<?php
require_once ('models/kho_nvl.php');
require_once ('models/dphieu.php');
//?>

<h1 class="h3 mb-2 text-center text-gray-800 ">Kho Nguyên Vật Liệu</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Kho Nguyên Vật Liệu</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=kho_nvl&action=insert" class="btn btn-primary mb-3">Thêm</a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày lập</th>
                    <th>idNCC</th>
                    <th>Trạng thái</th>
                    <th>idNVL</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Kho Nguyên Vật Liệu</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
                </tfoot>
                <tbody>

                <?php
                foreach ($dphieu as $item){

                    ?>
                    <form method="post">
                        <tr>
                            <td><?= $item->id?></td>
                            <td><?= $item->ngaylap?></td>
                            <td><?= $item->idNCC?></td>
                             <td><?= $item->trangthai?></td>
                              <td><?= $item->idNVL?></td>

                            <td>
                                <a  href="index.php?controller=dphieu&action=edit&id=<?= $item->id?>"  class='btn btn-primary mr-3'>Sửa</a>
                                <button type="submit" name="dele" value="<?= $item->id ?>"    class='btn btn-danger'>Xóaaaaaaa</button>

                    </form>
                    </td>
                    
                    </tr>
                    <?php
                }
                ?>
                </tbody>
        <a  href="index.php?controller=dphieu&action=show&id=<?php $id ?>"  class='btn btn-danger mb-3'>Chi Tiết</a>

            </table>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    dphieu::delete($id);
}
?>


