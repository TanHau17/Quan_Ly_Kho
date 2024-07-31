<?php
class SanPham
{
    public $Id;
    public $TenSP;
    public $IdDVT;
    public $IdNCC;
    // public $GiaMua;
    public $NgayNhap;
    public $SoLuong;
    public $TrangThai;
    public $id_kho_sp;



    function   __construct($Id,$TenSP,$IdDVT,$IdNCC,$NgayNhap,$SoLuong,$TrangThai,$id_kho_sp)
    {
        $this->Id=$Id;
        $this->TenSP=$TenSP;
        $this->IdDVT=$IdDVT;
        $this->IdNCC=$IdNCC;
        // $this->GiaMua=$GiaMua;
        $this->NgayNhap=$NgayNhap;
        $this->SoLuong=$SoLuong;
        $this->TrangThai=$TrangThai;
        $this->id_kho_sp = $id_kho_sp;


    }
    
    static function all($startDate = null, $endDate = null)
{
    $db = DB::getInstance();

    $query = 'SELECT sp.Id, sp.TenSP, dvt.DonVi, ncc.TenNCC, sp.NgayNhap, sp.SoLuong, sp.TrangThai, ksp.ten_kho_sp 
              FROM SanPham sp 
              JOIN DonViTinh dvt ON sp.IdDVT = dvt.Id 
              JOIN NhaCungCap ncc ON sp.IdNCC = ncc.Id 
              JOIN kho_sp ksp ON sp.id_kho_sp = ksp.id_kho_sp';

        if ($startDate && $endDate) {
            $query .= ' WHERE sp.NgayNhap BETWEEN :startDate AND :endDate';
        }

        $reg = $db->prepare($query);

        // Kiểm tra xem prepare có thành công không
        if (!$reg) {
            // Xử lý lỗi nếu cần thiết
            die('Lỗi trong quá trình chuẩn bị truy vấn.');
        }

        if ($startDate && $endDate) {
            $reg->bindParam(':startDate', $startDate);
            $reg->bindParam(':endDate', $endDate);
        }

        // Kiểm tra xem execute có thành công không
        if (!$reg->execute()) {
            // Xử lý lỗi nếu cần thiết
            die('Lỗi trong quá trình thực thi truy vấn.');
        }

        $list = [];
        $result = $reg->fetchAll();

        foreach ($result as $item) {
            $list[] = new SanPham($item['Id'], $item['TenSP'], $item['DonVi'], $item['TenNCC'], $item['NgayNhap'], $item['SoLuong'], $item['TrangThai'], $item['ten_kho_sp']);
        }

        return $list;
        }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM SanPham WHERE Id ='.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
                return new SanPham($item['Id'], $item['TenSP'], $item['IdDVT'],$item['IdNCC'],$item['NgayNhap'], $item['SoLuong'],$item['TrangThai'],$item['id_kho_sp']);
        }
        return null;
    }

    
    static function add($id, $ten, $IdDVT, $IdNCC,$NgayNhap, $soluong, $TrangThai, $id_kho_sp)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO SanPham(Id, TenSP, IdDVT, IdNCC, NgayNhap, SoLuong, TrangThai, id_kho_sp) VALUES (:id, :ten, :IdDVT, :IdNCC,:NgayNhap, :soluong, :TrangThai, :id_kho_sp)';
        
        // Sử dụng prepared statement để tránh SQL injection
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(':id', $id);
        $statement->bindParam(':ten', $ten);
        $statement->bindParam(':IdDVT', $IdDVT);
        $statement->bindParam(':IdNCC', $IdNCC);
        $statement->bindParam(':NgayNhap', $NgayNhap);
        $statement->bindParam(':soluong', $soluong);
        $statement->bindParam(':TrangThai', $TrangThai);
        $statement->bindParam(':id_kho_sp', $id_kho_sp);
    
        // Thực thi truy vấn
        $statement->execute();
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=sanpham&action=index');
    }
    
    static function update($id, $ten, $IdDVT, $IdNCC,$NgayNhap ,$soluong, $TrangThai, $id_kho_sp)
    {
        $db = DB::getInstance();
    
        // Sử dụng prepared statement để tránh SQL injection
        $query = 'UPDATE SanPham 
                  SET TenSP = ?, IdDVT = ?, IdNCC = ?, NgayNhap = ?, SoLuong = ?, TrangThai = ?, id_kho_sp = ? 
                  WHERE Id = ?';
    
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(1, $ten);
        $statement->bindParam(2, $IdDVT);
        $statement->bindParam(3, $IdNCC);
        $statement->bindParam(4, $NgayNhap);
        $statement->bindParam(5, $soluong);
        $statement->bindParam(6, $TrangThai);
        $statement->bindParam(7, $id_kho_sp);
        $statement->bindParam(8, $id);
    
        // Thực thi truy vấn
        if ($statement->execute()) {
            // Truy vấn thành công
            header('location:index.php?controller=sanpham&action=index');
        } else {
            // Xử lý lỗi (ví dụ: hiển thị thông báo)
            echo "Lỗi khi cập nhật dữ liệu.";
        }
    }

// Hàm cập nhật Trạng Thái và Kho cho danh sách sản phẩm dựa trên mảng ID
function updateProducts($selectedIds, $id_kho_sp) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=db_quanlykho", "root", "");

        foreach ($selectedIds as $Id) {
            // Cập nhật Trạng Thái và Kho cho sản phẩm có ID là $productId
            $query = "UPDATE SanPham SET TrangThai = '1', id_kho_sp = :id_kho_sp WHERE Id = :Id";

            $statement = $pdo->prepare($query);
            $statement->bindParam(':Id', $Id);
            $statement->bindParam(':id_kho_sp', $id_kho_sp);

            if ($statement->execute()) {
                echo "Cập nhật thành công cho sản phẩm có ID $Id.<br>";
            } else {
                echo "Lỗi khi cập nhật sản phẩm có ID $Id: " . $pdo->errorInfo()[2] . "<br>";
            }
        }
    } catch (PDOException $e) {
        die("Lỗi kết nối đến CSDL: " . $e->getMessage());
    }
}


// Kiểm tra nếu form được submit
//     if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Kiểm tra nếu có danh sách sản phẩm được chọn
//     if (isset($_POST["selectedItems"]) && is_array($_POST["selectedItems"])) {
//         // Lấy danh sách các ID sản phẩm đã được chọn
//         $selectedIds = $_POST["selectedItems"];

//         // Gọi hàm để cập nhật sản phẩm
//         updateProducts($selectedIds);
//     } else {
//         echo "Không có sản phẩm nào được chọn.";
//     }
// }

    static function updatesl($id,$soluong)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE SanPham SET SoLuong="'.$soluong.'" WHERE Id='.$id);
    }
    static function updateksp($id,$id_kho_sp)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE SanPham SET SoLuong="'.$id_kho_sp.'" WHERE Id='.$id);
    }
    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE SanPham SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE SanPham SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM SanPham WHERE Id='.$id);
        header('location:index.php?controller=sanpham&action=index');
    }
}