<?php

// Pass session data over.
session_start();
 
// Include the required dependencies.
require( __DIR__.'/php-graph-sdk-5.5/src/Facebook/autoload.php' );
require_once("Album.php");
require_once("Photo.php");
require_once("Image.php");

$numberOfAlbum = 5;
$numberOfPhoto = 6;

$fb = new \Facebook\Facebook([
  'app_id' => '1546957835356362',
  'app_secret' => '8a46f8c78843e266509cf450d7697029' //test
  //'secret' => '936c2c065806dd418ce3695d250a4727', // prod
  ]);

$accessToken = $fb->getApp()->getAccessToken();

try {
  $response = $fb->get('/fotos13amateur/albums?fields=name&limit=100', $accessToken);
  $graphEdge = $response->getGraphEdge();

  $albums = $graphEdge->all();
  
  foreach ($albums as $album) {
    if($album["name"] != "Mobile Uploads"){
      $albumsId[] = $album["id"];
	}
  }
  
  $random_keys = array_rand($albumsId, $numberOfAlbum);
  
  for($i = 0 ; $i < $numberOfAlbum ; $i++){
  ${'albumId'.$i} = $albumsId[$random_keys[$i]];
  }
  //get 6 var albumId0 to albumId5
  for($i = 0 ; $i < $numberOfAlbum ; $i++ ){
    $response = $fb->get('/'.${'albumId'.$i}, $accessToken);
    $graphNode = $response->getGraphObject();
    //print_r($graphNode['name']."<br/>");
    
    if($graphNode['name'] != "Mobile Uploads"){
      ${'albumObject'.$i} = new Album();
      ${'albumObject'.$i}
        ->setId($graphNode['id'])
        ->setName($graphNode['name']);
    }
  }
  //I have now 5 Album objects : names : $albumObject0 to $albumObject4
  
  //TODO : in a for boucle !
  //0
  $response = $fb->get('/'.$albumObject0->getId().'?fields=photos', $accessToken);
  $graphNode = $response->getGraphObject();
  
  $photoGraphEdge = $graphNode['photos'];

  $photos = $photoGraphEdge->all();
  
  $rand_keys = array_rand($photos, $numberOfPhoto);
  
  for($i = 0 ; $i < $numberOfPhoto ; $i++){
    ${'photoObject'.$i} = new Photo();
    ${'photoObject'.$i}
      ->setId($photos[$rand_keys[$i]]->getField('id'))
      ->setName($photos[$rand_keys[$i]]->getField('name'))
      ->setAlbumId($albumObject0->getId());
  }
  //now we have 6 photo objects : names : $photoObject0 to $photoObject5
  //var_dump($photoObject5); // looks ok
  
  
  //1
  $response = $fb->get('/'.$albumObject1->getId().'?fields=photos', $accessToken);
  $graphNode = $response->getGraphObject();
  
  $photoGraphEdge = $graphNode['photos'];

  $photos = $photoGraphEdge->all();
  $rand_keys = array_rand($photos, $numberOfPhoto);
  
  for($i = 0 ; $i < $numberOfPhoto ; $i++){
    $j = $i+6;
    ${'photoObject'.$j} = new Photo();
    ${'photoObject'.$j}
      ->setId($photos[$rand_keys[$i]]->getField('id'))
      ->setName($photos[$rand_keys[$i]]->getField('name'))
      ->setAlbumId($albumObject1->getId());
  }
  //now we have 12 photo objects : names : $photoObject0 to $photoObject11
  //var_dump($photoObject11); // looks ok
  
  //2
  $response = $fb->get('/'.$albumObject2->getId().'?fields=photos', $accessToken);
  $graphNode = $response->getGraphObject();
  
  $photoGraphEdge = $graphNode['photos'];


  $photos = $photoGraphEdge->all();
  $rand_keys = array_rand($photos, $numberOfPhoto);
  
  for($i = 0 ; $i < $numberOfPhoto ; $i++){
    $j = $i + 12;
    ${'photoObject'.$j} = new Photo();
    ${'photoObject'.$j}
      ->setId($photos[$rand_keys[$i]]->getField('id'))
      ->setName($photos[$rand_keys[$i]]->getField('name'))
      ->setAlbumId($albumObject2->getId());
  }
  //now we have 18 photo objects : names : $photoObject0 to $photoObject17
  //var_dump($photoObject17); // looks ok
  
  //3
  $response = $fb->get('/'.$albumObject3->getId().'?fields=photos', $accessToken);
  $graphNode = $response->getGraphObject();
  
  $photoGraphEdge = $graphNode['photos'];
  
  $photos = $photoGraphEdge->all();
  $rand_keys = array_rand($photos, $numberOfPhoto);
  
  for($i = 0 ; $i < $numberOfPhoto ; $i++){
  $j = $i + 18;
    ${'photoObject'.$j} = new Photo();
    ${'photoObject'.$j}
      ->setId($photos[$rand_keys[$i]]->getField('id'))
      ->setName($photos[$rand_keys[$i]]->getField('name'))
      ->setAlbumId($albumObject3->getId());
  }
  //now we have 24 photo objects : names : $photoObject0 to $photoObject23
  //var_dump($photoObject23); // looks ok
  
  //4
  $response = $fb->get('/'.$albumObject4->getId().'?fields=photos', $accessToken);
  $graphNode = $response->getGraphObject();
  
  $photoGraphEdge = $graphNode['photos'];
  
  $photos = $photoGraphEdge->all();
  $rand_keys = array_rand($photos, $numberOfPhoto);
  
  for($i = 0 ; $i < $numberOfPhoto ; $i++){
  $j = $i + 24;
    ${'photoObject'.$j} = new Photo();
    ${'photoObject'.$j}
      ->setId($photos[$rand_keys[$i]]->getField('id'))
      ->setName($photos[$rand_keys[$i]]->getField('name'))
      ->setAlbumId($albumObject4->getId());
  }
  //now we have 30 photo objects : names : $photoObject0 to $photoObject29
  //var_dump($photoObject29); // looks ok
  
  //END TODO : in a for boucle !


  for($i = 0 ; $i < 30 ; $i++){
    
    ${'imageObject'.$i} = new Image();    
    
    if(${'photoObject'.$i}->getName() != NULL){
      $response = $fb->get('/'.${'photoObject'.$i}->getId().'?fields=images,name', $accessToken);
      $graphObject = $response->getGraphObject();     


      ${'imageObject'.$i}->setId($graphObject["id"])
	    ->setName($graphObject["name"])
	    ->setUrlBigImg($graphObject['images'][0]["source"])
	    ->setAlbumId(${'photoObject'.$i}->getAlbumId());
      
      
      foreach($graphObject['images'] as $image){
        if($image["height"] == 225){
	      //echo "<img src='".$image["source"]."' alt='".$graphObject["name"]."' /> <br />";
          ${'imageObject'.$i}-> setUrlLittleImg($image["source"]);
	    }
      }
    }
    
    else{
    
      $response = $fb->get('/'.${'photoObject'.$i}->getId().'?fields=images', $accessToken);
      $graphObject = $response->getGraphObject();


      ${'imageObject'.$i}->setId($graphObject["id"])
	    ->setName(NULL)
	    ->setUrlBigImg($graphObject['images'][0]["source"]);
      
      
      foreach($graphObject['images'] as $image){
        if($image["height"] == 225){
	      //echo "<img src='".$image["source"]."' alt='' /> <br />";
          ${'imageObject'.$i}-> setUrlLittleImg($image["source"]);
	    }
	  }
    }
  }
  
  
  /*for($i = 0 ; $i < 30 ; $i++){
    echo"Image".$i." : ";
    var_dump(${'imageObject'.$i});
    echo"<br />";echo"<br />";
    echo"photo".$i." : ";
    var_dump(${'photoObject'.$i});
    echo"<br />";echo"<br />";
  }
  
  for($i = 0 ; $i < 30 ; $i+=6){
    echo"<br />";echo"<br />";
    echo"photo".$i." : ";
    var_dump(${'photoObject'.$i});
    echo"<br />";echo"<br />";
  }*/
  
  /*$j=0;
  for($i = 0 ; $i < 30 ; $i++){
    if($i % 6 == 0){
      echo "<br />"; echo "<br />";
      var_dump(${'albumObject'.$j});
      echo "<br />"; echo "<br />";
      $j+=1;
    }
  }*/
  
  
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

?>


<html>
  <head>
    <script type="Text/Javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../lightslider-master/src/js/lightslider.js"></script>
    <script type="text/javascript" src="../SudoSlider/js/jquery.sudoSlider.min.js"></script>
	<link type="text/css" rel="stylesheet" href="../lightslider-master/src/css/lightslider.css" />
	
    <link type="text/css" rel="stylesheet" href="css/modal.css" />
    <link type="text/css" rel="stylesheet" href="css/slideshow.css" />
    <link type="text/css" rel="stylesheet" href="css/galleryPerso.css" />

  </head>
  <body>
    <!--BEGIN div-->
	<div class="album">
      <h2><?php echo $albumObject0->getName(); ?></h2>
      
      <div class="demo">
        <ul id="lightSlider" style="height: auto;">
	  <li data-thumb="<?php echo $imageObject0->getUrlBigImg() ;?>" class="lslide" style="width: "<?php echo '900px;' ?>"; margin-right: 0px;">
	    <img id="myImg0" src="<?php echo $imageObject0->getUrlBigImg() ;?>" alt="" <?php /*only if height > width*/?> style="height:700px;">
	  </li>
	  <li data-thumb="<?php echo $imageObject1->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
        <img id="myImg1" src="<?php echo $imageObject1->getUrlBigImg() ;?>" alt=""style="height:700px;">
	  </li>
	  <li data-thumb="<?php echo $imageObject2->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
	    <img id="myImg2" src="<?php echo $imageObject2->getUrlBigImg() ;?>"style="height:700px;">
	  </li>
	  <li data-thumb="<?php echo $imageObject3->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
	    <img id="myImg3" src="<?php echo $imageObject3->getUrlBigImg() ;?>"style="height:700px;">
	  </li>
	  <li data-thumb="<?php echo $imageObject4->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
	    <img id="myImg4" src="<?php echo $imageObject4->getUrlBigImg() ;?>"style="height:700px;">
	  </li>
	  <li data-thumb="<?php echo $imageObject5->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
	    <img id="myImg5" src="<?php echo $imageObject5->getUrlBigImg() ;?>"style="height:700px;">
	  </li>
        </ul>
      </div>
	</div>
    <!--END div-->


    <!--BEGIN div-->
	<div class="album">
      <h2><?php echo $albumObject1->getName(); ?></h2>
    
      <div class="demo">
        <ul id="lightSlider1">
          <li data-thumb="<?php echo $imageObject6->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg6" src="<?php echo $imageObject6->getUrlBigImg() ;?>" alt="" style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject7->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg7" src="<?php echo $imageObject7->getUrlBigImg() ;?>" alt="" style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject8->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg8" src="<?php echo $imageObject8->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject9->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg9" src="<?php echo $imageObject9->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject10->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg10" src="<?php echo $imageObject10->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject11->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg11" src="<?php echo $imageObject11->getUrlBigImg() ;?>"style="height:700px;">
          </li>
        </ul>  
      </div>
    </div>
    <!--END div-->


    <!--BEGIN div-->
	<div class="album">
      <h2><?php echo $albumObject2->getName(); ?></h2>
    
      <div class="demo">
        <ul id="lightSlider2">
          <li data-thumb="<?php echo $imageObject12->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg12" src="<?php echo $imageObject12->getUrlBigImg() ;?>" alt=""style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject13->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg13" src="<?php echo $imageObject13->getUrlBigImg() ;?>" alt=""style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject14->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg14" src="<?php echo $imageObject14->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject15->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg15" src="<?php echo $imageObject15->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject16->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg16" src="<?php echo $imageObject16->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject17->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg17" src="<?php echo $imageObject17->getUrlBigImg() ;?>"style="height:700px;">
          </li>
        </ul>  
      </div>
    </div>
    <!--END div-->


    <!--BEGIN div-->
	<div class="album">
      <h2><?php echo $albumObject3->getName(); ?></h2>
      
      <div class="demo">
        <ul id="lightSlider3">
          <li data-thumb="<?php echo $imageObject18->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg18" src="<?php echo $imageObject18->getUrlBigImg() ;?>" alt=""style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject19->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg19" src="<?php echo $imageObject19->getUrlBigImg() ;?>" alt=""style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject20->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg20" src="<?php echo $imageObject20->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject21->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg21" src="<?php echo $imageObject21->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject22->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg22" src="<?php echo $imageObject22->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject23->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg23" src="<?php echo $imageObject23->getUrlBigImg() ;?>"style="height:700px;">
          </li>
        </ul>
      </div>
    </div>
    <!--END div-->


    <!--BEGIN div-->
	<div class="album">
      <h2><?php echo $albumObject4->getName(); ?></h2>
      
      <div class="demo">
        <ul id="lightSlider4">
          <li data-thumb="<?php echo $imageObject24->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg24" src="<?php echo $imageObject24->getUrlBigImg() ;?>" alt=""style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject25->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg25" src="<?php echo $imageObject25->getUrlBigImg() ;?>" alt=""style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject26->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg26" src="<?php echo $imageObject26->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject27->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg27" src="<?php echo $imageObject27->getUrlBigImg() ;?>"style="height:700px;">
          </li>
          <li data-thumb="<?php echo $imageObject28->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg28" src="<?php echo $imageObject28->getUrlBigImg() ;?>"style="height:700px;">
          </li>        
          <li data-thumb="<?php echo $imageObject29->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin-right: 0px;">
            <img id="myImg29" src="<?php echo $imageObject29->getUrlBigImg() ;?>"style="height:700px;">
          </li>
        </ul>
      </div>
    </div>
    <!--END div-->







<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01" style="width = <?php echo (1371 * 850 / 2048) ?>">
  <div id="caption"></div>
</div>

<script type="text/javascript" src="../design/js/js_perso/modal.js"></script>
<script type="Text/Javascript" src="js/lightSliderPerso.js"></script>
<script type="Text/Javascript" src="js/galleryPerso.js"></script>

  </body>
</html>



