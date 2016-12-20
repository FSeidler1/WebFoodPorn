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
            else if($_GET["action"] == "logout")
            {
                $this->logoff();
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

    // User Login
    function login() {
        $_POST = json_decode(file_get_contents("php://input"), true);        
        $this->db->login($_POST['benutzer_login'], $_POST['passwort_login']);
        $this->json = $this->db->isUserLoggedin();
    }

    // Logoff Loggoff
    function logoff() {
        $this->db->logoff();
        $this->json = "true";
    }

    // Get User DAta (exept Password)
    function getUser() {
        $_POST = json_decode(file_get_contents("php://input"), true); 

        $users = $this->db->getUser();

        $this->json = json_encode($users);
    }


    // Get all User DAta (exept Password)
    function getAllUsers() {
        $users = $this->db->getAllUsers();

        $this->json = json_encode($users);
    }

    // Save User data
    function updateUser() {
        $_POST = json_decode(file_get_contents("php://input"), true); 
        $this->db->updateUser($_POST["beschreibung"], $_POST["image"]);
        if(isset($_POST["altesPW"]) === TRUE)
        {
            $this->updatePassword();
        }
        $this->json = "true";
    }

    // Save User password
    function updatePassword() {
        $_POST = json_decode(file_get_contents("php://input"), true); 
        $this->json = $this->db->updateUserPassword($_POST["altesPW"], $_POST["neuesPW"]);
    }

    // Add new User
    function addUser() {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $username = $_POST["benutzer_registration"];
        $email = $_POST["email_registration"];
        $password = $_POST["passwort_registration"];
        $this->json = $this->db->registerUser($username, $email, $password);
    }

    // Display
    public function display(){
        echo $this->json;
    }
}
?>