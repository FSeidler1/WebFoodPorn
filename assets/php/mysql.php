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
            `date` DATE NOT NULL , 
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
            PRIMARY KEY (`id_user`)
            ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
            $stmt->execute();

            // Create Like Table
            $stmt = self::$_db->prepare("CREATE TABLE IF NOT EXISTS `fooddb`.`like` ( `id_like` INT NOT NULL AUTO_INCREMENT , 
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
            `text` TEXT NOT NULL , 
            `date` DATE NOT NULL , 
            `fs_foodporn` INT NOT NULL , 
            `fs_user` INT NOT NULL , 
            PRIMARY KEY (`id_comment`)
            ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
            $stmt->execute();

            // Create Example Entrys
        }
    }
?>