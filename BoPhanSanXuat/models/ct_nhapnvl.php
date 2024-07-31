<?php
class ct_nhapnvl{


    public $Id;
    public $IdPhieuNhap;
    public $TenNVL;
    public $IdDVT;
    public $SoLuongNhap;



    function __construct($Id,$IdPhieuNhap,$TenNVL,$IdDVT,$SoLuongNhap)
    {
        $this->Id = $Id;
        $this->IdPhieuNhap = $IdPhieuNhap;
        $this->TenNVL=  $TenNVL;
        $this->IdDVT=  $IdDVT;
        $this->SoLuongNhap = $SoLuongNhap;
    }
    static function all()
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT ct.Id ,db.Id As "IdPhieu",ct.TenNVL ,dvt.DonVi,ct.SoLuongNhap FROM ct_nhapnvl ct JOIN DonViTinh dvt JOIN dphieu db ON ct.IdPhieuNhap = db.Id AND dvt.Id = ct.IdDVT');
        foreach ($reg->fetchAll() as $item){
            $list[] =new ct_nhapnvl($item['Id'],$item['IdPhieu'],$item['TenNVL'],$item['DonVi'],$item['SoLuongNhap']);
        }
        return $list;
    }
    static function find($id)
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT ct.Id ,db.Id As "IdPhieu",ct.TenNVL ,dvt.DonVi,ct.SoLuongNhap FROM ct_nhapnvl ct JOIN DonViTinh dvt JOIN dphieu db ON ct.$IdPhieuNhap = db.Id AND dvt.Id = ct.IdDVT WHERE ct.$IdPhieuNhap='.$id);
        foreach ($reg->fetchAll() as $item){
            $list[] =new ct_nhapnvl($item['Id'],$item['IdPhieu'],$item['TenNVL'],$item['DonVi'],$item['SoLuongNhap']);
        }
        return $list;
    }
    static function add($IdPhieuNhap,$TenNVL,$IdDVT,$SoLuongNhap)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO ct_nhapnvl(IdPhieuNhap,TenNVL,IdDVT,SoLuongNhap) VALUES ('.$IdPhieuNhap.',"'.$TenNVL.'",'.$IdDVT.','.$SoLuongNhap.')');

    }

}
