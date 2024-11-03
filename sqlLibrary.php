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
// I realise how horrible this function is, but I am out of time to fix it.
function formatRow($tag,$bold,) : string {
  //https://www.php.net/manual/en/function.func-get-args.php
  $str = "";
  $numargs = func_num_args();
  if ($numargs-2 == 0) { // return nothing if no args passed.
    return "";
  }

  $arg_list = func_get_args();
  for ($i = 2; $i < $numargs; $i++){ // take current argument, wrap it in tag.
    $str = $str . tagWrap($arg_list[$i],$bold, $tag);
  }

  return $str;
}


function tagWrap($val,) {
  $str = $val;
  $numargs = func_num_args();
  if ($numargs-1 == 0) { // return nothing if no args passed.
    return "";
  }

  $arg_list = func_get_args();
  for ($i = 1; $i < $numargs; $i++){ // take current argument, wrap it in tag.
    if ($arg_list[$i]) {

    $str = "<{$arg_list[$i]}>$str</{$arg_list[$i]}>";
    }
  }
  return $str;

}
function wrap($str, $char) {
    return $char . $str . $char;
}

class ArtItem {
  private int $id;
  private string $artName;
  private string $doc;
  private float $width;
  private float $height;
  private float $price;
  private string $desc;

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
  public function __construct ($row) {
    $this->id = $row['id'];
    $this->artName = $row['name'];
    $this->doc = $row['date_of_completion'];
    $this->width = $row['width'];
    $this->height = $row['height'];
    $this->price = $row['price'];
    $this->desc = $row['description'];
  }

  public function generateTableRow() : string {
    return "";
  }
}
?>
