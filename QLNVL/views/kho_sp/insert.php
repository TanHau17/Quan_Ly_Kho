<form method="post" name="create-kho_sp">
    <div class="form-group ml-5">
    <div class="col-md-4 mb-3">
            <!-- <label for="validationDefault01">Kho Sản Phẩm</label> -->
            <!-- <input type="text" class="form-control" id="validationDefault03" name="id_kho_sp" placeholder="id kho" required> -->
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Kho Sản Phẩm</label>
            <input type="text" class="form-control" id="validationDefault01" name="ten_kho_sp" placeholder="Tên kho" required>
        </div>
        <!-- <div class="col-md-4 mb-3">
                    <label for="validationDefault02">Trạng thái</label>
                    <select class="form-control" name="trangthai" >
                        <option value="">Chọn trạng thái</option>
                        <option value="1">Đã Duyệt</option>
                        <option value="0">Chưa Duyệt</option>
                        <?php
                            // if ($donmua->TrangThai=="1")
                            //     echo "Đã Duyệt";
                            // else echo "Chưa Duyệt";

                            ?>
                    </select>
                </div> -->

         <div class="col-md-4 mb-3">
            <label for="validationDefault02">Địa Chỉ</label>
            <input type="text" class="form-control" id="validationDefault02"name="dia_chi" placeholder="Nhập Địa Chỉ.." required>
            <button type="submit" name="create-kho_sp" class=" mt-2 btn-danger btn">Thêm</button>
        </div>
        

    </div>
</form>
<?php
if(isset($_POST['create-kho_sp'])){
    $id_kho_sp = $_POST['id_kho_sp'];
    $ten_kho_sp= $_POST["ten_kho_sp"];
    $dia_chi= $_POST["dia_chi"];
    $TrangThai= $_POST["TrangThai"];
    kho_sp::add($id_kho_sp,$ten_kho_sp,$dia_chi,$TrangThai);

}
?>