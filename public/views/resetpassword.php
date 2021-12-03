<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Quên mật khẩu | Reset Password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width = device-width" initial-scale="1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link href="public/styles/reset.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">
		<div class="row vh-100 justify-content-center align-items-center">
			<div class="col-sm-8 col-md-6 col-lg-4 shadow reset-ui">
				<div class="row justify-content-center">
					<img src="public/images/icons/header-icon.png" class="icon">
				</div>
				<div class="row reset-header">
					<h3>Quên mật khẩu</h3>
				</div>
				<form class="reset-form">
					<div class="form-floating">
						<input type="email" class="form-control" id="floatingInput" placeholder="Chức năng khôi phục mật khẩu hiện tại chưa hoạt động được" disabled>
						<label for="floatingInput">Chức năng này hiện tại không khả dụng</label>
					</div>
					<p class="reset-note">Chúng tôi sẽ gửi mật khẩu mới trong email của bạn khi bạn khôi phục mật khẩu</p>
					<button type="submit" class="reset-btn mb-4" disabled>Khôi phục mật khẩu</button>
					<p class="reset-signup"><a href="./?to=login">Đăng nhập | </a><a href="./?to=signup">Đăng ký</a></p>
				</form>
			</div>
		</div>
	</div>
	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
</body>
</html>