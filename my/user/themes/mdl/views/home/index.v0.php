<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use my\user\helpers\Timezone;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var my\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Home');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-home-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col s3 m4">
            <div class="card">
                <div class="card-image">
                    <img src="<?= \my\user\helpers\Defaults::getAvatarUrl() ?>">
                    <span class="card-title">Card Title</span>
                </div>
                <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>

            <div class="collection">
                <a href="#!" class="collection-item">Alan<span class="badge">1</span></a>
                <a href="#!" class="collection-item">Alan<span class="new badge">4</span></a>
                <a href="#!" class="collection-item">Alan</a>
                <a href="#!" class="collection-item">Alan<span class="badge">14</span></a>
            </div>

            <div class="card-panel teal">
          <span class="white-text">I am a very simple card. I am good at containing small bits of information.
          I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
          </span>
            </div>

        </div>

        <div class="col s9 m8">

            <div class="card-panel">
                <span class="blue-text text-darken-2">This is a card panel with dark blue text</span>
            </div>

            <div class="card green-wine-trans border-side-white no-margin">
                <div class="card-content">
                    <h2 class="roboto-200">
                        Eligibility
                    </h2>
                    <hr>
                    <p>
                        Undergraduate students can form teams of 3 - 5 members from any backgrounds as long as the group can create an application during the
                        hackathon proper.
                        These students should be enrolled for the current academic year or considered as a student for the current semester.
                        You may <a class="malachite-text lightbox-52774140831453" href="#">Click Here</a> to register.
                    </p>
                    <hr>
                    <p>Walk-ins are not accepted. For member substitutions and other membership inquiries, please email dlsuhackercup@gmail.com</p>
                    <hr>
                    <p>
                        <b>
                            Accepted teams will  have their team leader notified via email and will include accompanying documents and additional instructions.
                        </b>
                    </p>
                </div>
            </div>

            <div class="card green-wine-trans border-side-red no-margin">
                <div class="card-content">
                    <p> General Requirements </p>
                    <hr>
                    <ol>
                        <li>
                            Minimum of one representative from the group is required to participate at the Orientation &amp; Workshop on November 14.
                        </li>
                        <li>
                            Groups must submit the necessary requirements for their application to be considered as valid. The list of required documents to be submitted can
                            be seen through the registration form <a class="lightbox-52774140831453 malachite-text" href="#">here</a>.
                        </li>
                        <li>
                            Proper decorum is expected from each participant. Any disrespectful behavior will lead to the disqualification of the entire group and
                            possible sanctions against the said student.
                        </li>
                        <li>
                            All team members are required to be present on November 21-22
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card green-wine">
                <div class="card-content white-text">
                    <a class="btn-floating right center green-spring">
                        3
                    </a>
                    <h5>
                        Get your team ready for HackerCup 2015 <span class="transparent-text">hi hi</span>
                    </h5>
                </div>
                <div style="min-height: 140px;" class="card-content white black-text">
                    Accepted teams will receive an email from the HackerCup Team. If you do get accepted,
                    sharpen up your skills and get enough sleep!
                </div>
            </div>

            <div class="card green-wine">
                <div class="card-content white-text">
                    <a class="btn-floating right center green-spring">
                        3
                    </a>
                    <h5>
                        Get your team ready for HackerCup 2015 <span class="transparent-text">hi hi</span>
                    </h5>
                </div>
                <div style="min-height: 140px;" class="card-content white black-text">
                    <div class="col-xs-12 col-md-8">
                        <p class="lead">
                            FEDORA.OR.ID adalah komunitas Fedora Indonesia pertama yang didirikan tahun 2006. Website ini dibangun untuk menyajikan tutorial, tips &amp; trik, dan berita seputar Fedora Linux dalam bahasa Indonesia. Tulisan pada website ini adalah kontribusi dari komunitas. <a href="http://fedora.or.id/tentang-fedora-indonesia/">Lebih jauh tentang kami...</a>
                        </p>
                        <article id="post-201">
                            <header class="entry-content">
                                <div class="row">
                                    <div style="padding-left: 0px;" class="col-xs-12 col-md-2 hidden-xs">
                                        <div class="fd-category">
                                            <a href="http://fedora.or.id/category/komunitas/" class="fd-category-komunitas">Komunitas</a>										</div>
                                    </div>
                                    <div class="col-xs-12 col-md-7">
                                        <div class="fd-post-title">
                                            <a rel="bookmark" href="http://fedora.or.id/we-are-back/">We Are Back!</a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-3 hidden-xs">
                                        <div class="fd-posted-on">
                                            <span class="posted-on"><a rel="bookmark" href="http://fedora.or.id/we-are-back/"><time datetime="2016-05-25T08:11:30+00:00" class="entry-date published">May 25, 2016</time><time datetime="2016-05-25T08:41:01+00:00" class="updated">May 25, 2016</time></a></span><span class="byline"> by <span class="author vcard"><a href="http://fedora.or.id/author/zea/" class="url fn n">Zea</a></span></span>										</div>
                                    </div>
                                </div>
                            </header><!-- .entry-content -->
                        </article><!-- #post-## -->
                        <hr style="border-top: 1px dashed rgb(238, 238, 238);">
                        <article id="post-183">
                            <header class="entry-content">
                                <div class="row">
                                    <div style="padding-left: 0px;" class="col-xs-12 col-md-2 hidden-xs">
                                        <div class="fd-category">
                                            <a href="http://fedora.or.id/category/berita/" class="fd-category-berita">Berita</a>										</div>
                                    </div>
                                    <div class="col-xs-12 col-md-7">
                                        <div class="fd-post-title">
                                            <a rel="bookmark" href="http://fedora.or.id/fedora-21-capai-end-of-life-segera-upgrade-sebelum-1-desember/">Fedora 21 Capai End Of Life, Segera Upgrade Sebelum 1 Desember</a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-3 hidden-xs">
                                        <div class="fd-posted-on">
                                            <span class="posted-on"><a rel="bookmark" href="http://fedora.or.id/fedora-21-capai-end-of-life-segera-upgrade-sebelum-1-desember/"><time datetime="2015-11-19T05:24:10+00:00" class="entry-date published">November 19, 2015</time><time datetime="2016-05-20T04:33:35+00:00" class="updated">May 20, 2016</time></a></span><span class="byline"> by <span class="author vcard"><a href="http://fedora.or.id/author/bagus-aji-santoso/" class="url fn n">Bagus Aji Santoso</a></span></span>										</div>
                                    </div>
                                </div>
                            </header><!-- .entry-content -->
                        </article><!-- #post-## -->
                        <hr style="border-top: 1px dashed rgb(238, 238, 238);">

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col s12 m6">
                    <div class="col s3 m4 l3">
                        <img width="65" height="65" class="circle" src="http://www.android-kiosk.com/wp-content/themes/androidkioskcom/images/material_man1.png">
                    </div>
                    <div class="col s9 m8 l9">
                        <blockquote>
                            <p class="grey-text text-darken-3">
                                <span style="font-weight:500;">When we first</span> started working with this app, it had a pretty steep learning curve. These guys have been working diligently on building their documentation, listening to their customers and adding fixes/additional features; and it has paid off! This app is worth every cent if you are looking to use it commercially like we have.

                            </p>
                            <p style="font-weight:300;">Gunther Vinson, TowMate LLC</p>
                            <div class="divider"></div>
                        </blockquote>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="col s3 m4 l3">
                        <img width="65" height="65" class="circle" src="http://www.android-kiosk.com/wp-content/themes/androidkioskcom/images/material_man3.png">
                    </div>
                    <div class="col s9 m8 l9">
                        <blockquote>
                            <p class="grey-text text-darken-3">
                                <span style="font-weight:500;">Great product - incredible support</span>. We use this product in about 40 locations at our company and it works perfectly all-day, every-day.
                            </p>
                            <p style="font-weight:300;">David Higginson</p>
                            <div class="divider"></div>
                        </blockquote>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="col s3 m4 l3">
                        <img width="65" height="65" class="circle" src="http://www.android-kiosk.com/wp-content/themes/androidkioskcom/images/material_man2.png">
                    </div>
                    <div class="col s9 m8 l9">
                        <blockquote>
                            <p class="grey-text text-darken-3">
                                <span style="font-weight:500;">Perfect</span>, use it for our tennis court reservation kiosk with a Google Apps Script web app. Works perfectly.
                            </p>
                            <p style="font-weight:300;">Serge Gravelle</p>
                            <div class="divider"></div>
                        </blockquote>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</div>