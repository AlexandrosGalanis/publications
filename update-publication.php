<?php 

    session_start();

    
    $authorid = $_SESSION['userid'];
    $error = 0;
    $choice = 0;
    $message ='<h1 style="margin:20px;">Give ID of publication you want to change</h1>';

    function escape($value){//XSS attacks protection
        return htmlspecialchars($value , ENT_QUOTES,'UTF-8');
    }

    if(empty($_SESSION['typeofuser']) ){
        header ("Location: index.php");
        exit;
    }else{
        $userid = $_SESSION['userid'];
    }

    if (isset($_SESSION['username'])) {
        
        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            
            header("Location:http://publications.epizy.com/logout.php");
            exit;
        }
    
    }

    $typeofpublication = "";
    $title = "";
    $year = 0;
    $month = 0;
    $note = "";
    $url = "";
    $key = "";
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
    $publicationname = "";

    $typeofpublicationarray = array();
    $idarray = array();
    $titlearray = array();
    $montharray = array();
    $yeararray = array();
    $notesarray = array();
    $urlarray = array();
    $keyarray = array();
    $publicationnamearray = array();
    $userspublicationscounter = 0;

    $hostname = "sql313.epizy.com";//used to have localhost
    $dbusername = "epiz_25763156";//used to have id12758451_labreservations
    $dbpassword = "0kSBbmCf2qv4E";//used to have LabReservations
    $db = "epiz_25763156_publications";//used to have id12758451_labreservations

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$db", $dbusername, $dbpassword);
        // set the PDO error mode to exception
                
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("select id, typeofpublication, title, year, month, note, url, ikey, publicationname from publications where authorid = :authorid "); //Collect data for user's publications
        $stmt->bindParam(':authorid', $authorid);
        $stmt->execute(); 
        $row = $stmt->fetch();
        $totalpublications = $row['result'];

        while ($row = $stmt->fetch()) {
            $typeofpublicationarray[$userspublicationscounter] = escape($row['typeofpublication']);
            $idarray[$userspublicationscounter] = escape($row['id']);
            $titlearray[$userspublicationscounter] = escape($row['title']);
            $montharray[$userspublicationscounter] = escape($row['month']);
            $yeararray[$userspublicationscounter] = escape($row['year']);
            $notesarray[$userspublicationscounter] = escape($row['note']);
            $urlarray[$userspublicationscounter] = escape($row['url']);
            $keyarray[$userspublicationscounter] = escape($row['ikey']);
            $publicationnamearray[$userspublicationscounter] = escape($row['publicationname']);
            $userspublicationscounter++; 
        }


        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($_POST['action'] == 'Update or Delete') {
                $id = $_POST['id'];

                if($_SESSION['typeofuser'] == 'Admin'){
                    $stmt = $conn->prepare("select * from publications where id =:id");
                    $stmt->bindParam(':id', $id);

                }else if($_SESSION['typeofuser'] == 'Publisher' or $_SESSION['typeofuser'] === 'Manager'){
                    $stmt = $conn->prepare("select * from publications where id =:id and authorid = :userid ");
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':userid',$userid);

                }
                $stmt->execute();

                while ($row = $stmt->fetch()) {

                    $title = $row['title'];
                    $month  = $row['month'];
                    $year  = $row['year'];
                    $note  = $row['note'];
                    $url  = $row['url'];
                    $key = $row['ikey'];
                    $publisher = $row['publicationname'];
                    $typeofpublication = $row['typeofpublication'];

                    if($typeofpublication === "Article"){
                        $pages = $row['pages'];
                        $volume = $row['volume'];
                        $number = $row['number'];
                        $doi = $row['doi'];
                        $choice=1;

                    }else if($typeofpublication === "Workshop"){
                        $volume = $row['volume'];
                        $number = $row['number'];
                        $booktitle = $row['booktitle'];
                        $editor = $row['editor'];
                        $series = $row['series'];
                        $organization = $row['organization'];
                        $pages = $row['pages'];
                        $address = $row['address'];
                        $doi = $row['doi'];
                        $choice=2;

                    }else if($typeofpublication === "Book"){
                        $volume = $row['volume'];
                        $number = $row['number'];
                        $edition = $row['edition'];
                        $series = $row['series'];
                        $address = $row['address'];
                        $isbn = $row['isbn'];
                        $issn = $row['issn'];
                        $choice=3;

                    }else if($typeofpublication === "InBook"){
                        $volume = $row['volume'];
                        $number = $row['number'];
                        $chapter = $row['chapter'];
                        $series = $row['series'];
                        $edition = $row['edition'];
                        $address = $row['address'];
                        $pages = $row['pages'];
                        $type = $row['type'];
                        $isbn = $row['isbn'];
                        $issn = $row['issn'];
                        $choice=4;

                    }else if($typeofpublication === "Newspaper"){
                        $address = $row['address'];
                        $pages = $row['pages'];
                        $issn = $row['issn'];
                        $choice=5;

                    }else if($typeofpublication === "Catalog"){
                        $chapter = $row['chapter'];
                        $edition = $row['edition'];
                        $pages = $row['pages'];
                        $address = $row['address'];
                        $issn = $row['issn'];
                        $choice=6;

                    }
                    $error++;
                }



                if(empty($title)){
                    
                    $message = '<h1 class ="bg-danger">There is no record with that id</h1>';

                }else{
                    $message = '<h1 class ="bg-info" >Publication was found</h1>';
                }


            }else if($_POST['action'] === 'Update'){
                
                
                //TODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
                $title = $_POST["title"];
                $month  = $_POST["month"];
                $year  = $_POST["year"];
                $note  = $_POST["note"];
                $url  = $_POST["url"];
                $key = $_POST["key"];
                $publisher = $_POST["publisher"];
                
                $pages = $_POST["pages"];
                $volume = $_POST["volume"];
                $number = $_POST["number"];
                $doi = $_POST["doi"];
                $booktitle = $_POST["booktitle"];
                $editor = $_POST["editor"];
                $series = $_POST["series"];
                $organization = $_POST["organization"];
                $address = $_POST["address"];
                $edition = $_POST["edition"];
                $isbn = $_POST["isbn"];
                $issn = $_POST["issn"];
                $chapter = $_POST["chapter"];
                $type = $_POST["type"];
                $id = $_POST["id"];

            
                
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

                if($_SESSION['typeofuser'] == 'Admin'){
                    $stmt = $conn->prepare("UPDATE publications
                    SET title= :title, year = :year ,month = :month , note = :note, url = :url, ikey = :key, publicationname = :publisher, chapter = :chapter, editor = :editor, series = :series
                    ,address = :address, edition = :edition, organization = :organization, isbn = :isbn, issn = :issn, pages = :pages, volume = :volume, number = :number, doi = :doi, type = :type, booktitle = :booktitle
                    WHERE id = :id");

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
                    $stmt->bindParam(':id', $id);

                    $stmt->execute();
                    $message = '<div class="p-3 mb-2 bg-success text-white">You successfully changed selected publication!!!</div>';

                }else if($_SESSION['typeofuser'] == 'Publisher' or $_SESSION['typeofuser'] === 'Manager'){
                    $stmt = $conn->prepare("UPDATE publications
                    SET title= :title, year = :year ,month = :month , note = :note, url = :url, ikey = :key, publicationname = :publisher, chapter = :chapter, editor = :editor, series = :series
                    ,address = :address, edition = :edition, organization = :organization, isbn = :isbn, issn = :issn, pages = :pages, volume = :volume, number = :number, doi = :doi, type = :type, booktitle = :booktitle
                    WHERE id = :id and authorid = :userid");

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
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':userid',$userid);

                    $stmt->execute();
                    $message = '<div class="p-3 mb-2 bg-success text-white">You successfully changed selected publication!!!</div>';

                }


            }else if($_POST['action'] === 'Delete'){
                $id = $_POST['id'];

                if($_SESSION['typeofuser'] == 'Admin'){
                    $stmt = $conn->prepare("delete from publications where id = :id");
                    $stmt->bindParam(':id',$id);

                    $stmt->execute();
                    $message = '<div class="p-3 mb-2 bg-success text-white">You successfully deleted selected publication!!!</div>';

                }else if($_SESSION['typeofuser'] == 'Publisher' or $_SESSION['typeofuser'] === 'Manager'){
                    
                    $stmt = $conn->prepare("delete from publications where id = :id and authorid = :userid");
                    $stmt->bindParam(':id',$id);
                    $stmt->bindParam(':userid',$userid);

                    $stmt->execute();
                    $message = '<div class="p-3 mb-2 bg-success text-white">You successfully deleted selected publication!!!</div>';
                }
            }

        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        //header("Location: http://labreservations.epizy.com/servererror.php");
        die;
    }
    $conn = null;

?> 
    
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link href="styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <title>Update Publications</title>
        
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
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/statistics.php'\">Statistics</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location = 'http://publications.epizy.com/current-publications.php'\">Current Publications</button>
                        ";

                        $adminbuttons = "
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/edit-user.php'\">Edit User</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/create-user.php'\">Create User</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/newunit.php'\">New Unit</button>";

                        $loggedout =" <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/signin.php'\">Sign in</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/signup.php'\">Sign up</button>";



                        $loggedin ="<button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location = 'http://publications.epizy.com/newpublication.php'\">New Publication</button>
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
                    
                                  
                                  
                   
                    <?php  echo $message;?>

                    <div style="width : 90%; margin-left: 25px;">                      
                                                
                        <table id="yourpublications" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Type of Publication</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Name Of Journal/Publisher</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    echo '<h1 style="margin-top: 25px;">Your Publications</h1>';
                                    for($x = 0; $x < $userspublicationscounter; $x++){
                                        echo 
                                        '<tr>
                                            <td>'.escape($idarray[$x]).'</td>
                                            <td>'.escape($titlearray[$x]).'</td>
                                            <td>'.escape($typeofpublicationarray[$x]).'</td>
                                            <td>'.escape($montharray[$x]).'</td>
                                            <td>'.escape($yeararray[$x]).'</td>
                                            <td>'.escape($notesarray[$x]).'</td>
                                            <td>'.escape($urlarray[$x]).'</td>
                                            <td>'.escape($keyarray[$x]).'</td>
                                            <td>'.escape($publicationnamearray[$x]).'</td>
                                        </tr>';
                                    }
                                ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Type of Publication</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Name Of Journal/Publisher</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                            $('#yourpublications').DataTable();
                            } );
                        </script>
                        <hr style="height:10px;color:gray;background-color:gray;max-width: 100%;">
                    </div>

                    <div style= "margin:20px;">
                        


                        <form method="post">
                                <h5>ID:</h5><input type="number" name="id" value="" min="0" max="1000000">

                                <input class="btn btn-secondary" type="submit" name="action" class="btn btn-warning" value="Update or Delete">
                                
                        </form>

                    



                        
                       <?php
                       
                        
                                $articleform=' 
                                    <form method="post">
                                        <h2>Update Article<h2>
                                        <table class="table table-sm table-borderless " style="width: 50%">
                                            <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="'. escape($title) .'" required></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="'. escape($month) .'" min="1" max="12"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="'. escape($year) .'" min="1990" max="2020" required></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="'. escape($note) .'"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="'. escape($url) .'"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="'. escape($key) .'"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Name Of Journal:</h5><input type="text" name="publisher" value="'. escape($publisher) .'" required></th>
                                                <th><h5>Pages:</h5><input type="number" name="pages" value="'. escape($pages) .'" min="1" max="1000000"></th>
                                                <th><h5>Volume:</h5><input type="number" name="volume" value="'. escape($volume) .'" min="0" max="1000000"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Number:</h5><input type="number" name="number" value="'. escape($number) .'" min="0" max="1000000"></th>
                                                <th><h5>DOI:</h5><input type="text" name="doi" value="'. escape($doi) .'"></th>
                                            </tr>
                                        </table>
                                        <br>
                                        <span class="error"><?= $validation_error;?></span>
                                        <br>
                                        <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Update">
                                        <input type="hidden" name="id" value="'.escape($id).'">
                                    </form>
                                    <form  method="post">
                                        <input type="hidden" name="id" value="'.escape($id).'">
                                        <input class="btn btn-danger" type="submit" name="action" class="btn btn-warning" value="Delete">
                                    </form>';
                                    
                            
                            
                                $workshopform = ' 
                                    <form method="post">
                                        <h2>Update Workshop<h2>
                                        <table class="table table-sm table-borderless " style="width: 50%">
                                            <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="'. escape($title).'" required></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="'. escape($month).'" min="1" max="12"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="'. escape($year).'" min="1990" max="2020" required></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="'. escape($note).'"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="'. escape($url).'"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="'. escape($key).'"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Publisher:</h5><input type="text" name="publisher" value="'. escape($publisher).'"></th>
                                                <th><h5>Book Title:</h5><input type="text" name="booktitle" value="'. escape($booktitle).'" required></th>
                                                <th><h5>Editor:</h5><input type="text" name="editor" value="'. escape($editor).'"></th>
                                                
                                            </tr>
                                            <tr>
                                                <th><h5>Series:</h5><input type="text" name="series" value="'. escape($series).'"></th>
                                                <th><h5>Organization:</h5><input type="text" name="organization" value="'. escape($organization).'"></th>
                                                <th><h5>Pages:</h5><input type="number" name="pages" value="'. escape($pages).'" min="1" max="1000000"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Address:</h5><input type="text" name="address" value="'. escape($address).'"></th>
                                                <th><h5>Volume:</h5><input type="number" name="volume" value="'. escape($volume).'" min="0" max="1000000"></th>
                                                <th><h5>Number:</h5><input type="number" name="number" value="'. escape($number).'" min="0" max="1000000"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>DOI:</h5><input type="text" name="doi" value="'. escape($doi).'"></th>
                                            </tr>
                                            
                                        </table>
                                        <br>
                                        <span class="error"><?= $validation_error;?></span>
                                        <br>
                                        <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Update">
                                        <input type="hidden" name="id" value="'.escape($id).'">
                                        </form>
                                        <form  method="post">
                                            <input type="hidden" name="id" value="'.escape($id).'">
                                            <input class="btn btn-danger" type="submit" name="action" class="btn btn-warning" value="Delete">
                                        </form>';
                                    
                                    $bookform = '
                                    <form method="post">
                                        <h2>Update Book<h2>
                                        <table class="table table-sm table-borderless " style="width: 50%">
                                          <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="'. escape($title).'" required></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="'. escape($month).'" min="1" max="12"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="'. escape($year).'" min="1990" max="2020" required></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="'. escape($note).'"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="'. escape($url).'"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="'. escape($key).'"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Publisher:</h5><input type="text" name="publisher" value="'. escape($publisher).'" required></th>
                                                <th><h5>Edition:</h5><input type="text" name="edition" value="'. escape($edition).'"></th>
                                                <th><h5>Series:</h5><input type="text" name="series" value="'. escape($series).'"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Address:</h5><input type="text" name="address" value="'. escape($address).'"></th>
                                                <th><h5>Volume:</h5><input type="number" name="volume" value="'. escape($volume).'" min="0" max="1000000"></th>
                                                <th><h5>Number:</h5><input type="number" name="number" value="'. escape($number).'" min="0" max="1000000"></th>
                                            </tr>
                                            </tr>
                                            <tr>
                                                <th><h5>ISBN:</h5><input type="text" name="isbn" value="'. escape($isbn).'"></th>
                                                <th><h5>ISSN:</h5><input type="text" name="issn" value="'. escape($issn).'"></th>
                                            </tr>
                                        </table>
                                        <br>
                                        <span class="error"><?= $validation_error;?></span>
                                        <br>
                                        <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Update">
                                        <input type="hidden" name="id" value="'.escape($id).'">
                                        </form>
                                        <form  method="post">
                                            <input type="hidden" name="id" value="'.escape($id).'">
                                            <input class="btn btn-danger" type="submit" name="action" class="btn btn-warning" value="Delete">
                                        </form>';

                                    
                                    $inbookform= '<form method="post">
                                        <h2>Update Inbook<h2>
                                        <table class="table table-sm table-borderless " style="width: 50%">
                                           <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="'. escape($title).'" required></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="'. escape($month).'" min="1" max="12"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="'. escape($year).'" min="1990" max="2020" required></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="'. escape($note).'"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="'. escape($url).'"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="'. escape($key).'"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Publisher:</h5><input type="text" name="publisher" value="'. escape($publisher).'" required></th>
                                                <th><h5>Chapter:</h5><input type="text" name="chapter" value="'.escape($chapter).'" required></th>
                                                <th><h5>Series:</h5><input type="text" name="series" value="'.escape($series).'"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Edition:</h5><input type="text" name="edition" value="'. escape($edition).'"></th>
                                                <th><h5>Volume:</h5><input type="number" name="volume" value="'. escape($volume).'" min="0" max="1000000"></th>
                                                <th><h5>Number:</h5><input type="number" name="number" value="'. escape($number).'" min="0" max="1000000"></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Address:</h5><input type="text" name="address" value="'. escape($address).'"></th>
                                                <th><h5>Pages:</h5><input type="number" name="pages" value="'. escape($pages).'" min="1" max="1000000" required></th>
                                                <th><h5>Type:</h5><input type="text" name="type" value="'. escape($type).'"></th>
                                                
                                            </tr>
                                                <th><h5>ISBN:</h5><input type="text" name="isbn" value="'. escape($isbn).'"></th>
                                                <th><h5>ISSN:</h5><input type="text" name="issn" value="'. escape($issn).'"></th>
                                                <tr>
                                            </tr>
                                        </table>
                                        <br>
                                        <span class="error"><?= $validation_error;?></span>
                                        <br>
                                        <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Update">
                                        <input type="hidden" name="id" value="'.escape($id).'">
                                        </form>
                                        <form  method="post">
                                            <input type="hidden" name="id" value="'.escape($id).'">
                                            <input class="btn btn-danger" type="submit" name="action" class="btn btn-warning" value="Delete">
                                        </form>';
                                    
                                    $newspaperform = 
                                        '<form method="post">
                                            <h2>Update Newspaper<h2>
                                            <table class="table table-sm table-borderless " style="width: 50%">
                                                <tr>
                                                <th><h5>Title:</h5><input type="text" name="title" value="'. escape($title).'" required></th>
                                                <th><h5>Month:</h5><input type="number"  name="month" value="'. escape($month).'" min="1" max="12"></th>
                                                <th><h5>Year:</h5><input type="number" name="year" value="'. escape($year).'" min="1990" max="2020" required></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Notes:</h5><input type="text" name="note" value="'. escape($note).'"></th>
                                                <th><h5>URL:</h5><input type="text" name="url" value="'. escape($url).'"></th>
                                                <th><h5>KEY:</h5><input type="text" name="key" value="'. escape($key).'"></th>
                                            </tr>
                                                <tr>
                                                    <th><h5>Publisher:</h5><input type="text" name="publisher" value="'.escape($publisher).'" required></th>
                                                    <th><h5>Address:</h5><input type="text" name="address" value="'. escape($address).'"></th>
                                                    <th><h5>Pages:</h5><input type="number" name="pages" value="'. escape($pages).'" min="1" max="1000000" required></th>
                                                </tr>
                                                <tr>
                                                    <th><h5>ISSN:</h5><input type="text" name="issn" value="'. escape($issn).'"></th>
                                                </tr>
                                                    
                                                    
                                            </table>
                                            <br>
                                            <span class="error"><?= $validation_error;?></span>
                                            <br>
                                            <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Update">
                                            <input type="hidden" name="id" value="'.escape($id).'">
                                        </form>
                                        <form  method="post">
                                            <input type="hidden" name="id" value="'.escape($id).'">
                                            <input class="btn btn-danger" type="submit" name="action" class="btn btn-warning" value="Delete">
                                        </form>';
                                    
                                    
                                    $catalogform='
                                        <form method="post">
                                            <h2>Update Catalog<h2>
                                            <table class="table table-sm table-borderless " style="width: 50%">
                                                <tr>
                                                    <th><h5>Title:</h5><input type="text" name="title" value="'. escape($title).'" required></th>
                                                    <th><h5>Month:</h5><input type="number"  name="month" value="'. escape($month).'" min="1" max="12"></th>
                                                    <th><h5>Year:</h5><input type="number" name="year" value="'.escape($year).'" min="1990" max="2020" required></th>
                                                </tr>
                                                <tr>
                                                    <th><h5>Notes:</h5><input type="text" name="note" value="'. escape($note).'"></th>
                                                    <th><h5>URL:</h5><input type="text" name="url" value="'. escape($url).'"></th>
                                                    <th><h5>KEY:</h5><input type="text" name="key" value="'. escape($key).'"></th>
                                                </tr>
                                                <tr>
                                                    <th><h5>Publisher:</h5><input type="text" name="publisher" value="'. escape($publisher).'" required></th>
                                                    <th><h5>Chapter:</h5><input type="text" name="chapter" value="'. escape($chapter).'" required></th>
                                                    <th><h5>Edition:</h5><input type="text" name="edition" value="'. escape($edition).'"></th>
                                                    
                                                </tr>
                                                <tr>
                                                    <th><h5>Pages:</h5><input type="number" name="pages" value="'.escape($pages).'" min="1" max="1000000"></th>
                                                    <th><h5>Address:</h5><input type="text" name="address" value="'.escape($address).'"></th>
                                                    <th><h5>ISSN:</h5><input type="text" name="issn" value="'. escape($issn).'"></th>
                                                </tr>
                                                    
                                                    
                                            </table>
                                            <br>
                                            <span class="error"><?= $validation_error;?></span>
                                            <br>
                                            <input class="btn btn-primary" type="submit" name="action" class="btn btn-warning" value="Update">
                                            <input type="hidden" name="id" value="'.escape($id).'">
                                        </form>
                                        <form  method="post">
                                            <input type="hidden" name="id" value="'.escape($id).'">
                                            <input class="btn btn-danger" type="submit" name="action" class="btn btn-warning" value="Delete">
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
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
    </body>
</html>
