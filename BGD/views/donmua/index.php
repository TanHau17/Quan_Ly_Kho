<?php
require_once ('connection.php');
require_once ('models/donmua.php');
require_once ('models/nhacungcap.php');

$list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from NhaCungCap');
        foreach ($reg->fetchAll() as $item){
            $list[] =new NhaCungCap($item['Id'],$item['TenNCC'],$item['DienThoai'],$item['Email'],$item['DiaChi']);
        }

        $list1 =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT db.Id ,db.NgayMua , nv.TaiKhoan ,kh.TenNCC ,db.ThanhTien,db.TrangThai FROM DonMua db JOIN NhanVien nv JOIN NhaCungCap kh ON nv.Id =db.IdNV AND kh.Id = db.IdNCC');
        foreach ($reg->fetchAll() as $item){
            $list1[] =new DonMua($item['Id'],$item['NgayMua'],$item['TaiKhoan'],$item['TenNCC'],$item['ThanhTien'],$item['TrangThai']);
        }   

?>

<h1 class="h3 mb-2 text-center text-gray-800 ">Đơn mua NVL</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=donmua&action=insert" class="btn btn-primary mb-3">Thêm</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Thời gian</th>
                    <th>Nhân Viên</th>
                    <th>Nhà Cung Cấp</th>
                    <th>Tổng tiền</th>
                    <th>Trạng Thái</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($donmua as $item){
                    ?>
                    <form method="post">
                        <tr>
                            <td><?= $item->Id   ?></td>
                            <td><?=date('d/m/Y', strtotime($item->NgayMua))?></td>
                            <td><?= $item->IdNV
                                ?></td>
                            <td><?= $item->IdNCC?></td>
                            <td><?= number_format($item->ThanhTien, 0,"." , ",")?> VNĐ</td>
                            <td><?php
                                if ($item->TrangThai=="1"){
                                    echo "Đã Thanh Toán";
                                }
                                else {
                                    echo "Chưa thanh toán";
                                }
                                ?></td>
                            <td>
                                <a href="index.php?controller=donmua&action=show&id=<?= $item->Id?>"  class='btn btn-primary mr-3'>Details</a>
                                <a href="index.php?controller=donmua&action=print&id=<?= $item->Id?>"  class='btn btn-primary mr-3'>Print</a>
                                <button type="submit" name="dele" value="<?= $item->Id ?>" class='btn btn-danger'>Delete</button>
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
<script>
    var modal = document.getElementById('myModal');

    var btn = document.getElementById('openModalBtn');

    var span = document.getElementById('closeModal');

    btn.onclick = function() {
        modal.style.display = 'block';
    }

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    function submitForm() {
        var formData = document.getElementById('data').value;
        console.log('Form data submitted: ' + formData);
        modal.style.display = 'none';
    }
</script>
</div>
<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    donmua::delete($id);
}
?>