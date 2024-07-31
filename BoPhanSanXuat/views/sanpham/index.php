
<?php
require_once ('models/sanpham.php');
?>

<h1 class="h3 mb-2 text-center text-gray-800 ">Sản Phẩm</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Sản Phẩm</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=sanpham&action=insert" class="btn btn-primary mb-3">Thêm</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>click</th>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị</th>
                    <th>Nhà cung cấp</th>
                    <th>Ngày Nhập</th>
                    <th>Số lượng</th>
                    <th>Trạng Thái</th>
                    <th>Kho sản phẩm</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>click</th>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị</th>
                    <th>Nhà cung cấp</th>
                    <th>Ngày Nhập</th>
                    <th>Số lượng</th>
                    <th>Trạng Thái</th>
                    <th>Kho sản phẩm</th>
                    <th>Action</th>

                </tr>
                </tfoot>
                <tbody>

                <?php
                foreach ($sanpham as $item){

                    ?>
                    <form method="post">
                        <tr>           
                        <td><input type="checkbox" name="selectedItems[]" value="<?= $item->Id ?>"></td>
                            <td><?= $item->Id    ?></td>
                            <td><?= $item->TenSP ?></td>
                            <td><?= $item->IdDVT ?></td> 
                            <td><?= $item->IdNCC ?></td>
                            <td><?= $item->NgayNhap ?></td>
                            <td><?= $item->SoLuong?></td>
                            <td><?php
                                if ($item->TrangThai=="1"){
                                    echo "Đã Duyệt";
                                }
                                else {
                                    echo "Chưa Duyệt";
                                }
                                ?></td>
                            <td><?= $item->id_kho_sp ?></td>
                                    
                            <td><!--<a  href="index.php?controller=khachhangs&action=showPost&id=--><!--"  class='btn btn-primary mr-3'>Details</a>-->
                             <a  href="index.php?controller=sanpham&action=edit&id=<?= $item->Id?>"  class='btn btn-primary mr-3'>Sửa</a>
                             <button type="submit" name="dele" value="<?= $item->Id ?>"    class='btn btn-danger'>Xóa</button>
                             <a  href="index.php?controller=sanpham&action=dpsp&id=<?= $item->Id?>"  class='btn btn-warning mr-3'>Điều phối</a>

                    </form>
                    </td>
                  
                    </tr>  
                
                    <?php
                }
                ?>   
                 <tr>
                <td><input type="checkbox" id="selectAll"> Chọn tất cả</td>
                <td colspan="7"><button type="submit" name="submit">Lấy IdSP</button></td>
            </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Xử lý sự kiện khi checkbox "Chọn tất cả" được thay đổi
        $('#selectAll').change(function () {
            $('input[name="selectedItems[]"]').prop('checked', $(this).prop('checked'));
        });

        // Xử lý sự kiện khi một checkbox sản phẩm được thay đổi
        $('input[name="selectedItems[]"]').change(function () {
            // Kiểm tra xem có bất kỳ checkbox nào không được chọn
            var anyUnchecked = $('input[name="selectedItems[]"]:not(:checked)').length > 0;

            // Nếu có ít nhất một checkbox không được chọn, hủy chọn checkbox "Chọn tất cả"
            $('#selectAll').prop('checked', !anyUnchecked);
        });
    });
</script>


<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    SanPham::delete($id);
}
?>


