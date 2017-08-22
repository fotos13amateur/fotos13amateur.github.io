<?php
class Photo{

  private $id;
  private $name;
  private $albumId;

  public function getId() {
   return $this->id;
  }
	
  public function getName() {
    return $this->name;
  }
  
  public function getAlbumId() {
    return $this->albumId;
  }
	
  public function setId($id) {
      $this->id = $id;
	  return $this;
  }
	
  public function setName($name) {
    $this->name = $name;
	return $this;
  }
  
  public function setAlbumId($albumId) {
    $this->albumId = $albumId;
	return $this;
  }
}
?>
