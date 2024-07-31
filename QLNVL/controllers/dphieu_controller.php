<?php
require_once ('controllers/base_controller.php');
require_once ('models/dphieu.php');
class Dphieucontroller extends BaseController
{
    function  __construct()
    {
        $this->folder = 'dphieu';
       
    }
    public function index()
    {
        $dphieu = dphieu::all();
        $data =array('dphieu'=> $dphieu);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }
    public function duyet()
    {
        $dphieu = dphieu::all();
        $data =array('dphieu'=> $dphieu);
        $this->render('duyet',$data);
    }
  

}