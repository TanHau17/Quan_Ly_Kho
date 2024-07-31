<?php
class DonBan{

    public $Id;
    public $NgayBan;
    public $IdNV;
    public $IdKH;
    public $TrangThai;


    function __construct($Id,$NgayBan,$IdNV,$IdKH,$TrangThai)
    {
        $this->Id = $Id;
        $this->NgayBan = $NgayBan;
        $this->IdNV =  $IdNV;
        $this->IdKH = $IdKH;
        $this->TrangThai= $TrangThai;
    }
    static function all()
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT db.Id ,db.NgayBan , nv.TaiKhoan ,kh.TenKH ,db.TrangThai FROM DonBan db JOIN NhanVien nv JOIN KhachHang kh ON nv.Id =db.IdNV AND kh.Id = db.IdKH');
        foreach ($reg->fetchAll() as $item){
            $list[] =new DonBan($item['Id'],$item['NgayBan'],$item['TaiKhoan'],$item['TenKH'],$item['TrangThai']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT db.Id ,db.NgayBan , nv.TaiKhoan ,kh.TenKH ,db.TrangThai FROM DonBan db JOIN NhanVien nv JOIN KhachHang kh ON nv.Id =db.IdNV AND kh.Id = db.IdKH WHERE db.Id = :id');
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new DonBan($item['Id'],$item['NgayBan'],$item['TaiKhoan'],$item['TenKH'],$item['TrangThai']);
        }
        return null;
    }
    static function add($ngayban,$IdNV,$IdKH,$TrangThai)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO DonBan(NgayBan,IdNV,IdKH,TrangThai) VALUES ("'.$ngayban.'",'.$IdNV.','.$IdKH.',"'.$TrangThai.'")');

    }
    static function  update($id,$DonBan)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE DonBan SET DonBan ="'.$DonBan.'" WHERE Id='.$id);
        header('location:index.php?controller=donban&action=index');
    }
    static function  thanhtoan($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE DonBan SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuathanhtoan($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE DonBan SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM ChiTietBan WHERE IdDonBan='.$id);
        $reg1 =$db->query('DELETE FROM DonBan WHERE Id = '.$id);
        
        return $reg1;
    }

    static function filterByStatus($status, $start, $recordsPerPage) {
        $list = [];
        $db = DB::getInstance();
        
        $query = 'SELECT db.Id ,db.NgayBan , nv.TaiKhoan ,kh.TenKH ,db.TrangThai 
                  FROM DonBan db JOIN NhanVien nv JOIN KhachHang kh ON nv.Id =db.IdNV AND kh.Id = db.IdKH 
                  WHERE db.TrangThai = :status 
                  LIMIT :start, :recordsPerPage';
    
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
            $list[] =new DonBan($item['Id'],$item['NgayBan'],$item['TaiKhoan'],$item['TenKH'],$item['TrangThai']);      }
    
        return $list;
    }
}
