<?php
        require_once ('models/donvitinh.php');
        require_once ('models/nhacungcap.php');
        require_once ('models/dphieu.php');
        require_once ('models/nvl.php');

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
//

$list2 = [];
$db2 =DB::getInstance();
$reg2 = $db2->query('select * from nvl');
foreach ($reg2->fetchAll() as $item){
    $list2[] =new NVL($item['Id'],$item['TenNVL'],$item['IdDVT'],$item['IdNCC'],$item['SoLuong'],$item['TrangThai'],$item['id_kho_nvl']);
}
$data2 =array('nvl'=> $list2);
?>
<h1 style="margin-left: 120px;">THÊM KẾ HOẠCH</h1>
<form method="post" name="create-sp">
    <div class="form-group ml-5">
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Ngày lập </label>
            <input type="datetime-local" class="form-control" id="validationDefault01" name="NgayLap" placeholder="" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Nhà Cung Cấp</label>
            <select class="form-control" id="lsp_ma" name="ncc">
                <?php foreach ($list1 as $item) {
                   echo "<option value=".$item->Id.">".$item->TenNCC ."</option>";
                 } ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Đơn Vị tính</label>
            <select class="form-control" id="lsp_ma" name="dvt">
                <?php foreach ($list as $item) {
                   echo "<option value=".$item->Id.">".$item->DonVi ."</option>";
                 } ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Nguyên Vật Liệu</label>
            <select class="form-control" id="lsp_ma" name="ten">
                <?php foreach ($list2 as $item) {
                   echo "<option value=".$item->Id.">".$item->TenNVL ."</option>";
                 } ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
                    <label for="validationDefault02">Trạng thái</label>
                   <!-- Dropdown -->
                    <select readonly  class="form-control" name="trangthai">
                        <option value="">Chọn trạng thái</option>
                        <option value="1">Đã Duyệt</option>
                        <option value="0">Chưa Duyệt</option>
                        <?php
                        // foreach ($list2 as $item) {
                        //     echo "<option value='".$item->trangthai."'>".$item->trangthai."</option>";
                        // }
                        ?>
                    </select>

                    <!-- Hiển thị trạng thái dựa trên giá trị đã chọn -->
                    <?php
                    if (isset($_POST['trangthai'])) {
                        $selectedtrangthai = $_POST['trangthai'];
                        
                        echo "Trạng thái đã chọn: ";
                        if ($selectedtrangthai == "1") {
                            echo "Đã Duyệt";
                        } else {
                            echo "Chưa Duyệt";
                        }
                    }
                    ?>
        </div>
        <div class="col-md-4 mb-3">
                <label for="validationDefault02">Số lượng</label>
                <input type="number" class="form-control" id="validationDefault02" name="soLuong" placeholder="Nhập số lượng" required>
                <button type="submit" name="create-sp" class=" mt-2 btn-danger btn" style="margin-left: 200px;">Thêm</button>
            </div>
      
            </form>


    </div>
</form>
<?php
if(isset($_POST['create-sp'])){
  $id= $_POST["id"];
  $NgayLap= $_POST["NgayLap"];
  $ncc= $_POST["ncc"];
  $trangthai= $_POST["trangthai"];
  $ten= $_POST["ten"];
  $soLuong= $_POST["soLuong"];
    dphieu::add($id,$NgayLap,$ncc,$trangthai,$ten,$soLuong);
}
?>