<?php
class ChiTietBan{

    public $Id;
    public $IdDonBan;
    public $IdSP;
    public $IdDVT;
    public $SoLuong;


    function __construct($Id,$IdDonBan,$IdSP,$IdDVT,$SoLuong)
    {
        $this->Id = $Id;
        $this->IdDonBan = $IdDonBan;
        $this->IdSP=  $IdSP;
        $this->IdDVT=  $IdDVT;
        $this->SoLuong = $SoLuong;
    }
    static function all()
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT ct.Id ,db.Id As "Don",sp.TenSP ,dvt.DonVi ,ct.SoLuong ,ct.ThanhTien FROM ChiTietBan ct JOIN DonViTinh dvt JOIN DonBan db JOIN SanPham sp ON ct.IdDonBan = db.Id AND ct.IdSP = sp.Id AND sp.IdDVT = dvt.Id');
        foreach ($reg->fetchAll() as $item){
            $list[] =new ChiTietBan($item['Id'],$item['Don'],$item['TenSP'],$item['DonVi'],$item['SoLuong']);
        }
        return $list;
    }
    static function find($id)
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT ct.Id ,db.Id As "Don",sp.TenSP ,dvt.DonVi ,ct.SoLuong ,ct.ThanhTien FROM ChiTietBan ct JOIN DonViTinh dvt JOIN DonBan db JOIN SanPham sp ON ct.IdDonBan = db.Id AND ct.IdSP = sp.Id AND sp.IdDVT = dvt.Id WHERE ct.IdDonBan='.$id);
        foreach ($reg->fetchAll() as $item){
            $list[] =new ChiTietBan($item['Id'],$item['Don'],$item['TenSP'],$item['DonVi'],$item['SoLuong'],$item['ThanhTien']);
        return $list;
    }
    
}


static function add($IdDonHang,$IdSP,$SoLuong)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO ChiTietBan(IdDonBan,IdSP,SoLuong) VALUES ('.$IdDonHang.','.$IdSP.','.$SoLuong.')');

    }

}