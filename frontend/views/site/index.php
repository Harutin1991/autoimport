<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\CurrencyHelper;
use yii\data\ArrayDataProvider;
use backend\models\Slider;
use backend\models\Sitesettings;
use frontend\models\Category;
use frontend\models\Product;
use backend\models\Aboutus;
use backend\models\Team;

$sliders = Slider::find()->where(['status' => 1])->asArray()->all();

$products = Product::findList(['limit' => 12]);
$aboutUs = Aboutus::find()->one();
$team = Team::find()->all();
$settings = Sitesettings::find_One();
$settings = $settings[0];
//echo "<pre>";print_r($products);die;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'ARIAS') . ' | ' . Yii::t('app', 'Home');

?>
<div id="home" class="">
    <div id="slides_wrapper" class="">
        <div id="slides">
            <ul class="slides-container">
                <li class="nav1">
                    <img src="http://via.placeholder.com/1600x840" alt="" class="img">
                    <div class="caption">
                        <div class="container">
                            <div class="txt1"><span>FIND YOUR DREAM CAR</span></div>
                            <div class="txt2">CAR M5 GRAN TURISMO</div>
                            <div class="txt3">MODEL 2017 <span>$64,000</span></div>
                            <div class="link1"><a href="details.html" class="slider-link1"><span>SEE DETAILS</span></a></div>
                        </div>
                    </div>
                </li>
                <li class="nav2">
                    <img src="http://via.placeholder.com/1600x840" alt="" class="img">
                    <div class="caption">
                        <div class="container">
                            <div class="txt1"><span>FIND YOUR DREAM CAR</span></div>
                            <div class="txt2">AUTO 330e iPERFORMANCE</div>
                            <div class="txt3">MODEL 2017 <span>$99,000</span></div>
                            <div class="link1"><a href="details.html" class="slider-link1"><span>SEE DETAILS</span></a></div>
                        </div>
                    </div>
                </li>
            </ul>
            <nav class="slides-navigation">
                <a href="#" class="next"></a>
                <a href="#" class="prev"></a>
            </nav>
        </div>
    </div>
</div>

<div id="intro">
    <div class="container">
        <div class="booking-wrapper">
            <div class="booking">
                <form action="javascript:;" class="form1">
                    <div class="row">
                        <div class="col1">
                            <div class="select1_wrapper">
                                <label>Manufacture</label>
                                <div class="select1_inner">
                                    <select class="select2 select" style="width: 100%">
                                        <option value="1">Any Make</option>
                                        <option value="2">Vehicle Name</option>
                                        <option value="3">Vehicle Name</option>
                                        <option value="4">Vehicle Name</option>
                                        <option value="5">Vehicle Name</option>
                                        <option value="6">Vehicle Name</option>
                                        <option value="7">Vehicle Name</option>
                                    </select>
                                </div>
                                <a href="#" class="more">MISSING MANUFACTURER?</a>
                            </div>
                        </div>
                        <div class="col1">
                            <div class="select1_wrapper">
                                <label>Model</label>
                                <div class="select1_inner">
                                    <select class="select2 select" style="width: 100%">
                                        <option value="1">Any Model</option>
                                        <option value="2">Model 1</option>
                                        <option value="3">Model 2</option>
                                        <option value="4">Model 3</option>
                                        <option value="5">Model 4</option>
                                        <option value="6">Model 5</option>
                                        <option value="7">Model 6</option>
                                    </select>
                                </div>
                                <a href="#" class="more">MISSING MODEL?</a>
                            </div>
                        </div>
                        <div class="col1">
                            <div class="select1_wrapper">
                                <label>Status</label>
                                <div class="select1_inner">
                                    <select class="select2 select" style="width: 100%">
                                        <option value="1">Vehicle Status</option>
                                        <option value="2">Status 1</option>
                                        <option value="3">Status 2</option>
                                        <option value="4">Status 3</option>
                                        <option value="5">Status 4</option>
                                        <option value="6">Status 5</option>
                                        <option value="7">Status 6</option>
                                    </select>
                                </div>
                                <a href="#" class="more">E.G:  NEW, USED, CERTIFIED</a>
                            </div>
                        </div>
                        <div class="col1">
                            <div class="select1_wrapper">
                                <label>Min Year</label>
                                <div class="select1_inner">
                                    <select class="select2 select" style="width: 100%">
                                        <option value="1">Min Year</option>
                                        <option value="2">2018</option>
                                        <option value="3">2017</option>
                                        <option value="4">2016</option>
                                        <option value="5">2015</option>
                                        <option value="6">2014</option>
                                        <option value="7">2013</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col1">
                            <div class="select1_wrapper">
                                <label>Max Year</label>
                                <div class="select1_inner">
                                    <select class="select2 select" style="width: 100%">
                                        <option value="1">Max Year</option>
                                        <option value="2">2018</option>
                                        <option value="3">2017</option>
                                        <option value="4">2016</option>
                                        <option value="5">2015</option>
                                        <option value="6">2014</option>
                                        <option value="7">2013</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col2">
                            <div id="slider-range-wrapper">
                                <div class="txt">PRICE RANGE</div>

                                <div id="slider-range"></div>

                                <div class="clearfix">
                                    <input type="text" id="amount" readonly>
                                    <input type="text" id="amount2" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col3">
                            <div class="adv-serach"><a href="#">ADVANCED SEARCH</a></div>
                            <button type="submit" class="btn-default btn-form1-submit"><span>SEARCH THE VEHICLE</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="thumb1">
                    <div class="thumbnail clearfix">
                        <figure>
                            <a href="details.html">
                                <img src="http://via.placeholder.com/370x200" alt="" class="img-responsive">
                            </a>
                        </figure>
                        <div class="caption">
                            <div class="txt1">
                                <span class="txt">FIRST DRIVE REVIEW</span>
                                <span class="stars">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                </span>
                            </div>
                            <div class="txt2">2010 Vehicle Name / YELLOW</div>
                            <div class="txt3">Curabitur libero. Donec facilisis velit eu est. Phasellus cons quat. Aenean vitae quam. Vivamus et nunc. Nunc consequ
                                sem velde metus imperdiet lacinia.</div>
                            <div class="link"><a href="details.html" class="btn-default btn1"><span>READ MORE</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumb1">
                    <div class="thumbnail clearfix">
                        <figure>
                            <a href="details.html">
                                <img src="http://via.placeholder.com/370x200" alt="" class="img-responsive">
                            </a>
                        </figure>
                        <div class="caption">
                            <div class="txt1">
                                <span class="txt">INSTRUMENTED TEST</span>
                                <span class="stars">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-half-o" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                </span>
                            </div>
                            <div class="txt2">1950 Vehicle Name / BLACK</div>
                            <div class="txt3">Curabitur libero. Donec facilisis velit eu est. Phasellus cons quat. Aenean vitae quam. Vivamus et nunc. Nunc consequ
                                sem velde metus imperdiet lacinia.</div>
                            <div class="link"><a href="details.html" class="btn-default btn1"><span>READ MORE</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumb1">
                    <div class="thumbnail clearfix">
                        <figure>
                            <a href="details.html">
                                <img src="http://via.placeholder.com/370x200" alt="" class="img-responsive">
                            </a>
                        </figure>
                        <div class="caption">
                            <div class="txt1">
                                <span class="txt">BUYERS INFO</span>
                                <span class="stars">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-half-o" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                </span>
                            </div>
                            <div class="txt2">2013 Vehicle Name / WHITE</div>
                            <div class="txt3">Curabitur libero. Donec facilisis velit eu est. Phasellus cons quat. Aenean vitae quam. Vivamus et nunc. Nunc consequ
                                sem velde metus imperdiet lacinia.</div>
                            <div class="link"><a href="details.html" class="btn-default btn1"><span>READ MORE</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<div id="welcome">
    <div id="parallax1" class="parallax">
        <div class="bg1 parallax-bg"></div>
        <div class="parallax-content">
            <div class="container">

                <div class="logo-s"><img src="http://via.placeholder.com/174x79" alt="" class="img-responsive"></div>

                <div class="txt1">WELCOME TO CAR DEALER</div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="txt2">
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit diam, sed diam nonummy nibh “<b>euismod tincidunt</b>” ut laoreet dolore magna aliquam losa volutpat.  Lorem ipsum dolor sit amet, consectetuer adipiscing elit diam nonummy euismod tincidunt.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="txt3">
                            LOREM IPSUM <span>DOLOR</span>
                            SIT AMET CONCATEUR DUO
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="best">
    <div class="container">

        <div class="title1"><span>BEST OFFERS FROM AUTOCLUB</span></div>

        <div class="tabs1">
            <div class="tabs1_tabs">
                <ul>
                    <li class="active"><a href="#tabs1-1">MOST RESEARCHED MANUFACTURERS</a></li>
                    <li><a href="#tabs1-2">LATEST VEHICLES ON SALE</a></li>
                </ul>
            </div>
            <div class="tabs1_content">
                <div id="tabs1-1">

                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2015</div>
                                                <div class="txt2">Vehicle Name Hybrid</div>
                                                <div class="info clearfix">
                                                    <span class="price">$24,380</span>
                                                    <span class="speed">35,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2015  •  Automatic  •  White  •  Petrol
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2016</div>
                                                <div class="txt2">2016 Vehicle Name </div>
                                                <div class="info clearfix">
                                                    <span class="price">$95,900</span>
                                                    <span class="speed">99,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2016  •  Manual  •  Red  •  Petrol
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2015</div>
                                                <div class="txt2">2016 Vehicle Name</div>
                                                <div class="info clearfix">
                                                    <span class="price">$98,995</span>
                                                    <span class="speed">95,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2015  •  Automatic  •  Blue  •  Petrol
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2017</div>
                                                <div class="txt2">2017 Vehicle Name</div>
                                                <div class="info clearfix">
                                                    <span class="price">$31,900</span>
                                                    <span class="speed">12,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2017  •  Automatic  •  Dark Red  •  Petrol
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2016</div>
                                                <div class="txt2">Vehicle Name - AMG</div>
                                                <div class="info clearfix">
                                                    <span class="price">$18,995</span>
                                                    <span class="speed">52,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2016  •  Automatic  •  Yellow  •  Diesel
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2017</div>
                                                <div class="txt2">2017 Vehicle Name</div>
                                                <div class="info clearfix">
                                                    <span class="price">$64,380</span>
                                                    <span class="speed">210 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    New  •  2017  •  Automatic  •  Green  •  Diesel
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <ul class="ul1">
                                <li><a href="#">All manufacturers</a></li>
                                <li><a href="#">ASTIN KARTON</a></li>
                                <li><a href="#">ALPHA MGM</a></li>
                                <li><a href="#">AVDI</a></li>
                                <li><a href="#">BMQ</a></li>
                                <li><a href="#">LAND QUOVER</a></li>
                                <li><a href="#">MERODES</a></li>
                                <li><a href="#">PURCHE</a></li>
                                <li><a href="#">SALAKI</a></li>
                                <li><a href="#">TIRETA</a></li>
                                <li><a href="#">VURVU</a></li>
                                <li><a href="#">HUSHAGEN</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div id="tabs1-2">

                    <div class="row">
                        <div class="col-sm-12 col-md-9">

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2017</div>
                                                <div class="txt2">2017 Vehicle Name</div>
                                                <div class="info clearfix">
                                                    <span class="price">$31,900</span>
                                                    <span class="speed">12,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2017  •  Automatic  •  Dark Red  •  Petrol
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2016</div>
                                                <div class="txt2">Vehicle Name</div>
                                                <div class="info clearfix">
                                                    <span class="price">$18,995</span>
                                                    <span class="speed">52,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2016  •  Automatic  •  Yellow  •  Diesel
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2017</div>
                                                <div class="txt2">2017 Vehicle Name</div>
                                                <div class="info clearfix">
                                                    <span class="price">$64,380</span>
                                                    <span class="speed">210 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    New  •  2017  •  Automatic  •  Green  •  Diesel
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2015</div>
                                                <div class="txt2">Vehicle Name Sport Hybrid</div>
                                                <div class="info clearfix">
                                                    <span class="price">$24,380</span>
                                                    <span class="speed">35,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2015  •  Automatic  •  White  •  Petrol
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2016</div>
                                                <div class="txt2">2016 Vehicle Name </div>
                                                <div class="info clearfix">
                                                    <span class="price">$95,900</span>
                                                    <span class="speed">99,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2016  •  Manual  •  Red  •  Petrol
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="thumb2">
                                        <div class="thumbnail clearfix">
                                            <figure>
                                                <a href="details.html">
                                                    <img src="http://via.placeholder.com/270x150" alt="" class="img-responsive">
                                                </a>
                                            </figure>
                                            <div class="caption">
                                                <div class="txt1">REGISTERED 2015</div>
                                                <div class="txt2">2016 Vehicle Name</div>
                                                <div class="info clearfix">
                                                    <span class="price">$98,995</span>
                                                    <span class="speed">95,000 KM</span>
                                                </div>
                                                <div class="txt3">
                                                    Used  •  2015  •  Automatic  •  Blue  •  Petrol
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <ul class="ul1">
                                <li><a href="#">All manufacturers</a></li>
                                <li><a href="#">ASTIN KARTON</a></li>
                                <li><a href="#">ALPHA MGM</a></li>
                                <li><a href="#">AVDI</a></li>
                                <li><a href="#">BMQ</a></li>
                                <li><a href="#">LAND QUOVER</a></li>
                                <li><a href="#">MERODES</a></li>
                                <li><a href="#">PURCHE</a></li>
                                <li><a href="#">SALAKI</a></li>
                                <li><a href="#">TIRETA</a></li>
                                <li><a href="#">VURVU</a></li>
                                <li><a href="#">HUSHAGEN</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>





    </div>
</div>


<div id="car">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-lg-offset-7">
                <div class="car-inner">
                    <div class="txt1"><span>WORLD’S LEADING CAR DEALER</span></div>
                    <div class="txt2">WELCOME TO CAR MARKETPLACE</div>
                    <div class="txt3">
                        <p>
                            Curabitur libero. Donec facilisis velit eudsl est. Phasellus consequat. Aenean vita quam. Vivamus et nunc. Nunc consequat sem velde metus imperdiet lacinia. Dui estter neque molestie necd dignissim ac hendrerit quis purus. Etiam sit amet vec convallis massa scelerisque mattis. Sed placerat leo nec.
                        </p>
                        <p>
                            Ipsum midne ultrices magn eu tempor quam dolor eustrl sem. Donec quis dolel Donec pede quam placerat alterl tristique faucibus posuere lobortis.

                        </p>
                    </div>
                    <ul class="ul2">
                        <li><a href="#">Donec facilisis velit eu est phasellus consequat </a></li>
                        <li><a href="#">Aenean vitae quam. Vivamus et nunc nunc consequat</a></li>
                        <li><a href="#">Sem vel metus imperdiet lacinia enean </a></li>
                        <li><a href="#">Dapibus aliquam augue fusce eleifend quisque tels</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="info">
    <div class="info-wrapper">
        <div class="container">
            <div class="info-inner">
                <div class="info1">
                    <div class="info1-inner animated" data-animation="fadeInDown" data-animation-delay="200">
                        <img src="images/ic1.png" alt="" class="img1">
                        <div class="caption">
                            <div class="txt1"><span class="animated-number" data-duration="2000" data-animation-delay="0">1250</span></div>
                            <div class="txt2">NEW CARS IN STOCK</div>
                        </div>
                    </div>
                </div>
                <div class="info1">
                    <div class="info1-inner animated" data-animation="fadeInDown" data-animation-delay="250">
                        <img src="images/ic2.png" alt="" class="img1">
                        <div class="caption">
                            <div class="txt1"><span class="animated-number" data-duration="2000" data-animation-delay="0">2120</span>+</div>
                            <div class="txt2">USED CARS IN STOCK</div>
                        </div>
                    </div>
                </div>
                <div class="info1">
                    <div class="info1-inner animated" data-animation="fadeInDown" data-animation-delay="300">
                        <img src="images/ic3.png" alt="" class="img1">
                        <div class="caption">
                            <div class="txt1"><span class="animated-number" data-duration="2000" data-animation-delay="0">9753</span></div>
                            <div class="txt2">HAPPY CUSTOMERS</div>
                        </div>
                    </div>
                </div>
                <div class="info1">
                    <div class="info1-inner animated" data-animation="fadeInDown" data-animation-delay="350">
                        <img src="images/ic4.png" alt="" class="img1">
                        <div class="caption">
                            <div class="txt1"><span class="animated-number" data-duration="2000" data-animation-delay="0">1022</span></div>
                            <div class="txt2">CAR SPARE PARTS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="testimonials">
    <div class="container">

        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">

                <div id="review">
                    <div class="">
                        <div class="carousel-box">
                            <div class="inner">
                                <div class="carousel main">
                                    <ul>
                                        <li>
                                            <div class="review">
                                                <div class="review_inner">

                                                    <div class="testimonial-wrapper">
                                                        <div class="txt1"><b>GEORGE SMITH,</b> Customer, RUNGE RIVER Owner</div>
                                                        <div class="txt2">
                                                            <div class="img-wrapper"><img src="http://via.placeholder.com/104x104" alt="" class="img-responsive"></div>
                                                        </div>
                                                        <div class="txt3">Donec facilisis velit eust. Phasellus cons quat. Aenean vitae quam. Vivamus et nunc. Nunc consequsem
                                                            velde metus imperdiet lacinia.  Nam rutrum congue diam. Vestibulum acda risus eros auctor egestas. Morbids sem magna, viverra quis sollicitudin quis consectetuer quis nec magna.</div>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="review">
                                                <div class="review_inner">

                                                    <div class="testimonial-wrapper">
                                                        <div class="txt1"><b>JOHN DOE,</b> Customer, RUNGE RIVER DISCOVERY Owner</div>
                                                        <div class="txt2">
                                                            <div class="img-wrapper"><img src="http://via.placeholder.com/104x104" alt="" class="img-responsive"></div>
                                                        </div>
                                                        <div class="txt3">Donec facilisis velit eust. Phasellus cons quat. Aenean vitae quam. Vivamus et nunc. Nunc consequsem
                                                            velde metus imperdiet lacinia.  Nam rutrum congue diam. Vestibulum acda risus eros auctor egestas. Morbids sem magna, viverra quis sollicitudin quis consectetuer quis nec magna.</div>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="review">
                                                <div class="review_inner">

                                                    <div class="testimonial-wrapper">
                                                        <div class="txt1"><b>AMANDA RICHARDSON,</b> Customer, RUNGE RIVER Avoqie</div>
                                                        <div class="txt2">
                                                            <div class="img-wrapper"><img src="http://via.placeholder.com/104x104" alt="" class="img-responsive"></div>
                                                        </div>
                                                        <div class="txt3">Donec facilisis velit eust. Phasellus cons quat. Aenean vitae quam. Vivamus et nunc. Nunc consequsem
                                                            velde metus imperdiet lacinia.  Nam rutrum congue diam. Vestibulum acda risus eros auctor egestas. Morbids sem magna, viverra quis sollicitudin quis consectetuer quis nec magna.</div>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>









                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="review_pagination"></div>


                </div>












            </div>
        </div>

    </div>
</div>

<div class="bot1-wrapper">
    <div class="container">
        <div class="bot1 clearfix">
            <div class="row">
                <div class="col-sm-3">

                    <div class="bot1-title"><span>LATEST NEWS</span></div>

                    <div class="news-block">
                        <div class="news1">
                            <div class="txt1">Duis scelerisque aliquet ante donec
                                libero pede porttitor dacu</div>
                            <div class="txt2"><a href="#">Read More</a></div>
                        </div>
                        <div class="news1">
                            <div class="txt1">Duis scelerisque aliquet ante donec
                                libero pede porttitor dacu</div>
                            <div class="txt2"><a href="#">Read More</a></div>
                        </div>
                        <div class="news1">
                            <div class="txt1">Duis scelerisque aliquet ante donec
                                libero pede porttitor dacu</div>
                            <div class="txt2"><a href="#">Read More</a></div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-3">

                    <div class="bot1-title"><span>LATEST AUTOS</span></div>

                    <div class="autos-block">
                        <div class="autos1 clearfix">
                            <figure><img src="http://via.placeholder.com/80x65" alt="" class="img-responsive"></figure>
                            <div class="caption">
                                <div class="txt1">VEHICLE NAME</div>
                                <div class="txt2">35,000 KM</div>
                                <div class="txt3"><a href="#">Read More</a></div>
                            </div>
                        </div>
                        <div class="autos1 clearfix">
                            <figure><img src="http://via.placeholder.com/80x65" alt="" class="img-responsive"></figure>
                            <div class="caption">
                                <div class="txt1">VEHICLE NAME</div>
                                <div class="txt2">35,000 KM</div>
                                <div class="txt3"><a href="#">Read More</a></div>
                            </div>
                        </div>
                        <div class="autos1 clearfix">
                            <figure><img src="http://via.placeholder.com/80x65" alt="" class="img-responsive"></figure>
                            <div class="caption">
                                <div class="txt1">VEHICLE NAME</div>
                                <div class="txt2">35,000 KM</div>
                                <div class="txt3"><a href="#">Read More</a></div>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="col-sm-3">

                    <div class="bot1-title"><span>from twitter</span></div>

                    <div class="twitter-block">
                        <div class="twitter1 clearfix">
                            <div class="txt1">Duis scelerisque aliquet ante donec
                                libero pede porttitor dacu</div>
                            <div class="txt2"><a href="#">20 minutes ago</a></div>
                        </div>
                        <div class="twitter1 clearfix">
                            <div class="txt1">Duis scelerisque aliquet ante donec
                                libero pede porttitor dacu</div>
                            <div class="txt2"><a href="#">20 minutes ago</a></div>
                        </div>
                        <div class="twitter1 clearfix">
                            <div class="txt1">Duis scelerisque aliquet ante donec
                                libero pede porttitor dacu</div>
                            <div class="txt2"><a href="#">20 minutes ago</a></div>
                        </div>



                    </div>

                </div>
                <div class="col-sm-3">

                    <div class="bot1-title"><span>CONTACT US</span></div>

                    <div class="address2"><span aria-hidden="true" class="ei icon_pin"></span>202 W 7th St, Suite 233 Los Angeles, California 90014 USA</div>

                    <div class="bot1-map-wrapper">
                        <div class="phone2"><span aria-hidden="true" class="ei icon_phone"></span>Phone:  1-800- 624-5462</div>
                        <div class="fax2"><span aria-hidden="true" class="ei icon_printer"></span>FAX:  1-800- 624-5462</div>
                        <div class="email2"><span aria-hidden="true" class="ei icon_mail"></span>Email:  <a href="#">info@domain.com</a></div>
                        <div class="open-loaction-map"><a href="#">Open Location Map</a></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<section class="hero-area">
    <div class="hero-slides owl-carousel">
        <!-- Single Hero Slide -->
	  <?php foreach ($sliders as $slider): ?>
    	  <div class="single-hero-slide bg-img" style="background-image: url(<?= Yii::$app->params['adminUrl'] . 'uploads/images/slider/' . $slider['id'] . '/' . $slider['path'] ?>);">
    		<div class="container h-100">
    		    <div class="row h-100 align-items-center">
    			  <div class="col-12">
    				<div class="hero-slides-content">
    				    <h2 data-animation="fadeInUp" data-delay="100ms"><?= $slider['title'] ?></h2>
    				</div>
    			  </div>
    		    </div>
    		</div>
    	  </div>
	  <?php endforeach; ?>
    </div>

    <?= $this->render('/site/category') ?>
</section>
<?php $this->render('/site/filters') ?>
	
	<section class="featured-properties-area section-padding-100-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading wow fadeInUp">
						<h2><?= Yii::t('app', 'TOP OFFERS') ?></h2>
						<p class="hidden"><?= Yii::t('app', 'Suspendisse dictum enim sit amet libero malesuada feugiat.') ?></p>
                    </div>
                </div>
            </div>

            <div class="row">
				<?php foreach ($products as $key => $product): ?>
				<div class="col-12 col-md-6 col-xl-4">
                    <!-- a href="/<?= Yii::$app->language ?>/<?= Category::getCategoryRouteName($product['category_id']) ?>/<?= $product['id'] ?>" target="_blank" -->
					<a href="/<?= Yii::$app->language ?>/apartments/<?= $product['id'] ?>" target="_blank">
                        <div class="single-featured-property mb-50 wow fadeInUp" data-wow-delay="100ms">
                            <div class="property-thumb">
                                <img src="<?= Yii::$app->params['adminUrl'] . 'uploads/images/' . $product['image'] ?>" alt="" />
                                <div class="tag">
                                    <span><?= Yii::t('app', 'For Sale') ?></span>
                                </div>
                                <div class="list-price">
                                    <p>$<?= $product['price'] ?></p>
                                </div>
                            </div>
                            <div class="property-content">
                                <h5><?= $product['name'] ?></h5>
                                <p class="location"><img src="/img/icons/location.png" alt=""><?= $product['address'] ?></p>
                                <div class="txt">
                                    <?= $product['short_description'] ?>
                                </div>
                                
                            </div>
                        </div>
                    </a>
                </div>
		<?php endforeach; ?>
                </div>
            </div>
        </section>
		
<section class="call-to-action-area bg-fixed bg-overlay-black" style="background-image: url(/img/bg-img/cta.jpg)">
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <div class="cta-content text-center">
                    <h2 class="wow fadeInUp" data-wow-delay="300ms"><?=$settings['text1']?></h2>
                    <h6 class="wow fadeInUp" data-wow-delay="400ms"><?=$settings['text2']?></h6>
                    <a href="/product/index" class="btn btn-overlay south-btn mt-50"><span>Որոնել</span></a>                
				</div>
            </div>
        </div>
    </div>
</section>

<section class="meet-the-team-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Մասնագետներ</h2>
                        <p class="hidden">Suspendisse dictum enim sit amet libero</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
				<?php if(!empty($team)):?>
				<?php foreach($team as $val):?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="250ms">
                      
                        <div class="team-member-thumb">
                            <img src="<?= Yii::$app->params['adminUrl'] . 'uploads/images/team/' . $val->id .'/'.$val->image?>" alt="">
                        </div>
                      
                        <div class="team-member-info">
                            <div class="section-heading">
                                <img src="/img/icons/prize.png" alt="">
                                <h2><?=$val->fname.' '.$val->sname?></h2>
                                <p><?=$val->profession?></p>
                            </div>
                            <div class="address">
                                <h6><img src="/img/icons/phone-call.png" alt=""><?=$val->phone?></h6>
                                <h6><img src="/img/icons/envelope.png" alt=""><?=$val->email?></h6>
                            </div>
                        </div>
                    </div>
                </div>
				<?php endforeach;?>
				<?php endif;?>
            </div>
        </div>
    </section>

    <section class="south-editor-area d-flex align-items-center hidden">
        <div class="editor-content-area">
            <div class="section-heading wow fadeInUp" data-wow-delay="250ms">
                <img src="/img/icons/prize.png" alt="">
                <h2>Emmanuel Macron</h2>
                <p>Հիմնադիր</p>
            </div>
            <p class="wow fadeInUp" data-wow-delay="500ms">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat odio perspiciatis dolor dignissimos vel architecto, temporibus cupiditate quas harum ex. Quia voluptates voluptatibus unde numquam ipsum odio porro quaerat corporis.</p>
            <div class="address wow fadeInUp" data-wow-delay="750ms">
                <h6><img src="/img/icons/phone-call.png" alt=""> +32 488 84 48 62</h6>
                <h6><img src="/img/icons/envelope.png" alt=""> info@bafront.com</h6>
            </div>
            <div class="signature mt-50 wow fadeInUp" data-wow-delay="1000ms">
                <img src="/img/core-img/signature.png" alt="">
            </div>
        </div>

        <div class="editor-thumbnail">
            <img src="/img/bg-img/editor.jpg" alt="">
        </div>
    </section>
