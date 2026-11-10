<?php
// Experience.php - the Experience class (one object = one coffee experience)

class Experience {

    // private properties
    private $id;
    private $cafeName;
    private $drink;
    private $stars;
    private $comment;

    // constructor: runs when we write  new Experience(...)
    public function __construct($id, $cafeName, $drink, $stars, $comment) {
        $this->id       = $id;
        $this->cafeName = $cafeName;
        $this->drink    = $drink;
        $this->stars    = $stars;
        $this->comment  = $comment;
    }

    // getters
    public function getId()       { return $this->id; }
    public function getCafeName() { return $this->cafeName; }
    public function getDrink()    { return $this->drink; }
    public function getComment()  { return $this->comment; }

    // Show the saved rating without changing it from the experience card
    public function getStars() {
        $html = "";
        for ($starNumber = 1; $starNumber <= 5; $starNumber++) {
            if ($starNumber <= $this->stars) {
                $html = $html . "<span class='rating-star on'>&#9733;</span>";
            } else {
                $html = $html . "<span class='rating-star'>&#9733;</span>";
            }
        }
        return $html;
    }
}
?>
