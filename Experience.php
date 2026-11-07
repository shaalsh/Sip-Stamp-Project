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

    // returns 5 stars: coloured ones for the rating, empty ones for the rest
    public function getStars() {
        $html = "";
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->stars) {
                $html = $html . "<span class='rate-star on' data-id='" . $this->id . "' data-stars='" . $i . "'>&#9733;</span>";
            } else {
                $html = $html . "<span class='rate-star' data-id='" . $this->id . "' data-stars='" . $i . "'>&#9733;</span>";
            }
        }
        return $html;
    }
}
?>
