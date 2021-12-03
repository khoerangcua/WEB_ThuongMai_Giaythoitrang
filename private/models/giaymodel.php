<?php 
require_once("private/modules/db_module.php");


class GiayModel{
	public function LoadNewArrival($ngay)
	{

		$link = null;

		taoKetNoi($link);

		$result = chayTruyVanTraVeDL($link, "SELECT giays.*, giamgias.phantramgiam 
											FROM (SELECT giays.* FROM tbl_giay as giays 
													WHERE giays.ngaynhap >= $ngay) AS giays 
											LEFT JOIN tbl_giamgia AS giamgias 
											ON giays.id_giay = giamgias.id_giay");

		$arrgiay = array();

		while ($row = mysqli_fetch_assoc($result)) {

			array_push($arrgiay, $row);
		}

		giaiPhongBoNho($link, $result);

		return ($arrgiay);
	}

	public function LoadBestSeller($soluongbanduoc)
	{
		$giays = array();

		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT * FROM (SELECT g.* FROM (SELECT cthd.id_giay FROM tbl_chitiethoadon as cthd GROUP BY cthd.id_giay HAVING SUM(cthd.soluong) > " . $soluongbanduoc . ") AS cthd INNER JOIN tbl_giay as g ON cthd.id_giay = g.id_giay) as bangphu1 LEFT JOIN tbl_giamgia as gg on gg.id_giay = bangphu1.id_giay");

		while ($row = mysqli_fetch_assoc($result)) {

			array_push($giays, $row);
		}
		giaiPhongBoNho($link, $result);
		return $giays;
	}

	public function LoadHotSale()
	{
		$giays = array();
		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT * FROM tbl_giamgia as gg LEFT JOIN tbl_giay as g ON gg.id_giay = g.id_giay WHERE gg.ngayketthuc > CURRENT_DATE()");
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($giays, $row);
		}
		return $giays;
	}

	public function LoadGiayTheoLoai($idthuonghieu)
	{
		$giays = array();
		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT bangphu1.*, gg.phantramgiam FROM (SELECT g.* FROM tbl_giaythuonghieu AS gth INNER JOIN tbl_giay as g ON gth.id_giay = g.id_giay WHERE gth.id_thuonghieu = " . $idthuonghieu . ") AS bangphu1 LEFT JOIN tbl_giamgia as gg ON bangphu1.id_giay = gg.id_giay");

		while ($row = mysqli_fetch_assoc($result)) {
			array_push($giays, $row);
		}

		return $giays;
	}

	public function LoadGiayTheoFiller($thuonghieu, $gia, $size)
	{

		$query = "SELECT DISTINCT(`id_giay`), bangphu2.ten, bangphu2.gia, bangphu2.anhchinh, bangphu2.anhphu1, bangphu2.phantramgiam FROM (SELECT bangphu1.*, tbl_giamgia.phantramgiam FROM (SELECT bangphu.*, tbl_giaysize.size FROM (SELECT tbl_giay.*, tbl_giaythuonghieu.id_thuonghieu FROM tbl_giay INNER JOIN tbl_giaythuonghieu ON tbl_giay.id_giay = tbl_giaythuonghieu.id_giay) AS bangphu INNER JOIN tbl_giaysize ON bangphu.id_giay = tbl_giaysize.id_giay) AS bangphu1 LEFT JOIN tbl_giamgia ON bangphu1.id_giay = tbl_giamgia.id_giay) AS bangphu2";

		if ($thuonghieu != -1 || $gia != -1 || $size != -1) {
			$query .= " WHERE ";

			if ($thuonghieu != -1) {
				$query .= " ( ";
				for ($i = 0; $i < count($thuonghieu); $i++) {

					if ($i == 0) {
						$query .= " bangphu2.id_thuonghieu = " . $thuonghieu[$i] . " ";
					} else {
						$query .= " OR bangphu2.id_thuonghieu = " . $thuonghieu[$i] . " ";
					}
				}
				$query .= " ) ";
			}

			if ($gia != -1) {

				for ($i = 0; $i < count($gia); $i++) {
					if ($i == 0 && $thuonghieu != -1) {
						$query .= " And ( bangphu2.gia - (bangphu2.gia * IFNULL(bangphu2.phantramgiam,0) / 100) " . $gia[$i] . " ";
					} else {
						if ($i == 0 && !$thuonghieu != -1) {
							$query .= " ( bangphu2.gia - (bangphu2.gia * IFNULL(bangphu2.phantramgiam,0) / 100) " . $gia[$i] . " ";
						} else {
							$query .= " OR bangphu2.gia - (bangphu2.gia * IFNULL(bangphu2.phantramgiam,0) / 100) " . $gia[$i] . " ";
						}
					}
				}
				$query .= " ) ";
			}

			if ($size != -1) {
				for ($i = 0; $i < count($size); $i++) {

					if ($i == 0 && $gia != -1 || $thuonghieu != -1) {
						$query .= " And ( bangphu2.size = '" . $size[$i] . "'";
					} else {
						if ($i == 0 && !($gia != -1) || $thuonghieu != -1) {
							$query .= " ( bangphu2.size = '" . $size[$i] . "'";
						} else {
							$query .= " OR bangphu2.size = '" . $size[$i] . "'";
						}
					}
					
				}
				$query .= " ) ";
			}
		}

		

		$giays = array();
		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($giays, $row);
		}
		
		return $giays;
	}

	public function LoadGiay($id_giay)
	{
		$link = null;
		taoKetNoi($link);

		$result = chayTruyVanTraVeDL($link, "SELECT bangphu1.*, th.tenthuonghieu FROM (SELECT g.*, th.id_thuonghieu FROM (SELECT g.*, s.size FROM (SELECT g.*, gg.phantramgiam FROM (SELECT * FROM tbl_giay AS g WHERE g.id_giay = $id_giay) AS g LEFT JOIN tbl_giamgia AS gg ON g.id_giay = gg.id_giay) AS g INNER JOIN tbl_giaysize as s ON g.id_giay = s.id_giay) AS g INNER JOIN tbl_giaythuonghieu AS th ON g.id_giay = th.id_giay) AS bangphu1 INNER JOIN tbl_thuonghieu AS th ON bangphu1.id_thuonghieu = th.id_thuonghieu");

		$giays = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($giays, $row);
			
		}

		return $giays;
	}

	public function LoadGiayTheoTenHoacLoai($key)
	{
		$link = null;
		taoKetNoi($link);

		$result = chayTruyVanTraVeDL($link, "SELECT bangphu4.*, gg.phantramgiam FROM (SELECT * FROM (SELECT bangphu1.*, th.tenthuonghieu FROM (SELECT g.*, g_th.id_thuonghieu FROM tbl_giay AS g INNER JOIN tbl_giaythuonghieu AS g_th on g.id_giay = g_th.id_giay) AS bangphu1 INNER JOIN tbl_thuonghieu as th on bangphu1.id_thuonghieu = th.id_thuonghieu) AS bangphu3 WHERE bangphu3.ten LIKE '%".$key."%' OR bangphu3.tenthuonghieu LIKE '%".$key."%') AS bangphu4 LEFT JOIN tbl_giamgia AS gg on bangphu4.id_giay = gg.id_giay");

		$giays = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($giays, $row);
			
		}

		return $giays;
	}


}
?>