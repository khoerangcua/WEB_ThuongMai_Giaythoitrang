<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <!--bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <!--link style-->
    <link rel="stylesheet" href="public/styles/header.css">
    <link rel="stylesheet" href="public/styles/footer.css">
    <link rel="stylesheet" href="public/styles/hienthitimkiem.css">
</head>

<body>
    <!--HEADER-->

    <header>
        <?php
        include_once("public/templates/header.php");
        ?>
    </header>

    <!--breadcrumb-->

    <nav style="background-color:#F8F8F8" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./?to=home">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="to">Tất cả sản phẩm</li>
            </ol>
        </div>
    </nav>
    <!--CONTENT-->

    <div class="container">

        <!--TIỀU ĐỀ-->
        <div class="row">
            <div class="col">
                <div class="heading">
                    <h2>Tất cả sản phẩm</h2>
                </div>
            </div>
        </div>

        <!--BỘ LỌC-->
        <div class="row">
            <div class="col-lg-3">
            <div class="d-xxl-none d-xl-none d-lg-none filter-heading filter-control" onClick="filtertoogle(this)">
                            <span class="">Bộ lọc sản phẩm ▼</span>
                        </div>
                <form action="./" method="get" id="filter">
                    <input type="hidden" name="to" value="search">
                    <input type="hidden" name="from" value="self">

                    <div class="filter">
                        <div class="filter-brands">
                            <span class="filter-select">Thương hiệu</span>
                            <span class="filter-control filter-select" onClick="filterbrandtoggle(this)">-</span>
                            <ul id="filter-brand-items">
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="thuonghieu[]" value="1" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        adidas
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="thuonghieu[]" value="2" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        nike
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="thuonghieu[]" value="3" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        jordan
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="thuonghieu[]" value="4" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        mlb
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="thuonghieu[]" value="5" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        vans
                                    </label>
                                </li>



                            </ul>
                        </div>
                        <div class="filter-price">
                            <span class="filter-select">Giá</span>
                            <span class="filter-control filter-select" onClick="filterpricetoggle(this)">-</span>
                            <ul id="filter-price-items">
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gia[]" value=" < 1000000 " id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Dưới 1,000,000₫
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gia[]" value="BETWEEN 1000000 AND 2000000" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        1,000,000₫ - 2,000,000₫
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gia[]" value="BETWEEN 2000000 AND 3500000" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        2,000,000₫ - 3,500,000₫
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gia[]" value="BETWEEN 3500000 AND 5000000" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        3,500,000₫ - 5,000,000₫
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gia[]" value=" > 5000000" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Trên 5,000,000₫
                                    </label>
                                </li>


                            </ul>
                        </div>
                        <div class="filter-size">
                            <span class="filter-select">Kích thước</span>
                            <span class="filter-control filter-select" onClick="filtersizetoggle(this)">-</span>
                            <ul id="filter-size-items">
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="37" id="37" autocomplete="off">
                                    <label class="size-btn" for="37">37</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="37.5" id="37.5" autocomplete="off">
                                    <label class="size-btn" for="37.5">37.5</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="38" id="38" autocomplete="off">
                                    <label class="size-btn" for="38">38</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="38.5" id="38.5" autocomplete="off">
                                    <label class="size-btn" for="38.5">38.5</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="39" id="39" autocomplete="off">
                                    <label class="size-btn" for="39">39</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="39.5" id="39.5" autocomplete="off">
                                    <label class="size-btn" for="39.5">39.5</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="40" id="40" autocomplete="off">
                                    <label class="size-btn" for="40">40</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="40.5" id="40.5" autocomplete="off">
                                    <label class="size-btn" for="40.5">40.5</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="41" id="41" autocomplete="off">
                                    <label class="size-btn" for="41">41</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="41.5" id="41.5" autocomplete="off">
                                    <label class="size-btn" for="41.5">41.5</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="42" id="42" autocomplete="off">
                                    <label class="size-btn" for="42">42</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="42.5" id="42.5" autocomplete="off">
                                    <label class="size-btn" for="42.5">42.5</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="size-selector" name="size[]" value="43" id="43" autocomplete="off">
                                    <label class="size-btn" for="43">43</label>
                                </li>
                            </ul>
                        </div>



                    </div>
                    <button type="submit" class="filter-btn">Tìm sản phẩm</button>
                </form>

            </div>

            <!--LƯỚI SẢN PHẨM-->
            <div class="col-lg-9">
                <div class="row pro-list">

                    <?php
                    include_once("private/ctrls/timkiemcontroller.php");
                    $timkiemController = new TimKiemController();
                    $timkiemController->TimKiem();
                    ?>
                </div>
            </div>
        </div>

        <!-- THANH ĐIỀU HƯỚNG TRANG-->
        <div class="direction-bar">
            <div class="col-12">
                <a href="#" class="direction">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                    </svg>
                </a>
                <?php
                $timkiemController = new TimKiemController();
                $timkiemController->LoadThanhPhanTrang();
                ?>
                <a href="#" class="direction">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
    <!-- NEWS-->
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $timkiemController = new TimKiemController();
            $timkiemController->LoadBottomBanner();
            ?>
        </div>
    </div>








    <!--FOOTER-->
    <footer>
        <?php
        include_once("public/templates/footer.php");
        ?>
    </footer>

    <!--header-script-->
    <script src="public/scripts/header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>

    <!--footer-script-->
    <script src="public/scripts/footer.js"></script>

    <!--hienthitimkiem-script-->
    <script src="public/scripts/hienthitimkiem.js"></script>
    <!--(chỉnh chỗ này)-->

    <!--bootstrap 5-script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>