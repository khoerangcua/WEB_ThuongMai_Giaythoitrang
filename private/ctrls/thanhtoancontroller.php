<?php
require_once("private/models/giohangmodel.php");
require_once("private/models/taikhoanmodel.php");
require_once("private/models/hoadonmodel.php");
class ThanhToanController
{
    public function LoadPage()
    {
        $taikhoan = isset($_SESSION["taikhoan"]) ? $_SESSION["taikhoan"] : -1;
        $action = isset($_GET["action"]) ? $_GET["action"] : -1;
        if ($taikhoan == -1) 
        {
            header("Location: ./?to=login");
        }
        else {
            if ($action == -1) {
                $this->LoadGiaoDienThanhToan($taikhoan["id_taikhoan"]);
            } else {
                $ketqua = $this->ThanhToan();
                if ($ketqua == true) {
                    $chiphivanchuyen = $_GET["hinhthucvanchuyen"] == "tieuchuan" ? 25000: 50000;
                    $this->ThanhToanThanhCong($taikhoan["id_taikhoan"], $chiphivanchuyen);
                }
                else {
                    $this->ThanhToanThatBai();
                }
            }            
        }             
    }

    private function ThanhToanThanhCong($id, $chiphivanchuyen)
    {
       // Load giỏ hàng
       $gioHangModel = new GioHangModel();
       $giays = $gioHangModel->LoadGioHang($id);

       // Load thông tin tài khoản
       $taiKhoanModel = new TaiKhoanModel();
       $khachhang = $taiKhoanModel->LoadTaiKhoanInfor($id);

       $tamtinh = 0; 
       $giamgia = 0;
       foreach ($giays as $key => $value) {
           $tamtinh += $value["gia"] * $value["soluong"];
           $giamgia += (isset($value["phantramgiam"]) ? $value["gia"] * $value["phantramgiam"] / 100 : 0) * $value["soluong"];
       }
       $tongtien = $tamtinh + $chiphivanchuyen - $giamgia;

       $hoten = $khachhang["ho"] . " " . $khachhang["ten"];

       echo
       "
       <div class='container'>
           <a href='./?to=trangchu'><img src='public/images/icons/header-icon.png' class='d-none d-lg-block icon-lg'></a>
           <a class='row justify-content-center' href='./?to=trangchu'><img src='public/images/icons/header-icon.png' class='d-lg-none d-xl-block d-xl-none icon'></a>
           <br style='clear:both'>
           <div class='alert alert-success' role='alert'>
           <p>Bạn đã đặt hàng thành công!</p>
           <p>Sẽ có người gọi điện xác nhận đơn hàng của bạn trong vòng 24h. Mong bạn chú ý điện thoại nhé!</p>
         </div>
           <div class='row justify-content-center align-items-center'>
           <div class='col-sm-10 col-md-10 col-lg-8 '>
                    
                    <div class='row p-2' style='background-color: #dfe0e1'>
                        <div class='col-lg-7 col-md-12'>
                            <div class='row login-header'>
                                <h3 class='order-heading'>Thông tin giao hàng</h3>
                            </div>
                            <p class='success-info'>
                                Họ và tên: $hoten
                            </p>
                            <p class='success-info'>
                                Số điện thoại: ".$khachhang["sdt"]." 
                            </p>

                           <p class='success-info'>
                               Địa chỉ: ".$khachhang["diachi"]."
                            </p>
                        </div>
                        
                        <div class='col-lg-5 col-md-12'>    
                            <h3 class='order-heading'>Chi tiết về đơn hàng</h3>
                       <table class='product-table'>
                           <thead>
                               <tr>
                                   <th><span class='visually-hidden'>Ảnh sản phẩm</span></th>
                                   <th><span class='visually-hidden'>Thông tin sản phẩm</span< /th>
                                   <th><span class='visually-hidden'>Số lượng</span< /th>
                                   <th><span class='visually-hidden'>Đơn giá</span< /th>
                               </tr>

                           </thead>
                           <tbody>
                           ";
                           foreach ($giays as $key => $value) {
                               echo
                               "
                               <tr class='product'>
                                   <td class='product-image'>
                                       <div class='product-thumbnail'>
                                           <div class='thumbnail-wrapper'>
                                               <img class='thumbnail-img' src='".$value["anhchinh"]."'>
                                               <span class='thumbnail-quantity'>".$value["soluong"]."</span>
                                           </div>
                                       </div>
                                   </td>
                                   <th class='product-desc'>
                                       <span class='product-name'>".$value["ten"]."</span>
                                       <span class='product-info'>Size: ".$value["size"]."</span>
                                   </th>
                                   <td class='product-quantity visually-hidden'>".$value["soluong"]."</td>
                                   <td class='product-price'>
                                       <span>".number_format($value["gia"],0,".",",")."₫</span>
                                   </td>
                               </tr>
                               ";
                           }                               
                           echo"
                           </tbody>
                        </table>
                        <div class='col-12'>                      
                           <div class='total'>
                               <p>
                                   Tổng cộng: <span id='tongcong2'>".number_format($tongtien, 0, '.', ',')."₫</span>
                               </p>
                           </div>
                        </div>
                        <div class='col-7 mb-4'>
                            <button class='order-btn'><a href='index.php'>Quay lại Trang chủ</a></button>
                        </div>
                    </div>
                    </div>
               </div>
               <div class='note mt-5'>
                                <h3 class='order-heading'>Lưu ý với khách hàng</h3>
                                <p>***Đối với hình thức thanh toán chuyển khoản quý khách vui lòng thực hiện chuyển khoản đến: </p>
                                <p>- Tài khoản Vietcombank chi nhánh TPHCM</p>
                                <p>- STK: 123456789123</p>
                                <p>- Chủ tài khoản: Bảo Hải Đức Đạt Duy</p>
                                <p>Với nội dung: Họ tên và Số điện thoại của quý khách. Vd: Lê Duy 0123456789 </p>
                            </div>
           </div>
       ";
   }  
    private function ThanhToanThatBai()
    {
        // Chưa làm
        print ("thatbai");
    }

    private function ThanhToan()
    {
        // Lấy thông tin hóa đơn
        $idtaikhoan = $_GET["idtaikhoan"];
        $idkhachhang = $_GET["idkhachhang"];
        $ten = str_replace("+", " ", $_GET["hoten"]);
        $email = $_GET["email"];
        $sdt = $_GET["sodienthoai"];
        $diachi = str_replace("+", " ", $_GET["diachi"]);
        $hinhthucvanchuyen = $_GET["hinhthucvanchuyen"] == "tieuchuan" ? "Tiêu chuẩn": "Nhanh";
        $hinhthucthanhtoan = $_GET["hinhthucthanhtoan"] == "tienmat" ? "Tiền mặt" : "Chuyển khoản";
        $chiphivanchuyen = $_GET["hinhthucvanchuyen"] == "tieuchuan" ? 25000: 50000;

        // Thêm mới hóa đơn và chi tiết hóa đơn
        $hoaDonModel = new HoaDonModel();
        $result = $hoaDonModel->ThemHoaDon($idtaikhoan, $idkhachhang, $ten, $email, $sdt, $diachi, $hinhthucvanchuyen, $hinhthucthanhtoan, $chiphivanchuyen);
        return $result;
    }

    private function LoadGiaoDienThanhToan($id)
    {
        // Load giỏ hàng
        $gioHangModel = new GioHangModel();
        $giays = $gioHangModel->LoadGioHang($id);

        // Load thông tin tài khoản
        $taiKhoanModel = new TaiKhoanModel();
        $khachhang = $taiKhoanModel->LoadTaiKhoanInfor($id);

        $tamtinh = 0; 
        $giamgia = 0;
        foreach ($giays as $key => $value) {
            $tamtinh += $value["gia"] * $value["soluong"];
            $giamgia += (isset($value["phantramgiam"]) ? $value["gia"] * $value["phantramgiam"] / 100 : 0) * $value["soluong"];
        }
        $tongtien = $tamtinh + 50000 - $giamgia;

        $hoten = $khachhang["ho"] . " " . $khachhang["ten"];

        echo
        "
        <div class='container'>
            <a href='./?to=trangchu'><img src='public/images/icons/header-icon.png' class='d-none d-lg-block icon-lg'></a>
            <a class='row justify-content-center' href='./?to=trangchu'><img src='public/images/icons/header-icon.png' class='d-lg-none d-xl-block d-xl-none icon'></a>
            <br style='clear:both'> 
            <form method='GET' action='./'>
                <input type='hidden' name='to' value='purchase'>
                <input type='hidden' name='action' value='thanhtoan'>
                <input type='hidden' name='idkhachhang' value='".$khachhang["id_khachhang"]."'>
                <input type='hidden' name='idtaikhoan' value='".$khachhang["id_taikhoan"]."'>
                <div class='row'>
                    <div class='col-lg-7 col-sm-12 mb-5'>
                        <div class='login-form row'>
                            <h3 class='order-heading'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-card-text' viewBox='0 0 16 16'>
                                    <path d='M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z' />
                                    <path d='M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z' />
                                </svg> Thông tin giao hàng</h3>
                            <div class='col-12'>
                                <div class='form-floating mb-2'>
                                    <input type='text' name='hoten' value='$hoten' class='form-control' id='floatingInput' placeholder='Họ và tên'>
                                    <label for='floatingInput'>Họ và tên</label>
                                </div>
                            </div>
                            <div class='col-7'>
                                <div class='form-floating mb-2'>
                                    <input type='email' name='email' value='".$khachhang["email"]."' class='form-control' id='floatingPassword' placeholder='Email'>
                                    <label for='floatingPassword'>Email</label>
                                </div>
                            </div>
                            <div class='col-5'>
                                <div class='form-floating mb-2'>
                                    <input type='number' name='sodienthoai' value='".$khachhang["sdt"]."' class='form-control' id='floatingPassword' placeholder='Số điện thoại'>
                                    <label for='floatingPassword'>Số điện thoại</label>
                                </div>
                            </div>

                            <div class='col-12'>
                                <div class='form-floating mb-3'>
                                    <input type='text' name='diachi' value='".$khachhang["diachi"]."' class='form-control' id='floatingPassword' placeholder='Địa chỉ'>
                                    <label for='floatingPassword'>Địa chỉ</label>
                                </div>
                            </div>

                            <div class='col-12 mb-3'>
                                <h3 class='order-heading'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-truck' viewBox='0 0 16 16'>
                                        <path d='M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z' />
                                    </svg> Hình thức vận chuyển</h3>
                                <div class='tbl-purchase'>
                                    <div class='form-check purchase1'>
                                        <input class='form-check-input' id='giaohangtieuchuan' type='radio' name='hinhthucvanchuyen' value='tieuchuan' id=''>
                                        <label class='form-check-label' for='flexRadioDefault1'>
                                            Giao hàng tiêu chuẩn
                                        </label>
                                    </div>
                                    <div class='form-check purchase2'>
                                        <input class='form-check-input' id='giaohangnhanh' type='radio' name='hinhthucvanchuyen' value='nhanh' id='' checked>
                                        <label class='form-check-label' for='flexRadioDefault2'>
                                            Giao hàng nhanh
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class='col-12'>
                                <h3 class='order-heading'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-credit-card-2-back' viewBox='0 0 16 16'>
                                        <path d='M11 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1z' />
                                        <path d='M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm13 2v5H1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-1 9H2a1 1 0 0 1-1-1v-1h14v1a1 1 0 0 1-1 1z' />
                                    </svg> Hình thức thanh toán</h3>

                                <div class='tbl-purchase mb-3'>
                                    <div class='form-check purchase1'>
                                        <input class='form-check-input' type='radio' name='hinhthucthanhtoan' value='tienmat' id='' checked>
                                        <label class='form-check-label' for='flexRadioDefault1'>
                                            Thanh toán khi nhận hàng (COD)
                                        </label>
                                    </div>
                                    <div class='form-check purchase2'>
                                        <input class='form-check-input' type='radio' name='hinhthucthanhtoan' value='chuyenkhoan' id=''>
                                        <label class='form-check-label' for='flexRadioDefault2'>
                                            Chuyển khoản qua ngân hàng
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class='col-12 d-lg-none'>
                                <h3 class='order-heading'>Tóm tắt đơn hàng</h3>
                                <div class='summary'>
                                    <p>
                                        Tạm tính: <span id='tamtinh1' value='$tamtinh'>".number_format($tamtinh, 0, ',', ',')."₫</span>
                                    </p>
                                    <p>
                                        Phí vận chuyển: <span id='chiphivanchuyen_ui1' value='50000'>50,000₫</span>
                                    </p>
                                    <p>
                                        Giảm giá: <span id='giamgia1' value='$giamgia'>- ".number_format($giamgia, 0, '.', ',')."₫</span>
                                    </p>
                                </div>
                                <div class='total'>
                                    <p>
                                        Tổng cộng: <span id='tongcong1'>".number_format($tongtien, 0, '.', ',')."₫</span>
                                    </p>
                                </div>
                            </div>

                            <div class='col-7'>
                                <a class='order-return' href='?to=cart'>← Quay lại giỏ hàng</a>
                            </div>
                            <div class='col-5'>
                                <button type='submit' class='order-btn'>Đặt hàng</button>
                            </div>
                        </div>

                    </div>
                    <div class='col-lg-5 col-sm-12'>
                        <h3 class='order-heading'>Chi tiết về đơn hàng</h3>
                        <table class='product-table'>
                            <thead>
                                <tr>
                                    <th><span class='visually-hidden'>Ảnh sản phẩm</span></th>
                                    <th><span class='visually-hidden'>Thông tin sản phẩm</span< /th>
                                    <th><span class='visually-hidden'>Số lượng</span< /th>
                                    <th><span class='visually-hidden'>Đơn giá</span< /th>
                                </tr>

                            </thead>
                            <tbody>
                            ";
                            foreach ($giays as $key => $value) {
                                echo
                                "
                                <tr class='product'>
                                    <td class='product-image'>
                                        <div class='product-thumbnail'>
                                            <div class='thumbnail-wrapper'>
                                                <img class='thumbnail-img' src='".$value["anhchinh"]."'>
                                                <span class='thumbnail-quantity'>".$value["soluong"]."</span>
                                            </div>
                                        </div>
                                    </td>
                                    <th class='product-desc'>
                                        <span class='product-name'>".$value["ten"]."</span>
                                        <span class='product-info'>Size: ".$value["size"]."</span>
                                    </th>
                                    <td class='product-quantity visually-hidden'>".$value["soluong"]."</td>
                                    <td class='product-price'>
                                        <span>".number_format($value["gia"],0,".",",")."₫</span>
                                    </td>
                                </tr>
                                ";
                            }                               
                            echo"
                            </tbody>
                        </table>
                        <div class='col-12 d-md-none d-sm-none d-lg-block'>
                            <h3 class='order-heading'>Tóm tắt đơn hàng</h3>
                            <div class='summary'>
                                <p>
                                    Tạm tính: <span id='tamtinh2' value='$tamtinh'>".number_format($tamtinh, 0, ".", ",")."₫</span>
                                </p>
                                <p>
                                    Phí vận chuyển: <span id='chiphivanchuyen_ui2' value='50000'>50,000₫</span>
                                </p>
                                <p>
                                    Giảm giá: <span id='giamgia2' value='$giamgia'>- ".number_format($giamgia, 0, '.', ',')."₫</span>
                                </p>
                            </div>
                            <div class='total'>
                                <p>
                                    Tổng cộng: <span id='tongcong2'>".number_format($tongtien, 0, '.', ',')."₫</span>
                                </p>
                            </div>
                        </div>

                        <div class='note'>
                            <h3 class='order-heading'>Lưu ý với khách hàng</h3>
                            <p>***Đối với hình thức thanh toán chuyển khoản quý khách vui lòng thực hiện chuyển khoản đến: </p>
                            <p>- Tài khoản Vietcombank chi nhánh TPHCM</p>
                            <p>- STK: 123456789123</p>
                            <p>- Chủ tài khoản: Bảo Hải Đức Đạt Duy</p>
                            <p>Với nội dung: Họ tên và Số điện thoại của quý khách. Vd: Lê Duy 0123456789 </p>
                        </div>
                    </div>
                </div>
            </form>
	    </div>
        ";
    }
}
?>