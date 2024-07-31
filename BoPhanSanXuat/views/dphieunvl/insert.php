
<?php
require_once ('connection.php');
require_once ('models/nhacungcap.php');
require_once ('models/donvitinh.php');
require_once ('models/ct_nhapnvl.php');
require_once ('models/nvl.php');
require_once ('models/dphieunvl.php');

$list1 = [];
$db1 =DB::getInstance();
$reg1 = $db1->query('SELECT * FROM NhaCungCap');
foreach ($reg1->fetchAll() as $item){
    $list1[] =new NhaCungCap($item['Id'],$item['TenNCC'],$item['DienThoai'],$item['Email'],$item['DiaChi']);
}

$sp = [];
$db_sp =DB::getInstance();
$reg_sp = $db_sp->query('SELECT * FROM DonViTinh');
foreach ($reg_sp->fetchAll() as $item){
    $sp[] =new DonViTinh($item['Id'], $item['DonVi']);
}

$nvl = [];
$db_nvl =DB::getInstance();
$reg_nvl = $db_nvl->query('SELECT * FROM nvl');
foreach ($reg_nvl->fetchAll() as $item){
    $nvl[] =new NVL($item['Id'],$item['TenNVL'],$item['IdDVT'],$item['IdNCC'],$item['SoLuong'],$item['TrangThai'],$item['id_kho_nvl']);
}

?>
<script>
    // Hàm định dạng giá tiền
    function formatCurrency(input) {
        // Loại bỏ các ký tự không phải số
        var value = input.value.replace(/[^0-9]/g, '');
        
        // Định dạng giá tiền với dấu chấm mỗi 3 số 0
        input.value = parseFloat(value).toLocaleString('en-US');
    }
</script>



<form  method="post" name="add">
    <div class="form-group">
        <FIELDSET style="border-collapse: collapse;border: 1px solid red" class="ml-5 mr-5">
            <legend class="ml-2">Phiếu Yêu Cầu Nhập Nguyên Vật Liệu</legend>
            <div class="form-group ml-5">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault01">Nhà Cung Cấp</label>
                    <select class="form-control" name="nhacungcap" id="nhacungcap">
                        <optgroup style="color: #1cc6a4" label="Chọn Nhà cung cấp">
                            <?php
                            foreach ($list1 as $item){
                                echo  "<option value='$item->Id'>".$item->TenNCC."</option>";
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-inline ml-5">


            </div>
            <div class="form-row">
                <div class="form-group col-md-3 ml-5">
                    <label for="validationDefault02">Ngày Lập</label>
                    <input type="datetime-local" class="form-control" name="ngaylap" id="ngaylap" value="<?php $ngay_hien_tai = date("Y-m-d");
                                                        echo $ngay_hien_tai;?>">
                </div>

                <!-- <div class="form-group col-md-4 ml-5">
                    <label for="validationDefault02">Trạng thái</label>
                    <select class="form-control" name="trangthai" id="trangthai">
                        <option value="">Chọn trạng thái</option>
                        <option value="1">Đã duyệt</option>
                        <option value="0">Chưa duyệt</option>
                    </select>
                </div>
                <div class="form-group col-md-2 ml-5">
                    <label for="validationDefault02">Nhân viên</label>
                    <select class="form-control" name="nhanvien">

                        <?php
                        foreach ($list as $item){
                            if ($item->TaiKhoan == $_SESSION['username'])
                                echo "<option value='$item->Id'>".$item->TenNV."</option>";
                        }
                        ?>

                    </select>
                </div> -->

            </div>
        </FIELDSET>
        <!--   end //-->
        <FIELDSET style="border-collapse: collapse;border: 1px solid red" class="mt-5 ml-5 mr-5">
            <legend class="ml-2">Chi Tiết Nguyên Vật Liệu</legend>

            <div class="form-row ml-4">

            <div class="col-md-4 form-group mb-3">
                <label class="" for="validationDefault01">Nguyên Vật Liệu</label>
                <select class="form-control" id="tennvl" name="tennvl">
                    <optgroup label="chọn sản phẩm">
                        <?php
                        foreach ($nvl as $item){
                            if ($item->SoLuong> 0) {
                                // Hiển thị tên sản phẩm và số lượng
                                echo "<option value='$item->TenNVL' data-sp_sl='$item->SoLuong' > $item->TenNVL (Số lượng:". $item->SoLuong .")</option>";
                            }
                        }
                        ?>
                    </optgroup>
                </select>
            </div>

            <div class="col-md-3 form-group mb-3">
                <label for="validationDefault01">Số lượng nhập</label>
                <input type="number" class="form-control" value="1" id="soluong" name="soluong"  placeholder="Số lượng" >
                
            </div>

            <div class="col-md-3 form-group mb-3">
                    <label for="validationDefault01">ĐVT</label>

                    <select class="form-control" id="dvt" name="dvt">

                        <?php
                        foreach ($sp as $item){
                             echo "<option value='$item->Id'>$item->DonVi</option>";
                        }
                        ?>

                    </select>
                </div>            

                <div class="col-md-1 form-group mb-3">
                    <label for="validationDefault01">Action</label>

                    <input class="form-control btn btn-outline-primary" id="btnThemSanPhammua" value="thêm">
                </div>
            </div>

            <table id="tblChiTietDonHang" class="table table-bordered">
                <thead>
                <th>NVL</th>
                <th>Số lượng</th>
                <th>Đơn vị tính</th>
                <th>Hành động</th>
                </thead>
                <tbody>
                </tbody>
            </table>

        </FIELDSET>
        <button type="submit" name="add" id="add" class=" mt-2 ml-5 btn-danger btn">Tạo </button>
    </div>
</form>
<?php


// mảng array do đặt tên name="sp_dh_dongia[]"
if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['add'])){
    $arr_ma = $_POST['sp_ma'];                   // mảng array do đặt tên name="sp_ma[]"
    $arr_soluong = $_POST['sp_dh_soluong'];   // mảng array do đặt tên name="sp_dh_SoLuongNhap[]"
    // $arr_sp_dh_dongia = str_replace(['.', ','], '', $_POST['sp_dh_dongia']);

    // mảng array do đặt tên name="sp_dh_dongia[]"
    $arr_dvt = $_POST['sp_dh_dvt'];     // mảng array do đặt tên name="sp_dh_dongia[]"
    // $arr_sp_dh_tong=[];
    // $tongdon=0;
    $date = date('m/d/Y h:i:s a', time());
    // for ($i = 0;$i< count($arr_sp_ma);$i++){
    //     $arr_sp_dh_tong[$i] = $arr_sp_dh_SoLuongNhap[$i]*$arr_sp_dh_dongia[$i];
    //     $tongdon+=$arr_sp_dh_tong[$i];
    // }

//    echo print_r($arr_sp_dh_tong);
//    echo  number_format($tongdon,0,".",",");
    
        $nhacungcap = $_POST['nhacungcap']; //id nhacc
        $trangthai = 0;   //trang thai don
        $ngaylap = $_POST['ngaylap'];   //ngay lap don
        dphieunvl::add($ngaylap,$nhacungcap,$trangthai);


    // echo print_r($arr_sp_ma);
    // echo print_r($arr_sp_dh_SoLuongNhap);
    // echo print_r($arr_sp_dh_tong);
    // echo print_r($reg_db->fetchAll());
    $dphieunvl = [];
    $db_db =DB::getInstance();
    $reg_db = $db_db->query('select * from dphieunvl ORDER BY Id DESC');
    foreach ($reg_db->fetchAll() as $item){
        $dphieunvl[] =new dphieunvl($item['id'],$item['ngaylap'],$item['idNCC'],$item['trangthai']);
    }
    $Idphieunvl = $dphieunvl[0]->Id;

    for($i = 0; $i < count($arr_ma); $i++) {

        $ma = $arr_ma[$i];
        $soluong = $arr_soluong[$i];
        $dvt =$arr_dvt[$i];
        // $sp_dh_dongia = $arr_sp_dh_dongia[$i];
        // $thanhtien =$arr_sp_dh_tong[$i];
         ct_nhapnvl::add($Idphieunvl,$ma,$dvt,$soluong);
    }
       header('location:index.php?controller=dphieunvl');
}
?>

<script>
    const quantityInput = document.getElementById('soluong');

// Bắt sự kiện khi giá trị thay đổi
    quantityInput.addEventListener('change', function() {
    // Kiểm tra nếu giá trị là số âm
    if (this.value < 0) {
        alert('Số lượng không thể là số âm');
        this.value = 0; // Đặt lại giá trị thành 0
    }
});
</script>