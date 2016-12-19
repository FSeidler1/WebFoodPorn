<?php

class DB 
	{
		private static $_db_username = "root";
		private static $_db_password = "";
		private static $_db_host = "localhost";
		private static $_db_name = "fooddb";
		private static $_db;

		function __construct() 
		{
			try 
			{
				self::$_db = new PDO("mysql:host=" . self::$_db_host . ";dbname=" . self::$_db_name,  self::$_db_username , self::$_db_password);
			} 
			catch(PDOException $e) 
			{
				die();
			}
        }

        // Initializes Tables & example etrys
        function initDB() 
        {
            // Create Foodporn Table
            $stmt = self::$_db->prepare("CREATE TABLE IF NOT EXISTS `fooddb`.`foodporn` ( `id_foodporn` INT NOT NULL AUTO_INCREMENT , 
            `image` TEXT NOT NULL , 
            `title` TEXT NOT NULL , 
            `description` LONGTEXT NOT NULL , 
            `category` VARCHAR(255) NOT NULL , 
            `fs_user` INT NOT NULL , 
            `dateCreated` DATE NOT NULL , 
            PRIMARY KEY (`id_foodporn`)
            ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
            $stmt->execute();

            // Create User Table
            $stmt = self::$_db->prepare("CREATE TABLE IF NOT EXISTS `fooddb`.`user` ( `id_user` INT NOT NULL AUTO_INCREMENT , 
            `username` VARCHAR(255) NOT NULL , 
            `mail` VARCHAR(255) NOT NULL , 
            `password` VARCHAR(255) NOT NULL , 
            `description` TEXT NOT NULL , 
            `image` TEXT NOT NULL , 
            `session` TEXT NOT NULL , 
            PRIMARY KEY (`id_user`)
            ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
            $stmt->execute();

            // Create Like Table
            $stmt = self::$_db->prepare("CREATE TABLE IF NOT EXISTS `fooddb`.`likes` ( `id_like` INT NOT NULL AUTO_INCREMENT , 
            `islike` INT(2) NOT NULL , 
            `fs_user` INT NOT NULL , 
            `fs_foodporn` INT NOT NULL , 
            PRIMARY KEY (`id_like`)
            ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
            $stmt->execute();

            // Create Favorit Table
            $stmt = self::$_db->prepare("CREATE TABLE IF NOT EXISTS `fooddb`.`favorit` ( `id_favorit` INT NOT NULL AUTO_INCREMENT , 
            `fs_foodporn` INT NOT NULL , 
            `fs_user` INT NOT NULL , 
            PRIMARY KEY (`id_favorit`)
            ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
            $stmt->execute();

            // Create Comment Table
            $stmt = self::$_db->prepare("CREATE TABLE IF NOT EXISTS `fooddb`.`comment` ( `id_comment` INT NOT NULL AUTO_INCREMENT , 
            `content` TEXT NOT NULL , 
            `dateCreated` DATE NOT NULL , 
            `fs_foodporn` INT NOT NULL , 
            `fs_user` INT NOT NULL , 
            PRIMARY KEY (`id_comment`)
            ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
            $stmt->execute();

            // Create foodporn Example Entry
            $stmt = self::$_db->prepare("SELECT count(id_foodporn) AS c FROM foodporn");
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count < 1)
            {
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(1,'../../img/test.png', 'Beispielbild', 'Beschreibung des Beispiel Foodporns', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(2,'../../img/try.png', 'Beispielbild', 'Beschreibung des Beispiel Foodporns', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(3,'../../img/default.png', 'Erdbeer Dessert', 'Beschreibung des Erdbeerdesserts Foodporns', 'Desserts', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(4,'../../img/test.png', 'Beispielbild', 'Beschreibung des Beispiel Foodporns', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(5,'../../img/try.png', 'Beispielbild', 'Beschreibung des Beispiel Foodporns', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(6,'../../img/default.png', 'Erdbeer Dessert', 'Beschreibung des Erdbeerdesserts Foodporns', 'Desserts', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(7,'../../img/test.png', 'Beispielbild', 'Beschreibung des Beispiel Foodporns', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(8,'../../img/try.png', 'Beispielbild', 'Beschreibung des Beispiel Foodporns', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(9,'../../img/default.png', 'Erdbeer Dessert', 'Beschreibung des Erdbeerdesserts Foodporns', 'Desserts', 1, NOW())");
                $stmt->execute();
            }
            
            // Create user Example Entry
            $stmt = self::$_db->prepare("SELECT count(id_user) AS c FROM user");
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count < 1)
            {
                $stmt = self::$_db->prepare("INSERT INTO user (id_user,username,mail,password,description,image,session)
                VALUES(1,'Test', 'test@test.ch', '" . md5("Test123") . "', 'Über mich:', './img/default.png', '')");
                $stmt->execute();
            }
            
            // Create like Example Entry
            $stmt = self::$_db->prepare("SELECT count(id_like) AS c FROM likes");
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count < 1)
            {
                $stmt = self::$_db->prepare("INSERT INTO likes (islike, fs_user, fs_foodporn)
                VALUES(1,1,1)");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO likes (islike, fs_user, fs_foodporn)
                VALUES(1,1,1)");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO likes (islike, fs_user, fs_foodporn)
                VALUES(1,1,1)");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO likes (islike, fs_user, fs_foodporn)
                VALUES(0,1,1)");
                $stmt->execute();
            }
            
            // Create favorit Example Entry
            $stmt = self::$_db->prepare("SELECT count(id_favorit) AS c FROM favorit");
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count < 1)
            {
                $stmt = self::$_db->prepare("INSERT INTO favorit (fs_user, fs_foodporn)
                VALUES(1,1)");
                $stmt->execute();
            }
            
            // Create comment Example Entry
            $stmt = self::$_db->prepare("SELECT count(id_comment) AS c FROM comment");
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count < 1)
            {
                $stmt = self::$_db->prepare("INSERT INTO comment (content, dateCreated, fs_foodporn, fs_user)
                VALUES('Ha ha is geil!',NOW(),1,1)");
                $stmt->execute();
            }
        }

        // Return True if User is logged in
        function isUserLoggedin() 
        {
            $stmt = self::$_db->prepare("SELECT count(id_user) AS c FROM user WHERE session=:sid");
            $sid = session_id();
            $stmt->bindParam(":sid", $sid);
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count == 1)
            {
                return "true";
            }
            else if($count < 1)
            {
                return "false";
            }
            else
            {
                return "Error: More then one identical User could be logged in!";
            }
        }

        // Get All Users
        function getAllUsers()
        {
            $stmt = self::$_db->prepare("SELECT u.id_user AS id_user, u.username AS username, u.mail AS mail, u.description AS description, u.image AS image FROM user AS u");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Get User By id_user 
        function getUserById($uid)
        {
            $stmt = self::$_db->prepare("SELECT u.id_user AS id_user, u.username AS username, u.mail AS mail, u.description AS description, u.image AS image FROM user AS u
                                        WHERE u.id_user=:uid");
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Get User By id_user 
        function getUser()
        {
            $stmt = self::$_db->prepare("SELECT u.id_user AS id_user, u.username AS username, u.mail AS mail, u.description AS description, u.image AS image FROM user AS u
                                        WHERE u.id_user=:uid");
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Update User 
        function updateUser($username, $mail, $descr, $img)
        {
            $stmt = self::$_db->prepare("UPDATE user SET username=:username, mail=:mail, description=:descr, image=:img WHERE id_user:uid");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":mail", $mail);
            $stmt->bindParam(":descr", $descr);
            $stmt->bindParam(":img", $img);
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            return "true";
        }

        // Update User Password
        function updateUserPassword($new, $old)
        {
            $stmt = self::$_db->prepare("UPDATE user SET password=:new WHERE id_user=:uid AND password=:old");
            $stmt->bindParam(":new", $new);
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->bindParam(":old", $old);
            $stmt->execute();
            return "true";
        }

        // Login User
        function login($username ,$password)
        {
            $stmt = self::$_db->prepare("SELECT count(id_user) AS c FROM user WHERE username=:un AND password=:pw");
            $stmt->bindParam(":un", $username);
            $stmt->bindParam(":pw", $password);
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count == 1)
            {
                $stmt = self::$_db->prepare("UPDATE user SET session=:sid WHERE username=:un AND password=:pw");
                $sid = session_id();
                $stmt->bindParam(":sid", $sid);
                $stmt->bindParam(":un", $username);
                $stmt->bindParam(":pw", $password);
                $stmt->execute();
            }
        }

        // Logof User with Session 
        function logoff() {
            $stmt = self::$_db->prepare("UPDATE user SET session='' WHERE session=:sid");
            $sid = session_id();
            $stmt->bindParam(":sid", $sid);
            $stmt->execute();
        }

        // Register USer
        function registerUser($username, $mail, $password)
        {
            $stmt = self::$_db->prepare("INSERT INTO user (username,mail,password,session)
                VALUES(:username,:mail,:password,:sid)");
            $sid = session_id();
            $stmt->bindParam("username", $username);
            $stmt->bindParam("mail", $mail);
            $stmt->bindParam("password", $password);
            $stmt->bindParam(":sid", $sid);
            $stmt->execute();
            return "true";
        }

        // Get USer ID
        function getUserID()
        {
            $stmt = self::$_db->prepare("SELECT id_user FROM user WHERE session=:sid");
            $sid = session_id();
            $stmt->bindParam(":sid", $sid);
            $stmt->execute();
            return $stmt->fetch()["id_user"];
        }

        // Add getCountLike
        function addLike($fid, $isLike)
        {
            $stmt = self::$_db->prepare("SELECT count(id_like) AS c FROM likes WHERE fs_foodporn=:fid AND fs_user=:uid");
            $stmt->bindParam(":fid", $fid);
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count < 1)
            {
                $stmt = self::$_db->prepare("INSERT INTO likes (islike, fs_user, fs_foodporn) VALUES(:islike,:uid,:fid)");
                $stmt->bindParam(":islike", $isLike);
                $stmt->bindParam(":uid", $uid);
                $stmt->bindParam(":fid", $fid);
                $stmt->execute();
                return "true";
            }
            else
            {
                return "false";
            }
        }

        // Get Likes
        function getCountLike($fid, $isLike)
        {
            $stmt = self::$_db->prepare("SELECT count(id_like) AS c FROM likes WHERE fs_foodporn=:fid AND islike=:islike");
            $stmt->bindParam(":fid", $fid);
            $stmt->bindParam(":islike", $isLike);
            $stmt->execute();
            return $stmt->fetch()["c"];
        }

        // Add Comment
        function addComment($fid, $content)
        {
            $stmt = self::$_db->prepare("INSERT INTO comment (content, dateCreated, fs_foodporn, fs_user) VALUES(:content,NOW(),:fid,:uid)");
            $stmt->bindParam(":content", $content);
            $stmt->bindParam(":fid", $fid);
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            return "true";
        }

        // Get Comments 
        function getCommentsByFoodpornId($fid)
        {
            $stmt = self::$_db->prepare("SELECT * FROM comment WHERE fs_foodporn=:fid");
            $stmt->bindParam(":fid", $fid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Add Foodporn
        function addFoodporn($img, $title, $desc, $cat)
        {
            $stmt = self::$_db->prepare("INSERT INTO comment (image,title,description,category,fs_user,dateCreated)
                                        VALUES(:img, :title, :desc, :cat, :uid, NOW())");
            $stmt->bindParam(":img", $img);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":desc", $desc);
            $stmt->bindParam(":cat", $cat);
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            return "true";
        }

        // Get ONLY Foodporn Comntext
        function getAllFoodporns()
        {
            $stmt = self::$_db->prepare("SELECT * FROM foodporn");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Get Foodporns filtered by category
        function getAllFoodpornsByCategory($cat)
        {
            $stmt = self::$_db->prepare("SELECT * FROM foodporn WHERE category=:cat");
            $stmt->bindParam(":cat", $cat);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Get Foodporns filtered by favorites
        function getAllFoodpornsByFavorite()
        {
            $stmt = self::$_db->prepare("SELECT fp.* FROM favorit AS fav
                                        LEFT JOIN foodporn AS fp
                                        On fav.fs_foodporn = fp.id_foodporn AND fav.fs_user=:uid");
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Gets all History Foodporns
        function getFoodpornsByHostory()
        {
            $stmt = self::$_db->prepare("SELECT * FROM foodporn WHERE fs_user=:uid");
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Get Foodporn by id_foodporn
        function getFoodpornById($fid)
        {
            $stmt = self::$_db->prepare("SELECT * FROM foodporn WHERE id_foodporn=:fid");
            $stmt->bindParam(":fid", $fid);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        // Get if the foodporn is favorited
        function isFavoriteFoodporn($fid)
        {
            $stmt = self::$_db->prepare("SELECT count(id_favorit) AS c FROM favorit WHERE fs_foodporn=:fid AND fs_user=:uid");
            $stmt->bindParam(":fid", $fid);
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count == 1)
            {
                return "true";
            }
            else
            {
                return "false";
            }
        }
    }
?>