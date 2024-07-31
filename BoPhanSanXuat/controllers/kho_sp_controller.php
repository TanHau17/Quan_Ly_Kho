<?php
require_once ('controllers/base_controller.php');
require_once ('models/kho_sp.php');
class KhoSpcontroller extends BaseController
{
    function  __construct()
    {
        $this->folder = 'kho_sp';
    }
    public function index()
    {
        $kho_sp = kho_sp::all();
        $data =array('kho_sp'=> $kho_sp);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $kho_sp = kho_sp::find($_GET['id_kho_sp']);
        $data = array('kho_sp' => $kho_sp);
        $this->render('show', $data);
    }
    public function edit()
    {
        $kho_sp = kho_sp::find($_GET['id_kho_sp']);
        $data = array('kho_sp' => $kho_sp);
        $this->render('edit', $data);
    }
    public function  thongke()
    {
        $kho_sp = kho_sp::find($_GET['id_kho_sp']);
        $data = array('kho_sp' => $kho_sp);
        $this->render('thongke', $data);
    }

}