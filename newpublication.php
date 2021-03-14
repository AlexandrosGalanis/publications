<?php 

    
    session_start();

    function escape($value){//XSS attacks protection
        return htmlspecialchars($value , ENT_QUOTES,'UTF-8');
    }

    if(empty($_SESSION['typeofuser'])){
        header ("Location: index.php");
        exit;
    }

    if (isset($_SESSION['username'])) {
        
        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            
            header("Location:http://publications.epizy.com/logout.php");
            exit;
        }
    
    }

    $validation_error = "";
    $username = "";
    $password  = "";
    $typeofuser  = "";
    $firstname  = "";
    $lastname  = "";
    $orcid = "";
    $site = "";
    $typeofauthor = "";
    $choice = 0;
    $error = 0;
    $message = '<h1 style="margin:15px;">Create New Publication!</h1>';



    $typeofpublication = "";
    $title = "";
    $year = 0;
    $month = 0;
    $note = "";
    $url = "";
    $key = "";
    $publisher = "";
    $chapter = "";
    $editor = "";
    $series = "";
    $address = "";
    $edition = "";
    $organization = "";
    $isbn = "";
    $issn = "";
    $pages = 0;
    $volume  = 0;
    $number = 0;
    $doi = "";
    $type = "";
    $booktitle = "";




    
    $authorid = $_SESSION['userid'];


        
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if ($_POST['action'] == 'Apply new publication') {
            $typeofpublication = $_POST['typeofpublication'];
            
            if($typeofpublication === "Article"){
                $choice=1;
            }else if($typeofpublication === "Workshop"){
                $choice=2;
            }else if($typeofpublication === "Book"){
                $choice=3;
            }else if($typeofpublication === "InBook"){
                $choice=4;
            }else if($typeofpublication === "Newspaper"){
                $choice=5;
            }else if($typeofpublication === "Catalog"){
                $choice=6;
            }


        } else if ($_POST['action'] == 'Submit') {
            //action for delete

            //basic value fields
            $typeofpublication = $_POST['typeofpublication'];
            $title = $_POST["title"];
            $month  = $_POST["month"];
            $year  = $_POST["year"];
            $note  = $_POST["note"];
            $url  = $_POST["url"];
            $key = $_POST["key"];
            $publisher = $_POST["publisher"];

            if($typeofpublication === "Article"){
                $pages = $_POST["pages"];
                $volume = $_POST["volume"];
                $number = $_POST["number"];
                $doi = $_POST["doi"];

            }else if($typeofpublication === "Workshop"){
                if($_POST['selectvolumeornumber'] === "Volume"){
                    $number = 0;
                    $volume = $_POST["volumeornumber"];
                }else{
                    $number = $_POST["volumeornumber"];
                    $volume = 0;
                }
                $booktitle = $_POST["booktitle"];
                $editor = $_POST["editor"];
                $series = $_POST["series"];
                $organization = $_POST["organization"];
                $pages = $_POST["pages"];
                $address = $_POST["address"];
                
                
                $doi = $_POST["doi"];

            }else if($typeofpublication === "Book"){
                if($_POST['selectvolumeornumber'] === "Volume"){
                    $number = 0;
                    $volume = $_POST["volumeornumber"];
                }else{
                    $number = $_POST["volumeornumber"];
                    $volume = 0;
                }
                $edition = $_POST["edition"];
                $series = $_POST["series"];
                $address = $_POST["address"];
                $isbn = $_POST["isbn"];
                $issn = $_POST["issn"];


            }else if($typeofpublication === "InBook"){
                if($_POST['selectvolumeornumber'] === "Volume"){
                    $number = 0;
                    $volume = $_POST["volumeornumber"];
                }else{
                    $number = $_POST["volumeornumber"];
                    $volume = 0;
                }
                $chapter = $_POST["chapter"];
                $series = $_POST["series"];
                $edition = $_POST["edition"];
                $address = $_POST["address"];
                $pages = $_POST["pages"];
                $type = $_POST["type"];
                $isbn = $_POST["isbn"];
                $issn = $_POST["issn"];

            }else if($typeofpublication === "Newspaper"){
                $address = $_POST["address"];
                $pages = $_POST["pages"];
                $issn = $_POST["issn"];


            }else if($_POST['typeofpublication'] === "Catalog"){
               $chapter = $_POST["chapter"];
               $edition = $_POST["edition"];
               $pages = $_POST["pages"];
               $address = $_POST["address"];
               $issn = $_POST["issn"];

            }

            // Set session variables
        
            $hostname = "sql313.epizy.com";
            $dbusername = "epiz_25763156";
            $dbpassword = "0kSBbmCf2qv4E";
            $db = "epiz_25763156_publications";



            if($authorid === "" or empty($authorid)){
                $authorid = 0;
            }
            if($year === "" or empty($year)){
                $year = 0;
            }
            if($month === "" or empty($month)){
                $month = 0;
            }
            if($pages === "" or empty($pages)){
                $pages = 0;
            }
            if($volume === "" or empty($volume)){
                $volume = 0;
            }
            if($number === "" or empty($number)){
                $number = 0;
            }
            if($typeofpublication === "" or empty($typeofpublication)){
                $typeofpublication = 0;
            }
            if($title === "" or empty($title)){
                $title = "";
            }
            if($note === "" or empty($note)){
                $note = "";
            }
            if($url === "" or empty($url)){
                $url = "";
            }
            if($key === "" or empty($key)){
                $key = "";
            }
            if($publisher === "" or empty($publisher)){
                $publisher = "";
            }
            if($chapter === "" or empty($chapter)){
                $chapter = "";
            }
            if($editor === ""  or empty($editor)){
                $editor = "";
            }
            if($address === ""  or empty($address)){
                $address = "";
            }
            if($series === ""  or empty($series)){
                $series = "";
            }
            if($organization === ""  or empty($organization)){
                $organization = "";
            }
            if($isbn === ""  or empty($isbn)){
                $isbn = "";
            }
            if($issn === ""  or empty($issn)){
                $issn = "";
            }
            if($doi === ""  or empty($doi)){
                $doi = "";
            }
            if($type === ""  or empty($type)){
                $type = "";
            }
            if($booktitle === ""  or empty($booktitle)){
                $booktitle = "";
            }
            if($edition === ""  or empty($edition)){
                $edition = "";
            }


            try {
                
                
                $conn = new PDO("mysql:host=$hostname;dbname=$db", $dbusername, $dbpassword);
                // set the PDO error mode to exception
                
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->query("select doi,issn,isbn from publications where not(doi = '' and issn = '' and isbn = '')");                
                while ($row = $stmt->fetch()) {
                    if($row['doi'] !="" and $doi === $row['doi']){
                        $validation_error = "There is already that DOI copy!!! please try again"; 
                        $error = 1;
                    }
                    if($row['isbn'] !="" and $isbn === $row['isbn']){
                        $validation_error = "There is already that ISBN copy!!! please try again"; 
                        $error = 1;
                    }
                    if($row['issn'] !="" and $issn === $row['issn'] )  {
                        $validation_error = "There is already that ISSN copy!!! please try again"; 
                        $error = 1;
                    }
                }
                if($error === 0){
                    // prepare sql and bind parameters
                    $stmt = $conn->prepare("INSERT INTO `publications`(`typeofpublication`, `authorid`, `title`, `year`, `month`, `note`, `url`, `ikey`, 
                        `publicationname`, `chapter`, `editor`, `series`, `address`, `edition`, `organization`, `isbn`, `issn`, `pages`, `volume`, `number`,
                        `doi`, `type`, `booktitle`)  
                    VALUES (:typeofpublication, :authorid, :title, :year, :month, :note, :url, :key, :publisher, :chapter, :editor, :series, :address, 
                    :edition, :organization, :isbn, :issn, :pages, :volume, :number, :doi, :type, :booktitle)");

                    $stmt->bindParam(':typeofpublication', $typeofpublication);
                    $stmt->bindParam(':authorid', $authorid);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':year', $year);
                    $stmt->bindParam(':month', $month);
                    $stmt->bindParam(':note', $note);
                    $stmt->bindParam(':url', $url);
                    $stmt->bindParam(':key', $key);
                    $stmt->bindParam(':publisher', $publisher);
                    $stmt->bindParam(':chapter', $chapter);
                    $stmt->bindParam(':editor', $editor);
                    $stmt->bindParam(':series', $series);
                    $stmt->bindParam(':address', $address);
                    $stmt->bindParam(':edition', $edition);
                    $stmt->bindParam(':organization', $organization);
                    $stmt->bindParam(':isbn', $isbn);
                    $stmt->bindParam(':issn', $issn);
                    $stmt->bindParam(':pages', $pages);
                    $stmt->bindParam(':volume', $volume);
                    $stmt->bindParam(':number', $number);
                    $stmt->bindParam(':doi', $doi);
                    $stmt->bindParam(':type', $type);
                    $stmt->bindParam(':booktitle', $booktitle);

                    $stmt->execute();

                    $message = '<div class="p-3 mb-2 bg-success text-white">You successfully made a new publication!!!</div>';
                
                }
                //echo "New records created successfully";
                //die;

            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                //header("Location: http://labreservations.epizy.com/servererror.php");
                die;
            }
            $conn = null;
            
        }
    
    }

    
   
?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Create New Publication</title>
        <link href="styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark mh:100 ">
            <a class="navbar-brand" href="index.php">Publications</a>
				<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="http://publications.epizy.com/index.php"><i class="fas fa-bars"></i>
				</button>
				
			<!-- Navbar Search-->
			<h5 class="text-color-for-unit">Department of Information & Communication Systems</h5>
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                
				<img src="images/1.jpg" height="42" width="42"> 
            </form>
            <!-- Navbar-->
           
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark nav" id="sidenavAccordion">
						<div class="sb-sidenav-menu">
						<?php
                        $standardbuttons ="
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/index.php'\">Main</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location='http://publications.epizy.com/current-publications.php'\">Current Publications</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/statistics.php'\">Statistics</button>
                        ";

                        $adminbuttons = "
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/edit-user.php'\">Edit User</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/create-user.php'\">Create User</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/newunit.php'\">New Unit</button>";

                        $loggedout =" <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/signin.php'\">Sign in</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/signup.php'\">Sign up</button>";



                        $loggedin ="<button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location = 'http://publications.epizy.com/update-publication.php'\">Update Publications</button>
                        
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-danger\" onclick=\"document.location = 'http://publications.epizy.com/logout.php'\">Log out</button>";


                        echo $standardbuttons;
                        if(isset($_SESSION['typeofuser']) and $_SESSION['typeofuser'] === "Admin"  ){
                            echo $adminbuttons;
                        }

                        if(empty($_SESSION['typeofuser'])){
                            echo $loggedout;
                        }else{
                            echo $loggedin;
                        }
                        ?>
						</div>
						<div class="sb-sidenav-footer">
							<div class="small">Logged in as:</div>
							<?php
                                if($_SESSION['username'] =="" or empty($_SESSION['username'])){
                                    echo "No one";
                                }else{
                                    echo escape($_SESSION['username']);
                                }
                            
                            ?>
						</div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                     <?php
                        echo $message;
                    ?>

                    <div class="container-fluid">
                        
                        
                        <h1 class="mt-4">Select type of publication</h1>
                        <h2><?php 
                        echo $validation_error;
                        ?><h2>

                        <form method="post">
                            <select class="btn btn-secondary dropdown-toggle" name="typeofpublication" value="">
                                <option value="Article">Article</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Book">Book</option>
                                <option value="InBook">InBook</option>
                                <option value="Newspaper">Newspaper</option>
                                <option value="Catalog">Catalog</option>

                            </select>

                            <input class="btn btn-secondary" type="submit" name="action" class="btn btn-warning" value="Apply new publication">

                        </form>
                       



                            <?php
                                $articleform=' 
                                    <form method="post">
                                        <h2>New Article<h2>
                                        <table class="table table-sm table-borderless " style="width: 50%">
                                            <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="" min="1" max="12" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="" min="1990" max="2020" required style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Name Of Journal:</h5><input type="text" name="publisher" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Pages:</h5><input type="number" name="pages" value="" min="1" max="1000000" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Volume:</h5><input type="number" name="volume" value="" min="0" max="1000000" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Number:</h5><input type="number" name="number" value="" min="0" max="1000000" style="width: 200px;height: 30px;"></th>
                                                <th><h5>DOI:</h5><input type="text" name="doi" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                        </table>
                                        <br>
                                        <span class="error"><?= $validation_error;?></span>
                                        <br>
                                        <input type="hidden" name="typeofpublication" value="Article">
                                        <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Submit">
                                    </form>';


                                $workshopform = ' 
                                    <form method="post">
                                        <h2>New Workshop<h2>
                                        <table class="table table-sm table-borderless " style="width: 50%">
                                            <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="" min="1" max="12" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="" min="1990" max="2020" required style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Publisher:</h5><input type="text" name="publisher" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Book Title:</h5><input type="text" name="booktitle" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Editor:</h5><input type="text" name="editor" value="" style="width: 200px;height: 30px;"></th>
                                                
                                            </tr>
                                            <tr>
                                                <th><h5>Series:</h5><input type="text" name="series" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Organization:</h5><input type="text" name="organization" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Pages:</h5><input type="number" name="pages" value="" min="1" max="1000000" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Address:</h5><input type="text" name="address" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Select:</h5>
                                                <select class=" dropdown-toggle" name="selectvolumeornumber" value="" style="width: 200px;height: 30px;">
                                                    <option value="Volume">Volume</option>
                                                    <option value="Number">Number</option>
                                                </select></th>
                                                <th><h5>Volume/Number:</h5><input type="number" name="volumeornumber" value="" min="0" max="1000000" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>DOI:</h5><input type="text" name="doi" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            
                                        </table>
                                        <br>
                                        <span class="error"><?= $validation_error;?></span>
                                        <br>
                                        <input type="hidden" name="typeofpublication" value="Workshop">
                                        <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Submit">

                                    </form>';
                                    
                                    $bookform = '
                                    <form method="post">
                                        <h2>New Book<h2>
                                        <table class="table table-sm table-borderless " style="width: 50%">
                                           <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="" min="1" max="12" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="" min="1990" max="2020" required style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Publisher:</h5><input type="text" name="publisher" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Edition:</h5><input type="text" name="edition" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Series:</h5><input type="text" name="series" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Address:</h5><input type="text" name="address" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Select:</h5>
                                                <select class=" dropdown-toggle" name="selectvolumeornumber" value="" style="width: 200px;height: 30px;">
                                                    <option value="Volume">Volume</option>
                                                    <option value="Number">Number</option>
                                                </select></th>
                                                <th><h5>Volume/Number:</h5><input type="number" name="volumeornumber" value="" min="0" max="1000000" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            </tr>
                                            <tr>
                                                <th><h5>ISBN:</h5><input type="text" name="isbn" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>ISSN:</h5><input type="text" name="issn" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                        </table>
                                        <br>
                                        <span class="error"><?= $validation_error;?></span>
                                        <br>
                                        <input type="hidden" name="typeofpublication" value="Book">
                                        <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Submit">

                                    </form>';
                                    
                                    $inbookform= '<form method="post">
                                        <h2>New Inbook<h2>
                                        <table class="table table-sm table-borderless " style="width: 50%">
                                            <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="" min="1" max="12" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="" min="1990" max="2020" required style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Publisher:</h5><input type="text" name="publisher" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Chapter:</h5><input type="text" name="chapter" value="" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Series:</h5><input type="text" name="series" value="" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Edition:</h5><input type="text" name="edition" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Select:</h5>
                                                <select class=" dropdown-toggle"  name="selectvolumeornumber" value="" style="width: 200px;height: 30px;">
                                                    <option value="Volume">Volume</option>
                                                    <option value="Number">Number</option>
                                                </select></th>
                                                <th><h5>Volume/Number:</h5><input type="number" name="volumeornumber" value="" min="0" max="1000000" style="width: 200px;height: 30px;"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Address:</h5><input type="text" name="address" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>Pages:</h5><input type="number" name="pages" value="" min="1" max="1000000" required style="width: 200px;height: 30px;"></th>
                                                <th><h5>Type:</h5><input type="text" name="type" value="" style="width: 200px;height: 30px;"></th>
                                                
                                            </tr>
                                                <th><h5>ISBN:</h5><input type="text" name="isbn" value="" style="width: 200px;height: 30px;"></th>
                                                <th><h5>ISSN:</h5><input type="text" name="issn" value="" style="width: 200px;height: 30px;"></th>
                                                <tr>
                                            </tr>
                                        </table>
                                        <br>
                                        <span class="error"><?= $validation_error;?></span>
                                        <br>
                                        <input type="hidden" name="typeofpublication" value="InBook">
                                        <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Submit">

                                    </form>';
                                        
                                    $newspaperform = 
                                        '<form method="post">
                                            <h2>New Newspaper<h2>
                                            <table class="table table-sm table-borderless " style="width: 50%">
                                                <tr>
                                                    <th><h5>Title:</h5><input type="text" name="title" value="" required style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Month:</h5><input type="number"  name="month" value="" min="1" max="12" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Year:</h5><input type="number" name="year" value="" min="1990" max="2020" required style="width: 200px;height: 30px;"></th>
                                                </tr>
                                                <tr>
                                                    <th><h5>Notes:</h5><input type="text" name="note" value="" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>URL:</h5><input type="text" name="url" value="" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>KEY:</h5><input type="text" name="key" value="" style="width: 200px;height: 30px;"></th>
                                                </tr>
                                                <tr>
                                                    <th><h5>Publisher:</h5><input type="text" name="publisher" value="" required style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Address:</h5><input type="text" name="address" value="" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Pages:</h5><input type="number" name="pages" value="" min="1" max="1000000" required style="width: 200px;height: 30px;"></th>
                                                </tr>
                                                <tr>
                                                    <th><h5>ISSN:</h5><input type="text" name="issn" value=""></th>
                                                </tr>
                                                    
                                                    
                                            </table>
                                            <br>
                                            <span class="error"><?= $validation_error;?></span>
                                            <br>
                                            <input type="hidden" name="typeofpublication" value="Newspaper">
                                            <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Submit">
                                    
                                        </form>';
                                    
                                    $catalogform='
                                        <form method="post">
                                            <h2>New Catalog<h2>
                                            <table class="table table-sm table-borderless " style="width: 50%">
                                                <tr>
                                                    <th><h5>Title:</h5><input type="text" name="title" value="" required style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Month:</h5><input type="number"  name="month" value="" min="1" max="12" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Year:</h5><input type="number" name="year" value="" min="1990" max="2020" required style="width: 200px;height: 30px;"></th>
                                                </tr>
                                                <tr>
                                                    <th><h5>Notes:</h5><input type="text" name="note" value="" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>URL:</h5><input type="text" name="url" value="" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>KEY:</h5><input type="text" name="key" value="" style="width: 200px;height: 30px;"></th>
                                                </tr>
                                                <tr>
                                                    <th><h5>Publisher:</h5><input type="text" name="publisher" value="" required style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Chapter:</h5><input type="text" name="chapter" value="" required style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Edition:</h5><input type="text" name="edition" value="" style="width: 200px;height: 30px;"></th>
                                                    
                                                </tr>
                                                <tr>
                                                    <th><h5>Pages:</h5><input type="number" name="pages" value="" min="1" max="1000000" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>Address:</h5><input type="text" name="address" value="" style="width: 200px;height: 30px;"></th>
                                                    <th><h5>ISSN:</h5><input type="text" name="issn" value="" style="width: 200px;height: 30px;"></th>
                                                </tr>
                                                    
                                                    
                                            </table>
                                            <br>
                                            <span class="error"><?= $validation_error;?></span>
                                            <br>
                                            <input type="hidden" name="typeofpublication" value="Catalog">
                                            <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Submit">
                                    
                                        </form>';

                                
                                if($choice === 1){
                                    echo $articleform;
                                }else if($choice === 2){
                                    echo $workshopform;
                                }else if($choice === 3){
                                    echo $bookform;
                                }else if($choice === 4){
                                    echo $inbookform;
                                }else if($choice === 5){
                                    echo $newspaperform;
                                }else if($choice === 6){
                                    echo $catalogform;
                                }
                            ?>












                                    
                    </div>
                </main>


                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
							 
                            <div>
                                <a href="#">Made By Alexander Galanis</a>
                                &middot;
                                <a href="#">Manolis Piperias</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
    </body>
</html>
