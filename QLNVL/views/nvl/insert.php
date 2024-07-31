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
     
        //end dvt
        $list1 = [];
        $db1 =DB::getInstance();
        $reg1 = $db1->query('select * from NhaCungCap');
        foreach ($reg1->fetchAll() as $item){
            $list1[] =new NhaCungCap($item['Id'],$item['TenNCC'],$item['DienThoai'],$item['Email'],$item['DiaChi']);
        }
        $data1 =array('nhacungcap'=> $list1);
        //ncc

        $list2 = [];
        $db2 =DB::getInstance();
        $data2 =array('nvl'=> $list2);
        $reg2 = $db2->query('select * from nvl');
        foreach ($reg2->fetchAll() as $item){
            $list2[] =new NVL($item['Id'],$item['TenNVL'],$item['IdDVT'],$item['IdNCC'],$item['SoLuong'],$item['TrangThai'],$item['id_kho_nvl']);
                        }
        $data2 =array('nvl'=> $list2);
        //
        $list3 = [];
        $db3 =DB::getInstance();
        $data3 =array('kho_nvl'=> $list3);
        $reg3 = $db3->query('select * from kho_nvl');
        foreach ($reg3->fetchAll() as $item){
            $list3[] =new kho_nvl($item['id_kho_nvl'],$item['ten_kho_nvl'],$item['dia_chi']);
                        }
        $data3 =array('kho_nvl'=> $list3);
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<center>
    <form method="post" name="create-nvl" >
<!-- <div class="col-md-4 mb-3">
            <label for="validationDefault02">id Sản Phẩm</label>
            <input type="text" class="form-control" id="validationDefault02" name="id" placeholder="Nhập id sản phẩm" required>
        </div> -->
     <div class="col-md-4 mb-3">
            <label for="validationDefault02">Tên Nguyên Vật Liệu</label>
            <input  type="text" class="form-control" id="validationDefault02" name="ten" placeholder="Nhập Tên" required>
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
            <label for="validationDefault02">Nhà Cung Cấp</label>
            <select class="form-control" id="lsp_ma" name="ncc">
                <?php foreach ($list1 as $item) {
                   echo "<option value=".$item->Id.">".$item->TenNCC ."</option>";
                 } ?>
            </select>
        </div>
        <form method="post" action="">
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Kho nguyên vật liệu</label>
            <select class="form-control" id="knvl" name="knvl">
            <option value="">Chọn kho</option>

                <?php 
                foreach ($list3 as $item) {
                   echo "<option value=".$item->id_kho_nvl.">".$item->ten_kho_nvl ."</option>";
                 }
                  ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
                    <label for="validationDefault02">Trạng thái</label>
                   <!-- Dropdown -->
                    <select readonly  class="form-control" name="TrangThai">
                        <option value="">Chọn trạng thái</option>
                        <option value="1">Đã Duyệt</option>
                        <option value="0">Chưa Duyệt</option>
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
                <input type="number" class="form-control" id="validationDefault02" name="soluong" placeholder="Nhập số lượng" required>
                <button type="submit" name="create-nvl" class=" mt-2 btn-danger btn">Thêm</button>
            </div>
         </form>

        </div>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#knvl').change(function () {
            var id_kho_nvl = $(this).val();
            var trangThaiDropdown = $('select[name="TrangThai"]');

            // Check the condition and set TrangThai accordingly
            if (id_kho_nvl > 0) {
                trangThaiDropdown.val("1"); // Set to "Đã Duyệt"
            } else {
                trangThaiDropdown.val("0"); // Set to "Chưa Duyệt"
            }
        });
    });
</script>

<?php
if(isset($_POST['create-nvl'])){
    $ten= $_POST["ten"];
    $id = $nvl->Id;
    $dvt= $_POST["dvt"];
    $ncc= $_POST["ncc"];
    $soluong= $_POST["soluong"];
    $TrangThai= $_POST["TrangThai"];
    $knvl = $_POST["knvl"];
    NVL::add($id,$ten,$dvt,$ncc,$soluong,$TrangThai,$knvl);
}
?>

