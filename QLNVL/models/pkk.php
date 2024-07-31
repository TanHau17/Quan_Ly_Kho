<?php
class pkk
{
    public $Id;
    public $ngayKK;
    public $IdSP;
    // public $GiaMua;
    public $id_kho_sp;
    public $ghichu;



    function   __construct($Id,$ngayKK,$IdSP,$id_kho_sp,$ghichu)
    {
        $this->Id=$Id;
        $this->ngayKK=$ngayKK;
        $this->IdSP=$IdSP;
        // $this->GiaMua=$GiaMua;
        // $this->GiaBan=$GiaBan;
        $this->id_kho_sp = $id_kho_sp;
        $this->ghichu = $ghichu;


    }
    
    
    static function all()
    {
        $list = [];
        $db = DB::getInstance();
        $reg = $db->query('SELECT kk.Id, kk.ngayKK,sp.TenSP,sp.SoLuong,ksp.ten_kho_sp,kk.ghichu 
                   FROM pkk kk 
                   JOIN SanPham sp ON kk.IdSP = sp.Id 
                   JOIN kho_sp ksp ON kk.id_kho_sp = ksp.id_kho_sp');

        foreach ($reg->fetchAll() as $item) {
            $list[] = new pkk($item['Id'], $item['ngayKK'], $item['TenSP'],$item['SoLuong'],$item['ten_kho_sp'],$item['ghichu']);
        }
        return $list;
    }
    static function find($id)
    {
        // Tắt hiển thị thông báo lỗi
error_reporting(0);

// Hoặc nếu bạn chỉ muốn tắt hiển thị thông báo "Undefined index"
error_reporting(E_ALL & ~E_NOTICE);

        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM pkk WHERE Id ='.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
                return new pkk($item['Id'], $item['ngayKK'], $item['TenSP'],$item['SoLuong'],$item['id_kho_sp'],$item['ghichu']);
        }
        return null;
    }
    static function add($id,$ngayKK, $IdSP, $id_kho_sp,$ghichu)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO pkk(Id, ngayKK, IdSP, id_kho_sp, ghichu) VALUES (:id, :ngayKK, :IdSP, :id_kho_sp, :ghichu)';
        
        // Sử dụng prepared statement để tránh SQL injection
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(':id', $id);
        $statement->bindParam(':ngayKK', $ngayKK);
        $statement->bindParam(':IdSP', $IdSP);
        $statement->bindParam(':id_kho_sp', $id_kho_sp);
        $statement->bindParam(':ghichu', $ghichu);
    
        // Thực thi truy vấn
        $statement->execute();
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=pkk&action=index');
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