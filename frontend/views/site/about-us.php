<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Product */

use backend\models\Slider;
use backend\models\Aboutus;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Team;

$this->title = Yii::t('app', 'ARIAS') . ' | ' . Yii::t('app', 'About Us');

$about = Aboutus::find_One();
$team = Team::find()->all();
?>

<section class="breadcumb-area bg-img" style="background-image: url(/img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title"><?=$about[0]['title']?></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<section class="about-content-wrapper section-padding-100-0-35-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="section-heading text-left wow fadeInUp" data-wow-delay="250ms">
                        <h2 class="text-center">Where does it come from?</h2>
                    </div>
                    <div class="about-content">
                        <img class="wow fadeInUp" data-wow-delay="350ms" src="/img/bg-img/about.jpg" alt="">
                        <div class="wow fadeInUp txt-about" data-wow-delay="450ms">
                            <?=$about[0]['short_description']?>
                        </div>
                    </div>
                </div>

               
            </div>
        </div>
    </section>
<section class="call-to-action-area bg-fixed bg-overlay-black hidden" style="background-image: url(img/bg-img/cta.jpg)">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-12">
                    <div class="cta-content text-center">
                        <h2 class="wow fadeInUp" data-wow-delay="300ms">ՓՆՏՐՈՒՄ ԵՔ ՏԱՐԱԾՔ ՎԱՐՁԱԿԱԼՈՒԹՅԱՆ ՀԱՄԱՐ?</h2>
                        <h6 class="wow fadeInUp hidden" data-wow-delay="400ms">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h6>
                        <a href="#" class="btn south-btn mt-50 wow fadeInUp mes-btn" data-wow-delay="500ms">Կապնվեք մեզ հետ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="layer-single-blog"></div>
            </div>
        </div>
    </div>

    <section class="meet-the-team-area section-padding-35-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Մասնագետներ</h2>
                        <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis aliquid quis architecto quaerat hic optio voluptates explicabo, atque nisi totam doloremque quo dolores expedita rerum veniam perspiciatis temporibus, voluptatibus deserunt.    </p>
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