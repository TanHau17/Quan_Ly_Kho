<?php
class DonMua{

    public $Id;
    public $NgayMua;
    public $id_kho_sp;
    public $IdNCC;
    public $ThanhTien;
    public $TrangThai;


    function __construct($Id,$NgayMua,$id_kho_sp,$IdNCC,$ThanhTien,$TrangThai)
    {
        $this->Id = $Id;
        $this->NgayMua = $NgayMua;
        $this->id_kho_sp =  $id_kho_sp;
        $this->IdNCC = $IdNCC;
        $this->ThanhTien= $ThanhTien;
        $this->TrangThai= $TrangThai;
    }
    static function all()
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT db.Id ,db.NgayMua , ksp.ten_kho_sp ,kh.TenNCC ,db.ThanhTien,db.TrangThai
         FROM DonMua db 
         JOIN kho_sp ksp 
         JOIN NhaCungCap kh ON ksp.id_kho_sp =db.id_kho_sp AND kh.Id = db.IdNCC');
        foreach ($reg->fetchAll() as $item){
            $list[] =new DonMua($item['Id'],$item['NgayMua'],$item['ten_kho_sp'],$item['TenNCC'],$item['ThanhTien'],$item['TrangThai']);
        }
        return $list;
    }
    
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT db.Id ,db.NgayMua , ksp.ten_kho_sp ,kh.TenNCC ,db.ThanhTien,db.TrangThai 
        FROM DonMua db JOIN kho_sp ksp JOIN NhaCungCap kh ON ksp.id_kho_sp =db.id_kho_sp AND kh.Id = db.IdNCC WHERE db.Id = '.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new DonMua($item['Id'],$item['NgayMua'],$item['ten_kho_sp'],$item['TenNCC'],$item['ThanhTien'],$item['TrangThai']);
        }
        return null;
    }
    static function add($ngayban,$id_kho_sp,$IdNCC,$Tong,$TrangThai)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO DonMua(NgayMua,id_kho_sp,IdNCC,ThanhTien,TrangThai) 
        VALUES ("'.$ngayban.'",'.$id_kho_sp.','.$IdNCC.','.$Tong.',"'.$TrangThai.'")');

    }

    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE DonMua SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE DonMua SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM ChiTietMua WHERE IdDonMua='.$id);
        $reg1 =$db->query('DELETE FROM DonMua WHERE Id = '.$id);
        header('location:index.php?controller=donmua&action=index');
    }

}
