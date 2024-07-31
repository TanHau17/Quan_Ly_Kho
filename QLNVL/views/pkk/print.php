<?php
require_once('models/pkk.php');
include_once('models/sanpham.php');

$list1 = [];
$db1 = DB::getInstance();
$reg1 = $db1->query('SELECT kk.Id, kk.ngayKK,sp.TenSP,sp.SoLuong,ksp.ten_kho_sp,kk.ghichu 
FROM pkk kk 
JOIN SanPham sp ON kk.IdSP = sp.Id 
JOIN kho_sp ksp ON kk.id_kho_sp = ksp.id_kho_sp');

foreach ($reg1->fetchAll() as $item) {
    $list1[] = new pkk($item['Id'], $item['ngayKK'], $item['TenSP'], $item['SoLuong'], $item['ten_kho_sp'], $item['ghichu']);
}

// Chọn một phần tử từ mảng $list1 (ví dụ: phần tử đầu tiên)
$pkk = isset($list1[0]) ? $list1[0] : new pkk(); // Hoặc khởi tạo một đối tượng pkk mặc định nếu mảng $list1 trống

?>

<body class="A4">

        <!-- Block content - Đục lỗ trên giao diện bố cục chung, đặt tên là `content` -->
        <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <section class="sheet padding-10mm" style="padding-left: 10px;padding-right: 10px">
            <!-- Thông tin Cửa hàng -->
            <table border="0" width="100%" cellspacing="0">
                <tbody>
                <tr>
                    <td align="center"></td>
                    <td align="center">
                        <b style="font-size: 2em;">Phiếu kiểm kê</b><br />
                        <!-- <small>Phần mềm quản lý kho nhanh chóng hiệu quả</small><br />
                        <small>Giúp các bạn có niềm tin, hành trang vững vàng trên con đường trở thành Nhà kinh doanh</small> -->
                       <br> <h2> </h2>
                    </td>
                </tr>
                </tbody>
            </table>

            <!-- Thông tin đơn hàng -->
            <p style="margin-top: 50px"><i><u>Thông tin Phiếu </u></i></p>
            <table border="0" width="100%" cellspacing="0">
                <tbody>
                <tr>
                    <td width="30%">Ngày Kiểm Kê:</td>
                    <td><b><?= date('d/m/Y H:i:s', strtotime($pkk->ngayKK)) ?></b></td>
                </tr>
                <tr>
                    <td>Tên SP:</td>
                    <td><b><?= $pkk->IdSP ?></b></td>
                </tr>
                <tr>
                    <td>Số lượng:</td>
                    <td><b><?= $pkk->id_kho_sp ?></b></td>
                </tr>
                <tr>
                    <td>Kho</td>
                    <td><b><?= $pkk->ghichu  ?> </b></td>
                </tr>
                <tr>
                    <td>Ghi chú</td>
                    <td><b><?php $pkk->ghichu ?></b></td>
                </tr>
                </tbody>
            </table>
        </section>

        <!-- Thông tin sản phẩm -->
        <p><i><u>Chi tiết phiếu</u></i></p>
        <table border="1" width="100%" cellspacing="0" cellpadding="5">
            <thead>
            <tr style="text-align: center">
                <th>STT</th>
                <th>Ngày kiểm kê</th>
                <th>Sản phẩm kiểm kê</th>
                <th>Số lượng</th>
                <th>Tại kho</th>
                <th>Ghi chú</th>
            </tr>
            </thead>
            <tbody>
            <?php
            
            $dem=1;
            foreach ($list1 as $item)
            {


            ?>
                <tr>
                    <td align="center"> <?=$dem?></td>
                    <td align="center"> <?=$item->ngayKK?></td>
                    <td align="center"><?=$item->IdSP?></td>
                    <td align="center"><?=$item->id_kho_sp?></td>
                    <td align="center"><?=$item->ghichu?></td>
                 
                </tr>
            <?php
                $dem=$dem+1;
                }
                ?>
            </tbody>
            <tfoot>
            <tr>
            </tr>
            </tfoot>
        </table>

        <!-- Thông tin Footer -->
        <br/>
        <table border="0" width="100%">
            <tbody>
            <tr>
                <td align="center">
                    <small>Xin cám ơn Quý khách đã ủng hộ Cửa hàng, Chúc Quý khách An Khang, Thịnh Vượng!</small>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
    <!-- End block content -->
    </body>

<?php



?>