<?php
class dphieu{
    public $id;
    public $ngaylap;
    public $idNCC;
	public $trangthai;
	public $idNVL;
	public $soLuong;
	public $idDVT;


    function __construct($id,$ngaylap,$idNCC, $trangthai, $idNVL, $soLuong, $idDVT)
    {
        $this->id=$id;
        $this->ngaylap=$ngaylap;
        $this->idNCC=$idNCC;
		$this->trangthai=$trangthai;
		$this->idNVL=$idNVL;
        $this->soLuong = $soLuong;
        $this->idDVT = $idDVT;
		

    }
   
   
    static function all()
    {
        $list = [];
        $db = DB::getInstance();
        $reg = $db->query('SELECT dp.Id,dp.ngaylap, ncc.TenNCC, dp.trangthai, nvl.TenNVL,nvl.soLuong,nvl.IdDVT 
                   FROM dphieu dp 
                   JOIN NhaCungCap ncc ON dp.idNCC = ncc.Id 
                   JOIN nvl nvl ON dp.idNVL = nvl.Id');

        foreach ($reg->fetchAll() as $item) {
            $list[] = new dphieu($item['Id'], $item['ngaylap'], $item['TenNCC'],$item['trangthai'],$item['TenNVL'],$item['soLuong'],$item['IdDVT']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM nvl WHERE Id ='.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
                return  new dphieu($item['Id'], $item['ngaylap'], $item['TenNCC'],$item['trangthai'],$item['TenNVL'],$item['soLuong'],$item['IdDVT']);
        }
        return null;
    }
    public static function add($id, $ngaylap, $idNCC, $trangthai, $idNVL, $soLuong)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO dphieu (id, ngaylap, idNCC, trangthai, idNVL, soLuong) VALUES (:id, :ngaylap, :idNCC, :trangthai, :idNVL, :soLuong)';
    
        // Sử dụng prepared statement để tránh SQL injection
        $statement = $db->prepare($query);
    
        // Bind các giá trị
        $statement->bindParam(':id', $id);
        $statement->bindParam(':ngaylap', $ngaylap);
        $statement->bindParam(':idNCC', $idNCC);
        $statement->bindParam(':trangthai', $trangthai);
        $statement->bindParam(':idNVL', $idNVL);
        $statement->bindParam(':soLuong', $soLuong);
    
        // Thực thi truy vấn
        $statement->execute();
    
    
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=dphieu&action=index');
    }

    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM dphieu WHERE id='.$id);
        header('location:index.php?controller=dphieu&action=index');
    }
    
}