<?php
class TMDT
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance(); // Sử dụng hàm getInstance từ class DB để lấy kết nối PDO
    }

    public function xuatsanpham($sql)
    {
        $statement = $this->db->prepare($sql);
        $statement->execute();
    
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị tính</th>
                    <th>Nhà cung cấp</th>
                    <th>Trạng Thái</th>
                    <th>Số Lượng</th>
                    <th>Kho</th>
                </tr>
            </thead>
            <tbody>
                
                <?php 

                $totalProducts = 0;
                $approvedProducts = 0;
                $unapprovedProducts = 0;
                foreach ($result as $row) :
                    $totalProducts++;

                    // Kiểm tra TrangThai để tăng số lượng sản phẩm đã duyệt hoặc chưa duyệt
                    if ($row['TrangThai'] == 1) {
                        $approvedProducts++;
                    } else {
                        $unapprovedProducts++;
                    }
                     ?>
                    <tr>
                        <td><?= $row['Id'] ?></td>
                        <td><?= $row['TenSP'] ?></td>
                        <td><?= $this->getDonVi($row['IdDVT']) ?></td>
                        <td><?= $this->getNCC($row['IdNCC']) ?></td>
                        <td><?= $row['TrangThai'] == 1 ? 'Đã duyệt' : 'Chưa duyệt'; ?></td>
                        <td><?= $row['SoLuong'] ?></td>
                        <td><?= $this->getKSP($row['id_kho_sp'])?></td>
                        
                    </tr>

                <?php endforeach; ?>
                
                <tr>
                    <td colspan="4">Tổng số sản phẩm: <?= $totalProducts ?></td>
                    <td colspan="2">Số sản phẩm đã duyệt: <?= $approvedProducts ?></td>
                    <td colspan="2">Số sản phẩm chưa duyệt: <?= $unapprovedProducts ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <?php
    }
    
    private function getDonVi($idDVT)
{
    // Use a prepared statement to avoid SQL injection
    $sql = 'SELECT DonVi FROM donvitinh WHERE id = :idDVT';
    $statement = $this->db->prepare($sql);
    $statement->bindParam(':idDVT', $idDVT, PDO::PARAM_INT);
    $statement->execute();

    // Fetch the result from the database
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if there is data and return the unit (DonVi)
    return $result ? $result['DonVi'] : 'Undefined';
}

   
    
private function getNCC($idNCC)
{
    // Use a prepared statement to avoid SQL injection
    $sql = 'SELECT TenNCC FROM nhacungcap WHERE id = :idNCC';
    $statement = $this->db->prepare($sql);
    $statement->bindParam(':idNCC', $idNCC, PDO::PARAM_INT);
    $statement->execute();

    // Fetch the result from the database
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if there is data and return the unit (DonVi)
    return $result ? $result['TenNCC'] : 'Undefined';
}
private function getKSP($id_kho_sp)
{
    $sql = 'SELECT ten_kho_sp FROM kho_sp WHERE id_kho_sp = :id_kho_sp';
    $statement = $this->db->prepare($sql);
    $statement->bindParam(':id_kho_sp', $id_kho_sp, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['ten_kho_sp'] : 'Không xác định';
}


    


public function loadMenuKho($sql)
{
    $statement = $this->db->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                echo '<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Kho</th>
                        <th>Tên Kho</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($result as $row) {
            $id_kho_sp = $row['id_kho_sp'];
            $ten_kho_sp = $row['ten_kho_sp'];

            echo '<tr>
                    <td>' . $id_kho_sp . '</td>
                    <td><a href="?controller=kho_sp&action=thongke&id_kho_sp=' . $id_kho_sp . '">' . $ten_kho_sp . '</a></td>
                </tr>';
            }

            echo '</tbody></table>';

}


public function laySanPhamTheoKho($id_kho_sp)
{
    // Sử dụng prepared statement để tránh SQL injection
    $sql = 'SELECT * FROM sanpham WHERE id_kho_sp = :id_kho_sp';
    $statement = $this->db->prepare($sql);
    $statement->bindParam(':id_kho_sp', $id_kho_sp, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Gọi phương thức xuatsanpham để hiển thị danh sách sản phẩm
    $this->xuatsanpham($result);
}
}
?>
