<?php
class pkk
{
    public $Id;
    public $ngayKK;
    public $IdSP;
    // public $GiaMua;
    // public $GiaBan;
    public $SoLuong;
    public $TrangThai;
    public $id_kho_sp;



    function   __construct($Id,$TenSP,$IdDVT,$IdNCC,$SoLuong,$TrangThai,$id_kho_sp)
    {
        $this->Id=$Id;
        $this->TenSP=$TenSP;
        $this->IdDVT=$IdDVT;
        $this->IdNCC=$IdNCC;
        // $this->GiaMua=$GiaMua;
        // $this->GiaBan=$GiaBan;
        $this->SoLuong=$SoLuong;
        $this->TrangThai=$TrangThai;
        $this->id_kho_sp = $id_kho_sp;


    }
    
    static function all()
    {
        $list = [];
        $db = DB::getInstance();
        $reg = $db->query('SELECT sp.Id, sp.TenSP, dvt.DonVi, ncc.TenNCC, sp.SoLuong, sp.TrangThai, ksp.ten_kho_sp 
                   FROM pkk sp 
                   JOIN DonViTinh dvt ON sp.IdDVT = dvt.Id 
                   JOIN NhaCungCap ncc ON sp.IdNCC = ncc.Id 
                   JOIN kho_sp ksp ON sp.id_kho_sp = ksp.id_kho_sp');

        foreach ($reg->fetchAll() as $item) {
            $list[] = new pkk($item['Id'], $item['TenSP'], $item['DonVi'],$item['TenNCC'],$item['SoLuong'],$item['TrangThai'],$item['ten_kho_sp']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM pkk WHERE Id ='.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
                return new pkk($item['Id'], $item['TenSP'], $item['IdDVT'],$item['IdNCC'], $item['SoLuong'],$item['TrangThai'],$item['id_kho_sp']);
        }
        return null;
    }
    static function add($id, $ten, $IdDVT, $IdNCC, $soluong, $TrangThai, $id_kho_sp)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO pkk(Id, TenSP, IdDVT, IdNCC, SoLuong, TrangThai, id_kho_sp) VALUES (:id, :ten, :IdDVT, :IdNCC, :soluong, :TrangThai, :id_kho_sp)';
        
        // Sử dụng prepared statement để tránh SQL injection
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(':id', $id);
        $statement->bindParam(':ten', $ten);
        $statement->bindParam(':IdDVT', $IdDVT);
        $statement->bindParam(':IdNCC', $IdNCC);
        $statement->bindParam(':soluong', $soluong);
        $statement->bindParam(':TrangThai', $TrangThai);
        $statement->bindParam(':id_kho_sp', $id_kho_sp);
    
        // Thực thi truy vấn
        $statement->execute();
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=pkk&action=index');
    }
    
    static function update($id, $ten, $IdDVT, $IdNCC, $soluong, $TrangThai, $id_kho_sp)
    {
        $db = DB::getInstance();
    
        // Sử dụng prepared statement để tránh SQL injection
        $query = 'UPDATE pkk 
                  SET TenSP = ?, IdDVT = ?, IdNCC = ?, SoLuong = ?, TrangThai = ?, id_kho_sp = ? 
                  WHERE Id = ?';
    
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(1, $ten);
        $statement->bindParam(2, $IdDVT);
        $statement->bindParam(3, $IdNCC);
        $statement->bindParam(4, $soluong);
        $statement->bindParam(5, $TrangThai);
        $statement->bindParam(6, $id_kho_sp);
        $statement->bindParam(7, $id);
    
        // Thực thi truy vấn
        if ($statement->execute()) {
            // Truy vấn thành công
            header('location:index.php?controller=pkk&action=index');
        } else {
            // Xử lý lỗi (ví dụ: hiển thị thông báo)
            echo "Lỗi khi cập nhật dữ liệu.";
        }
    }
    static function updatedp($id, $TrangThai, $id_kho_sp)
{
    $db = DB::getInstance();

    // Sử dụng prepared statement để tránh SQL injection
    $query = 'UPDATE pkk 
              SET TrangThai = ?, id_kho_sp = ? 
              WHERE Id = ?';

    $statement = $db->prepare($query);

    // Bind các giá trị
    $statement->bindParam(1, $TrangThai);
    $statement->bindParam(2, $id_kho_sp);
    $statement->bindParam(3, $id);

    // Thực thi truy vấn
    if ($statement->execute()) {
        // Truy vấn thành công
        header('location:index.php?controller=pkk&action=index');
    } else {
        // Xử lý lỗi (ví dụ: hiển thị thông báo)
        echo "Lỗi khi cập nhật dữ liệu.";
    }
}


    static function updatesl($id,$soluong)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE pkk SET SoLuong="'.$soluong.'" WHERE Id='.$id);
    }
    static function updateksp($id,$id_kho_sp)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE pkk SET SoLuong="'.$id_kho_sp.'" WHERE Id='.$id);
    }
    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE pkk SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE pkk SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM pkk WHERE Id='.$id);
        header('location:index.php?controller=pkk&action=index');
    }
}