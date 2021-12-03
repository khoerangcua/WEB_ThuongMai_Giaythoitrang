<?php
require_once("private/models/giohangmodel.php");
require_once("private/models/giaymodel.php");
class GioHangController
{
    public function LoadGioHang()
    {
        // Kiểm tra đã đăng nhập chưa? 
        $login_status = isset($_SESSION["taikhoan"]) ? true : false; 
        if ($login_status) {
            // Kiểm tra hành động: thêm thay xóa sản phẩm trong giỏ hàng? 

            $hanhdong = isset($_GET["action"]) ? $_GET["action"] : -1;
            if ($hanhdong == "them") {
                $from = isset($_GET["from"]) ? $_GET["from"] : -1;
                if ($from == "themvaogio") {
                    $this->ThemSanPham();
                    header("Location: ./?to=detail&id=".$_GET["id_giay"]."");
                    exit();
                }
                $this->ThemSanPham();
            }
            if ($hanhdong == "xoa") {
                $this->XoaSanPham();
            }

            $this->HienThiSanPhamTrongGio();

        }
        else{
            header("Location: ./?to=login");
            
        } 
    }

    private function ThemSanPham(){
        $taikhoan = $_SESSION["taikhoan"];
        $id_giay = $_GET["id_giay"];
        $size = $_GET["size"];
        $soluong = $_GET["soluong"];

        $gioHangModel = new  GioHangModel();
        $gioHangModel->ThemHang($taikhoan["id_taikhoan"], $id_giay, $size, $soluong);
    }

    private function XoaSanPham(){
        $taikhoan = $_SESSION["taikhoan"];
        $id_giay = $_GET["id_giay"];

        $gioHangModel = new GioHangModel();
        $gioHangModel->XoaHang($taikhoan["id_taikhoan"], $id_giay);
    }

    private function HienThiSanPhamTrongGio(){
        
        $taikhoan = $_SESSION["taikhoan"];

        $gioHangModel = new GioHangModel();
        $giays = $gioHangModel->LoadGioHang($taikhoan["id_taikhoan"]);
        
        $tongtien = 0; 
        foreach ($giays as $key => $value) {
            $gia = $value["gia"];
            $phantramgiam = isset($value["phantramgiam"]) ? $value["phantramgiam"] : 0;
            $tongtien += (($gia - ($gia * $phantramgiam / 100)) * $value["soluong"]);
        }
        
        // Hiển thị header
        echo 
        "
            <header>
        ";
                
        include_once("public/templates/header.php");                
        echo
        "
            </header>
        ";

        // Hiển thị breakcrumb
        echo
        "
            <nav style='background-color:#F8F8F8' aria-label='breadcrumb'>
                <div class='container'>
                    <ol class='breadcrumb'>
                        <li class='breadcrumb-item'><a href='./?to=home'>Trang chủ</a></li>
                        <li class='breadcrumb-item active' aria-current='page'>Giỏ hàng</li>
                    </ol>
                </div>
            </nav>
        ";

        // Div container
        echo 
        "
        <div class='container'>
        ";
            // Header 1
            echo
            "
            <div class='row'>
                <div class='col'>
                    <div class='heading'>
                        <h2>Giỏ hàng của bạn</h2>
                    </div>
                </div>
            </div>
            ";
            // Danh muc san pham
            echo
            "
            <div class='row'>
                <div class='col-lg-8 col-sm-12 cart-info'>
                    <p class='cart-note'>Bạn đang có <b>".count($giays)."</b> sản phẩm trong giỏ hàng</p>
            ";
                    foreach ($giays as $key => $value) {                       
                        $gia = $value["gia"];
                        $phantramgiam = isset($value["phantramgiam"]) ? $value["phantramgiam"] : 0;
                        $thanhtien = ($gia - ($gia * $phantramgiam / 100)) * $value["soluong"];
                        echo
                        "
                        <div class='row cart-items'>
                            <div class='col-md-5 col-lg-3 col-xl-3 col-3'>
                                <a href='./?to=detail&id=".$value["id_giay"]."'>
                                    <img class='img-fluid w-100' src='".$value["anhchinh"]."'>
                                </a>
                            </div>

                            <div class='col-md-7 col-lg-9 col-xl-9 col-9'>
                                <div>
                                    <div class='d-flex justify-content-between'>
                                        <div>
                                            <h3>".$value["ten"]."</h3>
                                            <p class='mb-3 text-muted text-uppercase small'>Size: ".$value["size"]."</p>
                                            <p class='mb-2 text-muted text-uppercase small'>Color: ".$value["mau"]."</p>
                                        </div>
                                        <div class='qty'>
                                            <button type='button' onclick='this.parentNode.querySelector('input[type=number]').stepDown()' class='minus decrease'>-</button>
                                            <input type='number' size='4' name='updates[]' min='1' value='".$value["soluong"]."' class='cart-number'>
                                            <button type='button' onclick='this.parentNode.querySelector('input[type=number]').stepUp()' class='plus increase'>+</button>
                                        </div>
                                    </div>
                                    <div class='d-flex justify-content-between align-items-center'>
                                        <div>
                                            <a href='./?to=cart&action=xoa&id_giay=".$value["id_giay"]."' type='button' class='card-link-secondary small text-uppercase mr-3'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                                    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z' />
                                                    <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z' />
                                                </svg>
                                            </a>
                                        </div>
                                        <p class='mb-0'><span><strong>".number_format($thanhtien, 0, ',', ',')."₫</strong></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ";
                    }
            echo
            "
                    <div class='row cart-note'>
                        <div class='col 12'>
                            <p class='cart-note-label'>Chính sách đổi trả</p>
                            <ul class='policy'>
                                <li>Chính sách 1</li>
                                <li>Chính sách 2</li>
                                <li>Chính sách 3</li>
                                <li>Chính sách 4</li>
                                <li>Chính sách 5</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class='col-lg-4 col-sm-12'>
                    <a href='./?to=home' class='continue'>Tiếp tục mua hàng →</a>
                    <div class='cart-summary'>
                        <h3>Thông tin thanh toán</h3>
                        <div class='summary-total'>
                            <p>
                                Tổng tiền: <span>".number_format($tongtien, 0, ',', ',')."₫</span>
                            </p>
                        </div>
                        <h5>Bạn có thể nhập mã giảm giá khi xác nhận thanh toán</h5>
                        <a class='checkout-btn button' href='./?to=purchase'>THANH TOÁN</a>
                    </div>
                </div>
            </div>

            ";

            // Có thể bạn sẽ thích
            echo
            "
            <div class='row'>
                <div class='col'>
                    <div class='heading'>
                        <h2>Có thể bạn sẽ thích</h2>
                        <a class='more' href='./?to=search&from=another&name=xemthem&value=moi'>Xem thêm</a>
                    </div>
                </div>
            </div>
            ";

            $this->LoadNewArrival(4);



        // End div container
        echo
        "
        </div>
        ";



    }

    private function LoadNewArrival($soluonghienthi){

        // load danh sách giày mới nhất
        $giayModel = new GiayModel();
        $giays = $giayModel->LoadNewArrival("2021-1-1");

        echo
        "
            <div class='row pro-list'>
        ";

        // thực hiện in ra danh sách       
        for ($i=0; $i < $soluonghienthi && $i < count($giays) ; $i++) {

            // trường hợp giày có thông tin giảm giá
            if (isset($giays[$i]["phantramgiam"])) {
                $giasaugiam = $giays[$i]["gia"]* (100 - $giays[$i]["phantramgiam"])/100;
                echo ("
                        <div class='col-lg-3 col-md-6 col-6 products'>
                            <div class='pro-img'>
                                <div class='pro-sale'><span>-".$giays[$i]["phantramgiam"]."%</span></div>
                                <a href='./?to=detail&id=".$giays[$i]["id_giay"]."'>
                                    <img class='pro-img pro-img-1' src='".$giays[$i]["anhchinh"]."'>
                                    <img class='pro-img' src='".$giays[$i]["anhphu1"]."'>

                                </a>
                                <div class='pro-btn d-flex'>
                                    <a href='./?to=detail&id=".$giays[$i]["id_giay"]."' class='hidden-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                  </svg></a>
                                </div>
                            </div>
                            <div class='pro-detail'>
                                <h3 class='pro-name'><a href='./?to=detail&id=".$giays[$i]["id_giay"]."'>".$giays[$i]["ten"]."</a></h3>
                                <div class='pro-price'>
                                    <p class='pro-price sale'>".number_format($giasaugiam, 0, ',', ',')."đ 
                                        <span class='pro-price-retail'><del>".number_format($giays[$i]["gia"], 0, ',', ',')."₫</del></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                     ");
            }
            // Trường hợp giày không có thông tin giảm giá
            else{               
                echo ("
                        <div class='col-lg-3 col-md-6 col-6 products'>
                            <div class='pro-img'>
                                
                                <a href='./?to=detail&id=".$giays[$i]["id_giay"]."'>
                                    <img class='pro-img pro-img-1' src='".$giays[$i]["anhchinh"]."'>
                                    <img class='pro-img' src='".$giays[$i]["anhphu1"]."'>

                                </a>
                                <div class='pro-btn d-flex'>
                                    <a href='./?to=detail&id=".$giays[$i]["id_giay"]."' class='hidden-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                  </svg></a>
                                </div>
                            </div>
                            <div class='pro-detail'>
                                <h3 class='pro-name'><a href='./?to=detail&id=".$giays[$i]["id_giay"]."'>".$giays[$i]["ten"]."</a></h3>
                                <p class='pro-price'> 
                                    <span>".number_format($giays[$i]["gia"], 0, ',', ',')."₫</span>
                                </p>
                            </div>
                        </div>
                     ");
            }
        }

        echo
        "
            </div>;
        ";
    }


}
?>