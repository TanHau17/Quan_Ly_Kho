<?php
require_once ('controllers/base_controller.php');
require_once ('models/kho_nvl.php');
class khonvlcontroller extends BaseController
{
    function  __construct()
    {
        $this->folder = 'kho_nvl';
    }
    public function index()
    {
        $kho_nvl = kho_nvl::all();
        $data =array('kho_nvl'=> $kho_nvl);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $kho_nvl = kho_nvl::find($_GET['id_kho_nvl']);
        $data = array('kho_nvl' => $kho_nvl);
        $this->render('show', $data);
    }
    public function edit()
    {
        $kho_nvl = kho_nvl::find($_GET['id_kho_nvl']);
        $data = array('kho_nvl' => $kho_nvl);
        $this->render('edit', $data);
    }
   
}