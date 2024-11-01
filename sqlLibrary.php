<?php
// Do not include sqlconfig here.

// https://stackoverflow.com/questions/71265229/is-there-a-type-hint-for-an-array-of-objects-of-a-specific-class-in-php-8-3
function fetchAllArt($mysqli) { // : ArtItem[]
  global $mysqli;
  $result = $mysqli->query("SELECT * FROM art_items;");
  
  $artItems = [];
  
  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //https://www.php.net/manual/en/function.array-push.php 
      $artItems[] = new ArtItem($row);
    }
  }

  return $artItems;
}

class ArtItem {
  private int id;
  private string artName;
  private string doc; 
  private float width;
  private float height;
  private float price;
  private string desc;

  public function getDesc() : string {
    return $this->desc;
  }
  public function getPrice() : float {
    return $this->price;
  }
  public function getHeight() : float {
    return $this->height;
  }
  public function getWidth() : float {
    return $this->width;
  }
  public function getDoc() : string {
    return $this->doc;
  }
  public function getArtName() : string {
    return $this->artName;
  }
  public function getId() : int {
    return $this->id;
  }
  public __construct ($row) {
    $this->id = $row['id'];
    $this->artName = $row['name'];
    $this->doc = $row['date_of_completion'];
    $this->width = $row['width'];
    $this->height = $row['height'];
    $this->price = $row['price'];
    $this->desc = $row['description'];
  }




}
?>
