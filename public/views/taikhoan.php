<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <!--bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <!--link style-->
    <link rel="stylesheet" href="public/styles/thongtintaikhoan.css">
    <link rel="stylesheet" href="public/styles/header.css">
    <link rel="stylesheet" href="public/styles/footer.css">

    <!--(chỉnh chỗ này)-->
</head>

<body>
    <?php
    require_once("private/ctrls/taikhoancontroller.php");
    $taiKhoanController = new TaiKhoanController();
    $taiKhoanController->LoadPage();
    ?>
</body>



</html>