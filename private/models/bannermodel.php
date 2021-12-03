<?php
require_once("private/modules/db_module.php");


class BannerModel
{
	
	public function LoadBanners($trang, $vitri){

		$link = "";				
		taoKetNoi($link);
		
		$result = chayTruyVanTraVeDL($link," SELECT * FROM tbl_banner AS banners WHERE banners.desc = 'DSD' AND banners.trang = '$trang' AND banners.vitri = '$vitri' ");
		
		
		$arrbanner = array();
		
		while($rows = mysqli_fetch_assoc($result)){
			
			array_push($arrbanner, $rows);
			
		}
		
		giaiPhongBoNho($link, $result);
		
		return($arrbanner);
	}
	public function LoadBanner($trang, $vitri){
		$banners = array();

		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link,"select * from tbl_banner where `desc` = 'DSD' and `trang` = '".$trang."' and `vitri` = '".$vitri."'");
		while($rows = mysqli_fetch_assoc($result)){
			array_push($banners, $rows);
			break;
	
		}
		giaiPhongBoNho($link, $result);
		return $banners[0];
	}		
	}
