<?php

use frontend\assets\FrontendAsset;
use yii\helpers\Html;

FrontendAsset::register($this);

$this->title = Yii::t('frontend', 'Inely - Service for achieving goals');

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= Html::encode($this->title) ?></title>
<meta name="description" content="Archer - Responsive Landing Page">
    
<link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/favicons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/favicons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/favicons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/favicons/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="img/favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="img/favicons/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="img/favicons/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="img/favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="img/favicons/manifest.json">
<link rel="shortcut icon" href="img/favicons/favicon.ico">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-TileImage" content="img/favicons/mstile-144x144.png">
<meta name="msapplication-config" content="img/favicons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

<?= Html::csrfMetaTags() ?>

<?php $this->head() ?>    
</head>

<?php $this->beginBody() ?>
<body>
    
<?= $this->render('header') ?>
<?= $content ?>
<?= $this->render('footer') ?>

<?php $this->endBody() ?>

<!-- Google map modal -->
<div class="modal fade" id="modal-google-map" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
        <div class="map">
          <div id="map-canvas"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Google map modal end-->

<!--Site policy modal -->
<div class="modal fade site-policy" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-header">
        <h2 class="modal-title text-center" id="ModalLabel">Terms of Use</h2>
      </div>
      <div class="modal-body">
        <p>This privacy policy discloses the privacy practices for (website address). This privacy policy applies solely to information collected by this web site. It will notify you of the following: </p>
        <ul>
          <li>What personally identifiable information is collected from you through the web site, how it is used and with whom it may be shared.</li>
          <li>What choices are available to you regarding the use of your data.</li>
          <li>The security procedures in place to protect the misuse of your information.</li>
          <li>How you can correct any inaccuracies in the information.</li>
        </ul>
        <h3>Information Collection, Use, and Sharing </h3>
        <p>We are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not sell or rent this information to anyone.</p>
        <p>We will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary to fulfill your request, e.g. to ship an order.</p>
        <p>Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.</p>
        <h3>Your Access to and Control Over Information </h3>
        <p>You may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:</p>
        <ul>
          <li>See what data we have about you, if any.</li>
          <li>Change/correct any data we have about you.</li>
          <li>Have us delete any data we have about you.</li>
          <li>Express any concern you have about our use of your data.</li>
        </ul>
        <h3>Security </h3>
        <p>We take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.</p>
        <p>Wherever we collect sensitive information (such as credit card data), that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a closed lock icon at the bottom of your web browser, or looking for "https" at the beginning of the address of the web page.</p>
        <p>While we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific job (for example, billing or customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information are kept in a secure environment.</p>
        <h3>Registration </h3>
        <p>In order to use this website, a user must first complete the registration form. During registration a user is required to give certain information (such as name and email address). This information is used to contact you about the products/services on our site in which you have expressed interest. At your option, you may also provide demographic information (such as gender or age) about yourself, but it is not required.</p>
        <h3>Orders </h3>
        <p>We request information from you on our order form. To buy from us, you must provide contact information (like name and shipping address) and financial information (like credit card number, expiration date). This information is used for billing purposes and to fill your orders. If we have trouble processing an order, we'll use this information to contact you.</p>
        <h3>Cookies </h3>
        <p>We use "cookies" on this site. A cookie is a piece of data stored on a site visitor's hard drive to help us improve your access to our site and identify repeat visitors to our site. For instance, when we use a cookie to identify you, you would not have to log in a password more than once, thereby saving time while on our site. Cookies can also enable us to track and target the interests of our users to enhance the experience on our site. Usage of a cookie is in no way linked to any personally identifiable information on our site.</p>
        <h3>Updates</h3>
        <p>Our Privacy Policy may change from time to time and all updates will be posted on this page.</p>
        <p>If you feel that we are not abiding by this privacy policy, you should contact us immediately via telephone at <a href="tel:+1856-236-1853">+1856-236-1853</a> or via email <a href="mailto:Contact@archer.com">Contact@archer.com</a></p>
      </div>
    </div>
  </div>
</div>

<!--Site policy modal end-->

<!--contact form modal-->

<div class="modal fade" id="modal-contact-form" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">

        <!--contact form-->

        <div class="contact-form text-center">
          <header class="section-header"> <img src="img/support-icon.svg" alt="support icon">
            <h2>Contact us</h2>
            <h3>Have any questions? Send us a message.</h3>
          </header>
          <form class="cta-form cta-light" action="php/contact.php" method="post">
            <div class="form-group">
              <input  type="text" name="name" class="contact-name form-control input-lg" placeholder="Name *" id="contact-name">
            </div>
            <div class="form-group">
              <input  type="text"  name="email" class="contact-email form-control input-lg" placeholder="Email address *" id="contact-email">
            </div>
            <div class="form-group">
              <textarea name="message" class="contact-message form-control input-lg" rows="4" placeholder="Message *" id="contact-message"></textarea>
            </div>
            <div class="form-group">
              <input type="text" name="antispam" placeholder="Antispam question: 7 + 5 = ?" class="contact-antispam form-control input-lg" id="contact-antispam">
            </div>
            <button type="submit" class="btn">SEND MESSAGE</button>
          </form>
        </div>

        <!--contact form end-->

        <p class="contact-form-success"><i class="fa fa-check"></i><span>Thanks for contacting us!</span> We will get back to you very soon.</p>
      </div>
    </div>
  </div>
</div>

<!--contact form modal end--> 

</body>
</html>
<?php $this->endPage() ?>    
