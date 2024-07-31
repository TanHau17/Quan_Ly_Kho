
<?php
require_once ('models/dphieu.php');

if (isset($_POST['filterByDateRange'])) {
    $startDate = isset($_POST['startDate']) ? date('Y-m-d', strtotime($_POST['startDate'])) : null;
    $endDate = isset($_POST['endDate']) ? date('Y-m-d', strtotime($_POST['endDate'])) : null;

    // Validate and sanitize the dates if needed
    // Implement your validation logic here

    $filteredProducts = dphieu::all($startDate, $endDate);
} else {
    // If the form is not submitted, retrieve all products
    $filteredProducts = dphieu::all();
}
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Lấy ra ô checkbox "Chọn tất cả"
        var selectAllCheckbox = document.getElementById("selectAll");

        // Lấy ra tất cả các ô checkbox trong tbody
        var checkboxes = document.querySelectorAll("tbody input[type='checkbox']");

        // Thêm sự kiện click cho ô checkbox "Chọn tất cả"
        selectAllCheckbox.addEventListener("click", function () {
            // Duyệt qua tất cả các ô checkbox trong tbody và đặt trạng thái checked giống với ô "Chọn tất cả"
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Thêm sự kiện click cho mỗi ô checkbox trong tbody
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener("click", function () {
                // Nếu có một ô checkbox không được chọn, bỏ chọn ô "Chọn tất cả"
                if (!checkbox.checked) {
                    selectAllCheckbox.checked = false;
                }
            });
        });
    });
</script>
<h1 class="h3 mb-2 text-center text-gray-800 ">Phiếu Yêu Cầu Xuất NVL </h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách </h6>
    </div>
   


<div class="card-body">
    
    <div class="table-responsive">
    
    <!-- copy từ đây -->
    <?php
    // Đảm bảo biến $selectedIds được khai báo và có giá trị
    $selectedIds = isset($selectedIds) ? $selectedIds : array();
    ?>
    <?php
            // Kiểm tra nếu form được submit
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Kiểm tra nếu có danh sách sản phẩm được chọn
                if (isset($_POST["selectedItems"]) && is_array($_POST["selectedItems"])) {
                    // Lấy danh sách các ID sản phẩm đã được chọn
                    $selectedIds = $_POST["selectedItems"];

                
                    header("Location: index.php?controller=dphieu&action=duyet");
                } else {
                    echo "<script>
                        alert('Yêu cầu chọn checkbox nếu bạn muốn điều phối nhiều sản phẩm');
                    </script>";
                }
            }

            $arrayOfIds = $selectedIds;

            // Chuyển đổi mảng thành chuỗi dạng (id1, id2, ...)
            $stringOfIds = '(' . implode(',', $arrayOfIds) . ')';

            // In kết quả
            echo $stringOfIds;
            // Trong file index.php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['stringOfIds'] = '(' . implode(',', $selectedIds) . ')';

            ?>
            <!-- đến đây -->
        <form method="post" action="">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <!-- thêm vô index nvl-->  
                        <th><input type="checkbox" id="selectAll">  Chọn tất cả</th> 
                        <th>ID</th>
                        <th>Ngày lập</th>
                        <th>Nhà cung cấp</th>
                        <th>Trạng thái</th>
                        <th>Nguyên vật liệu</th>
                        <th>Số Lượng</th>
                        <th>Đơn vị tính</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>Click</th>
                    <th>ID</th>
                    <th>Ngày lập</th>
                    <th>Nhà cung cấp</th>
                    <th>Trạng thái</th>
                    <th>Nguyên vật liệu</th>
                    <th>Số Lượng</th>
                    <th>Đơn vị tính</th>
                    <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($filteredProducts as $item) { ?>
                        <tr>
                        <td><input type="checkbox" name="selectedItems[]" value="<?= $item->id ?>"></td>
                            <td><?= $item->id   ?></td>
                            <td><?= $item->ngaylap?></td>
                            <td><?= $item->idNCC?></td>
                            <td><?= $item->trangthai?></td>
                            <td><?= $item->idNVL?></td> 
                            <td><?= $item->soLuong?></td> 
                            <td><?= $item->idDVT?></td> 
                            <td>
                                <?php echo ($item->trangthai == "1") ? "Đã Duyệt" : "Chưa Duyệt"; ?>
                            </td>
                            

                            <td><?= $item->id ?></td>
                            <td>
                                
                                <a href="index.php?controller=dphieu&action=dpnvl&id=<?= $item->id ?>" class='btn btn-success mr-3'>Điều phối</a>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
                        <button  type="submit" class="btn btn-success" name="submit">Xác nhận</button>
            <!-- Add other actions or buttons here -->
        </form>
    </div>
</div>




<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    dphieu::delete($id);
}

?>


