<?php
class Controller {
    private $json;

    // Constructor
    function __construct(){
        if(isset($_GET["action"]) === TRUE) {
            if($_GET["action"] == "islogedin")
            {
                $this->islogedin();
            }
        }
        else
        {
            $this->getJson();
        }
    }

    // Checks if is logged in
    function islogedin() {
        // HACK return evertime true
        $this->json = true;
    }

    // Display
    public function display(){
        echo $this->json;
    }
}
?>