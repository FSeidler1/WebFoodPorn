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
                VALUES(1,'http://www.soto.de/images/produkte/img_minirollethai.jpg', 'Exotische Frühlingsrollen', 'Frühlingsrollen sind eine Vorspeise der asiatischen Küche aus speziellen Teigblättern mit einer Vielzahl unterschiedlicher Füllungen. Einige Varianten werden im Wok frittiert.', 'Vegetarisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(2,'http://www.rd.com/wp-content/uploads/2015/11/05-fruit-smoothies-blueberry-flaxseed.jpg', 'Blueberry Smoothie', 'Smoothies ist eine aus dem Amerikanischen stammende Bezeichnung für kalte Mixgetränke aus Obst und Milchprodukten, die frisch zubereitet oder als Fertigprodukte verkauft werden.', 'Smoothies', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(3,'http://www.chopchopgrills.com/wp-content/uploads/2015/12/265174-chicken-salad.jpg', 'Chicken Royal Salad', 'Das Haushuhn ist eine Zuchtform des Bankivahuhns, eines Wildhuhns aus Südostasien, und gehört zur Familie der Fasanenartigen. Landwirtschaftlich zählen sie zum Geflügel. Das männliche Haushuhn nennt man Hahn oder Gockel, den kastrierten Hahn Kapaun.', 'Fleisch', 2, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(4,'https://upload.wikimedia.org/wikipedia/commons/a/ae/Wiener-Schnitzel02.jpg', 'Gebackenes Schnitzel', 'Schnitzel sind dünn geschnittene Fleischstücke ohne Knochen, die meist zusätzlich mit einem Fleischklopfer platt geklopft werden, was das Fleisch durch Aufbrechen der Muskelfasern zarter macht. In der Schweiz werden Schnitzel auch Plätzli genannt.', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(5,'https://tastethestyle.files.wordpress.com/2013/08/lobster.jpg', 'Hummerschwänze á la Citron', 'Die Hummer sind eine meeresbewohnende Gattung der Zehnfußkrebse aus der Familie der Hummerartigen. Sie umfasst heute die zwei Arten Amerikanischer Hummer und Europäischer Hummer.', 'Fisch', 3, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(6,'https://i.ytimg.com/vi/5KLYz0pApq0/maxresdefault.jpg', 'Cheese-Bacon Burgen', 'Ein Hamburger ist ein warmes Schnell- oder Fertiggericht und bildet den Standardartikel vieler Fast-Food-Ketten.', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(7,'http://cdn.skim.gs/images/er7xhsed13uzk9foko5c/food-porn-friday-caramel-caramel-food-porn', 'Caramel Cake', 'Karamell ist eine durch starkes, trockenes Erhitzen erzeugte Mischung aus geschmolzenem Zucker und seinen oxidierten und kondensierten Reaktionsprodukten.', 'Desserts', 2, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(8,'https://backpackerlee.files.wordpress.com/2014/05/sushi2.jpg?w=768&h=511', 'Sushi Variation', 'Sushi ist ein japanisches Gericht aus erkaltetem, gesäuertem Reis, ergänzt um weitere Zutaten wie rohen oder geräucherten Fisch, rohe Meeresfrüchte, Nori, Gemüse, Tofuvarianten und Ei. Die Zusammenstellung variiert nach Art und Rezept.', 'Fisch', 2, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(9,'http://24.media.tumblr.com/5f380d70650c500023bfd010995a8a4c/tumblr_mj6gbo1v331qitz6do1_500.jpg', 'Asia Wok mit Rind', 'Die Rinder sind eine Gattungsgruppe der Hornträger. Es sind große und stämmige Tiere, von denen einige Arten als Nutztiere eine wichtige Rolle spielen, allen voran das Hausrind.', 'Fleisch', 3, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(10,'http://25.media.tumblr.com/tumblr_m36a25e3qU1qbjp5wo11_500.jpg', 'Erdbeereiskreation', 'Speiseeis, in der Schweiz und Luxemburg die Glace oder das Glacé, veraltet Gefrorenes, ist eine Süßspeise bestehend aus Flüssigkeiten wie Wasser, Milch, Sahne und eventuell Eigelb, verrührt mit Zucker und', 'Desserts', 4, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(11,'http://ristorante-romantica.ch/wp-content/uploads/2015/02/pizza-storia.jpg', 'Pizza Margherita', 'Pizza ist ein vor dem Backen würzig belegtes Fladenbrot aus einfachem Hefeteig aus der italienischen Küche. Die heutige, international verbreitete Variante mit Tomatensauce und Käse als Basis stammt vermutlich aus Neapel', 'Vegetarisch', 5, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(12,'http://www.hotel-bachmuehle.at/fileadmin/_processed_/csm_Wildgericht-mit-Pilzen_e7788ed176.adaptive.jpg', 'Hirschbraten mit Brotcroutons', 'Die Hirsche oder Geweihträger sind eine Säugetierfamilie aus der Ordnung der Paarhufer. Die Familie umfasst mehr als 50 Arten, von denen unter anderem der Rothirsch, der Damhirsch, das Reh, das Ren und der Elch auch in Europa verbreitet sind.', 'Fleisch', 1, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(13,'http://blog.frank-schildt.de/wp-content/gallery/krustenbraten/Schweinekrustenbraten_19.jpg', 'Schweine Krustenbraten', 'Das Fleisch bei 220 Grad im Ofen anbraten, Flüssigkeit (z.B. Wein, Fleischbouillon oder Fond) beigeben und bei 180 Grad fertig braten. Dabei Braten von Zeit zu Zeit mit Flüssigkeit übergiessen, das verleiht ihm eine schön glänzende Oberfläche, daher die Benennung «glasiert». Der Braten wird meist durchgebraten. Fleisch vor dem Tranchieren zugedeckt ca. 10 Min. stehen lassen. Durch das Stehenlassen verteilen sich Temperatur und Saft gleichmässig im Fleisch. Kerntemperaturen Kalb 65 bis 70 Grad, der Fleischsaft ist rosa. Schwein 70 bis 75 Grad, der Fleischsaft ist hell und klar.', 'Fleisch', 5, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(14,'http://images.pxlpartner.ch.s3.amazonaws.com/n58873/images/ostschweiz/grid9/sgbt-olma-bratwurst-1.jpg', 'Olma Bratwurst AOP', 'Die St.Galler Bratwurst ist seit Jahrzehnten in der ganzen Schweiz ein Begriff. In keiner anderen Schweizer Stadt werden derart feine und geschmacklich unverkennbare Bratwüste hergestellt, wie in St.Gallen. Das typische Qualitätsprodukt aus St.Gallen wird sogar ureigens mit St.Gallen in Verbindung gebracht. Neben Kloster- oder Olma-Stadt wird St.Gallen auch auswärts liebevoll als Bratwurst-Stadt bezeichnet.', 'Fleisch', 4, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(15,'http://i.imgur.com/iac4CIx.gif', 'Speck mit Spiegelei', 'Als Speck wird vor allem bei Schweinen das Fettgewebe bezeichnet, das sich zwischen Haut und Muskeln befindet.', 'Fleisch', 4, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(16,'https://www.cotswolddirectory.co.uk/wp-content/uploads/2015/06/vegan-food-550x326.jpg', 'Rollgerstensalat', 'Graupen, auch Gräupchen, Roll- oder Kochgerste genannt, sind ein Nährmittel aus geschälten, polierten Gersten- oder Weizenkörnern von runder, halb- oder länglich-runder Form.', 'Vegetarisch', 4, NOW())");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO foodporn (id_foodporn,image,title,description,category,fs_user,dateCreated)
                VALUES(17,'http://i.ndtvimg.com/i/2015-07/spaghetti_625x350_61436865755.jpg', 'Spaghetti al Pepone', 'Pasta ist in der italienischen Küche die Bezeichnung für Teigwaren aus Hartweizengrieß, Kochsalz und Wasser in vielen Größen und Formen.', 'Vegetarisch', 4, NOW())");
                $stmt->execute();
            }
            
            // Create user Example Entry
            $stmt = self::$_db->prepare("SELECT count(id_user) AS c FROM user");
            $stmt->execute();
            $count = $stmt->fetch()["c"];
            if($count < 1)
            {
                $stmt = self::$_db->prepare("INSERT INTO user (id_user,username,mail,password,description,image,session)
                VALUES(1,'Leonardo', 'test@test.ch', '" . hash("sha512","1234") . "', 'Ich habe mehr als 15 Jahre Internet Marketing Erfahrung und kenne mich sehr gut mit Facebook Marketing, Suchmaschinenoptimierung, Social Media Marketing, Linkaufbau, Content Marketing, Copywriting, E-Mail Marketing, Reichweitengenerierung, Instagram Marketing und Landing Pages aus – und ich kann dir sogar zeigen, wie du auf Snapchat Reichweite aufbaust und erfolgreich wirst.', 'https://upload.wikimedia.org/wikipedia/commons/c/cf/Profilbild_Polo_Ocker_Zoom.jpg', '')");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO user (id_user,username,mail,password,description,image,session)
                VALUES(2,'Franz', 'test@test.ch', '" . hash("sha512","1234") . "','Diese Seite ist vorrangig entstanden um Freunde, Bekannte, Kollegen und alle Interessierten der Internetgemeinde über meine Reisen zu informieren – also eine Art Reisetagebuch / Reiseblog mit einzelnen Reiseberichten. Nach und nach sind jedoch auch ein paar weitere Kategorien und Artikel hinzu bekommen und auch der Kreis der Leser hat sich stark erweitert. Somit sind zu den ehemals rein privaten Reiseberichten auch Hintergrundinformationen und weiteführende Verweise und Links hinzu gekommen.', 'https://pbs.twimg.com/profile_images/1717956431/BP-headshot-fb-profile-photo_400x400.jpg', '')");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO user (id_user,username,mail,password,description,image,session)
                VALUES(3,'Jennifer', 'test@test.ch', '" . hash("sha512","1234") . "', 'Ich bin 22 Jahre alt und bin gerade frisch von Amsterdam nach Berlin gezogen. Mein Vater ist Fotograf und reist unheimlich viel! Als ich klein war, hat er mich oft mitgenommen, was total spannend für mich war. Dadurch konnte ich viel von der Welt sehen. Besonders verliebt habe ich mich dabei in Wien, Papas Heimatstadt. Die Stadt ist wunderschön - ich liebe die prunkvollen barocken Häuserfassaden. Wien ist das absolute Gegenteil zu dem kleinen Dorf in Holland, in dem ich aufgewachsen bin.', 'https://tribzap2it.files.wordpress.com/2015/07/person-of-interest-season-4-sarah-shahi-cbs.jpg', '')");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO user (id_user,username,mail,password,description,image,session)
                VALUES(4,'Ivo', 'test@test.ch', '" . hash("sha512","1234") . "','Diese Seite ist vorrangig entstanden um Freunde, Bekannte, Kollegen und alle Interessierten der Internetgemeinde über meine Reisen zu informieren – also eine Art Reisetagebuch / Reiseblog mit einzelnen Reiseberichten. Nach und nach sind jedoch auch ein paar weitere Kategorien und Artikel hinzu bekommen und auch der Kreis der Leser hat sich stark erweitert. Somit sind zu den ehemals rein privaten Reiseberichten auch Hintergrundinformationen und weiteführende Verweise und Links hinzu gekommen.', 'http://www.suedkurier.de/storage/pic/cms2skol/lokales/news/bodensee/radolfzell/651155_1_rado_dieter_franz_GUK14FT4I.1.jpg?version=1109390238', '')");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO user (id_user,username,mail,password,description,image,session)
                VALUES(5,'Fabian', 'test@test.ch', '" . hash("sha512","1234") . "', 'Ich bin 22 Jahre alt und bin gerade frisch von Amsterdam nach Berlin gezogen. Mein Vater ist Fotograf und reist unheimlich viel! Als ich klein war, hat er mich oft mitgenommen, was total spannend für mich war. Dadurch konnte ich viel von der Welt sehen. Besonders verliebt habe ich mich dabei in Wien, Papas Heimatstadt. Die Stadt ist wunderschön - ich liebe die prunkvollen barocken Häuserfassaden. Wien ist das absolute Gegenteil zu dem kleinen Dorf in Holland, in dem ich aufgewachsen bin.', 'http://arthaus-musik.com/fileadmin/dvds/m1608/slides/107523-schubert-box-photo4.jpg', '')");
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
                VALUES(1,7)");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO favorit (fs_user, fs_foodporn)
                VALUES(2,9)");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO favorit (fs_user, fs_foodporn)
                VALUES(3,12)");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO favorit (fs_user, fs_foodporn)
                VALUES(4,6)");
                $stmt->execute();
                $stmt = self::$_db->prepare("INSERT INTO favorit (fs_user, fs_foodporn)
                VALUES(5,15)");
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        }

        // Update User 
        function updateUser($descr, $img)
        {
            $stmt = self::$_db->prepare("UPDATE user SET description=:descr, image=:img WHERE id_user=:uid");
            $stmt->bindParam(":descr", $descr);
            $stmt->bindParam(":img", $img);
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->execute();
        }

        // Update User Password
        function updateUserPassword($old, $new)
        {
            $old = hash("sha512",$old);
            $new = hash("sha512",$new);
            $stmt = self::$_db->prepare("UPDATE user SET password=:new WHERE id_user=:uid AND password=:old");
            $stmt->bindParam(":new", $new);
            $uid = self::getUserID();
            $stmt->bindParam(":uid", $uid);
            $stmt->bindParam(":old", $old);
        }

        // Login User
        function login($username ,$password)
        {
            $password = hash("sha512",$password);
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
            $password = hash("sha512",$password);
            $stmt = self::$_db->prepare("INSERT INTO user (username,mail,password,session,image)
                VALUES(:username,:mail,:password,:sid,'http://d2sh4fq2xsdeg9.cloudfront.net/application/assets/images/profile-no-photo.png')");
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
        function addFoodporn($img, $title, $descr, $cat)
        {
            $stmt = self::$_db->prepare("INSERT INTO foodporn (image,title,description,category,fs_user,dateCreated)
                                        VALUES(:img, :title, :descr, :cat, :uid, NOW())");
            $stmt->bindParam(":img", $img);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":descr", $descr);
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
            $stmt = self::$_db->prepare("SELECT fp.* FROM favorit AS fav LEFT JOIN foodporn AS fp On fav.fs_foodporn = fp.id_foodporn AND fav.fs_user=:uid WHERE id_foodporn IS NOT NULL");
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

        // Set Favorite Foodporn
        function setFavorite($fid)
        {
            if(self::isFavoriteFoodporn($fid) != "true")
            {
                $stmt = self::$_db->prepare("INSERT INTO favorit (fs_foodporn, fs_user) VALUES(:fid, :uid)");
                $stmt->bindParam(":fid", $fid);
                $uid = self::getUserID();
                $stmt->bindParam(":uid", $uid);
                $stmt->execute();
            }
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