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
            else if($_GET["action"] == "get")
            {
                $this->getUser();
            }
            else if($_GET["action"] == "update")
            {
                $this->updateUser();
            }
            else if($_GET["action"] == "updatePassword")
            {
                $this->updatePassword();
            }
            else if($_GET["action"] == "new")
            {
                $this->addUser();
            }
        }
        else
        {
            $this->getAllUsers();
        }
    }

    // Checks if is logged in
    function islogedin() {
        // HACK return evertime true
        $this->json = "true";
    }

    // Get User DAta (exept Password)
    function getUser() {
        // HACK return all user Data
        $this->json = "[{
            id_user: 1,
            username: 'Username',
            mail: 'example@mail.ch',
            description: 'Das ist mein Profil',
            image: './img/default.png'
        }]";
    }


    // Get all User DAta (exept Password)
    function getAllUsers() {
        // HACK return all user Data
        $this->json = "[{
            id_user: 1,
            username: 'Username',
            mail: 'example@mail.ch',
            description: 'Das ist mein Profil',
            image: './img/default.png'
        }, {
            id_user: 1,
            username: 'Username',
            mail: 'example@mail.ch',
            description: 'Das ist mein Profil',
            image: './img/default.png'
        }]";
    }

    // Save User data
    function updateUser() {
        // TODO Update Userdata
    }

    // Save User password
    function updatePassword() {
        // TODO Update Userpassword
    }

    // Add new User
    function addUser() {
        // TODO add new User
    }

    // Display
    public function display(){
        echo $this->json;
    }
}
?>