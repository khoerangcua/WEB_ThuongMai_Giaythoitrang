<?php
require_once("private/models/giohangmodel.php");
require_once("private/modules/db_module.php");
class HoaDonModel{
   public function ThemHoaDon($idtaikhoan, $idkhachhang ,$hoten, $email, $sdt, $diachi , $hinhthucvanchuyen, $hinhthucthanhtoan,$chiphivanchuyen)
   {
        // Load giỏ hàng
        $gioHangModel = new GioHangModel();
        $giays = $gioHangModel->LoadGioHang($idtaikhoan);

        // Load tạm tính, giảm giá, tổng tiền
        $tamtinh = 0;
        $giamgia = 0;
        foreach ($giays as $key => $value) {
            $tamtinh += $value["gia"] * $value["soluong"];
            $giamgia += (isset($value["phantramgiam"]) ? $value["gia"] * $value["phantramgiam"] / 100 : 0) * $value["soluong"];
        }
        $tongtien = $tamtinh + 50000 - $giamgia;

        $link = "";
        taoKetNoi($link);
        // Thêm mới hóa đơn
        $result = chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_hoadon` (`id_hoadon`, `id_khachhang`, `hoten`, `email`, `sodienthoai`, `diachi`, `hinhthucvanchuyen`, `hinhthucthanhtoan`, `tamtinh`, `phivanchuyen`, `giamgia`, `ngaylap`, `tongtien`) 
                                                                            VALUES (NULL, '$idkhachhang', '$hoten', '$email', '$sdt', '$diachi', '$hinhthucvanchuyen', '$hinhthucthanhtoan', '$tamtinh', '$chiphivanchuyen', '$giamgia', CURRENT_DATE(), '$tongtien');");
        if ($result == false) {
            return false;
        }
        else {
            //Lấy id hóa đơn
            $idhoadon = "";
            $result2 = chayTruyVanTraVeDL($link, "SELECT MAX(`id_hoadon`) FROM tbl_hoadon");
            while ($row = mysqli_fetch_array($result2)) {
                $idhoadon = $row[0];
                break;
            }
            // Thêm chi tiết hóa đơn
            foreach ($giays as $key => $value) {
                $phantramgiam = isset($value["phantramgiam"]) ? $value["phantramgiam"] : 0;
                $thanhtien = ($value["gia"] - ($phantramgiam * $value["gia"] / 100 )) * $value["soluong"];
                chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_chitiethoadon` (`id_hoadon`, `id_giay`, `size` ,`soluong`, `thanhtien`) VALUES ('$idhoadon', '".$value["id_giay"]."', '".$value["size"]."' ,'".$value["soluong"]."', '$thanhtien');");
            }
            return true;
        }                                                                    
   }

   
}
?>