<?php
require_once ('controllers/base_controller.php');
require_once ('models/pkk.php');

class pkkController extends BaseController
{
    function __construct()
    {
        $this->folder='pkk';
    }
    public function index()
    {
        $pkk = pkk::all();
        $data =array('pkk'=>$pkk);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }
   
}