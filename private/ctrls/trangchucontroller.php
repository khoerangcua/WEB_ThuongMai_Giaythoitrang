<?php
require_once("private/models/bannermodel.php");
require_once("private/models/giaymodel.php");
class TrangChuController 
{
    public function LoadTopBanner(){
        $bannerModel = new BannerModel();
        $banners = $bannerModel->LoadBanners("trang chu", "top");

        echo "<div class='carousel-indicators'>";
        for ($i = 0; $i < count($banners); $i++) {

            if ($i == 0) {

                echo ("
                        <button 
                        type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='" . $i . "' class ='active' aria-current='true' aria-label='Slide " . $i + 1 . "'>
                        </button> 
                     ");
            } else {
                echo ("
                        <button 
                        type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='" . $i . "' class ='' aria-current='true' aria-label='Slide " . $i + 1 . "'>
                        </button> 
                     ");
            }
        }
        echo "</div>";

        echo "<div class='carousel-inner'>";
        for ($i = 0; $i < count($banners); $i++) {
            $active = "";

            if ($i == 0) {
                $active = "active";
            } else {
                $active = "";
            }

            echo ("
                    <a href='./?to=search&from=another&name=" . $banners[$i]['name'] . "&value=" . $banners[$i]["value"] . "' class='carousel-item " . $active . " '>
                    <img src='" . $banners[$i]["diachianh"] . "' class='d-block w-100' alt=''>
                    </a> 
                 ");
        }
        echo ("</div>");
        

    }
    public function LoadNewArrival($soluonghienthi){

        // load danh sách giày mới nhất
        $giayModel = new GiayModel();
        $giays = $giayModel->LoadNewArrival("2021-1-1");

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
    }
    public function LoadBestSeller($soluonghienthi){
        // Load danh sách giày bestseller
        $giaymodel = new GiayModel();
        $giays = $giaymodel->LoadBestSeller(1);
        $i = 0;

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

    }
    public function LoadHotSale($soluonghienthi){

        // Load danh sách giàu hotesale
        $giaymodel = new GiayModel();
        $giays = $giaymodel->LoadHotSale();

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
    }
    public function LoadBottomBanner(){
        $bannerModel = new  BannerModel();
        $banner = $bannerModel->LoadBanner("trang chu", "bot");
        echo "<a href='./?to=search&from=another&name=".$banner["name"]."&value=".$banner["value"]."'><img width='100%' src='".$banner["diachianh"]."'></a>";

    }
}
?>