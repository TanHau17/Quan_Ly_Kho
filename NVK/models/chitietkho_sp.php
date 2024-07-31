<?php
class ChiTietKho_SP{

    public $Id;
    public $id_kho_sp;  
    public $ten_kho_sp;  
    public $dia_chi;
    public $TenSP;
    public $TrangThai;

    

    function __construct($Id,$id_kho_sp,$ten_kho_sp,$TenSP,$dia_chi,$TrangThai)
    {
        $this->Id = $Id;
        $this->id_kho_sp= $id_kho_sp;
        $this->ten_kho_sp=  $ten_kho_sp;
        $this->dia_chi= $dia_chi;
        $this->TenSP= $TenSP;
        $this->TrangThai= $TrangThai;


    }


    static function all()
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT ct.Id ,ksp.id_kho_sp As "kho_sp",ksp.id_kho_sp,ksp.ten_kho_sp,ksp.dia_chi, sp.TenSP,ct.TrangThai
        FROM chitietkho_sp ct  JOIN kho_sp ksp JOIN SanPham sp ON ct.id_kho_sp = ksp.id_kho_sp AND ct.IdSP = sp.Id ');
        foreach ($reg->fetchAll() as $item){
            $list[] =new ChiTietKho_SP($item['Id'],$item['id_kho_sp'],$item['ten_kho_sp'],$item['dia_chi'],
            $item['TenSP'],$item['TrangThai']);
        }
        return $list;
    }

    static function find($id_kho_sp)
    {
        $list =[];
        $db =DB::getInstance();
        $reg = $db->query('SELECT ct.id ,ksp.id_kho_sp As "kho_sp",sp.TenSP ,ct.TrangThai FROM chitietkho_sp ct JOIN kho_sp ksp JOIN SanPham sp  ON 
        ct.id_kho_sp = ksp.id_kho_sp AND ct.IdSP = sp.Id  WHERE ct.id_kho_sp='.$id_kho_sp);
        foreach ($reg->fetchAll() as $item){
$list[] =new ChiTietKho_SP($item['Id'],$item['id_kho_sp'],$item['ten_kho_sp'],$item['dia_chi'],$item['TenSP'],$item['TrangThai']);
        }
        return $list;
    }
    static function add($id,$id_kho_sp,$IdSP,$IdDVT,$SoLuong,$TrangThai)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO chitietkho_sp(id,id_kho_sp,IdSP,TrangThai) VALUES ('.$id.','.$id_kho_sp.','.$IdSP.','.$TrangThai.')');

    }
    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE chitietkho_sp SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE chitietkho_sp SET TrangThai ="0" WHERE Id='.$id);
    }
}
