<?php 

    session_start();


    $username = "";
    
    if(empty($_SESSION['username'])){
        $username = "";
    }else{
        $username = $_SESSION['username'];
        $id = $_SESSION['userid'];
    }

    if (isset($_SESSION['username'])) {
        
        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            
            header("Location:http://publications.epizy.com/logout.php");
            exit;
        }
    
    }
    
    function escape($value){//XSS attacks protection
        return htmlspecialchars($value , ENT_QUOTES,'UTF-8');
    }



    $kati = 0;
    $piecounter = 0; 

    $allarticles = array();
    $allworkshops = array();
    $allbooks = array();
    $allinbooks = array();
    $allnewspapers = array();
    $allcatalogs = array();
    $mastercounter = 1990;
    $counteraddress = 0;

    $address = array();
    $countbyaddress = array();

    $hostname = "sql313.epizy.com";//used to have localhost
    $dbusername = "epiz_25763156";//used to have id12758451_labreservations
    $dbpassword = "0kSBbmCf2qv4E";//used to have LabReservations
    $db = "epiz_25763156_publications";//used to have id12758451_labreservations


    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$db", $dbusername, $dbpassword);
        // set the PDO error mode to exception
                
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("select count(*) as result from publications "); //total publications
        $stmt->execute(); 
        $row = $stmt->fetch();
        $totalpublications = $row['result'];


        $stmt = $conn->prepare("SELECT count(*) as articles FROM `publications` WHERE typeofpublication = 'Article' "); //total articles
        $stmt->execute(); 
        $row = $stmt->fetch();
        $totalarticles = $row['articles'];

        $stmt = $conn->prepare("SELECT count(*) as workshops FROM `publications` WHERE typeofpublication = 'Workshop'"); //total Workshops
        $stmt->execute(); 
        $row = $stmt->fetch();
        $totalworkshops = $row['workshops'];
        
        $stmt = $conn->prepare("SELECT count(*) as books FROM `publications` WHERE typeofpublication = 'Book'"); //total Books
        $stmt->execute(); 
        $row = $stmt->fetch();
        $totalbooks = $row['books'];

        $stmt = $conn->prepare("SELECT count(*) as inbooks FROM `publications` WHERE typeofpublication = 'InBook'"); //total InBooks
        $stmt->execute(); 
        $row = $stmt->fetch();
        $totalinbooks = $row['inbooks'];

        $stmt = $conn->prepare("SELECT count(*) as newspapers FROM `publications` WHERE typeofpublication = 'Newspaper'"); //total Newspapers
        $stmt->execute(); 
        $row = $stmt->fetch();
        $totalnewspapers = $row['newspapers'];

        $stmt = $conn->prepare("SELECT count(*) as catalogs FROM `publications` WHERE typeofpublication = 'Catalog'"); //total Catalogs
        $stmt->execute(); 
        $row = $stmt->fetch();
        $totalcatalogs = $row['catalogs'];

        $stmt = $conn->prepare("SELECT( (SELECT count(*) from publications)/ (select count(*) from Users)) as publicationsperauthor"); //Total publications per author
        $stmt->execute(); 
        $row = $stmt->fetch();
        $publicationsperauthor = $row['publicationsperauthor'];

        if(isset($_SESSION['typeofuser']) and ($_SESSION['typeofuser'] === 'Publisher' or  $_SESSION['typeofuser'] === 'Manager' or $_SESSION['typeofuser'] === 'Admin' )){
        

            $stmt = $conn->prepare("SELECT count(*)/(max(year)-min(year)) as avg FROM `publications`");  //publications per year
            $stmt->execute(); 
            $row = $stmt->fetch();
            $publicationsperyear = $row['avg'];
            
            $stmt = $conn->prepare("SELECT max(year) as maxyear FROM `publications`");  //newest publication
            $stmt->execute(); 
            $row = $stmt->fetch();
            $olderstpublication = $row['maxyear'];
            
            $stmt = $conn->prepare("SELECT min(year) as minyear FROM `publications`"); //oldest publication
            $stmt->execute(); 
            $row = $stmt->fetch();
            $newestpublication = $row['minyear'];

            $stmt = $conn->prepare("SELECT max(year) as newestarticle FROM `publications` WHERE typeofpublication = 'Article'"); //newest Article
            $stmt->execute(); 
            $row = $stmt->fetch();
            $newestarticle = $row['newestarticle'];

            $stmt = $conn->prepare("SELECT min(year) as olderstarticle FROM `publications` WHERE typeofpublication = 'Article'"); //olderst Article
            $stmt->execute(); 
            $row = $stmt->fetch();
            $olderstarticle = $row['olderstarticle'];

            $stmt = $conn->prepare("SELECT max(year) as newestworkshop FROM `publications` WHERE typeofpublication = 'Workshop'"); //newest Workshops
            $stmt->execute(); 
            $row = $stmt->fetch();
            $newestworkshop = $row['newestworkshop'];

            $stmt = $conn->prepare("SELECT min(year) as oldestworkshop FROM `publications` WHERE typeofpublication = 'Workshop'"); //oldest Workshops
            $stmt->execute(); 
            $row = $stmt->fetch();
            $olderstworkshop = $row['oldestworkshop'];

            $stmt = $conn->prepare("SELECT max(year) as newestbook FROM `publications` WHERE typeofpublication = 'Book'"); //newest Books
            $stmt->execute(); 
            $row = $stmt->fetch();
            $newestbook = $row['newestbook'];

            $stmt = $conn->prepare("SELECT min(year) as oldestbook FROM `publications` WHERE typeofpublication = 'Book'"); //oldest Books
            $stmt->execute(); 
            $row = $stmt->fetch();
            $olderstbook = $row['oldestbook'];

            $stmt = $conn->prepare("SELECT max(year) as newestinbook FROM `publications` WHERE typeofpublication = 'InBook'"); //newest inBooks
            $stmt->execute(); 
            $row = $stmt->fetch();
            $newestinbook = $row['newestinbook'];

            $stmt = $conn->prepare("SELECT min(year) as oldestinbook FROM `publications` WHERE typeofpublication = 'InBook'"); //oldest inBooks
            $stmt->execute(); 
            $row = $stmt->fetch();
            $olderstinbook = $row['oldestinbook'];

            $stmt = $conn->prepare("SELECT max(year) as newestnewspapers FROM `publications` WHERE typeofpublication = 'Newspaper'"); //newest newspapers
            $stmt->execute(); 
            $row = $stmt->fetch();
            $newestnewspapers = $row['newestnewspapers'];

            $stmt = $conn->prepare("SELECT min(year) as oldestnewspapers FROM `publications` WHERE typeofpublication = 'Newspaper'"); //oldest newspapers
            $stmt->execute(); 
            $row = $stmt->fetch();
            $olderstnewspapers = $row['oldestnewspapers'];

            $stmt = $conn->prepare("SELECT max(year) as newestcatalogs FROM `publications` WHERE typeofpublication = 'Catalog'"); //newest Catalog
            $stmt->execute(); 
            $row = $stmt->fetch();
            $newestcatalogs = $row['newestcatalogs'];

            $stmt = $conn->prepare("SELECT min(year) as oldestcatalogs FROM `publications` WHERE typeofpublication = 'Catalog'"); //oldest Catalog
            $stmt->execute(); 
            $row = $stmt->fetch();
            $olderstcatalogs = $row['oldestcatalogs'];
            //===================================================================================================================================
            //personal statistics



            $stmt = $conn->prepare("select count(*) as result from publications where authorid = :id"); //total publications
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personaltotalpublications = $row['result'];


            $stmt = $conn->prepare("SELECT count(*) as articles FROM `publications` WHERE typeofpublication = 'Article' and authorid = :id"); //total articles
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personaltotalarticles = $row['articles'];

            $stmt = $conn->prepare("SELECT count(*) as workshops FROM `publications` WHERE typeofpublication = 'Workshop' and authorid = :id"); //total Workshops
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personaltotalworkshops = $row['workshops'];
            
            $stmt = $conn->prepare("SELECT count(*) as books FROM `publications` WHERE typeofpublication = 'Book' and authorid = :id"); //total Books
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personaltotalbooks = $row['books'];

            $stmt = $conn->prepare("SELECT count(*) as inbooks FROM `publications` WHERE typeofpublication = 'InBook' and authorid = :id"); //total InBooks
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personaltotalinbooks = $row['inbooks'];

            $stmt = $conn->prepare("SELECT count(*) as newspapers FROM `publications` WHERE typeofpublication = 'Newspaper' and authorid = :id"); //total Newspapers
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personaltotalnewspapers = $row['newspapers'];

            $stmt = $conn->prepare("SELECT count(*) as catalogs FROM `publications` WHERE typeofpublication = 'Catalog' and authorid = :id"); //total Catalogs
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personaltotalcatalogs = $row['catalogs'];

            $stmt = $conn->prepare("SELECT count(*)/(max(year)-min(year)) as avg FROM `publications`  where authorid = :id");  //publications per year
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalpublicationsperyear = $row['avg'];
            
            $stmt = $conn->prepare("SELECT max(year) as maxyear FROM `publications`  where authorid = :id");  //newest publication
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalnewestpublication = $row['maxyear'];
            
            $stmt = $conn->prepare("SELECT min(year) as minyear FROM `publications`  where authorid = :id"); //oldest publication
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalolderstpublication = $row['minyear'];

            $stmt = $conn->prepare("SELECT max(year) as newestarticle FROM `publications` WHERE typeofpublication = 'Article'  and authorid = :id"); //newest Article
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalnewestarticle = $row['newestarticle'];

            $stmt = $conn->prepare("SELECT min(year) as olderstarticle FROM `publications` WHERE typeofpublication = 'Article' and authorid = :id"); //olderst Article
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalolderstarticle = $row['olderstarticle'];

            $stmt = $conn->prepare("SELECT max(year) as newestworkshop FROM `publications` WHERE typeofpublication = 'Workshop' and authorid = :id"); //newest Workshops
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalnewestworkshop = $row['newestworkshop'];

            $stmt = $conn->prepare("SELECT min(year) as oldestworkshop FROM `publications` WHERE typeofpublication = 'Workshop' and authorid = :id"); //oldest Workshops
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalolderstworkshop = $row['oldestworkshop'];

            $stmt = $conn->prepare("SELECT max(year) as newestbook FROM `publications` WHERE typeofpublication = 'Book' and authorid = :id"); //newest Books
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalnewestbook = $row['newestbook'];

            $stmt = $conn->prepare("SELECT min(year) as oldestbook FROM `publications` WHERE typeofpublication = 'Book' and authorid = :id"); //oldest Books
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalolderstbook = $row['oldestbook'];

            $stmt = $conn->prepare("SELECT max(year) as newestinbook FROM `publications` WHERE typeofpublication = 'InBook' and authorid = :id"); //newest inBooks
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalnewestinbook = $row['newestinbook'];

            $stmt = $conn->prepare("SELECT min(year) as oldestinbook FROM `publications` WHERE typeofpublication = 'InBook' and authorid = :id"); //oldest inBooks
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalolderstinbook = $row['oldestinbook'];

            $stmt = $conn->prepare("SELECT max(year) as newestnewspapers FROM `publications` WHERE typeofpublication = 'Newspaper' and authorid = :id"); //newest newspapers
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalnewestnewspapers = $row['newestnewspapers'];

            $stmt = $conn->prepare("SELECT min(year) as oldestnewspapers FROM `publications` WHERE typeofpublication = 'Newspaper' and authorid = :id"); //oldest newspapers
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalolderstnewspapers = $row['oldestnewspapers'];

            $stmt = $conn->prepare("SELECT max(year) as newestcatalogs FROM `publications` WHERE typeofpublication = 'Catalog' and authorid = :id"); //newest Catalog
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalnewestcatalogs = $row['newestcatalogs'];

            $stmt = $conn->prepare("SELECT min(year) as oldestcatalogs FROM `publications` WHERE typeofpublication = 'Catalog' and authorid = :id"); //oldest Catalog
            $stmt->bindParam(':id', $id);
            $stmt->execute(); 
            $row = $stmt->fetch();
            $personalolderstcatalogs = $row['oldestcatalogs'];


            //===================================================================================================================================
            //end of personal statistics

        }
        
        if(isset($_SESSION['typeofuser']) and ($_SESSION['typeofuser'] === 'Manager' or $_SESSION['typeofuser'] === 'Admin' )){
            // bar chart
            $years = array();
            $numbers = array();

            $stmt = $conn->prepare("SELECT year, count(*) as number FROM publications GROUP BY year "); //pie chart, publications per years
            $stmt->execute(); 
            
            while ($row = $stmt->fetch()) {

                $years[$piecounter] = escape($row['year']);
                $numbers[$piecounter] = $row['number'];

                $piecounter++;
            }
            
            // pie chart
            //articles        
            $stmt = $conn->prepare("SELECT year, count(*) as number FROM publications where typeofpublication = 'Article' GROUP BY year "); //articles per years
            $stmt->execute(); 

            while ($row = $stmt->fetch()) {
                $mastercounter = escape($row['year']) - 1990;
                $allarticles[$mastercounter] = $row['number'];
            }
            //workshops
            $stmt = $conn->prepare("SELECT year, count(*) as number FROM publications where typeofpublication = 'Workshop' GROUP BY year "); //articles per years
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $mastercounter = escape($row['year']) - 1990;
                $allworkshops[$mastercounter] = $row['number'];
            }
            //book
            $stmt = $conn->prepare("SELECT year, count(*) as number FROM publications where typeofpublication = 'Book' GROUP BY year "); //articles per years
            $stmt->execute(); 

            while ($row = $stmt->fetch()) {
                $mastercounter = escape($row['year']) - 1990;
                $allbooks[$mastercounter] = $row['number'];
            }
            //inbooks
            $stmt = $conn->prepare("SELECT year, count(*) as number FROM publications where typeofpublication = 'InBook' GROUP BY year "); //articles per years
            $stmt->execute(); 

            while ($row = $stmt->fetch()) {
                $mastercounter = escape($row['year']) - 1990;
                $allinbooks[$mastercounter] = $row['number'];
            }
            //newspaper
            $stmt = $conn->prepare("SELECT year, count(*) as number FROM publications where typeofpublication = 'Newspaper' GROUP BY year "); //articles per years
            $stmt->execute(); 

            while ($row = $stmt->fetch()) {
                $mastercounter = escape($row['year']) - 1990;
                $allnewspapers[$mastercounter] = $row['number'];
            }
            //catalogs
            $stmt = $conn->prepare("SELECT year, count(*) as number FROM publications where typeofpublication = 'Catalog' GROUP BY year "); //articles per years
            $stmt->execute(); 

            while ($row = $stmt->fetch()) {
                $mastercounter = escape($row['year']) - 1990;
                $allcatalogs[$mastercounter] = $row['number'];
            }
            //fill all the remaining spaces of the arrays so we can pass it to the front end and proccess it over there for the pie
            for($mastercounter = 0; $mastercounter < 31; $mastercounter++){
                if(empty($allarticles[$mastercounter])){
                $allarticles[$mastercounter] = 0 ;
                }
                if(empty($allworkshops[$mastercounter])){
                $allworkshops[$mastercounter] = 0 ;
                }
                if(empty($allbooks[$mastercounter])){
                $allbooks[$mastercounter] = 0 ;
                }
                if(empty($allinbooks[$mastercounter])){
                $allinbooks[$mastercounter] = 0 ;
                }
                if(empty($allnewspapers[$mastercounter])){
                $allnewspapers[$mastercounter] = 0 ;
                }
                if(empty($allcatalogs[$mastercounter])){
                $allcatalogs[$mastercounter] = 0 ;
                }
            }
            //geo chart

            
            $stmt = $conn->prepare("SELECT address, count(*) as number FROM publications where typeofpublication = 'Workshop' GROUP BY address"); //number per country
            $stmt->execute(); 

            while ($row = $stmt->fetch()) {
                $address[$counteraddress] = escape($row['address']);
                $countbyaddress[$counteraddress] = $row['number'];
                $counteraddress++;
            }
        }

  
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        //header("Location: http://labreservations.epizy.com/servererror.php");
        die;
    }
    $conn = null;



    
    //NOT ANY                                                                       <h5>Average number of authors per publications:</h5>
    //22)NOT ANY                                                                    <h5>Minimum number of authors of publications:</h5>
    //23)NOT ANY                                                                    <h5>Maximum number of authors of publications:</h5>
    //24)SELECT( (SELECT count(*) from publications)/ (select count(*) from Users)) as number  <h5>Total publications per author:</h5>
    //25)                                                                           <h5>Total publications per year:</h5>
    //26)                                                                           



    
?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Statistics</title>
        <link href="styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        

        <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script>
        <script type = "text/javascript">google.charts.load('current', {packages: ['corechart']});</script>

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
                        ";

                        $adminbuttons = "
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/edit-user.php'\">Edit User</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/create-user.php'\">Create User</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/newunit.php'\">New Unit</button>";

                        $loggedout =" <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/signin.php'\">Sign in</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/signup.php'\">Sign up</button>";



                        $loggedin ="<button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location = 'http://publications.epizy.com/newpublication.php'\">New Publication</button>

                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location = 'http://publications.epizy.com/update-publication.php'\">Update Publications</button>
                        
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-danger\" onclick=\"document.location = 'http://publications.epizy.com/logout.php'\">Log out</button>";


                        echo $standardbuttons;
                        if(isset($_SESSION['typeofuser']) and $_SESSION['typeofuser'] === "Admin"  ){
                            echo $adminbuttons;
                        }

                        if($username === ""){
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
                
                    <h1 style="margin:20px;">Statistics</h1>
                    <br>
                        


                    <div style = "margin : 20px">
                        <h1>Global statistics</h1>
                        <table class="table" style = "width : 40%">
                            <tr>
                                <td><h5>Total publications:</h5></td>
                                <td><h5><?php echo $totalpublications?></h5></td>
                            </tr>
                            <tr>
                                <td><h5>Total Articles:</h5></td>
                                <td><h5><?php echo $totalarticles?></h5></td>
                            </tr>
                            <tr>
                                <td><h5>Total Workshops:</h5></td>
                                <td><h5><?php echo $totalworkshops?></h5></td>
                            </tr>
                            <tr>
                                <td><h5>Total Books:</h5></td>
                                <td><h5><?php echo $totalbooks?></h5></td>
                            </tr>
                            <tr>
                                <td><h5>Total InBooks:</h5></td>
                                <td><h5><?php echo $totalinbooks?></h5></td>
                            </tr>
                            <tr>
                                <td><h5>Total Newspapers:</h5></td>
                                <td><h5><?php echo $totalnewspapers?></h5></td>
                            </tr>
                            <tr>
                                <td><h5>Total Catalogs:</h5></td>
                                <td><h5><?php echo $totalcatalogs?></h5></td>
                            </tr>
                            <tr>
                                <td><h5>Total publications per author:</h5></td>
                                <td><h5><?php echo $publicationsperauthor  ?></h5></td>
                            </tr>
                            <?php
                                if(isset($_SESSION['typeofuser']) and ($_SESSION['typeofuser'] === 'Manager' or $_SESSION['typeofuser'] === 'Admin' )){
                                    
                                    echo '
                                
                                    <tr>
                                        <td><h5>Publications per year:</h5></td>
                                        <td><h5>'.$publicationsperyear.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Publications started from:</h5></td>
                                        <td><h5>'.$newestpublication.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Publications lasted until:</h5></td>
                                        <td><h5>'.$olderstpublication.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Articles started from:</h5></td>
                                        <td><h5>'.$olderstarticle.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Articles lasted until:</h5></td>
                                        <td><h5>'. $newestarticle.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Workshops started from:</h5></td>
                                        <td><h5>'. $olderstworkshop.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Workshops lasted until:</h5></td>
                                        <td><h5>'. $newestworkshop .'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Books started from:</h5></td>
                                        <td><h5>'.$olderstbook  .'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Books lasted until:</h5></td>
                                        <td><h5>'.$newestbook .'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>InBooks started from:</h5></td>
                                        <td><h5>'.$olderstinbook .'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>InBooks lasted until:</h5></td>
                                        <td><h5>'.$newestinbook .'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Newspapers started from:</h5></td>
                                        <td><h5>'.$olderstnewspapers.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Newspapers lasted until:</h5></td>
                                        <td><h5>'.$newestnewspapers.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Catalogs started from:</h5></td>
                                        <td><h5>'.$olderstcatalogs.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Catalogs lasted until:</h5></td>
                                        <td><h5>'.$newestcatalogs.'</h5></td>
                                    </tr>';
                                
                                }
                                ?>

                        
                        </table>


                        

             
                        <!--charts-->
                        <!--Bar chart Number of publications per year-->
                        <?php
                            if(isset($_SESSION['typeofuser']) and ($_SESSION['typeofuser'] === 'Manager' or $_SESSION['typeofuser'] === 'Admin' )){
                                echo '<div id = "barchart" style = "width: 550px; height: 400px;"></div>';
                            }
                        ?>
                        <script language = "JavaScript">
                            function drawChart() {
                                // Define the chart to be drawn.
                                var data = google.visualization.arrayToDataTable([
                                ['Year', 'Publications'],
                                <?php
                                    for($x = 0; $x < $piecounter; $x++){
                                        echo "['".$years[$x]."',".$numbers[$x]."],";
                                    }
                                ?>
                                ]);

                                var options = {title: 'Number of publications per year'}; 

                                // Instantiate and draw the chart.
                                var chart = new google.visualization.BarChart(document.getElementById('barchart'));
                                chart.draw(data, options);
                            }
                            google.charts.setOnLoadCallback(drawChart);
                        </script>

                        <!--pie chart from the start to the end number of publications per type-->

                        <br><br>
                        <div style="margin-left: 30px;">
                            <?php
                                if(isset($_SESSION['typeofuser']) and ($_SESSION['typeofuser'] === 'Manager' or $_SESSION['typeofuser'] === 'Admin' )){
                                    echo '
                                        
                                            <div style="margin-left: 100px;">
                                                <label>Quantity is (between 1990 and 2020):</label>
                                                <br>
                                                <label>From:</label>
                                                <input type="number" id="from" name="from" min="1990" max="2020" style="margin-left: 10px;" value = "1990" required> 
                                                <br>
                                                <label>To:</label>
                                                <input type="number" id="to" name="to" min="1990" max="2020" style="margin-left: 30px;" value = "2020" required>
                                                <br>
                                                <button type="button" class="btn btn-secondary" style="margin-left: 55px;" onclick="drawChart();">Give me results!</button>
                                            </div>

                                            <div id = "piechart" style = "width: 550px; height: 400px;"></div>
                                            
                                    ';
                                }
                            ?>
                                
                                <script language = "JavaScript">
                                    function drawChart() {
                                        // Define the chart to be drawn.
                                        var data = new google.visualization.DataTable();
                                        data.addColumn('string', 'Number of');
                                        data.addColumn('number', 'Number');
                                        data.addRows([
                                        ['Articles', action('Articles')],
                                        ['Workshops', action('Workshops')],
                                        ['Books', action('Books')],
                                        ['InBooks', action('InBooks')],
                                        ['Newspapers', action('Newspapers')],
                                        ['Catalogs', action('Catalogs')]
                                        ]);
                                        
                                        // Set chart options
                                        var options = {
                                        'title':'Number of publications from start to end per type',
                                        'width':550,
                                        'height':400
                                        };

                                        // Instantiate and draw the chart.
                                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                        chart.draw(data, options);
                                    }
                                    google.charts.setOnLoadCallback(drawChart);
                                </script>
                                
                                
                                <script>
                                    function action(type) {
                                        let starting = document.getElementById("from").value;
                                        let ending = document.getElementById("to").value;
                                        let number = 0;
                                        let x = 0;

                                        let articlesarray = <?php echo json_encode($allarticles); ?>;
                                        let workshoparray =<?php echo json_encode($allworkshops); ?>;
                                        let bookarray =<?php echo json_encode($allbooks); ?>;
                                        let inbookarray =<?php echo json_encode($allinbooks); ?>;
                                        let newspaperarray =<?php echo json_encode($allnewspapers); ?>;
                                        let catalogarray =<?php echo json_encode($allcatalogs); ?>;

                                        

                                        if(ending > starting || starting === ending){
                                            starting = starting - 1990;
                                            ending = ending - 1990;
                                            let counter = ending - starting; 

                                            if(type === "Articles"){
                                                for(x = starting; x < counter + 1; x++){
                                                    number = Number(number) + Number(articlesarray[x]);
                                                }
                                                return number;

                                            }else if(type === "Workshops"){
                                                for(x = starting; x < counter + 1; x++){
                                                    number = Number(number) + Number(workshoparray[x]);
                                                }
                                                return number;

                                            }else if(type === "Books"){
                                                for(x = starting; x < counter + 1; x++){
                                                    number = Number(number) + Number(bookarray[x]);
                                                }
                                                return number;
                                                
                                            }else if(type === "InBooks"){
                                                for(x = starting; x < counter + 1; x++){
                                                    number = Number(number) + Number(inbookarray[x]);
                                                }
                                                return number;
                                                
                                            }else if(type === "Newspapers"){
                                                for(x = starting; x < counter + 1; x++){
                                                    number = Number(number) + Number(newspaperarray[x]);
                                                }
                                                return number;

                                            }else if(type === "Catalogs"){
                                                for(x = starting; x < counter + 1; x++){
                                                    number = Number(number) + Number(catalogarray[x]);
                                                }
                                                return number;
                                            }
                                            

                                        }else{
                                            return 1;
                                        }

                                        return 1;
                                    }

                                </script>


                                <?php
                                    if(isset($_SESSION['typeofuser']) and ($_SESSION['typeofuser'] === 'Manager' or $_SESSION['typeofuser'] === 'Admin' )){
                                        echo '
                                            <h6>geo chart doesnt work since i dont have a propper api key</h6>
                                            <h6>if someone puts the currect api key for geocharts then it will work perfectly</h6>
                                            <div id="mapchart" style="width: 550px; height: 400px;"></div>';
                                    }
                                ?>
                                    <script type='text/javascript'>
                                            google.charts.load('current', {
                                            'packages': ['geochart'],
                                            // Note: you will need to get a mapsApiKey for your project.
                                            // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
                                            'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
                                            });
                                            google.charts.setOnLoadCallback(drawMarkersMap);

                                            function drawMarkersMap() {
                                            var data = google.visualization.arrayToDataTable([
                                                ['Country',   'Population', 'Area Percentage'],
                                                <?php
                                                    for($x = 0; $x < $counteraddress; $x++){
                                                        echo "['".$address[$x]."',".$countbyaddress[$x].",".$numbers[$x]."],";
                                                    }
                                                ?>
                                            ]);

                                            var options = {
                                                sizeAxis: { minValue: 0, maxValue: 100 },
                                                region: '155', // Western Europe
                                                displayMode: 'markers',
                                                colorAxis: {colors: ['#e7711c', '#4374e0']} // orange to blue
                                            };

                                            var chart = new google.visualization.GeoChart(document.getElementById('mapchart'));
                                            chart.draw(data, options);
                                            };
                                    </script>

                            <?php
                                if(isset($_SESSION['typeofuser']) and ($_SESSION['typeofuser'] === 'Manager' or $_SESSION['typeofuser'] === 'Admin' )){
                                    echo '<br><br><div id="timeline" style="height: 300px; witdh:100px;"></div>';
                                }
                            ?>
                            <!--TIMELINE CHART-->

                            <script type="text/javascript">
                                google.charts.load('current', {'packages':['timeline']});
                                google.charts.setOnLoadCallback(timeLineChart);
                                function timeLineChart() {
                                    var container = document.getElementById('timeline');
                                    var chart = new google.visualization.Timeline(container);
                                    var dataTable = new google.visualization.DataTable();

                                    dataTable.addColumn({ type: 'string', id: 'Publications' });
                                    dataTable.addColumn({ type: 'date', id: 'Start' });
                                    dataTable.addColumn({ type: 'date', id: 'End' });
                                    dataTable.addRows([
                                    [ 'Articles', new Date(<?php echo $olderstarticle?>,1,1), new Date(<?php echo $newestarticle?>,1,1) ],
                                    [ 'Workshops',      new Date(<?php echo $olderstworkshop?>,1,1),  new Date(<?php echo $newestworkshop?>,1,1) ],
                                    [ 'Books',      new Date(<?php echo $olderstbook?>,1,1),  new Date(<?php echo $newestbook?>,1,1) ],
                                    [ 'InBooks',      new Date(<?php echo $olderstinbook?>,1,1),  new Date(<?php echo $newestinbook?>,1,1) ],
                                    [ 'Newspapers',      new Date(<?php echo  $olderstnewspapers?>,1,1),  new Date(<?php echo $newestnewspapers?>,1,1) ],
                                    [ 'Catalogs',  new Date(<?php echo $olderstcatalogs?>,1,1),  new Date(<?php echo $newestcatalogs?>,1,1) ]]);
                                    
                                                
                                    var options = {'width':550,'height':400};


                                    chart.draw(dataTable , options);
                                }
                            </script>




                        </div>


                    <!--Personal statistics-->
                    <?php
                        if(isset($_SESSION['typeofuser']) and ($_SESSION['typeofuser'] === 'Publisher' or $_SESSION['typeofuser'] === 'Manager' or $_SESSION['typeofuser'] === 'Admin' )){
                            
                            echo '
                            <hr>
                            <br><br>
                            <h1>Personal Statistics</h1>

                            <table class="table" style = "width : 40%">
                                    <tr>
                                        <td><h5>Total personal publications:</h5></td>
                                        <td><h5>'.$personaltotalpublications.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Total personal  Articles:</h5></td>
                                        <td><h5>'.$personaltotalarticles.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Total personal  Workshops:</h5></td>
                                        <td><h5>'. $personaltotalworkshops.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Total personal  Books:</h5></td>
                                        <td><h5>'.  $personaltotalbooks.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Total personal  InBooks:</h5></td>
                                        <td><h5>'. $personaltotalinbooks.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Total personal  Newspapers:</h5></td>
                                        <td><h5>'.  $personaltotalnewspapers.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Total personal  Catalogs:</h5></td>
                                        <td><h5>'.$personaltotalcatalogs.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal publications per year:</h5></td>
                                        <td><h5>'.$personalpublicationsperyear.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal publications started from:</h5></td>
                                        <td><h5>'.$personalolderstpublication.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal publications lasted until:</h5></td>
                                        <td><h5>'.$personalnewestpublication.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal articles started from:</h5></td>
                                        <td><h5>'.$personalolderstarticle.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal articles lasted until:</h5></td>
                                        <td><h5>'.$personalnewestarticle.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal workshops started from:</h5></td>
                                        <td><h5>'.$personalolderstworkshop.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal workshops lasted until:</h5></td>
                                        <td><h5>'.$personalnewestworkshop.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal books started from:</h5></td>
                                        <td><h5>'.$personalolderstbook .'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal books lasted until:</h5></td>
                                        <td><h5>'.$personalnewestbook .'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal inBooks started from:</h5></td>
                                        <td><h5>'.$personalolderstinbook.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal inBooks lasted until:</h5></td>
                                        <td><h5>'. $personalnewestinbook.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal newspapers started from:</h5></td>
                                        <td><h5>'. $personalolderstnewspapers.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal newspapers lasted until:</h5></td>
                                        <td><h5>'.$personalnewestnewspapers.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal catalogs started from:</h5></td>
                                        <td><h5>'. $personalolderstcatalogs.'</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Personal catalogs lasted until:</h5></td>
                                        <td><h5>'.$personalnewestcatalogs.'</h5></td>
                                    </tr>
                                        
                                </table>';
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
