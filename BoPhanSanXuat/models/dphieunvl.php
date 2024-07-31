<?php
class dphieunvl{

    public $Id;
    public $NgayLap;
    public $IdNCC;
    public $TrangThai;


    function __construct($Id,$NgayLap,$IdNCC,$TrangThai)
    {
        $this->Id = $Id;
        $this->NgayLap = $NgayLap;
        $this->IdNCC = $IdNCC;
        $this->TrangThai= $TrangThai;
    }
    static function all()
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT dp.Id , dp.NgayLap, ncc.TenNCC , dp.TrangThai
         FROM dphieunvl dp JOIN nhacungcap ncc ON ncc.id = dp.idNCC');
        foreach ($reg->fetchAll() as $item){
            $list[] =new dphieunvl($item['Id'],$item['NgayLap'],$item['TenNCC'],$item['TrangThai']);
        }
        return $list;
    }
    
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT dp.Id , dp.NgayLap, ncc.TenNCC , dp.TrangThai
        FROM dphieunvl dp JOIN nhacungcap ncc ON ncc.id = dp.idNCC WHERE dp.Id = '.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new dphieunvl($item['Id'],$item['NgayLap'],$item['TenNCC'],$item['TrangThai']);
        }
        return null;
    }
    static function add($ngaylap,$IdNCC,$TrangThai)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO dphieunvl(NgayLap,IdNCC,TrangThai) 
        VALUES ("'.$ngaylap.'",'.$IdNCC.',"'.$TrangThai.'")');

    }

    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE dphieunvl SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE dphieunvl SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM ct_nhapnvl WHERE IdPhieuNhap='.$id);
        $reg1 =$db->query('DELETE FROM dphieunvl WHERE Id='.$id);
        header('location:index.php?controller=dphieunvl&action=index');
    }

    static function filterByStatus($status, $start, $recordsPerPage) {
        $list = [];
        $db = DB::getInstance();
        
        $query = 'SELECT dp.Id , dp.NgayLap, ncc.TenNCC , dp.TrangThai
        FROM dphieunvl dp JOIN nhacungcap ncc ON ncc.id = dp.idNCC WHERE dp.TrangThai = :status LIMIT :start, :recordsPerPage';
    
        $reg = $db->prepare($query);
        $reg->bindParam(':status', $status, PDO::PARAM_INT);
        $reg->bindParam(':start', $start, PDO::PARAM_INT);
        $reg->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
    
        if (!$reg->execute()) {
            // Xử lý lỗi, in thông báo hoặc log lỗi
            die('Query failed: ' . implode(":", $reg->errorInfo()));
        }
    
        $result = $reg->fetchAll();
    
        foreach ($result as $item) {
            $list[] = new dphieunvl($item['Id'],$item['NgayLap'],$item['TenNCC'],$item['TrangThai']);
        }
    
        return $list;
    }

}
