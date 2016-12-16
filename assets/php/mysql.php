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

        function initDB() 
        {
            // Create Foodporn Table
            $stmt = self::$_db->prepare("CREATE TABLE IF NOT EXISTS `fooddb`.`foodporn` ( `id_foodporn` INT NOT NULL AUTO_INCREMENT , 
            `image` TEXT NOT NULL , 
            `title` TEXT NOT NULL , 
            `description` TEXT NOT NULL , 
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
                VALUES(1,'./img/default.png', 'Beispielbild', 'Beschreibung des Beispiel Foodporns', 'Pasta', 1, NOW())");
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
            
            // Create favorit Example Entry
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
                return "Error: More then one User could be logged in!";
            }
        }
    }
?>