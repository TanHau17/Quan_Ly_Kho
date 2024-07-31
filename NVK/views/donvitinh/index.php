
<?php
require_once ('models/donvitinh.php');

//?>

<script>
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xóa mục này không?');
    }
</script>


<!-- Page Heading -->
<h1 class="h3 mb-2 text-center text-gray-800 ">Đơn vị tính</h1>
<!--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.-->
<!--    For more information about DataTables, please visit the <a target="_blank"-->
<!--                                                               href="https://datatables.net">official DataTables documentation</a>.</p>-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Đơn vị</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=donvitinh&action=insert" class="btn btn-primary mb-3">Thêm</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>

                    <th>STT</th>
                    <th>Tên</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>

                <?php
                $stt = 1; // Bắt đầu từ số 1
                foreach ($donvi as $item){

                    ?>
                    <form method="post">
                        <tr>
                        <td><?= $stt++; ?></td> <!-- Tăng giá trị của STT và hiển thị -->
                            <td><?= $item->DonVi?></td>
                            <td><!--<a  href="index.php?controller=khachhangs&action=showPost&id=--><!--"  class='btn btn-primary mr-3'>Details</a>-->
                            <a  href="index.php?controller=donvitinh&action=edit&id=<?= $item->Id?>"  class='btn btn-primary mr-3'>Edit</a>
                            <button type="submit" name="dele" value="<?= $item->Id ?>" onclick="return confirmDelete()"    class='btn btn-danger'>Delete</button>
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
    if (isset($_POST['dele'])) {
        $id = $_POST['dele'];
    
        // Gọi phương thức xóa và kiểm tra xác nhận
        $confirmation = DonViTinh::delete($id);
    
        if ($confirmation) {
            // Người dùng đã xác nhận, chuyển hướng tới trang danh sách
            header('location:index.php?controller=donvitinh&action=index');
        } else {
            // Người dùng chưa xác nhận, hiển thị thông báo hoặc thực hiện các xử lý khác
            echo "<script>alert('Bạn đã hủy xóa.')</script>";
        }
    }
?>


