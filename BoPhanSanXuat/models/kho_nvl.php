<?php
class kho_nvl{
    public $id_kho_nvl;
    public $ten_kho_nvl;
    public $dia_chi;


    function __construct($id_kho_nvl,$ten_kho_nvl,$dia_chi)
    {
        $this->id_kho_nvl=$id_kho_nvl;
        $this->ten_kho_nvl=$ten_kho_nvl;
        $this->dia_chi=$dia_chi;

    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from kho_nvl');
        foreach ($reg->fetchAll() as $item){
            $list[] =new kho_nvl($item['id_kho_nvl'],$item['ten_kho_nvl'],$item['dia_chi']);
        }
        return $list;
    }
    static function find($id_kho_nvl)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM kho_nvl WHERE id_kho_nvl = :id_kho_nvl');
        $req->execute(array('id_kho_nvl' => $id_kho_nvl));
        
        $item = $req->fetch();
        if (isset($item['id_kho_nvl'])) {
            return new kho_nvl($item['id_kho_nvl'],$item['ten_kho_nvl'],$item['dia_chi']);
        }
        return null;
    }
    static function add($id_kho_nvl,$ten_kho_nvl,$dia_chi)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO kho_nvl(id_kho_nvl,ten_kho_nvl,dia_chi) VALUES ("'.$id_kho_nvl.'","'.$ten_kho_nvl.'","'.$dia_chi.'")');
        header('location:index.php?controller=kho_nvl&action=index');
    }
    static function update($id_kho_nvl,$ten_kho_nvl,$dia_chi)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE kho_nvl SET ten_kho_nvl ="'.$ten_kho_nvl.'",dia_chi="'.$dia_chi.'" WHERE id_kho_nvl='.$id_kho_nvl);
        header('location:index.php?controller=kho_nvl&action=index');
    }
      
    static function  delete($id_kho_nvl){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM kho_nvl WHERE id_kho_nvl='.$id_kho_nvl);
        header('location:index.php?controller=kho_nvl&action=index');
    }

}