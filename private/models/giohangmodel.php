<?php
require_once("private/modules/db_module.php");
class GioHangModel
{
    public function LoadGioHang($id){

        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanTraVeDL($link, "SELECT bangphu2.*, gg.phantramgiam FROM (SELECT g.*, bangphu1.id_taikhoan, bangphu1.size, bangphu1.soluong FROM (SELECT * FROM tbl_giohang AS gh WHERE gh.id_taikhoan = $id) AS bangphu1 INNER JOIN tbl_giay AS g ON bangphu1.id_giay = g.id_giay) AS bangphu2 LEFT JOIN tbl_giamgia as gg on bangphu2.id_giay = gg.id_giay");

        $giays = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($giays,$row);
        }

        return $giays;
    }

    public function XoaHang($id_taikhoan, $id_giay)
    {
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_giohang WHERE tbl_giohang.id_taikhoan = $id_taikhoan AND tbl_giohang.id_giay = $id_giay");

        return $result;
    }

    public function ThemHang($id_taikhoan, $id_giay, $size, $soluong)
    {
        $link = "";
        taoKetNoi($link);
        $dem = 0;
        $result = chayTruyVanTraVeDL($link, "SELECT COUNT(id_taikhoan) FROM tbl_giohang WHERE `id_taikhoan` = $id_taikhoan AND `id_giay` = $id_giay AND `size` = $size");
        while ($row = mysqli_fetch_array($result)) {
            $dem  = $row[0];
        }
        if ($dem > 0) {
            // Đã tồn tại -> chỉ cập nhật
            chayTruyVanKhongTraVeDL($link, "UPDATE tbl_giohang SET `soluong` = `soluong` + $soluong WHERE `id_taikhoan` = $id_taikhoan AND `id_giay` = $id_giay AND `size` = $size");
        }
        else {
            // Chưa tồn tại -> thêm mới
            chayTruyVanKhongTraVeDL($link, "INSERT INTO tbl_giohang VALUES ($id_taikhoan,$id_giay,$size,$soluong)");
        }
    }
}
?>