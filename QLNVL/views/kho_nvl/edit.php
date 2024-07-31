<form method="post" name="edit-knvl">
    <div class="form-group ml-5">
        <!-- <div class="col-md-4 mb-3">
            <label for="validationDefault01">id</label>
            <input type="text" class="form-control" id="validationDefault01" value="<?= $kho_nvl->id_kho_nvl ?> " name="id" placeholder="Id" readonly required>
        </div> -->
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Tên kho</label>
            <input type="phone" class="form-control" id="validationDefault02" value="<?= $kho_nvl->ten_kho_nvl ?> " name="ten_kho_nvl" placeholder="Số điện thoại" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Địa chỉ</label>
            <input type="phone" class="form-control" id="validationDefault02" value="<?= $kho_nvl->dia_chi ?> " name="dia_chi" placeholder="Số điện thoại" required>
            <button type="submit" name="edit-dvt" class=" mt-2 btn-danger btn">Update</button>
        </div>
    </div>
</form>
<?php
if(isset($_POST['edit-knvl'])){
    $id_kho_nvl = $kho_nvl->id_kho_nvl;
    $ten_kho_nvl= $_POST['ten_kho_nvl']; ;
    $dia_chi= $_POST['dia_chi'] ;

    kho_nvl::update($id_kho_nvl,$ten_kho_nvl,$dia_chi);
}
?>
