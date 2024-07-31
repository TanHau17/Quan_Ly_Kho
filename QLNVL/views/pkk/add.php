<?php
        require_once ('models/kho_sp.php');
        require_once ('models/sanpham.php');

        $list2 = [];
        $db2 =DB::getInstance();
        $data2 =array('sanpham'=> $list2);
        $reg2 = $db2->query('select * from Sanpham');
        foreach ($reg2->fetchAll() as $item){
            $list2[] =new Sanpham($item['Id'],$item['TenSP'],$item['IdDVT'],$item['IdNCC'],$item['NgayNhap'],$item['SoLuong'],$item['TrangThai'],$item['id_kho_sp']);
                        }
        $data2 =array('sanpham'=> $list2);

        $list3 = [];
        $db3 =DB::getInstance();
        $data3 =array('kho_sp'=> $list3);
        $reg3 = $db3->query('select * from kho_sp');
        foreach ($reg3->fetchAll() as $item){
            $list3[] =new kho_sp($item['id_kho_sp'],$item['ten_kho_sp'],$item['dia_chi']);
                        }
        $data3 =array('kho_sp'=> $list3);
    
                

?>
<form method="post" name="create-pkk">
    <div class="form-group ml-5">
        <div class="col-md-4 mb-3">
            <!-- <label for="validationDefault01">Kho Sản Phẩm</label> -->
            <!-- <input type="text" class="form-control" id="validationDefault03" name="id_kho_sp" placeholder="id kho" required> -->
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Ngày kiểm kê</label>
            <input type="datetime-local" class="form-control" id="validationDefault01" name="ngayKK" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Sản phẩm</label>
            <select class="form-control" id="lsp_ma" name="IdSP">
                <?php foreach ($list2 as $item) {
                    echo "<option value=".$item->Id.">".$item->TenSP."</option>";
                } ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label  for="validationDefault02">Kho sản phẩm</label>
            <select   class="form-control" id="ksp" name="id_kho_sp">
                <option value="">Chọn kho</option>
                <?php foreach ($list3 as $item) {
                    echo "<option value=".$item->id_kho_sp.">".$item->ten_kho_sp."</option>";
                } ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Ghi chú</label>
            <input type="text" class="form-control" id="validationDefault02" name="ghichu" placeholder="Nhập ghi chú.." required>
            <button type="submit" name="create-pkk" class="mt-2 btn-danger btn">Thêm</button>
        </div>
    </div>
</form>

<?php
if(isset($_POST['create-pkk'])){
    $Id=$_POST['Id'];
    $ngayKK = $_POST["ngayKK"];
    $IdSP = $_POST["IdSP"];
    $id_kho_sp = $_POST["id_kho_sp"];
    $ghichu = $_POST["ghichu"];
    pkk::add($Id,$ngayKK, $IdSP, $id_kho_sp, $ghichu);
}
?>
