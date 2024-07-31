<?php
class NVL
{
    public $Id;
    public $TenNVL;
    public $IdDVT;
    public $IdNCC;
    public $SoLuong;
    public $TrangThai;
    public $id_kho_nvl;



    function   __construct($Id,$TenNVL,$IdDVT,$IdNCC,$SoLuong,$TrangThai,$id_kho_nvl)
    {
        $this->Id=$Id;
        $this->TenNVL=$TenNVL;
        $this->IdDVT=$IdDVT;
        $this->IdNCC=$IdNCC;
        $this->SoLuong=$SoLuong;
        $this->TrangThai=$TrangThai;
        $this->id_kho_nvl = $id_kho_nvl;


    }
    
    static function all($startDate = null, $endDate = null)
{
    $db = DB::getInstance();

    $query = 'SELECT nvl.Id, nvl.TenNVL, dvt.DonVi, ncc.TenNCC,  nvl.SoLuong, nvl.TrangThai, knvl.ten_kho_nvl 
              FROM nvl nvl 
              JOIN DonViTinh dvt ON nvl.IdDVT = dvt.Id 
              JOIN NhaCungCap ncc ON nvl.IdNCC = ncc.Id 
              JOIN kho_nvl knvl ON nvl.id_kho_nvl = knvl.id_kho_nvl';

        if ($startDate && $endDate) {
            $query .= ' WHERE nvl.NgayNhap BETWEEN :startDate AND :endDate';
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
            $list[] = new NVL($item['Id'], $item['TenNVL'], $item['DonVi'], $item['TenNCC'],  $item['SoLuong'], $item['TrangThai'], $item['ten_kho_nvl']);
        }

        return $list;
        }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM nvl WHERE Id ='.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
                return new NVL($item['Id'], $item['TenNVL'], $item['IdDVT'],$item['IdNCC'], $item['SoLuong'],$item['TrangThai'],$item['id_kho_nvl']);
        }
        return null;
    }

    
    static function add($id, $ten, $IdDVT, $IdNCC, $soluong, $TrangThai, $id_kho_nvl)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO nvl(Id, TenNVL, IdDVT, IdNCC, SoLuong, TrangThai, id_kho_nvl) VALUES (:id, :ten, :IdDVT, :IdNCC, :soluong, :TrangThai, :id_kho_nvl)';
        
        // Sử dụng prepared statement để tránh SQL injection
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(':id', $id);
        $statement->bindParam(':ten', $ten);
        $statement->bindParam(':IdDVT', $IdDVT);
        $statement->bindParam(':IdNCC', $IdNCC);
        $statement->bindParam(':soluong', $soluong);
        $statement->bindParam(':TrangThai', $TrangThai);
        $statement->bindParam(':id_kho_nvl', $id_kho_nvl);
    
        // Thực thi truy vấn
        $statement->execute();
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=nvl&action=index');
    }
    
    static function update($id, $ten, $IdDVT, $IdNCC,$soluong, $TrangThai, $id_kho_nvl)
    {
        $db = DB::getInstance();
    
        // Sử dụng prepared statement để tránh SQL injection
        $query = 'UPDATE nvl 
                  SET TenNVL = ?, IdDVT = ?, IdNCC = ?, SoLuong = ?, TrangThai = ?, id_kho_nvl = ? 
                  WHERE Id = ?';
    
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(1, $ten);
        $statement->bindParam(2, $IdDVT);
        $statement->bindParam(3, $IdNCC);
        $statement->bindParam(5, $soluong);
        $statement->bindParam(6, $TrangThai);
        $statement->bindParam(7, $id_kho_nvl);
        $statement->bindParam(8, $id);
    
        // Thực thi truy vấn
        if ($statement->execute()) {
            // Truy vấn thành công
            header('location:index.php?controller=nvl&action=index');
        } else {
            // Xử lý lỗi (ví dụ: hiển thị thông báo)
            echo "Lỗi khi cập nhật dữ liệu.";
        }
    }

// Hàm cập nhật Trạng Thái và Kho cho danh sách sản phẩm dựa trên mảng ID
function updateProducts($selectedIds, $id_kho_nvl) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=db_quanlykho", "root", "");

        foreach ($selectedIds as $Id) {
            // Cập nhật Trạng Thái và Kho cho sản phẩm có ID là $productId
            $query = "UPDATE nvl SET TrangThai = '1', id_kho_nvl = :id_kho_nvl WHERE Id = :Id";

            $statement = $pdo->prepare($query);
            $statement->bindParam(':Id', $Id);
            $statement->bindParam(':id_kho_nvl', $id_kho_nvl);

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
        $reg =$db->query('UPDATE nvl SET SoLuong="'.$soluong.'" WHERE Id='.$id);
    }
    static function updateksp($id,$id_kho_nvl)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE nvl SET SoLuong="'.$id_kho_nvl.'" WHERE Id='.$id);
    }
    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE nvl SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE nvl SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM nvl WHERE Id='.$id);
        header('location:index.php?controller=nvl&action=index');
    }
}