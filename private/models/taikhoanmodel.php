<?php
require_once("private/modules/db_module.php");
class TaiKhoanModel
{
    public function KiemTraDangNhap($tendangnhap, $matkhau){
        $link = "";
        taoKetNoi($link);
        $taikhoan = -1;

        $result = chayTruyVanTraVeDL($link, "SELECT * FROM `tbl_taikhoan` AS tk WHERE tk.tendangnhap = '$tendangnhap' AND tk.matkhau = '$matkhau'");
        while ($row = mysqli_fetch_assoc($result)) {
            $taikhoan = $row;
        }
        
        return $taikhoan;
    }

    public function ThemTaiKhoan($tendangnhap, $matkhau, $nhaplaimatkhau)
    {
        
        if (empty($tendangnhap) || empty($matkhau) || empty($nhaplaimatkhau)) {
            return -1;
        }
        if ($matkhau != $nhaplaimatkhau) {
            return -1;
        }
        

        $link = "";
        taoKetNoi($link);

        // Kiểm tra tài khoản đã tồn tại ? 
        $taikhoan = chayTruyVanTraVeDL($link, "SELECT COUNT(`id_taikhoan`) FROM tbl_taikhoan where `tendangnhap` = '$tendangnhap';");
        $dem = 0;
        while ($row = mysqli_fetch_array($taikhoan)) {
           $dem = $row[0];
        }
        if ($dem != 0) {
            return false;
        }

        $result = chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_taikhoan` (`id_taikhoan`, `tendangnhap`, `matkhau`, `phanquyen`) VALUES (NULL, '$tendangnhap', '$matkhau', '0');");
        if ($result == true) {
            // Lấy id tài khoản mới thêm
            $idtaikhoan = chayTruyVanTraVeDL($link, "SELECT MAX(`id_taikhoan`) FROM tbl_taikhoan");
            while ($row = mysqli_fetch_array($idtaikhoan)) {
                return $row[0];
            }
        }
        else {
            return -1;
        }
    }

    public function ThemThongTinKhachHang($ho, $ten, $sodienthoai, $email)
    {
        if (empty($ho) || empty($ten) || empty($sodienthoai) || empty($email) ) {
            return -1;
        }
        else{
            $link = "";
            taoKetNoi($link);
            $result = chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_thongtinkhachhang` (`id_khachhang`, `ho`, `ten`, `sdt`, `email`) VALUES (NULL, '$ho', '$ten', '$sodienthoai', '$email');");
            if ($result == true) {
                // Lấy id khách hàng mới thêm
                $idkhachhang = chayTruyVanTraVeDL($link, "SELECT MAX(`id_khachhang`) FROM tbl_thongtinkhachhang");
                while ($row = mysqli_fetch_array($idkhachhang)) {
                    return $row[0];
                    
                }
            }
            else {
                return -1;
            }
        }
    }

    public function LinkTaiKhoanToThongTinKhachHang($idtaikhoan, $idkhachhang)
    {
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanKhongTraVeDL($link, "INSERT INTO tbl_taikhoankhachhang VALUES ($idtaikhoan,$idkhachhang);");
        return $result;
    }

    public function LoadTaiKhoanInfor($idtaikhoan)
    {
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanTraVeDL($link, "SELECT tkkh.id_taikhoan, kh.* FROM tbl_taikhoankhachhang as tkkh INNER JOIN tbl_thongtinkhachhang as kh ON tkkh.id_khachhang = kh.id_khachhang WHERE tkkh.id_taikhoan = $idtaikhoan;");
        $khachhanginfor = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($khachhanginfor, $row);
            break;
        }
        return $khachhanginfor[0];
    }

    public function CapNhatThonTinKhachHang($idkhachhang, $ho, $ten, $sdt, $diachi, $email)
    {
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanKhongTraVeDL($link, "  UPDATE tbl_thongtinkhachhang SET `ho` = '$ho', `ten` = '$ten', `diachi` = '$diachi' , `sdt` = '$sdt', `email` = '$email' WHERE `id_khachhang` = '$idkhachhang';");
        return $result;
    }

    public function ThayDoiMatKhau ($tendangnhap, $matkhaucu, $matkhaumoi, $nhaplaimatkhaumoi)
    {
        if ($matkhaumoi != $nhaplaimatkhaumoi) {
            return false;
        }

        // Xác thực tài khoản
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanTraVeDL($link, "SELECT * FROM tbl_taikhoan AS tk WHERE tk.tendangnhap = '$tendangnhap'");
        
        //Kiểm tra xác thực mật khẩu cũ
        $idtaikhoan = "";
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["matkhau"] != $matkhaucu) {
                return false;
            }
            else {
                $idtaikhoan = $row["id_taikhoan"];
            }
            break;
        }

        //Thực hiện cập nhật
        $result2 = chayTruyVanKhongTraVeDL($link, "UPDATE tbl_taikhoan AS tk SET tk.matkhau = '$matkhaumoi' WHERE tk.id_taikhoan = '$idtaikhoan'");
        return $result2;
    }

}

?>