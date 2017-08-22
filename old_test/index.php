<?php

// Pass session data over.
session_start();
 
// Include the required dependencies.
require( __DIR__.'/php-graph-sdk-5.5/src/Facebook/autoload.php' );

$fb = new \Facebook\Facebook([
  'app_id' => '1546957835356362',
  //'secret' => '936c2c065806dd418ce3695d250a4727', // prod
  'app_secret' => '8a46f8c78843e266509cf450d7697029' //test
  //'default_access_token' => '{access-token}', // optional
  ]);

$defaultToken = '1546957835356362:8a46f8c78843e266509cf450d7697029';

$accessToken = $fb->getApp()->getAccessToken();

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/690146107850424?fields=images,name',$accessToken);
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphObject = $response->getGraphObject();

$bigPicture = $graphObject['images'][0]["source"];

foreach($graphObject['images'] as $image){
  if($image["height"] == 225 || $image["width"] == 225){
    //echo "<img src='".$image["source"]."' onclick=this.src='".$bigPicture."' />";
    $imageTest = $image["source"];
  }
}


try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/693741820824186?fields=images,name',$accessToken);
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphObject1 = $response->getGraphObject();

$bigPicture1 = $graphObject1['images'][0]["source"];

foreach($graphObject1['images'] as $image){
  if($image["height"] == 225 || $image["width"] == 225){
    //echo "<img src='".$image["source"]."' onclick=this.src='".$bigPicture."' />";
    $imageTest1 = $image["source"];
    $imageTest1Width =$image["width"];
    $imageTest1Height =$image["height"];
  }
}


$graphObject1Name = $graphObject1['name'];
if(strpos($graphObject1Name, '"')){
  $graphObject1Name = str_replace('"', '&#34;', $graphObject1Name);
}
if(strpos($graphObject1Name, "'")){
  $graphObject1Name = str_replace("'", "&#146;", $graphObject1Name);
}


?>

<!DOCTYPE html>
<html>
<head>
<style>
/*style modal*/
#myImg, #myImg2 {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover, #myImg2:hover {opacity: 0.7;}


/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 100; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #fff;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: fixed;
    top: 15px;
    right: 35px;
    color: #B0B0B0;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: white;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}


</style>

<style>
/*style slideshow*/
.demo {
    width:450px;
}

ul {
    list-style: none outside none;
    padding-left: 0;
    margin-bottom:0;
}

li {
    display: block;
    float: left;
    margin-right: 6px;
    cursor:pointer;
}

img {
    display: block;
    height: auto;
    max-width: 100%;
}
</style>


<link type="text/css" rel="stylesheet" href="lightslider-master/src/css/lightslider.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="lightslider-master/src/js/lightslider.js"></script>

</head>
<body>

<div class="demo">
    <ul id="lightSlider">
        <li data-thumb="<?php echo $bigPicture;?>" class="lslide" style="width: 450px; margin-right: 0px;">
            <img id="myImg" src="<?php echo $bigPicture;?>" alt="<?php echo $graphObject['name']; ?>">
        </li>
        <li data-thumb="<?php echo $bigPicture1;?>" class="lslide" style="width: 450px; margin-right: 0px;">
            <img id="myImg2" src="<?php echo $bigPicture1;?>" alt=" <?php echo $graphObject1Name; ?>">
        </li>
        <li data-thumb="https://sachinchoolur.github.io/lightslider/img/thumb/cS-3.jpg" class="lslide" style="width: 450px; margin-right: 0px;">
            <img src="https://sachinchoolur.github.io/lightslider/img/cS-3.jpg">
        </li>
        <li data-thumb="https://sachinchoolur.github.io/lightslider/img/thumb/cS-4.jpg" class="lslide" style="width: 450px; margin-right: 0px;">
            <img src="https://sachinchoolur.github.io/lightslider/img/cS-4.jpg">
        </li>
        <li data-thumb="https://sachinchoolur.github.io/lightslider/img/thumb/cS-5.jpg" class="lslide" style="width: 450px; margin-right: 0px;">
            <img src="https://sachinchoolur.github.io/lightslider/img/cS-5.jpg">
        </li>
        <li data-thumb="https://sachinchoolur.github.io/lightslider/img/thumb/cS-6.jpg" class="lslide" style="width: 450px; margin-right: 0px;">
            <img src="https://sachinchoolur.github.io/lightslider/img/cS-6.jpg">
        </li>
        <li data-thumb="https://sachinchoolur.github.io/lightslider/img/thumb/cS-7.jpg" class="lslide" style="width: 450px; margin-right: 0px;">
            <img src="https://sachinchoolur.github.io/lightslider/img/cS-7.jpg">
        </li>
        <li data-thumb="https://sachinchoolur.github.io/lightslider/img/thumb/cS-8.jpg" class="lslide" style="width: 450px; margin-right: 0px;">
            <img src="https://sachinchoolur.github.io/lightslider/img/cS-8.jpg">
        </li>
        <li data-thumb="https://sachinchoolur.github.io/lightslider/img/thumb/cS-9.jpg" class="lslide" style="width: 450px; margin-right: 0px;">
            <img src="https://sachinchoolur.github.io/lightslider/img/cS-9.jpg">
        </li>
        <li data-thumb="https://sachinchoolur.github.io/lightslider/img/thumb/cS-10.jpg" class="lslide" style="width: 450px; margin-right: 0px;">
            <img src="https://sachinchoolur.github.io/lightslider/img/cS-10.jpg">
        </li>
      </ul>
      <div class="lSAction"><a class="lSPrev"></a><a class="lSNext"></a></div>   
</div>

<script>
/*script slideshow*/
$('#lightSlider').lightSlider({
    gallery: true,
    item: 1,
    loop:true,
    slideMargin: 0,
    thumbItem: 9,

});
</script>


<script type="text/javascript">
/*
//Play with options slideshow
  $(document).ready(function() {
    $("#lightSlider").lightSlider({
      item: 3,
      autoWidth: false,
      slideMove: 1, // slidemove will be 1 if loop is true
      slideMargin: 10,
     
      addClass: '',
      mode: "slide",
      useCSS: true,
      cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
      easing: 'linear', //'for jquery animation',////
     
      speed: 400, //ms'
      auto: false,
      loop: false,
      slideEndAnimation: true,
      pause: 2000,
     
      keyPress: false,
      controls: true,
      prevHtml: '',
      nextHtml: '',
     
      rtl:false,
      adaptiveHeight:false,
     
      vertical:false,
      verticalHeight:500,
      vThumbWidth:100,
     
      thumbItem:10,
      pager: true,
      gallery: false,
      galleryMargin: 5,
      thumbMargin: 5,
      currentPagerPosition: 'middle',
     
      enableTouch:true,
      enableDrag:true,
      freeMove:true,
      swipeThreshold: 40,
     
      responsive : [],
     
      onBeforeStart: function (el) {},
      onSliderLoad: function (el) {},
      onBeforeSlide: function (el) {},
      onAfterSlide: function (el) {},
      onBeforeNextSlide: function (el) {},
      onBeforePrevSlide: function (el) {}
    });
  });
*/
</script>

<!-- The Modal 
<img id="myImg" src="<?php echo $bigPicture;?>" alt="<?php echo $graphObject['name']; ?>" width="179" height="225">

<img id="myImg2" src="<?php echo $bigPicture1;?>" alt=" <?php echo $graphObject1Name; ?> " width="<?php echo $imageTest1Width; ?>" height="<?php echo $imageTest1Height; ?>"> -->

<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>


<script>
/*script modal*/
// Get the modal
/*var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}


var img = document.getElementById('myImg2');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}*/
</script>
<script type="text/javascript" src="../design/js/js_perso/modal.js"></script>

</body>
</html>
