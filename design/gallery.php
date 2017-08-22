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
	    ->setAlbumId(${'photoObject'.$i}->getAlbumId())
		->setHeight($graphObject['images'][0]["height"])
		->setWidth($graphObject['images'][0]["width"]);
      
      
      /*foreach($graphObject['images'] as $image){
        if($image["height"] == 225){
	      //echo "<img src='".$image["source"]."' alt='".$graphObject["name"]."' /> <br />";
          ${'imageObject'.$i}-> setUrlLittleImg($image["source"]);
	    }
      }*/
    }
    
    else{
    
      $response = $fb->get('/'.${'photoObject'.$i}->getId().'?fields=images', $accessToken);
      $graphObject = $response->getGraphObject();


      ${'imageObject'.$i}->setId($graphObject["id"])
	    ->setName(NULL)
	    ->setUrlBigImg($graphObject['images'][0]["source"])
		->setAlbumId(${'photoObject'.$i}->getAlbumId())
		->setHeight($graphObject['images'][0]["height"])
		->setWidth($graphObject['images'][0]["width"]);
      
      
      /*foreach($graphObject['images'] as $image){
        if($image["height"] == 225){
	      //echo "<img src='".$image["source"]."' alt='' /> <br />";
          ${'imageObject'.$i}-> setUrlLittleImg($image["source"]);
	    }
	  }*/
    }
  }
  
  
  /*for($i = 0 ; $i < 30 ; $i++){
    echo"Image".$i." : ";
    var_dump(${'imageObject'.$i});
    echo"<br />";echo"<br />";
    echo"photo".$i." : ";
    var_dump(${'photoObject'.$i});
    echo"<br />";echo"<br />";
  }*/
  
  /*for($i = 0 ; $i < 30 ; $i+=6){
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



<!DOCTYPE html>
<html lang="en-US">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width" />
      <title>Responsive Design website template</title>
      <link rel="stylesheet" href="css/components.css">
      <link rel="stylesheet" href="css/responsee.css">
      <link rel="stylesheet" href="owl-carousel/owl.carousel.css">
      <link rel="stylesheet" href="owl-carousel/owl.theme.css">
      <!-- CUSTOM STYLE -->  
      <link rel="stylesheet" href="css/template-style.css">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
      <script type="text/javascript" src="js/jquery-ui.min.js"></script>    
      <script type="text/javascript" src="js/modernizr.js"></script>
      <script type="text/javascript" src="js/responsee.js"></script>   
      <!--[if lt IE 9]>
	      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
      <![endif]--> 

	  
	  
	  
	  
	  
	<script type="Text/Javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../lightslider-master/src/js/lightslider.js"></script>
    <script type="text/javascript" src="../SudoSlider/js/jquery.sudoSlider.min.js"></script>
	<link type="text/css" rel="stylesheet" href="../lightslider-master/src/css/lightslider.css" />
	
    <link type="text/css" rel="stylesheet" href="css/modal.css" />
    <link type="text/css" rel="stylesheet" href="css/slideshow.css" />
    <link type="text/css" rel="stylesheet" href="css/galleryPerso.css" />
	  
	  
   </head>
   <body class="size-1140">
      <!-- TOP NAV WITH LOGO -->  
      <header>
         <nav>
            <div class="line">
               <div class="top-nav">              
                  <div class="logo hide-l">
                     <a href="../design/">Fotos13 <br /><strong>Amateur</strong></a>
                  </div>                  
                  <p class="nav-text">Menu Text</p>
                  <div class="top-nav s-12 l-5">
                     <ul class="right top-ul chevron">
                        <li style="margin-right: 0px;"><a href="../design/">Accueil</a>
                        </li>
                        <!--<li>
			  <a href="../design/product.html">Product</a>
                        </li>-->
                        <li style="margin-right: 0px;"><a href="../design/services.html">Présentation</a>
                        </li>
                     </ul>
                  </div>
                  <ul class="s-12 l-2">
                     <li class="logo hide-s hide-m">
                        <a href="../design/">Fotos13 <br /><strong>Amateur</strong></a>
                     </li>
                  </ul>
                  <div class="top-nav s-12 l-5">
                     <ul class="top-ul chevron">
                        <li style="margin-right: 0px;"><a href="../design/gallery.php">Galerie</a>
                        </li>
                        <!--<li>
                           <a>Company</a>			    
                           <ul>
                              <li><a>Company 1</a>
                              </li>
                              <li><a>Company 2</a>
                              </li>
                              <li>
                                 <a>Company 3</a>				  
                                 <ul>
                                    <li><a>Company 3-1</a>
                                    </li>
                                    <li><a>Company 3-2</a>
                                    </li>
                                    <li><a>Company 3-3</a>
                                    </li>
                                 </ul>
                              </li>
                           </ul>
                        </li>-->
                        <li style="margin-right: 0px;"><a href="../design/contact.html">Contact</a>
                        </li>
                     </ul> 
                  </div>
               </div>
            </div>
         </nav>
      </header>
      <section>
         <div id="head">
            <div class="line">
               <h1>Responsive image gallery</h1>
            </div>
         </div>
         <div id="content">
            <div class="line">
               <div class="margin">
                   <!--<div class="s-12 m-6 l-4">
                      <img src="img/first-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/second-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/third-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/fourth-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/first-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/second-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/third-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/fourth-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/first-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/second-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/third-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>
                   <div class="s-12 m-6 l-4">
                      <img src="img/fourth-small.jpg">      
                      <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                      </p>
                   </div>-->
				   
				   
				   <div class="album">
					  <h2><?php echo $albumObject0->getName(); ?></h2>
					  
					  <div class="demo">
						<ul id="lightSlider" style="height: auto;">
						  <li data-thumb="<?php echo $imageObject0->getUrlBigImg() ;?>" class="lslide" style="width: "<?php echo '900px;' ?>"; margin: auto;">
							<img id="myImg0" src="<?php echo $imageObject0->getUrlBigImg() ;?>" alt="" 
							  <?php /*only if height > width*/ 
							    if($imageObject0->getHeight() > $imageObject0->getWidth()){
									echo 'style="height:700px;"';
								}
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject1->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg1" src="<?php echo $imageObject1->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject1->getHeight() > $imageObject1->getWidth()){
								  echo 'style="height:700px;"';
							    }
							  ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject2->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg2" src="<?php echo $imageObject2->getUrlBigImg() ;?>"
							<?php /*only if height > width*/ 
							  if($imageObject2->getHeight() > $imageObject2->getWidth()){
                                echo 'style="height:700px;"';
							  }
						    ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject3->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg3" src="<?php echo $imageObject3->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject3->getHeight() > $imageObject3->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject4->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg4" src="<?php echo $imageObject4->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject4->getHeight() > $imageObject4->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject5->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg5" src="<?php echo $imageObject5->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject5->getHeight() > $imageObject5->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
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
						  <li data-thumb="<?php echo $imageObject6->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg6" src="<?php echo $imageObject6->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject6->getHeight() > $imageObject6->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject7->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg7" src="<?php echo $imageObject7->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject7->getHeight() > $imageObject7->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject8->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg8" src="<?php echo $imageObject8->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject8->getHeight() > $imageObject8->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject9->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg9" src="<?php echo $imageObject9->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject9->getHeight() > $imageObject9->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject10->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg10" src="<?php echo $imageObject10->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject10->getHeight() > $imageObject10->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject11->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg11" src="<?php echo $imageObject11->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject11->getHeight() > $imageObject11->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
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
						  <li data-thumb="<?php echo $imageObject12->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg12" src="<?php echo $imageObject12->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject12->getHeight() > $imageObject12->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject13->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg13" src="<?php echo $imageObject13->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject13->getHeight() > $imageObject13->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject14->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg14" src="<?php echo $imageObject14->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject14->getHeight() > $imageObject14->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject15->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg15" src="<?php echo $imageObject15->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject15->getHeight() > $imageObject15->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject16->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg16" src="<?php echo $imageObject16->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject16->getHeight() > $imageObject16->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject17->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg17" src="<?php echo $imageObject17->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject17->getHeight() > $imageObject17->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
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
						  <li data-thumb="<?php echo $imageObject18->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg18" src="<?php echo $imageObject18->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject18->getHeight() > $imageObject18->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject19->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg19" src="<?php echo $imageObject19->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject19->getHeight() > $imageObject19->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject20->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg20" src="<?php echo $imageObject20->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject20->getHeight() > $imageObject20->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject21->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg21" src="<?php echo $imageObject21->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject21->getHeight() > $imageObject21->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject22->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg22" src="<?php echo $imageObject22->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject22->getHeight() > $imageObject22->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject23->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg23" src="<?php echo $imageObject23->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject23->getHeight() > $imageObject23->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						</ul>
					  </div>
					</div>
					<!--END div-->


					<!--BEGIN div-->
					<div class="album" style="margin-bottom:0px; border:none; padding-bottom:0px;">
					  <h2><?php echo $albumObject4->getName(); ?></h2>
					  
					  <div class="demo">
						<ul id="lightSlider4">
						  <li data-thumb="<?php echo $imageObject24->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg24" src="<?php echo $imageObject24->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject24->getHeight() > $imageObject24->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject25->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg25" src="<?php echo $imageObject25->getUrlBigImg() ;?>" alt=""
							  <?php /*only if height > width*/ 
							    if($imageObject25->getHeight() > $imageObject25->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject26->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg26" src="<?php echo $imageObject26->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject26->getHeight() > $imageObject26->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject27->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg27" src="<?php echo $imageObject27->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject27->getHeight() > $imageObject27->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						  <li data-thumb="<?php echo $imageObject28->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg28" src="<?php echo $imageObject28->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject28->getHeight() > $imageObject28->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>        
						  <li data-thumb="<?php echo $imageObject29->getUrlBigImg() ;?>" class="lslide" style="width: 900px; margin: auto;">
							<img id="myImg29" src="<?php echo $imageObject29->getUrlBigImg() ;?>"
							  <?php /*only if height > width*/ 
							    if($imageObject29->getHeight() > $imageObject29->getWidth()){
                                  echo 'style="height:700px;"';
							    }
						      ?> 
							>
						  </li>
						</ul>
					  </div>
					</div>
					<!--END div-->

					<!-- The Modal -->
					<div id="myModal" class="modal">
					  <span class="close">&times;</span>
					  <img class="modal-content" id="img01" >
					  <div id="caption"></div>
					</div>

					<script type="text/javascript" src="../design/js/js_perso/modal.js"></script>
					<script type="Text/Javascript" src="js/lightSliderPerso.js"></script>
					<script type="Text/Javascript" src="js/galleryPerso.js"></script>

				   

				   
               </div>
            </div>
         </div>
         <div id="fourth-block">
            <div class="line">
               <h1>Retrouver moi sur</h1>
               <div id="owl-demo2" class="owl-carousel owl-theme">
                  <div class="item">
                     <h2><a href="#"><img src="logos/fb.png" style="height: 35px; width:35px; display: inline-block; margin-right:30px;"/></a>Facebook</h2>
                     <p class="s-12 m-12 l-8 center">C'est ici que je publie toutes mes nouvelles photos. N'hésitez pas à me suivre pour ne rien manquer.</p>
                     <p class="s-12 m-12 l-8 center">J'aime également vos commentaires et critiques et je me fais une joie de toujours vous répondre !</p>
                  </div>
                  <div class="item">
                     <h2><a href="#"><img src="logos/insta.jpg" style="height: 35px; width:35px; display: inline-block; margin-right:30px;"/></a>Instagram</h2>
                     <p class="s-12 m-12 l-8 center">Ici aussi je mets quelques une de mes plus belles photos.</p>
                  </div>
                  <!--<div class="item">
                     <h2>Retina ready</h2>
                     <p class="s-12 m-12 l-8 center"></p>
                  </div>-->
               </div>
            </div>
         </div>
      </section>
      <!-- FOOTER -->   
      <footer>
         <div class="line">
            <div class="s-12 l-6">
               <p>Un truc à écrire ?</p>
            </div>
            <div class="s-12 l-6">
               <p class="right" style="font-size: 30px;">
                  Fotos13Amateur
               </p>
            </div>
         </div>
      </footer>
      <script type="text/javascript" src="owl-carousel/owl.carousel.js"></script>   
      <script type="text/javascript">
         jQuery(document).ready(function($) {  
           $("#owl-demo").owlCarousel({
         	slideSpeed : 300,
         	autoPlay : true,
         	navigation : false,
         	pagination : false,
         	singleItem:true
           });
           $("#owl-demo2").owlCarousel({
         	slideSpeed : 300,
         	autoPlay : true,
         	navigation : false,
         	pagination : true,
         	singleItem:true
           });
         });	
          
      </script> 
   </body>
</html>
