<?php
class dphieutp{

    public $Id;
    public $NgayLap;
    public $IdNCC;
    public $IdSP;
    public $TrangThai;


    function __construct($Id,$NgayLap,$IdNCC,$IdSP,$TrangThai)
    {
        $this->Id = $Id;
        $this->NgayLap = $NgayLap;
        $this->IdNCC = $IdNCC;
        $this->IdSP= $IdSP;
        $this->TrangThai= $TrangThai;
    }
    static function all()
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT db.Id ,db.NgayLap ,kh.TenNCC ,db.IdSP,db.TrangThai
         FROM dphieutp db 
         JOIN NhaCungCap kh ON kh.Id = db.IdNCC');
        foreach ($reg->fetchAll() as $item){
            $list[] =new dphieutp($item['Id'],$item['NgayLap'],$item['TenNCC'],$item['IdSP'],$item['TrangThai']);
        }
        return $list;
    }
    
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT db.Id ,db.NgayLap ,kh.TenNCC ,db.IdSP,db.TrangThai 
        FROM dphieutp db JOIN NhaCungCap kh ON kh.Id = db.IdNCC WHERE db.Id = '.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new dphieutp($item['Id'],$item['NgayLap'],$item['TenNCC'],$item['IdSP'],$item['TrangThai']);
        }
        return null;
    }
    static function add($NgayLap,$IdNCC,$IdSP,$TrangThai)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO dphieutp(NgayLap,IdNCC,IdSP,TrangThai) 
        VALUES ("'.$NgayLap.'",'.$IdNCC.','.$IdSP.',"'.$TrangThai.'")');

    }

    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE dphieutp SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE dphieutp SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        // $reg =$db->query('DELETE FROM sa WHERE IdPhieuNhap='.$id);
        $reg1 =$db->query('DELETE FROM dphieutp WHERE Id = '.$id);
        header('location:index.php?controller=dphieutp&action=index');
    }

    

}
