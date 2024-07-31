<?php
require_once ('models/dphieunvl.php');
require_once ('models/ct_nhapnvl.php');
$list =[];
$db =DB::getInstance();
$reg_db = $db->query('SELECT ct.Id, db.Id AS "IdPhieu", ct.TenNVL, dvt.DonVi, ct.SoLuongNhap 
FROM ct_nhapnvl ct 
JOIN DonViTinh dvt ON dvt.Id = ct.IdDVT 
JOIN dphieunvl db ON ct.IdPhieuNhap = db.Id WHERE ct.IdPhieuNhap='.$dphieunvl->Id);
$result = $reg_db->fetchAll();
foreach ($result as $item){
    $list[] =new ct_nhapnvl($item['Id'],$item['IdPhieu'],$item['TenNVL'],$item['DonVi'],$item['SoLuongNhap']);
}
// if ($reg_db !== false) {
//     // Thực hiện fetchAll() chỉ khi truy vấn thành công
//     $results = $reg_db->fetchAll();
//     foreach ($result as $item){
//        $list[] =new ct_nhapnvl($item['Id'],$item['IdPhieu'],$item['TenNVL'],$item['DonVi'],$item['SoLuong']);
//     }
// } else {
//     echo 'Xử lý trường hợp truy vấn không thành công';
// }
// $list1 = [];
// $db1 =DB::getInstance();
// $reg1 = $db1->query('select * from NhaCungCap');
// foreach ($reg1->fetchAll() as $item){
//     $list1[] =new NhaCungCap($item['Id'],$item['TenNCC'],$item['DienThoai'],$item['Email'],$item['DiaChi']);
// }
?>
    <h1 class="h3 mb-2 text-center text-gray-800 ">Chi tiết phiếu</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin phiếu</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ngày Lập</th>
                        <th>Nhà Cung Cấp</th>
                        <th>Trạng Thái</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td><?=$dphieunvl->Id ?></td>
                        <td><?=  date('d/m/Y H:i:s', strtotime($dphieunvl->NgayLap))?></td>
                        <!-- <td><?php echo print_r($dphieunvl) ?></td> -->
                        <td><?=$dphieunvl->IdNCC ?></td>
                        <td><?php
                            if ($dphieunvl->TrangThai=="1")
                                echo "Đã duyệt";
                            else echo "Chưa duyệt";

                            ?></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin nguyên vật liệu</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nguyên vật liệu</th>
                        <th>ĐVT</th>
                        <th>Số Lượng</th>
                        <!-- <th>Thành Tiền</th> -->

                    </tr>
                    </tfoot>

                    <tbody>

                    <?php
                    
                    foreach ($list as $item) {
                        echo  "<tr><td>$item->IdPhieuNhap</td>";
                        echo  "<td>$item->TenNVL</td>";
                        echo  "<td>$item->IdDVT</td>";
                        echo  "<td>$item->SoLuongNhap</td>";
                    }
                    ?>

                    </tbody>
                </table>

            </div>
        </div>
        <!-- <form method="post" name="dc">
            <?php

            if ($dphieunvl->TrangThai=="1"){ ?>
                <button type="submit" class="btn-outline-primary btn"  disabled >Đã Duyệt</button>
                <button type="submit"  class="btn-outline-primary btn" name="chua" >Chưa Duyệt</button>
                <?php

            }
            else {
                ?>
                <button type="submit"  class="btn-outline-primary btn" name="thanhtoan" >Đã Duyệt</button>
                <button type="submit"  class="btn-outline-primary btn" disabled>Chưa Duyệt</button>
            <?php } ?>
        </form> -->
    </div>
<?php

if (isset($_POST['chua'])) {
    dphieunvl::chuaduyet($dphieunvl->Id);
}
if (isset($_POST['thanhtoan'])) {
    dphieunvl::daduyet($dphieunvl->Id);
}

?>