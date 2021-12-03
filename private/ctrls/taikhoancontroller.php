<?php
require_once("private/models/taikhoanmodel.php");
class TaiKhoanController
{
    public function LoadPage()
    {
        $taikhoan = isset($_SESSION["taikhoan"]) ? $_SESSION["taikhoan"] : -1;
        if ($taikhoan == -1) {
            header("Location: ./?to=login");
        }
        else {
            $action = isset($_POST["action"]) ? $_POST["action"] : -1;
            if ($action == -1) {
                $action = isset($_GET["action"]) ? $_GET["action"] : -1;
            }
            if ($action == "capnhat") {
                // Cập nhật thông tin khách hàng
                $result = $this->CapNhatThongTinKhachHang($taikhoan);
                if ($result == false) {
                    $this->CapNhatThongTinKhachHangThatBai($taikhoan);
                }
                else {
                    $this->CapNhatThongTinKhachHangThanhCong($taikhoan);
                }
                exit();
            }
            if ($action == "thaydoimatkhau") {
                // Thay đổi mật khẩu
                
                $result = $this->ThayDoiMatKhau($taikhoan);
                if ($result == false) {
                    $this->ThayDoiMatKhauThatBai($taikhoan);
                }
                else {
                    $this->ThayDoiMatKhauThanhCong($taikhoan);
                }
                exit();
            }
            if ($action == "dangxuat") {

                
                if (isset($_SESSION["taikhoan"])) {
                    unset($_SESSION["taikhoan"]);
                    header("Location: index.php");
                }
                
            }
            $this->LoadGiaoDien($taikhoan);
            
        }
    }

    private function LoadGiaoDien($taikhoan)
    {
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfor = $taiKhoanModel->LoadTaiKhoanInfor($taikhoan["id_taikhoan"]);
        
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";

        echo
        "
        <div class='container'>
            <div class='row'>
                <div class='col-lg-3 col-md-12 mt-5'>
                    <ul class='nav nav-pills flex-column acc-menu' id='menu'>  
                        <button class='acc-items selected' id='mot'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z' />
                                <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z' />
                            </svg> Thông tin tài khoản                    
                        </button>
                        <button class='acc-items selected' id='hai'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-gear-fill' viewBox='0 0 16 16'>
                                <path d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z' />
                            </svg> Đổi mật khẩu
                        </button>
                        <a href='./?to=account&action=dangxuat'><button class='acc-items sign-out-btn'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z' />
                                <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z' />
                            </svg> Đăng xuất</button></a>
                    </ul>
                </div>

                <!--form1-->
                <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Thông tin tài khoản</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <input type='hidden' name='idkhachhang' value='".$khachhanginfor["id_khachhang"]."'>
                        <div class='mb-2'>
                            <label for='username' class='form-label'>Tài khoản</label>
                            <input type='text' id='username' value='".$taikhoan["tendangnhap"]."' class='form-control' placeholder='Tên đang nhập' disabled>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Họ-->
                                <div class='mb-2'>
                                    <label for='ho' class='form-label'>Họ</label>
                                    <input type='text' name='ho' value='".$khachhanginfor["ho"]."' class='form-control' id='ho'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Tên-->
                                <div class='mb-2'>
                                    <label for='ten' class='form-label'>Tên</label>
                                    <input type='text' name='ten' value='".$khachhanginfor["ten"]."' class='form-control' id='ten'>
                                </div>
                            </div>
                        </div>
                        <div class='mb-2'>
                            <label for='address' class='form-label'>Địa chỉ</label>
                            <input type='text' name='diachi' value='".$khachhanginfor["diachi"]."' class='form-control' id='address'>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='number' class='form-label'>Số điện thoại</label>
                                    <input type='number' name='sdt' value='".$khachhanginfor["sdt"]."' class='form-control' id='phone'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='email' class='form-label'>Email</label>
                                    <input type='email' name='email' value='".$khachhanginfor["email"]."' class='form-control' id='email'>
                                </div>
                            </div>
                        </div>
                        <button type='submit' name='action' value='capnhat' class='mt-3 update-btn button'>Cập nhật thông tin</button>

                    </form>
                </div>
                <!--form2-->
                <div class='col-lg-9 col-md-12' id='form2'>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Đổi mật khẩu</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <div class='row justify-content-center'>
                            <div class='col-4'>
                                <label for='oldpwd' class='col-form-label'>Nhập mật khẩu cũ </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='oldpwd' name='matkhaucu' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd' class='col-form-label'>Nhập mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='newpwd' name='matkhaumoi' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd2' class='col-form-label'>Nhập lại mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' name='nhaplaimatkhaumoi' id='newpwd2' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>


                        <div class='col-7'>
                        <button type='submit' name='action' value='thaydoimatkhau' class='mt-4 update-btn button'>Đổi mật khẩu</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";

        echo
        "
        <!--header-script-->
        <script src='public/scripts/header.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js' integrity='sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN' crossorigin='anonymous'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js' integrity='sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/' crossorigin='anonymous'></script>

        <!--footer-script-->
        <script src='public/scripts/footer.js'></script>
        <!--taikhoan-script-->
        <script src='public/scripts/taikhoan.js'></script>
        <!--bootstrap 5-script-->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js'></script>
        ";

    }

    private function CapNhatThongTinKhachHang()
    {
        
        $ho = $_POST["ho"];
        $ten = $_POST["ten"];
        $diachi = $_POST["diachi"];
        $sdt = $_POST["sdt"];
        $email = $_POST["email"];
        $idkhachhang = $_POST["idkhachhang"];

        $taiKhoanModel = new TaiKhoanModel();
        $result = $taiKhoanModel->CapNhatThonTinKhachHang($idkhachhang, $ho, $ten, $sdt, $diachi, $email);
        return $result;
    }

    private function CapNhatThongTinKhachHangThanhCong($taikhoan)
    {
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfor = $taiKhoanModel->LoadTaiKhoanInfor($taikhoan["id_taikhoan"]);
        
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";

        echo
        "
        <div class='container'>
            <div class='row'>
                <div class='col-lg-3 col-md-12 mt-5'>
                    <ul class='nav nav-pills flex-column acc-menu' id='menu'>  
                        <button class='acc-items selected' id='mot'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z' />
                                <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z' />
                            </svg> Thông tin tài khoản                    
                        </button>
                        <button class='acc-items selected' id='hai'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-gear-fill' viewBox='0 0 16 16'>
                                <path d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z' />
                            </svg> Đổi mật khẩu
                        </button>
                        <a href='./?to=account&action=dangxuat'><button class='acc-items sign-out-btn'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z' />
                                <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z' />
                            </svg> Đăng xuất</button>
                        </a>
                    </ul>
                </div>
                
                <!--form1-->
                    <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='alert alert-success' role='alert'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                    </svg><span>    Cập nhật thông tin thành công!</span>
                  </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Thông tin tài khoản</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <input type='hidden' name='idkhachhang' value='".$khachhanginfor["id_khachhang"]."'>
                        <div class='mb-2'>
                            <label for='username' class='form-label'>Tài khoản</label>
                            <input type='text' id='username' value='".$taikhoan["tendangnhap"]."' class='form-control' placeholder='Tên đang nhập' disabled>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Họ-->
                                <div class='mb-2'>
                                    <label for='ho' class='form-label'>Họ</label>
                                    <input type='text' name='ho' value='".$khachhanginfor["ho"]."' class='form-control' id='ho'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Tên-->
                                <div class='mb-2'>
                                    <label for='ten' class='form-label'>Tên</label>
                                    <input type='text' name='ten' value='".$khachhanginfor["ten"]."' class='form-control' id='ten'>
                                </div>
                            </div>
                        </div>
                        <div class='mb-2'>
                            <label for='address' class='form-label'>Địa chỉ</label>
                            <input type='text' name='diachi' value='".$khachhanginfor["diachi"]."' class='form-control' id='address'>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='number' class='form-label'>Số điện thoại</label>
                                    <input type='number' name='sdt' value='".$khachhanginfor["sdt"]."' class='form-control' id='phone'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='email' class='form-label'>Email</label>
                                    <input type='email' name='email' value='".$khachhanginfor["email"]."' class='form-control' id='email'>
                                </div>
                            </div>
                        </div>
                        <button type='submit' name='action' value='capnhat' class='mt-3 update-btn button'>Cập nhật thông tin</button>

                    </form>
                </div>
                <!--form2-->
                <div class='col-lg-9 col-md-12' id='form2'>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Đổi mật khẩu</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <div class='row justify-content-center'>
                            <div class='col-4'>
                                <label for='oldpwd' class='col-form-label'>Nhập mật khẩu cũ </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='oldpwd' name='matkhaucu' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd' class='col-form-label'>Nhập mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='newpwd' name='matkhaumoi' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd2' class='col-form-label'>Nhập lại mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' name='nhaplaimatkhaumoi' id='newpwd2' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>


                        <div class='col-7'>
                        <button type='submit' name='action' value='thaydoimatkhau' class='mt-4 update-btn button'>Đổi mật khẩu</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";

        echo
        "
        <!--header-script-->
        <script src='public/scripts/header.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js' integrity='sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN' crossorigin='anonymous'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js' integrity='sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/' crossorigin='anonymous'></script>

        <!--footer-script-->
        <script src='public/scripts/footer.js'></script>
        <!--taikhoan-script-->
        <script src='public/scripts/taikhoan.js'></script>
        <!--bootstrap 5-script-->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js'></script>
        ";
    }
    private function CapNhatThongTinKhachHangThatBai($taikhoan)
    {
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfor = $taiKhoanModel->LoadTaiKhoanInfor($taikhoan["id_taikhoan"]);
        
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";

        echo
        "
        <div class='container'>
            <div class='row'>
                <div class='col-lg-3 col-md-12 mt-5'>
                    <ul class='nav nav-pills flex-column acc-menu' id='menu'>  
                        <button class='acc-items selected' id='mot'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z' />
                                <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z' />
                            </svg> Thông tin tài khoản                    
                        </button>
                        <button class='acc-items selected' id='hai'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-gear-fill' viewBox='0 0 16 16'>
                                <path d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z' />
                            </svg> Đổi mật khẩu
                        </button>
                        <a href='./?to=account&action=dangxuat'><button class='acc-items sign-out-btn'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z' />
                                <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z' />
                            </svg> Đăng xuất</button>
                        </a>
                    </ul>
                </div>

                <!--form1-->
                <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='alert alert-danger' role='alert'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-exclamation-circle-fill' viewBox='0 0 16 16'>
                    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'/>
                    </svg><span> Cập nhật thông tin thất bại: Vui lòng kiểm tra lại thông tin!</span>
                    </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Thông tin tài khoản</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <input type='hidden' name='idkhachhang' value='".$khachhanginfor["id_khachhang"]."'>
                        <div class='mb-2'>
                            <label for='username' class='form-label'>Tài khoản</label>
                            <input type='text' id='username' value='".$taikhoan["tendangnhap"]."' class='form-control' placeholder='Tên đang nhập' disabled>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Họ-->
                                <div class='mb-2'>
                                    <label for='ho' class='form-label'>Họ</label>
                                    <input type='text' name='ho' value='".$khachhanginfor["ho"]."' class='form-control' id='ho'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Tên-->
                                <div class='mb-2'>
                                    <label for='ten' class='form-label'>Tên</label>
                                    <input type='text' name='ten' value='".$khachhanginfor["ten"]."' class='form-control' id='ten'>
                                </div>
                            </div>
                        </div>
                        <div class='mb-2'>
                            <label for='address' class='form-label'>Địa chỉ</label>
                            <input type='text' name='diachi' value='".$khachhanginfor["diachi"]."' class='form-control' id='address'>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='number' class='form-label'>Số điện thoại</label>
                                    <input type='number' name='sdt' value='".$khachhanginfor["sdt"]."' class='form-control' id='phone'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='email' class='form-label'>Email</label>
                                    <input type='email' name='email' value='".$khachhanginfor["email"]."' class='form-control' id='email'>
                                </div>
                            </div>
                        </div>
                        <span><strong>×</strong> Cập nhật thông tin thất bại: tài khoản hoặc mật khẩu không đúng</span>
                        <button type='submit' name='action' value='capnhat' class='mt-3 update-btn button'>Cập nhật thông tin</button>

                    </form>
                </div>
                <!--form2-->
                <div class='col-lg-9 col-md-12' id='form2'>
                    <div class='alert alert-danger' role='alert'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-exclamation-circle-fill' viewBox='0 0 16 16'>
                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'/>
                        </svg><span> Vui lòng kiểm tra lại thông tin</span>
                    </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Đổi mật khẩu</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <div class='row justify-content-center'>
                            <div class='col-4'>
                                <label for='oldpwd' class='col-form-label'>Nhập mật khẩu cũ </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='oldpwd' name='matkhaucu' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd' class='col-form-label'>Nhập mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='newpwd' name='matkhaumoi' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd2' class='col-form-label'>Nhập lại mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' name='nhaplaimatkhaumoi' id='newpwd2' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>


                        <div class='col-7'>
                        <button type='submit' name='action' value='thaydoimatkhau' class='mt-4 update-btn button'>Đổi mật khẩu</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";

        echo
        "
        <!--header-script-->
        <script src='public/scripts/header.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js' integrity='sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN' crossorigin='anonymous'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js' integrity='sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/' crossorigin='anonymous'></script>

        <!--footer-script-->
        <script src='public/scripts/footer.js'></script>
        <!--taikhoan-script-->
        <script src='public/scripts/taikhoan.js'></script>
        <!--bootstrap 5-script-->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js'></script>
        ";
    }

    private function ThayDoiMatKhau($taikhoan)
    {
        $tendangnhap = $taikhoan["tendangnhap"];
        $matkhaucu = $_POST["matkhaucu"];
        $matkhaumoi = $_POST["matkhaumoi"];
        $nhaplaimatkhaumoi = $_POST["nhaplaimatkhaumoi"];

        $taiKhoanModel = new TaiKhoanModel();
        $result = $taiKhoanModel->ThayDoiMatKhau($tendangnhap, $matkhaucu, $matkhaumoi, $nhaplaimatkhaumoi);
        return $result;
    }

    private function ThayDoiMatKhauThanhCong($taikhoan)
    {
    
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfor = $taiKhoanModel->LoadTaiKhoanInfor($taikhoan["id_taikhoan"]);
        
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";

        echo
        "
        <div class='container'>
            <div class='row'>
                <div class='col-lg-3 col-md-12 mt-5'>
                    <ul class='nav nav-pills flex-column acc-menu' id='menu'>  
                        <button class='acc-items selected' id='hai'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z' />
                                <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z' />
                            </svg> Thông tin tài khoản                    
                        </button>
                        <button class='acc-items selected' id='mot'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-gear-fill' viewBox='0 0 16 16'>
                                <path d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z' />
                            </svg> Đổi mật khẩu
                        </button>
                        <a><button class='acc-items sign-out-btn'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z' />
                                <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z' />
                            </svg> Đăng xuất</button>
                        </a>
                    </ul>
                </div>

                <!--form1-->
                <div class='col-lg-9 col-md-12' id='form2'>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Thông tin tài khoản</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <input type='hidden' name='idkhachhang' value='".$khachhanginfor["id_khachhang"]."'>
                        <div class='mb-2'>
                            <label for='username' class='form-label'>Tài khoản</label>
                            <input type='text' id='username' value='".$taikhoan["tendangnhap"]."' class='form-control' placeholder='Tên đang nhập' disabled>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Họ-->
                                <div class='mb-2'>
                                    <label for='ho' class='form-label'>Họ</label>
                                    <input type='text' name='ho' value='".$khachhanginfor["ho"]."' class='form-control' id='ho'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Tên-->
                                <div class='mb-2'>
                                    <label for='ten' class='form-label'>Tên</label>
                                    <input type='text' name='ten' value='".$khachhanginfor["ten"]."' class='form-control' id='ten'>
                                </div>
                            </div>
                        </div>
                        <div class='mb-2'>
                            <label for='address' class='form-label'>Địa chỉ</label>
                            <input type='text' name='diachi' value='".$khachhanginfor["diachi"]."' class='form-control' id='address'>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='number' class='form-label'>Số điện thoại</label>
                                    <input type='number' name='sdt' value='".$khachhanginfor["sdt"]."' class='form-control' id='phone'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='email' class='form-label'>Email</label>
                                    <input type='email' name='email' value='".$khachhanginfor["email"]."' class='form-control' id='email'>
                                </div>
                            </div>
                        </div>
                        <button type='submit' name='action' value='capnhat' class='mt-3 update-btn button'>Cập nhật thông tin</button>

                    </form>
                </div>
                <!--form2-->
                <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='alert alert-success' role='alert'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                        </svg><span>    Thay đổi mật khẩu thành công!</span>
                    </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Đổi mật khẩu</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <div class='row justify-content-center'>
                            <div class='col-4'>
                                <label for='oldpwd' class='col-form-label'>Nhập mật khẩu cũ </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='oldpwd' name='matkhaucu' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd' class='col-form-label'>Nhập mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='newpwd' name='matkhaumoi' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd2' class='col-form-label'>Nhập lại mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' name='nhaplaimatkhaumoi' id='newpwd2' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>


                        <div class='col-7'>
                        <button type='submit' name='action' value='thaydoimatkhau' class='mt-4 update-btn button'>Đổi mật khẩu</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";

        echo
        "
        <!--header-script-->
        <script src='public/scripts/header.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js' integrity='sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN' crossorigin='anonymous'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js' integrity='sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/' crossorigin='anonymous'></script>

        <!--footer-script-->
        <script src='public/scripts/footer.js'></script>
        <!--taikhoan-script-->
        <script src='public/scripts/taikhoan.js'></script>
        <!--bootstrap 5-script-->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js'></script>
        ";
    }
    private function ThayDoiMatKhauThatBai($taikhoan)
    {
        
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfor = $taiKhoanModel->LoadTaiKhoanInfor($taikhoan["id_taikhoan"]);
        
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";

        echo
        "
        <div class='container'>
            <div class='row'>
                <div class='col-lg-3 col-md-12 mt-5'>
                    <ul class='nav nav-pills flex-column acc-menu' id='menu'>  
                        <button class='acc-items selected' id='hai'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z' />
                                <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z' />
                            </svg> Thông tin tài khoản                    
                        </button>
                        <button class='acc-items selected' id='mot'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-gear-fill' viewBox='0 0 16 16'>
                                <path d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z' />
                            </svg> Đổi mật khẩu
                        </button>
                        <a href='./?to=account&action=dangxuat'><button class='acc-items sign-out-btn'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z' />
                                <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z' />
                            </svg> Đăng xuất</button>
                        </a>
                    </ul>
                </div>

                <!--form1-->
                <div class='col-lg-9 col-md-12' id='form2'>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Thông tin tài khoản</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <input type='hidden' name='idkhachhang' value='".$khachhanginfor["id_khachhang"]."'>
                        <div class='mb-2'>
                            <label for='username' class='form-label'>Tài khoản</label>
                            <input type='text' id='username' value='".$taikhoan["tendangnhap"]."' class='form-control' placeholder='Tên đang nhập' disabled>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Họ-->
                                <div class='mb-2'>
                                    <label for='ho' class='form-label'>Họ</label>
                                    <input type='text' name='ho' value='".$khachhanginfor["ho"]."' class='form-control' id='ho'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Tên-->
                                <div class='mb-2'>
                                    <label for='ten' class='form-label'>Tên</label>
                                    <input type='text' name='ten' value='".$khachhanginfor["ten"]."' class='form-control' id='ten'>
                                </div>
                            </div>
                        </div>
                        <div class='mb-2'>
                            <label for='address' class='form-label'>Địa chỉ</label>
                            <input type='text' name='diachi' value='".$khachhanginfor["diachi"]."' class='form-control' id='address'>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='number' class='form-label'>Số điện thoại</label>
                                    <input type='number' name='sdt' value='".$khachhanginfor["sdt"]."' class='form-control' id='phone'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='email' class='form-label'>Email</label>
                                    <input type='email' name='email' value='".$khachhanginfor["email"]."' class='form-control' id='email'>
                                </div>
                            </div>
                        </div>
                        <button type='submit' name='action' value='capnhat' class='mt-3 update-btn button'>Cập nhật thông tin</button>

                    </form>
                </div>
                <!--form2-->
                <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='alert alert-danger' role='alert'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-exclamation-circle-fill' viewBox='0 0 16 16'>
                    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'/>
                    </svg><span> Thay đổi mật khẩu thất bại: Vui lòng kiểm tra và nhập lại thông tin!</span>
                    </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Đổi mật khẩu</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <div class='row justify-content-center'>
                            <div class='col-4'>
                                <label for='oldpwd' class='col-form-label'>Nhập mật khẩu cũ </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='oldpwd' name='matkhaucu' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd' class='col-form-label'>Nhập mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='newpwd' name='matkhaumoi' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd2' class='col-form-label'>Nhập lại mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' name='nhaplaimatkhaumoi' id='newpwd2' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>


                        <div class='col-7'>
                        <button type='submit' name='action' value='thaydoimatkhau' class='mt-4 update-btn button'>Đổi mật khẩu</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";

        echo
        "
        <!--header-script-->
        <script src='public/scripts/header.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js' integrity='sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN' crossorigin='anonymous'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js' integrity='sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/' crossorigin='anonymous'></script>

        <!--footer-script-->
        <script src='public/scripts/footer.js'></script>
        <!--taikhoan-script-->
        <script src='public/scripts/taikhoan.js'></script>
        <!--bootstrap 5-script-->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js'></script>
        ";
    }
}
?>