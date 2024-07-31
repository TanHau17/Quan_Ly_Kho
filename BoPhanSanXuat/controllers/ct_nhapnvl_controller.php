
<?php
require_once ('controllers/base_controller.php');
require_once ('models/ct_nhapnvl.php');
class ct_nhapnvlController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'ct_nhapnvl';
    }
    public function  index()
    {
        $ctb = ct_nhapnvl::all();
        $data =array('ct_nhapnvl'=> $ctb);
        $this->render('index',$data);
    }
    public function  insert()
    {
        $this->render('insert');
    }
    public function edit()
    {
        $dphieu = dphieu::find($_GET['id']);
        $data =array('dphieu'=> $dphieu);
        $this->render('edit',$data);
    }
}
