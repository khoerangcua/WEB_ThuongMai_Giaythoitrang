<?php
require_once("private/models/taikhoanmodel.php");
class DangNhapController
{
    public function KiemTraDangNhap(){
        if (isset($_POST["dangnhap"])) {            
            $tendangnhap = $_POST["tendangnhap"];
            $matkhau = $_POST["matkhau"];

            $taiKhoanModel = new TaiKhoanModel();
            $taikhoan = $taiKhoanModel->KiemTraDangNhap($tendangnhap, $matkhau);
            
           
            if ($taikhoan == -1 ) {
               
                $this->HienThiDangNhapThatBai();
                exit();
            }
            else {
                
                $_SESSION["taikhoan"] = $taikhoan;
                
            }
        }
        if (isset($_SESSION["taikhoan"]) && $_SESSION["taikhoan"] != false ) {
            header("Location: ./?to=account");       
        }
        else {
            $this->LoadTrangDangNhap();
        }
    }

    private function LoadTrangDangNhap(){
        echo 
        "
        <div class='container'>
            <div class='row vh-100 justify-content-center align-items-center'>
                <div class='col-sm-8 col-md-6 col-lg-4 shadow login-ui'>
                    <a class='row justify-content-center' href='./?page=trangchu'><img src='public/images/icons/header-icon.png' class='icon'></a>
                    <div class='row login-header'>
                        <h3>đăng nhập</h3>
                    </div>

                    <form method='post' class='login-form' action='./?to=login'>
                        <input type='hidden' name='dangnhap' value='true'>
                        <div class='form-floating mb-4'>
                            <input type='text' name='tendangnhap' class='form-control' id='floatingInput' placeholder='Tên đăng nhập'>
                            <label for='floatingInput'>Tên đăng nhập</label>
                        </div>
                        <div class='form-floating mb-2'>
                            <input type='password' name='matkhau' class='form-control' id='floatingPassword' placeholder='Mật khẩu'>
                            <label for='floatingPassword'>Mật khẩu</label>
                        </div>
                        <div class='mb-4 form-check'>
                            <input type='checkbox' name='remember' class='form-check-input' id='exampleCheck1'>
                            <label class='form-check-label' for='exampleCheck1'>Ghi nhớ đăng nhập</label>
                            <a href='./?to=rspw' class='forgot'>Quên mật khẩu?</a>
                        </div>
                        <button type='submit' class='login-btn mb-4'>Đăng nhập</button>
                        <p class='login-signup'>Chưa có tài khoản? <a href='./?to=signup'>Đăng ký tại đây</a></p>
                    </form>
                </div>
            </div>
	    </div>
        ";

    }

    private function HienThiDangNhapThatBai(){
        echo 
        "
        <div class='container'>
            <div class='row vh-100 justify-content-center align-items-center'>
                <div class='col-sm-8 col-md-6 col-lg-4 shadow login-ui'>
                    <a class='row justify-content-center' href='./?page=trangchu'><img src='public/images/icons/header-icon.png' class='icon'></a>
                    <div class='row login-header'>
                        <h3>đăng nhập</h3>
                    </div>

                    <form method='POST' class='login-form' action='./?to=login'>
                        
                        <input type='hidden' name='dangnhap' value='true'>
                        <div class='form-floating mb-4'>
                            <input type='text' name='tendangnhap' class='form-control' id='floatingInput' placeholder='Tên đăng nhập'>
                            <label for='floatingInput'>Tên đăng nhập</label>
                        </div>
                        <div class='form-floating mb-2'>
                            <input type='password' name='matkhau' class='form-control' id='floatingPassword' placeholder='Mật khẩu'>
                            <label for='floatingPassword'>Mật khẩu</label>
                        </div>
                        <div class='mb-4 form-check'>
                            <input type='checkbox' name='remember' class='form-check-input' id='exampleCheck1'>
                            <label class='form-check-label' for='exampleCheck1'>Ghi nhớ đăng nhập</label>
                            <a href='resetpassword.php' class='forgot'>Quên mật khẩu?</a>
                        </div>
                        <button type='submit' class='login-btn mb-3'>Đăng nhập</button>
                        <p class='login-fail mb-4'><strong>×</strong> Đăng nhập thất bại: tài khoản hoặc mật khẩu không đúng </p>
                        <p class='login-signup'>Chưa có tài khoản? <a href='./?to=signup'>Đăng ký tại đây</a></p>
                    </form>
                </div>
            </div>
	    </div>
        ";
    }

}
?>