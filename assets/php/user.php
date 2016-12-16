<?php
class Controller {
    private $json;
    private $db;

    // Constructor
    function __construct(){
        // Init DB
        require_once "./mysql.php";
        $this->db = new DB();
        
        // Actions
        if(isset($_GET["action"]) === TRUE) {
            if($_GET["action"] == "islogedin")
            {
                $this->islogedin();
            }
            else if($_GET["action"] == "login")
            {
                $this->login();
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
            else if($_GET["action"] == "registration")
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
        $this->json = $this->db->isUserLoggedin();
    }

    function login() {
        // benutzer_login
        // passwort_login
        $this->json = "Not implementet jet";
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
        $this->json = "Not implementet jet";
    }

    // Save User password
    function updatePassword() {
        // TODO Update Userpassword
        $this->json = "Not implementet jet";
    }

    // Add new User
    function addUser() {
        // TODO add new User
        $this->json = "Not implementet jet";
    }

    // Display
    public function display(){
        echo $this->json;
    }
}
?>