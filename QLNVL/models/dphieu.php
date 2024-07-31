<?php
class dphieu{
    public $id;
    public $ngaylap;
    public $idNCC;
	public $trangthai;
	public $idNVL;
	public $soLuong;
	public $idDVT;


    function __construct($id,$ngaylap,$idNCC, $trangthai, $idNVL, $soLuong, $idDVT)
    {
        $this->id=$id;
        $this->ngaylap=$ngaylap;
        $this->idNCC=$idNCC;
		$this->trangthai=$trangthai;
		$this->idNVL=$idNVL;
        $this->soLuong = $soLuong;
        $this->idDVT = $idDVT;
		

    }
   
   
    static function all()
    {
        $list = [];
        $db = DB::getInstance();
        $reg = $db->query('SELECT dp.Id,dp.ngaylap, ncc.TenNCC, dp.trangthai, nvl.TenNVL,nvl.SoLuong,nvl.IdDVT 
                   FROM dphieu dp 
                   JOIN NhaCungCap ncc ON dp.idNCC = ncc.Id 
                   JOIN nvl nvl ON dp.idNVL = nvl.Id');

        foreach ($reg->fetchAll() as $item) {
            $list[] = new dphieu($item['Id'], $item['ngaylap'], $item['TenNCC'],$item['trangthai'],$item['TenNVL'],$item['SoLuong'],$item['IdDVT']);
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
                return  new dphieu($item['Id'], $item['ngaylap'], $item['TenNCC'],$item['trangthai'],$item['TenNVL'],$item['SoLuong'],$item['IdDVT']);
        }
        return null;
    }

    static function update($id,$ngaylap, $idNCC,$trangthai,$idNVL,$soLuong,$idDVT)
    {
        $db = DB::getInstance();
    
        // Sử dụng prepared statement để tránh SQL injection
        $query = 'UPDATE dphieu 
                  SET TenNVL = ?, IdDVT = ?, IdNCC = ?, SoLuong = ?, TrangThai = ?, 
                  WHERE Id = ?';
    
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(1, $id);
        $statement->bindParam(2, $idDVT);
        $statement->bindParam(3, $idNCC);
        $statement->bindParam(5, $soLuong);
        $statement->bindParam(6, $trangthai);
        $statement->bindParam(7, $ngaylap);
        $statement->bindParam(8, $idNVL);
    
        // Thực thi truy vấn
        if ($statement->execute()) {
            // Truy vấn thành công
            header('location:index.php?controller=dphieu&action=index');
        } else {
            // Xử lý lỗi (ví dụ: hiển thị thông báo)
            echo "Lỗi khi cập nhật dữ liệu.";
        }
    }

// Hàm cập nhật Trạng Thái và Kho cho danh sách sản phẩm dựa trên mảng ID
function updateProducts($selectedIds, $id) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=db_quanlykho", "root", "");

        foreach ($selectedIds as $Id) {
            // Cập nhật Trạng Thái và Kho cho sản phẩm có ID là $productId
            $query = "UPDATE dphieu SET TrangThai = '1', id_kho_nvl = :id_kho_nvl WHERE Id = :Id";

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

    // static function add($id, $ten, $IdDVT, $IdNCC, $soluong, $TrangThai, $id_kho_nvl)
    // {
    //     $db = DB::getInstance();
    //     $query = 'INSERT INTO nvl(Id, TenNVL, IdDVT, IdNCC, SoLuong, TrangThai, id_kho_nvl) VALUES (:id, :ten, :IdDVT, :IdNCC, :soluong, :TrangThai, :id_kho_nvl)';
        
    //     // Sử dụng prepared statement để tránh SQL injection
    //     $statement = $db->prepare($query);
    
    //     // Bind các giá trị
    //     $statement->bindParam(':id', $id);
    //     $statement->bindParam(':ten', $ten);
    //     $statement->bindParam(':IdDVT', $IdDVT);
    //     $statement->bindParam(':IdNCC', $IdNCC);
    //     $statement->bindParam(':soluong', $soluong);
    //     $statement->bindParam(':TrangThai', $TrangThai);
    //     $statement->bindParam(':id_kho_nvl', $id_kho_nvl);
    
    //     // Thực thi truy vấn
    //     $statement->execute();
        
    //     // Chuyển hướng đến trang index sau khi thêm dữ liệu
    //     header('location:index.php?controller=nvl&action=index');
    // }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM dphieu WHERE id='.$id);
        header('location:index.php?controller=dphieu&action=index');
    }
    
}