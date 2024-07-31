
<?php
require_once ('models/donvitinh.php');
require_once ('models/nhacungcap.php');
require_once ('models/kho_nvl.php');

$list = [];
$db =DB::getInstance();
$reg = $db->query('select * from DonViTinh');
foreach ($reg->fetchAll() as $item){
    $list[] =new DonViTinh($item['Id'],$item['DonVi']);
}
$data =array('donvi'=> $list);
//end dvt


$list1 = [];
$db1 =DB::getInstance();
$reg1 = $db1->query('select * from NhaCungCap');
foreach ($reg1->fetchAll() as $item){
    $list1[] =new NhaCungCap($item['Id'],$item['TenNCC'],$item['DienThoai'],$item['Email'],$item['DiaChi']);
}
$data1 =array('nhacungcap'=> $list1);

        $list2 = [];
        $db2 =DB::getInstance();
        $data2 =array('nvl'=> $list2);
        $reg2 = $db2->query('select * from nvl');
        foreach ($reg2->fetchAll() as $item){
            $list2[] =new NVL($item['Id'],$item['TenNVL'],$item['IdDVT'],$item['IdNCC'],$item['SoLuong'],$item['TrangThai'],$item['id_kho_nvl']);
                        }
        $data2 =array('nvl'=> $list2);

    $list3 = [];
    $db3 =DB::getInstance();
    $data3 =array('kho_nvl'=> $list3);
    $reg3 = $db3->query('select * from kho_nvl');
    foreach ($reg3->fetchAll() as $item){
        $list3[] =new kho_nvl($item['id_kho_nvl'],$item['ten_kho_nvl'],$item['dia_chi']);
                    }
    $data3 =array('kho_nvl'=> $list3);
?>
<form method="post" name="create-nvl">
    <div class="form-group ml-5">
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Tên Nguyên Vật Liệu</label>
            <input type="text" class="form-control" id="validationDefault01" value="<?= $nvl->TenNVL ?>" name="tennvl" placeholder="Tên Nguyên Vật Liệu" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Đơn Vị tính</label>
            <select class="form-control" id="lsp_ma"  name="dvt">
                <?php foreach ($list as $item) {
        if      ($nvl->IdDVT ==$item->Id){
            echo "<option value=".$item->Id." selected>".$item->DonVi ."</option>";
        }
        else {
            echo "<option value=".$item->Id.">".$item->DonVi ."</option>";
        }
                } ?>
            </select>
        </div>   
          <div class="col-md-4 mb-3">
            <label for="validationDefault02">Nhà Cung Cấp</label>
            <select class="form-control" id="lsp_ma"  name="ncc">
                <?php foreach ($list1 as $item) {
                    if      ($nvl->IdNCC == $item->Id){
                        echo "<option value=".$item->Id." selected>".$item->TenNCC ."</option>";
                    }
                    else {
                    echo "<option value=".$item->Id.">".$item->TenNCC ."</option>";
                    }
                } ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Kho nguyên vật liệu</label>
            <select class="form-control" disabled id="lsp_ma" name="knvl">
                <?php 
                foreach ($list3 as $item) {
                   echo "<option value=".$item->id_kho_nvl." readonly>".$item->ten_kho_nvl ."</option>";
                 }
                  ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
        <label for="validationDefault02">Trạng Thái</label>

            <select class="form-control" name="TrangThai" disabled>
                        <option value="">Chọn trạng thái</option>
                        <option value="1"> Duyệt</option>
                        <option value="0">Không Duyệt</option>
                        <?php
                        // foreach ($list2 as $item) {
                        //     echo "<option value='".$item->TrangThai."'>".$item->TrangThai."</option>";
                        // }
                        ?>
                    </select>

                    <!-- Hiển thị trạng thái dựa trên giá trị đã chọn -->
                    <?php
                    if (isset($_POST['TrangThai'])) {
                        $selectedTrangThai = $_POST['TrangThai'];
                        
                        echo "Trạng thái đã chọn: ";
                        if ($selectedTrangThai == "1") {
                            echo "Đã Duyệt";
                        } else {
                            echo "Chưa Duyệt";
                        }
                    }
                    ?>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Số lượng</label>
            <input type="number" class="form-control" id="validationDefault02" value="<?= $nvl->SoLuong ?>" name="soluong" placeholder="Nhập số lượng" required>
            <button type="submit" name="create-nvl" class=" mt-2 btn-danger btn">Update</button>
        </div>

    </div>
</form>
<?php
if(isset($_POST['create-nvl'])){
    $ten= $_POST["tennvl"];
    $id = $nvl->Id;
    $dvt= $_POST["dvt"];
    $ncc= $_POST["ncc"];
    $soluong= $_POST["soluong"];
    $TrangThai= $_POST["TrangThai"];
    $knvl = $_POST["knvl"];
    NVL::update($id,$ten,$dvt,$ncc,$soluong,$TrangThai,$knvl);
}
?>

