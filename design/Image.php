<?php
class Image{

  private $id;
  private $name;
  private $urlLittleImg;
  private $urlBigImg;
  private $albumId;
  private $height;
  private $width;

  public function getId() {
   return $this->id;
  }
	
  public function getName() {
    return $this->name;
  }
  
  public function getUrlLittleImg() {
    return $this->urlLittleImg;
  }
  
  public function getUrlBigImg() {
    return $this->urlBigImg;
  }
  
  public function getAlbumId() {
    return $this->albumId;
  }
  
  public function getHeight() {
    return $this->height;
  }
  
  public function getWidth() {
    return $this->width;
  }
	
  public function setId($id) {
      $this->id = $id;
	  return $this;
  }
	
  public function setName($name) {
    $this->name = $name;
	return $this;
  }
  
  public function setUrlLittleImg($urlLittleImg) {
    $this->urlLittleImg = $urlLittleImg;
	return $this;
  }
  
  public function setUrlBigImg($urlBigImg) {
    $this->urlBigImg = $urlBigImg;
	return $this;
  }
  
  public function setAlbumId($albumId) {
    $this->albumId = $albumId;
	return $this;
  }
  
  public function setHeight($height) {
    $this->height = $height;
	return $this;
  }
  
  public function setWidth($width) {
    $this->width = $width;
	return $this;
  }
}
?>
