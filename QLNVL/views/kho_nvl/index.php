<?php
require_once ('models/kho_nvl.php');
//?>
<h1 class="h3 mb-2 text-center text-gray-800 ">Kho Sản Phẩm</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách kho sản phẩm</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=kho_nvl&action=insert" class="btn btn-primary mb-3">Thêm</a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Kho sản phẩm</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Kho sản phẩm</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
                </tfoot>
                <tbody>

                <?php
                foreach ($kho_nvl as $item){

                    ?>
                    <form method="post">
                        <tr>
                            <td><?= $item->id_kho_nvl   ?></td>
                            <td><?= $item->ten_kho_nvl?></td>
                            <td><?= $item->dia_chi?></td>

                            <td>
                                <a  href="index.php?controller=kho_nvl&action=edit&id_kho_nvl=<?= $item->id_kho_nvl?>"  class='btn btn-primary mr-3'>Sửa</a>
                                <button type="submit" name="dele" value="<?= $item->id_kho_nvl ?>"    class='btn btn-danger'>Xóa</button>

                    </form>
                    </td>
                    
                    </tr>
                    <?php
                }
                ?>
                </tbody>
        <a  href="index.php?controller=kho_nvl&action=show&id_kho_nvl=0"  class='btn btn-danger mb-3'>Chi Tiết</a>

            </table>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $id_kho_nvl =$_POST['dele'];
    kho_nvl::delete($id_kho_nvl);
}
?>


