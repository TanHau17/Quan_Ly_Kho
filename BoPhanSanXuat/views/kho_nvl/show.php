<?php
include_once("models/loc_kho_nvl.php");
$p = new tmdt();
?>

<h1 class="h3 mb-2 text-center text-gray-800 ">Kho Sản Phẩm</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách kho sản phẩm</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=kho_nvl&action=insert" class="btn btn-primary mb-3">Thêm</a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <?php 
				    $p->loadMenuKho('select * from kho_nvl order by ten_kho_nvl asc');
			    ?>
                </thead>
                <tfoot>
                <tr>
                <?php
				$id_kho_nvl=$_REQUEST['id_kho_nvl'];
				if($id_kho_nvl>=0)
				{
					$p->xuatnvl("select * from nvl where id_kho_nvl='$id_kho_nvl' order by id asc");
				}
				else
				{
					$p->xuatnvl("select * from nvl order by Id asc");
				}
			?>
                </tr>
                </tfoot>
                <tbody>
        
        </div>
       
        	
        </div>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>