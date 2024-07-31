<script>
	function xoaSanPham()
	{
		var conf = confirm("Bạn có chắc muốn xóa sản phẩm này không?");
		return conf;
	}
</script>
<?php
	include_once'./ketnoi.php';
	require('Classes/PHPExcel.php');
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
	}else
	{
		$page = 1;
	}
	$rowsPerPage = 4;
	$perRow = $page*$rowsPerPage - $rowsPerPage;
	
	$sql = "SELECT * FROM sanpham INNER JOIN nhacungcap INNER JOIN donvi on sanpham.id_nhacungcap = nhacungcap.id_nhacungcap and sanpham.id_donvi = donvi.id_donvi ORDER by id_sanpham asc limit $perRow,$rowsPerPage";
	$query = mysqli_query($conn,$sql);
	
	$totalRows = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM sanpham"));
	$totalPages = ceil($totalRows/$rowsPerPage);
	
	$listPage = "";
	for($i = 1; $i<= $totalPages; $i++)
	{
		if($page == $i)
		{
			$listPage.='<li class="page-item active"><a class="page-link" href="quantri.php?page_layout=danhsachsp&page='.$i.'"">'.$i.'</a></li>';
		}
		else
		{
			$listPage.='<li class="page-item"><a class="page-link" href="quantri.php?page_layout=danhsachsp&page='.$i.'"">'.$i.'</a></li>';
		}
	}
	

	
	
	
	
	
	
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lumino - Tables</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/pagination.css">
<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Quản lý sản phẩm</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Quản lý sản phẩm</h1>
                
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Chọn tệp Excel để import</div>
                    <form action="import.php" method="post" enctype="multipart/form-data" style="margin-top: 10px;
    margin-left: 18px;">
        
        <input type="file" id="file" name="file" accept=".xlsx, .xls">

        <input type="submit" value="Import" name="Import" class="btn btn-success" style="margin-top:6px;">
    </form>
    
    
                    
					<div class="panel-body">
                    
						<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-name="name" data-sort-order="desc" style="text-align: center">
						    <thead>
    <tr>
        <th data-sortable="true">STT</th>
        <th data-sortable="true">Tên sản phẩm</th>
        <th data-sortable="true">Nhà cung cấp</th>
        <th data-sortable="true">Đơn vị tính</th>
        <th data-sortable="true">Số lượng nhập</th>
        <th data-sortable="true">Ngày nhập</th>
        <th data-sortable="true">Người nhập</th>
        <th data-sortable="true">Đơn giá</th>
        <th data-sortable="true">Sửa</th>
        <th data-sortable="true">Xóa</th>
    </tr>
</thead>


<tbody>
    <?php
    $count = $perRow + 1; // Tính toán lại giá trị của $count dựa trên số trang hiện tại và số hàng trên mỗi trang
    while ($rows = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td data-checkbox="true"><?php echo $count; ?></td> <!-- Thêm cột STT ở đây -->
            <td data-checkbox = "true"><a href="index.php?page_layout=suasp&id_sanpham=<?php echo $rows['id_sanpham'];  ?>"><?php echo $rows['ten_sp']; ?></a></td>
            <td data-checkbox = "true"><?php echo $rows['ten_nhacungcap']; ?></td>
            <td data-checkbox = "true"><?php echo $rows['ten_donvi']; ?></td>
            <td data-checkbox = "true"><?php echo $rows['so_luong']; ?></td>
           <td data-checkbox="true"><?php echo date('d-m-Y', strtotime($rows['ngay_nhap'])); ?></td> <!-- Định dạng ngày nhập thành D-M-Y -->
           <td data-checkbox = "true"><?php echo $rows['nguoi_nhap']; ?></td>
           <td data-checkbox = "true"><?php echo $rows['don_gia']; ?></td>
           <td>
                                    <a href="index.php?page_layout=suasp&id_sanpham=<?php echo $rows['id_sanpham']; ?>"><span><svg class = "glyph stroked brusbh" style = "width: 20px; height:20px;"><use xlink:href = "#stroked-brush" /></svg></span></a>
                                    </td>
            <td>
                                     <a onClick="return xoaSanPham();" href="xoasp.php?id_sanpham=<?php echo $rows['id_sanpham']; ?>"><span><svg class="glyph stroked cancel" style = "width: 20px; height:20px;"><use xlink:href="#stroked-cancel"/></svg></span></a>
                                     </td>
        </tr>
        <?php
        $count++; // Tăng biến đếm sau mỗi vòng lặp
    }
    ?>
</tbody>
						</table>
                        <ul class="pagination" style="float:right;">
                        <?php
							echo $listPage;
						?>
                        </ul>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

						<script>
						    $(function () {
						        $('#hover, #striped, #condensed').click(function () {
						            var classes = 'table';
						
						            if ($('#hover').prop('checked')) {
						                classes += ' table-hover';
						            }
						            if ($('#condensed').prop('checked')) {
						                classes += ' table-condensed';
						            }
						            $('#table-style').bootstrapTable('destroy')
						                .bootstrapTable({
						                    classes: classes,
						                    striped: $('#striped').prop('checked')
						                });
						        });
						    });
						
						    function rowStyle(row, index) {
						        var classes = ['active', 'success', 'info', 'warning', 'danger'];
						
						        if (index % 2 === 0 && index / 2 < classes.length) {
						            return {
						                classes: classes[index / 2]
						            };
						        }
						        return {};
						    }
						</script>
					</div>
				</div>
			</div>
<!--/.row-->	
		
		
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
