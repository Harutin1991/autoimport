<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use backend\models\Sitesettings;

$this->title = Yii::t('app','Contact');
$this->params['breadcrumbs'][] = $this->title;
$settings = Sitesettings::find_One();
$settings = $settings[0];
$phone = json_decode($settings['site_phone']);
?>
<section class="breadcumb-area bg-img" style="background-image: url(/img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title"><?=$this->title?></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<section class="south-contact-area section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact-heading">
                        <h6>ԿՈՆՏԱԿՏԱՅԻՆ ՏՎՅԱԼՆԵՐԸ</h6>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="content-sidebar">
                        <div class="weekly-office-hours">
                            <ul>
                                <li class="d-flex align-items-center justify-content-between"><span>Երկ․-ից - Ուրբաթ </span> <span>09․00 - 19․00</span></li>
                                <li class="d-flex align-items-center justify-content-between"><span>Շաբաթ</span> <span>09․00 - 14․00</span></li>
                                <li class="d-flex align-items-center justify-content-between"><span>Կիրակի</span> <span>Փակ է</span></li>
                            </ul>
                        </div>
                        <div class="address mt-30">
                            <h6><img src="/img/icons/phone-call.png" alt=""> <?=$phone[0]?></h6>
                            <h6><img src="/img/icons/envelope.png" alt=""> <?=$settings['site_email']?></h6>
                            <h6><img src="/img/icons/location.png" alt=""> <?=$settings['address']?></h6>
                        </div>
                        <div class="social-contact">
                            <ul class="social">
                                <li><a href=""><i class="fa fa-facebook"></i> </a></li>
                                <li><a href=""><i class="fa fa-instagram"></i></a></li>
                                <li><a href=""><i class="fa fa-youtube"></i></a></li>
                                <li><a href=""><i class="fa fa-linkedin"></i> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="contact-form">
                        <form action="#" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="text" id="contact-name" placeholder="Անուն* ">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="number" id="contact-number" placeholder="Հեռ․ համար*">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="contact-email" placeholder="Էլ․ հասցե*">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Տեքստ*"></textarea>
                            </div>
                            <button type="submit" class="btn south-btn">Ուղարկել</button>
                        </form>
                    </div>
                </div>
                
                <div class="col-12 col-lg-4">
                    <div class="footer-widget-area mb-100">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3047.4636257382203!2d44.49375511564414!3d40.19874877679125!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x406abd6ad656fbc9%3A0xbb88bbeeed6a3d6d!2s10%20Hrachya%20Kochar%20St%2C%20Yerevan%200033%2C%20Armenia!5e0!3m2!1sen!2s!4v1598113304847!5m2!1sen!2s" class="contact-map" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Google Maps -->
    <div class="map-area">
        <div class="">
            <div class="row">
                <div class="col-12">
                    <div id="googleMap" class="googleMap"></div>
                </div>
            </div>
        </div>
    </div>