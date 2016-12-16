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
            if($_GET["action"] == "add")
            {
                $this->addFoodporn();
            }
            else if($_GET["action"] == "get")
            {
                $this->getFoodporn();
            }
            else if($_GET["action"] == "filterCategory")
            {
                $this->filterCategory();
            }
            else if($_GET["action"] == "filterFavorite")
            {
                $this->filterFavorite();
            }
            else if($_GET["action"] == "like")
            {
                $this->like();
            }
            else if($_GET["action"] == "addComment")
            {
                $this->like();
            }
        }
        else
        {
            $this->getAllFoodporns();
        }
    }
    
    // Adds a foodporn to DB
    function addFoodporn() {
        // TODO save foodporn into db
        $this->json = "Not implementet jet";
    }

    // Add Like to this Foodporn
    function like() {
        // TODO set like / dislike in DB
        $this->json = "Not implementet jet";
    }

    // Add Comment to this Foodporn
    function addComment() {
        // TODO set comment in DB
        $this->json = "Not implementet jet";
    }

    // Get One Foodporn by id
    function getFoodporn() {
        // HACK get data from DB
        $this->json = "[{
            id_foodporn: 1,
            favorit: false,
            image: './img/default.png',
            title: 'Titel',
            description: 'Lorem ipsum...',
            user: {
                id_user: 1,
                username: 'Username',
                description: 'Beschreibung des Users',
                image: './img/default.png'
            },
            category: 'Nudeln',
            date: '2016-12-12 20:00:00',
            likes: 15,
            dislikes: 2,
            comments: [{
                id_comment: 1,
                content: 'Haha voll geil XD',
                date: '2016-12-12 20:00:00',
                user: {
                    id_user: 1,
                    username: 'Username',
                    description: 'Beschreibung des Users',
                    image: './img/default.png'
                }
            } , {
                id_comment: 2,
                content: 'erster!',
                date: '2016-12-12 20:00:00',
                user: {
                    id_user: 1,
                    username: 'Username',
                    description: 'Beschreibung des Users',
                    image: './img/default.png'
                }
            }]
        }];";
    }

    // Get All Foodporns
    function getAllFoodporns() {
        // HACK get data from DB
        $this->json = "[{
            id_foodporn: 1,
            favorit: false,
            image: './img/default.png',
            title: 'Titel',
            description: 'Lorem ipsum...',
            user: {
                id_user: 1,
                username: 'Username',
                description: 'Beswchreibung des Users',
                image: './img/default.png'
            },
            category: 'Nudeln',
            date: '2016-12-12 20:00:00',
            likes: 15,
            dislikes: 2,
            comments: [{
                id_comment: 1,
                content: 'Haha voll geil XD',
                date: '2016-12-12 20:00:00',
                user: {
                    id_user: 1,
                    username: 'Username',
                    description: 'Beschreibung des Users',
                    image: './img/default.png'
                }
            } , {
                id_comment: 2,
                content: 'erster!',
                date: '2016-12-12 20:00:00',
                user: {
                    id_user: 1,
                    username: 'Username',
                    description: 'Beschreibung des Users',
                    image: './img/default.png'
                }
            }]
        }, {
            id_foodporn: 1,
            favorit: false,
            image: './img/default.png',
            title: 'Titel',
            description: 'Lorem ipsum...',
            user: {
                id_user: 1,
                username: 'Username',
                description: 'Beswchreibung des Users',
                image: './img/default.png'
            },
            category: 'Nudeln',
            date: '2016-12-12 20:00:00',
            likes: 15,
            dislikes: 2,
            comments: [{
                id_comment: 1,
                content: 'Haha voll geil XD',
                date: '2016-12-12 20:00:00',
                user: {
                    id_user: 1,
                    username: 'Username',
                    description: 'Beschreibung des Users',
                    image: './img/default.png'
                }
            } , {
                id_comment: 2,
                content: 'erster!',
                date: '2016-12-12 20:00:00',
                user: {
                    id_user: 1,
                    username: 'Username',
                    description: 'Beschreibung des Users',
                    image: './img/default.png'
                }
            }]
        }];";
    }

    // filter by Category
    function filterCategory() {
        // HACK Implement getting Data from DB
        getAllFoodporns();
    }
    
    // filter by Favorite
    function filterFavorite() {
        // HACK Implement getting Data from DB
        getAllFoodporns();
    }

    // Display
    public function display(){
        echo $this->json;
    }
}
?>
    