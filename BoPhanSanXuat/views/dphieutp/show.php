<?php
require_once ('models/sanpham.php');
$list =[];
$db =DB::getInstance();
$reg = $db->query('SELECT sp.Id ,sp.TenSP ,dvt.DonVi ,sp.IdNCC,sp.NgayNhap,sp.SoLuong, sp.TrangThai, sp.id_kho_sp
FROM sanpham sp JOIN DonViTinh dvt JOIN dphieutp db ON sp.Id = db.IdSP AND dvt.Id = sp.IdDVT WHERE sp.Id='.$dphieutp->IdSP);
foreach ($reg->fetchAll() as $item){
    $list[] =new SanPham($item['Id'],$item['TenSP'],$item['DonVi'],$item['IdNCC'],$item['NgayNhap'],$item['SoLuong'],$item['TrangThai'],$item['id_kho_sp']);
}

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
                        <td><?=$dphieutp->Id ?></td>
                        <td><?=  date('d/m/Y H:i:s', strtotime($dphieutp->NgayLap))?></td>
                        <!-- <td><?=$dphieutp->IdNV ?></td> -->
                        <td><?=$dphieutp->IdNCC ?></td>
                        <!-- <td><?=number_format($dphieutp->ThanhTien,0,",",".") ?> VNĐ</td> -->
                        <td><?php
                            if ($dphieutp->TrangThai=="1")
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
            <h6 class="m-0 font-weight-bold text-primary">Chi Tiết Đơn</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Sản Phẩm</th>
                        <th>Số Lượng</th>

                    </tr>
                    </tfoot>

                    <tbody>

                    <?php
                    $dem=1;
                    foreach ($list as $item) {

                        echo  "<tr><td>$dem</td>";
                        echo  "<td>$item->TenSP</td>";
                        echo  "<td>$item->SoLuong</td>";
                        /*                echo  " <td><?=dphieutp->IdNV ?></td>";*/
                        /*                echo  " <td><?=dphieutp->IdKH ?></td>";*/
                        /*                 echo  "<td><?=number_format(dphieutp->ThanhTien,0,",",".") ?> VNĐ</td>";*/
                        /*                echo  " <td><?=dphieutp->TrangThai ?></td>";*/
//                    echo "</tr>";
                        $dem++;
                    }
                    ?>

                    </tbody>
                </table>

            </div>
        </div>
        <!-- <form method="post" name="dc">
            <?php

            if ($dphieutp->TrangThai=="1"){ ?>
                <button type="submit" class="btn-outline-primary btn"  disabled >Đã Thanh Toán</button>
                <button type="submit"  class="btn-outline-primary btn" name="chua" >Chưa Thanh Toán</button>
                <?php

            }
            else {
                ?>
                <button type="submit"  class="btn-outline-primary btn" name="duyet" >Đã Thanh Toán</button>
                <button type="submit"  class="btn-outline-primary btn" disabled>Chưa Thanh Toán</button>
            <?php } ?>
        </form> -->
    </div>
<?php

if (isset($_POST['chua'])) {
    dphieutp::chuaduyet($dphieutp->Id);
}
if (isset($_POST['duyet'])) {
    dphieutp::duyet($dphieutp->Id);
}

?>