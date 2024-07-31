
<?php
require_once ('models/nvl.php');
?>

<h1 class="h3 mb-2 text-center text-gray-800 ">Nguyên Vật Liệu</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Nguyên Vật Liệu</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=nvl&action=insert" class="btn btn-primary mb-3">Thêm</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Nguyên Vật Liệu</th>
                    <th>Đơn vị</th>
                    <th>Nhà cung cấp</th>
                    <th>Sô lượng</th>
                    <th>Trạng Thái</th>
                    <th>Kho Nguyên Vật Liệu</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Tên Nguyên Vật Liệu</th>
                    <th>Đơn vị</th>
                    <th>Nhà cung cấp</th>
                    <th>Sô lượng</th>
                    <th>Trạng Thái</th>
                    <th>Kho Nguyên Vật Liệu</th>
                    <th>Action</th>

                </tr>
                </tfoot>
                <tbody>

                <?php
                foreach ($nvl as $item){

                    ?>
                    <form method="post">
                        <tr>
                            <td><?= $item->Id    ?></td>
                            <td><?= $item->TenNVL ?></td>
                            <td><?= $item->IdDVT ?></td> 
                            <td><?= $item->IdNCC ?></td>
                          
                            <td><?= $item->SoLuong?></td>
                            <td><?php
                                if ($item->TrangThai=="1"){
                                    echo "Đã Duyệt";
                                }
                                else {
                                    echo "Chưa Duyệt";
                                }
                                ?></td>
                            <td><?= $item->id_kho_nvl ?></td>

                            <td><!--<a  href="index.php?controller=khachhangs&action=showPost&id=--><!--"  class='btn btn-primary mr-3'>Details</a>-->
                             <a  href="index.php?controller=nvl&action=edit&id=<?= $item->Id?>"  class='btn btn-primary mr-3'>Sửa</a>
                             <button type="submit" name="dele" value="<?= $item->Id ?>"    class='btn btn-danger'>Xóa</button>
                             <a  href="index.php?controller=nvl&action=dpnvl&id=<?= $item->Id?>"  class='btn btn-warning mr-3'>Điều phối</a>

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
    NVL::delete($id);
}
?>


