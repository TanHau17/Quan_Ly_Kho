<script>
    $(document).click(function () {

    });

    $('#btnThemSanPham').click(function() {
        // debugger;
        // Lấy thông tin Sản phẩm
        if ($('#sp_ma option:selected').text()==''){
            alert('loi');
        }
        else {
        var sp_ma = $('#sp_ma').val();
        var sp_sl = $('#sp_ma option:selected').data('sp_sl');
        var sp_ten = $('#sp_ma option:selected').text();
        var soluong = $('#soluong').val();

        // Log the array data
    console.log('sp_ma:', sp_ma);
    console.log('sp_sl:', sp_sl);
    console.log('sp_ten:', sp_ten);
    console.log('soluong:', soluong);

        // Tạo mẫu giao diện HTML Table Row
        var htmlTemplate = '<tr>';
        htmlTemplate += '<td>' + sp_ten + '<input type="hidden" name="sp_ma[]" value="' + sp_ma + '"/></td>';
        htmlTemplate += '<td>' + soluong + '<input type="hidden" name="sp_dh_soluong[]" value="' + soluong + '"/></td>';
        htmlTemplate += '<td>' + sp_sl + '<input type="hidden" name="sp_dh_sl[]" value="' + sp_sl + '"/></td>';
        htmlTemplate += '<td><button type="button" class="btn btn-danger btn-delete-row">Xóa</button></td>';
        htmlTemplate += '</tr>';

        // Thêm vào TABLE BODY
        $('#tblChiTietDonHang tbody').append(htmlTemplate);
        }
        // Clear
        $('#sp_ma').val('');
        $('#soluong').val('');
    });





    function clearInputFields() {
    // Làm mới giá trị của các trường nhập liệu
    $('#tensp').val('');
    $('#soluong').val('');
    // Nếu cần làm mới thêm trường khác, thêm vào đây
}

$('#btnThemSanPhammua').click(function() {
    var sp_ma = $('#tensp').val();
    var sp_gia_raw = $('#gia').val(); // Lấy giá trị không định dạng
    var sp_gia = parseFloat(sp_gia_raw.replace(/[^0-9]/g, '')); // Chuyển đổi giá trị thành số

    var dvt_ma = $('#dvt').val();
    var dvt = $('#dvt option:selected').text();
    var sp_ten = $('#tensp').val();
    var soluong = $('#soluong').val();

    var thanhtien = soluong * sp_gia;

    var htmlTemplate = '<tr>';
    htmlTemplate += '<td>' + sp_ten + '<input type="hidden" name="sp_ma[]" value="' + sp_ma + '"/></td>';
    htmlTemplate += '<td>' + soluong + '<input type="hidden" name="sp_dh_soluong[]" value="' + soluong + '"/></td>';
    htmlTemplate += '<td>' + dvt + '<input type="hidden" name="sp_dh_dvt[]" value="' + dvt_ma + '"/></td>';
    htmlTemplate += '<td>' + sp_gia_raw + '<input type="hidden" name="sp_dh_dongia[]" value="' + sp_gia + '"/></td>';
    htmlTemplate += '<td>' + thanhtien + '</td>';
    htmlTemplate += '<td><button type="button" class="btn btn-danger btn-delete-row">Xóa</button></td>';
    htmlTemplate += '</tr>';

    $('#tblChiTietDonHang tbody').append(htmlTemplate);

    clearInputFields();
});
// Custom function to parse formatted currency string to float
function parseCurrency(currencyString) {
    // Remove non-numeric characters and parse to float
    return parseFloat(currencyString.replace(/[^0-9.-]/g, ''));
}

// Gắn sự kiện xóa hàng vào nút "Xóa"
$('#tblChiTietDonHang').on('click', '.btn-delete-row', function() {
    $(this).closest('tr').remove();
});

    $('#chiTietDonHangContainer').on('click', '.btn-delete-row', function() {
        // Ta có cấu trúc
        // <tr>
        //    <td>
        //        <button class="btn-delete-row"></button>     <--- $(this) chính là đối tượng đang được người dùng click
        //    </td>
        // </tr>

        // Từ nút người dùng click -> tìm lên phần tử cha -> phần tử cha
        // Xóa dòng TR
        $(this).parent().parent()[0].remove();
    });
</script>