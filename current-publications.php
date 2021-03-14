<?php 

    session_start();

    
    $authorid = $_SESSION['userid'];
   
    if (isset($_SESSION['username'])) {
        
        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            
            header("Location:http://publications.epizy.com/logout.php");
            exit;
        }
    
    }


    $hostname = "sql313.epizy.com";//used to have localhost
    $dbusername = "epiz_25763156";//used to have id12758451_labreservations
    $dbpassword = "0kSBbmCf2qv4E";//used to have LabReservations
    $db = "epiz_25763156_publications";//used to have id12758451_labreservations

   
    function escape($value){//XSS attacks protection
        return htmlspecialchars($value , ENT_QUOTES,'UTF-8');
    }

    $dbconnect=mysqli_connect($hostname,$dbusername,$dbpassword,$db);

    if ($dbconnect->connect_error) {
        //die("Database connection failed: " . $dbconnect->connect_error);
        echo "Connection failed";
        header("Location: http://labreservations.epizy.com/servererror.php");
        exit;
    }
    $query = mysqli_query($dbconnect, "select doi,issn,isbn from publications where not(doi = '' and issn = '' and isbn = '')")//and Lab_ID = 'first'
    or die (mysqli_error($dbconnect));

    //ArticleArrayValues
    $idarticle = array();
    $titlearticle = array();
    $montharticle = array();
    $yeararticle = array();
    $notesarticle = array();
    $urlarticle = array();
    $keyarticle = array();
    $publicationnamearticle = array();
    $pagesarticle = array();
    $volumearticle = array();
    $numberarticle = array();
    $doiarticle = array();


    //WorkshopArrayValues
    $idworkshop = array();
    $titleworkshop = array();
    $monthworkshop = array();
    $yearworkshop = array();
    $notesworkshop = array();
    $urlworkshop = array();
    $keyworkshop = array();
    $publisherworkshop = array();
    $booktitleworkshop = array();
    $editorworkshop = array();
    $seriesworkshop = array();
    $organizationworkshop = array();
    $pagesworkshop = array();
    $addressworkshop = array();
    $volumeworkshop = array();
    $numberworkshop = array();
    $doiworkshop = array();




    //BookArrayValues
    $idbook = array();
    $titlebook = array();
    $monthbook = array();
    $yearbook = array();
    $notesbook = array();
    $urlbook = array();
    $keybook = array();
    $publisherbook = array();
    $editionbook = array();
    $seriesbook = array();
    $addressbook = array();
    $volumebook = array();
    $numberbook = array();
    $isbnbook = array();
    $issnbook = array();
    


    //InBookArrayValues
    $idinbook = array();
    $titleinbook = array();
    $monthinbook = array();
    $yearinbook = array();
    $notesinbook = array();
    $urlinbook = array();
    $keyinbook = array();
    $publisherinbook = array();
    $chapterinbook = array();
    $seriesinbook = array();
    $editioninbook = array();
    $volumeinbook = array();
    $numberinbook = array();
    $addressinbook = array();
    $pagesinbook = array();
    $typeinbook = array();
    $isbninbook = array();
    $issninbook = array();
    



    //NewspaperArrayValues
    $idnewspaper = array();
    $titlenewspaper = array();
    $monthnewspaper = array();
    $yearnewspaper = array();
    $notesnewspaper = array();
    $urlnewspaper = array();
    $keynewspaper = array();
    $publishernewspaper = array();
    $addressnewspaper = array();
    $pagesnewspaper = array();
    $issnnewspaper = array();
    


    //CatalogArrayValues
    $idcatalog = array();
    $titlecatalog = array();
    $monthcatalog = array();
    $yearcatalog = array();
    $notescatalog = array();
    $urlcatalog = array();
    $keycatalog = array();
    $publishercatalog = array();
    $chaptercatalog = array();
    $editioncatalog = array();
    $pagescatalog = array();
    $addresscatalog = array();
    $issncatalog = array();
    
    $query = mysqli_query($dbconnect, "SELECT * FROM publications")//and Lab_ID = 'first'
    or die (mysqli_error($dbconnect));

    $counterarticle = 0;
    $counterworkshop = 0;
    $counterbook = 0;
    $counterinbook = 0;
    $counternewspaper = 0;
    $countercatalog = 0;

    while ($row = mysqli_fetch_array($query)) {

        if($row['typeofpublication'] === "Article"){
            $idarticle[$counterarticle] = $row['id'];
            $titlearticle[$counterarticle] = $row['title'];
            $montharticle[$counterarticle] = $row['month'];
            $yeararticle[$counterarticle] = $row['year'];
            $notesarticle [$counterarticle] = $row['note'];
            $urlarticle [$counterarticle] = $row['url'];
            $keyarticle [$counterarticle] = $row['ikey'];
            $publicationnamearticle [$counterarticle] = $row['publicationname'];
            $pagesarticle [$counterarticle] = $row['pages'];
            $volumearticle [$counterarticle] = $row['volume'];
            $numberarticle [$counterarticle] = $row['number'];
            $doiarticle [$counterarticle] = $row['doi'];

            $counterarticle++;

        }else if($row['typeofpublication'] === "Workshop"){
            

            $idworkshop[$counterworkshop] = $row['id'];
            $titleworkshop[$counterworkshop] = $row['title'];
            $monthworkshop[$counterworkshop] = $row['month'];
            $yearworkshop[$counterworkshop] = $row['year'];
            $notesworkshop [$counterworkshop] = $row['note'];
            $urlworkshop[$counterworkshop] = $row['url'];
            $keyworkshop [$counterworkshop] = $row['ikey'];
            $publisherworkshop [$counterworkshop] = $row['publicationname'];
            $booktitleworkshop [$counterworkshop] = $row['booktitle'];
            $editorworkshop [$counterworkshop] = $row['editor'];
            $seriesworkshop [$counterworkshop] = $row['series'];
            $organizationworkshop [$counterworkshop] = $row['organization'];
            $pagesworkshop[$counterworkshop] = $row['pages'];
            $addressworkshop [$counterworkshop] = $row['address'];
            $volumeworkshop[$counterworkshop] = $row['volume'];
            $numberworkshop[$counterworkshop] = $row['number'];
            $doiworkshop[$counterworkshop] = $row['doi'];

            $counterworkshop++;


        }else if($row['typeofpublication'] === "Book"){
            
            $idbook[$counterbook] = $row['id'];
            $titlebook[$counterbook] = $row['title'];
            $monthbook[$counterbook] = $row['month'];
            $yearbook[$counterbook] = $row['year'];
            $notesbook[$counterbook] = $row['note'];
            $urlbook[$counterbook] = $row['url'];
            $keybook[$counterbook] = $row['ikey'];
            $publisherbook[$counterbook] = $row['publicationname'];
            $editionbook [$counterbook] = $row['edition'];
            $seriesbook[$counterbook] = $row['series'];
            $addressbook[$counterbook] = $row['address'];
            $volumebook [$counterbook] = $row['volume'];
            $numberbook[$counterbook] = $row['number'];
            $isbnbook [$counterbook] = $row['isbn'];
            $issnbook [$counterbook] = $row['issn'];

            $counterbook++;


        }else if($row['typeofpublication'] === "InBook"){
            //=TODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
            $idinbook [$counterinbook] = $row['id'];
            $titleinbook [$counterinbook] = $row['title'];
            $monthinbook [$counterinbook] = $row['month'];
            $yearinbook [$counterinbook] = $row['year'];
            $notesinbook [$counterinbook] = $row['note'];
            $urlinbook[$counterinbook] = $row['url'];
            $keyinbook [$counterinbook] = $row['ikey'];
            $publisherinbook[$counterinbook] = $row['publicationname'];
            $chapterinbook[$counterinbook] = $row['chapter'];
            $seriesinbook [$counterinbook] = $row['series'];
            $editioninbook [$counterinbook] = $row['edition'];
            $volumeinbook [$counterinbook] = $row['volume'];
            $numberinbook [$counterinbook] = $row['number'];
            $addressinbook [$counterinbook] = $row['address'];
            $pagesinbook [$counterinbook] = $row['pages'];
            $typeinbook [$counterinbook] = $row['type'];
            $isbninbook [$counterinbook] = $row['isbn'];
            $issninbook [$counterinbook] = $row['issn'];
                    
            $counterinbook++;

        }else if($row['typeofpublication'] === "Newspaper"){

            $idnewspaper[$counternewspaper] = $row['id'];
            $titlenewspaper [$counternewspaper] = $row['title'];
            $monthnewspaper[$counternewspaper] = $row['month'];
            $yearnewspaper [$counternewspaper] = $row['year'];
            $notesnewspaper[$counternewspaper] = $row['note'];
            $urlnewspaper[$counternewspaper] = $row['url'];
            $keynewspaper [$counternewspaper] = $row['ikey'];
            $publishernewspaper [$counternewspaper] = $row['publicationname'];
            $addressnewspaper [$counternewspaper] = $row['address'];
            $pagesnewspaper [$counternewspaper] = $row['pages'];
            $issnnewspaper [$counternewspaper] = $row['issn'];
            
            $counternewspaper++;

        }else if($row['typeofpublication'] === "Catalog"){

            $idcatalog [$countercatalog] = $row['id'];
            $titlecatalog [$countercatalog] = $row['title'];
            $monthcatalog [$countercatalog] = $row['month'];
            $yearcatalog [$countercatalog] = $row['year'];
            $notescatalog [$countercatalog] = $row['note'];
            $urlcatalog [$countercatalog] = $row['url'];
            $keycatalog[$countercatalog] = $row['ikey'];
            $publishercatalog [$countercatalog] = $row['publicationname'];
            $chaptercatalog [$countercatalog] = $row['chapter'];
            $editioncatalog [$countercatalog] = $row['edition'];
            $pagescatalog [$countercatalog] = $row['pages'];
            $addresscatalog [$countercatalog] = $row['address'];
            $issncatalog [$countercatalog] = $row['issn'];
            
            $countercatalog++;

        }

        
    }
   
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
        <title>Current Publications</title>
        
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
                            onclick=\"document.location='http://publications.epizy.com/statistics.php'\">Statistics</button>
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
                                if(empty($_SESSION['username'])){
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
                    <div class="container-fluid">
                        <h1 style="margin:5px;">Current Publications</h1>
                        <br>
                        
                    </div>
                                  
                                  
                    <!--Article-->
                    <div style="width : 90%; margin-left: 25px;">                      
                                                
                        <table id="articlestable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Name Of Journal</th>
                                    <th>Pages</th>
                                    <th>Volume</th>
                                    <th>Number</th>
                                    <th>DOI</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    echo '<h1 style="margin-top: 25px;">Article Table</h1>';
                                    for($x = 0; $x < $counterarticle; $x++){
                                        echo 
                                        '<tr>
                                            <td>'.escape($idarticle[$x]).'</td>
                                            <td>'.escape($titlearticle[$x]).'</td>
                                            <td>'.escape($montharticle[$x]).'</td>
                                            <td>'.escape($yeararticle[$x]).'</td>
                                            <td>'.escape($notesarticle[$x]).'</td>
                                            <td>'.escape($urlarticle[$x]).'</td>
                                            <td>'.escape($keyarticle[$x]).'</td>
                                            <td>'.escape($publicationnamearticle[$x]).'</td>
                                            <td>'.escape($pagesarticle[$x]).'</td>
                                            <td>'.escape($volumearticle[$x]).'</td>
                                            <td>'.escape($numberarticle[$x]).'</td>
                                            <td>'.escape($doiarticle[$x]).'</td>
                                        </tr>';


                                    }
                                ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Name Of Journal</th>
                                    <th>Pages</th>
                                    <th>Volume</th>
                                    <th>Number</th>
                                    <th>DOI</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                            $('#articlestable').DataTable();
                            } );
                        </script>
                        <hr style="height:10px;color:gray;background-color:gray;max-width: 100%;">
                    </div>
                    
                    <!--Workshop-->
                    <div style="width : 90%; margin-left: 25px;">                      
                                                
                        <table id="workshoptable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Book Title</th>
                                    <th>Editor</th>
                                    <th>Series</th>
                                    <th>Organization</th>
                                    <th>Pages</th>
                                    <th>Address</th>
                                    <th>Volume</th>
                                    <th>Number</th>
                                    <th>DOI</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    echo '<h1 style="margin-top: 25px;">Workshop Table</h1>';
                                    for($x = 0; $x < $counterworkshop; $x++){
                                        echo 
                                        '<tr>
                                            <td>'.escape($idworkshop[$x]).'</td>
                                            <td>'.escape($titleworkshop[$x]).'</td>
                                            <td>'.escape($monthworkshop[$x]).'</td>
                                            <td>'.escape($yearworkshop[$x]).'</td>
                                            <td>'.escape($notesworkshop[$x]).'</td>
                                            <td>'.escape($urlworkshop[$x]).'</td>
                                            <td>'.escape($keyworkshop[$x]).'</td>
                                            <td>'.escape($publisherworkshop[$x]).'</td>
                                            <td>'.escape($booktitleworkshop[$x]).'</td>
                                            <td>'.escape($editorworkshop[$x]).'</td>
                                            <td>'.escape($seriesworkshop[$x]).'</td>
                                            <td>'.escape($organizationworkshop[$x]).'</td>
                                            <td>'.escape($pagesworkshop[$x]).'</td>
                                            <td>'.escape($addressworkshop[$x]).'</td>
                                            <td>'.escape($volumeworkshop[$x]).'</td>
                                            <td>'.escape($numberworkshop[$x]).'</td>
                                            <td>'.escape($doiworkshop[$x]).'</td>
                                        </tr>';


                                    }


                                        
                                ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Book Title</th>
                                    <th>Editor</th>
                                    <th>Series</th>
                                    <th>Organization</th>
                                    <th>Pages</th>
                                    <th>Address</th>
                                    <th>Volume</th>
                                    <th>Number</th>
                                    <th>DOI</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                            $('#workshoptable').DataTable();
                            } );
                        </script>
                        <hr style="height:10px;color:gray;background-color:gray;max-width: 100%;">
                    </div>
                    
                    <!--Book-->
                    <div style="width : 90%; margin-left: 25px;">                      
                                                
                        <table id="booktable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Edition</th>
                                    <th>Series</th>
                                    <th>Address</th>
                                    <th>Volume</th>
                                    <th>Number</th>
                                    <th>ISBN</th>
                                    <th>ISSN</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    echo '<h1 style="margin-top: 25px;">Book Table</h1>';
                                    for($x = 0; $x < $counterbook; $x++){
                                        echo 
                                        '<tr>
                                            <td>'.escape($idbook[$x]).'</td>
                                            <td>'.escape($titlebook[$x]).'</td>
                                            <td>'.escape($monthbook[$x]).'</td>
                                            <td>'.escape($yearbook[$x]).'</td>
                                            <td>'.escape($notesbook[$x]).'</td>
                                            <td>'.escape($urlbook[$x]).'</td>
                                            <td>'.escape($keybook[$x]).'</td>
                                            <td>'.escape($publisherbook[$x]).'</td>
                                            <td>'.escape($editionbook[$x]).'</td>
                                            <td>'.escape($seriesbook[$x]).'</td>
                                            <td>'.escape($addressbook[$x]).'</td>
                                            <td>'.escape($volumebook[$x]).'</td>
                                            <td>'.escape($numberbook[$x]).'</td>
                                            <td>'.escape($isbnbook[$x]).'</td>
                                            <td>'.escape($issnbook[$x]).'</td>
                                        </tr>';

                                    }


                                        
                                ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Edition</th>
                                    <th>Series</th>
                                    <th>Address</th>
                                    <th>Volume</th>
                                    <th>Number</th>
                                    <th>ISBN</th>
                                    <th>ISSN</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                            $('#booktable').DataTable();
                            } );
                        </script>
                        <hr style="height:10px;color:gray;background-color:gray;max-width: 100%;">
                    </div>

                    <!--InBook-->    
                    <div style="width : 90%; margin-left: 25px;">                      
                                                
                        <table id="inbooktable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Chapter</th>
                                    <th>Series</th>
                                    <th>Edition</th>
                                    <th>Volume</th>
                                    <th>Number</th>
                                    <th>Address</th>
                                    <th>Pages</th>
                                    <th>Type</th>
                                    <th>ISBN</th>
                                    <th>ISSN</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    echo '<h1 style="margin-top: 25px;">InBook Table</h1>';
                                    for($x = 0; $x < $counterinbook; $x++){
                                        echo 
                                        '<tr>
                                            <td>'.escape($idinbook[$x]).'</td>
                                            <td>'.escape($titleinbook[$x]).'</td>
                                            <td>'.escape($monthinbook[$x]).'</td>
                                            <td>'.escape($yearinbook[$x]).'</td>
                                            <td>'.escape($notesinbook[$x]).'</td>
                                            <td>'.escape($urlinbook[$x]).'</td>
                                            <td>'.escape($keyinbook[$x]).'</td>
                                            <td>'.escape($publisherinbook[$x]).'</td>
                                            <td>'.escape($chapterinbook[$x]).'</td>
                                            <td>'.escape($seriesinbook[$x]).'</td>
                                            <td>'.escape($editioninbook[$x]).'</td>
                                            <td>'.escape($volumeinbook[$x]).'</td>
                                            <td>'.escape($numberinbook[$x]).'</td>
                                            <td>'.escape($addressinbook[$x]).'</td>
                                            <td>'.escape($pagesinbook[$x]).'</td>
                                            <td>'.escape($typeinbook[$x]).'</td>
                                            <td>'.escape($isbninbook[$x]).'</td>
                                            <td>'.escape($issninbook[$x]).'</td>
                                        </tr>';
                                    }
                                        
                                ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Chapter</th>
                                    <th>Series</th>
                                    <th>Edition</th>
                                    <th>Volume</th>
                                    <th>Number</th>
                                    <th>Address</th>
                                    <th>Pages</th>
                                    <th>Type</th>
                                    <th>ISBN</th>
                                    <th>ISSN</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                            $('#inbooktable').DataTable();
                            } );
                        </script>
                        <hr style="height:10px;color:gray;background-color:gray;max-width: 100%;">
                    </div>

                    <!--Newspaper-->    
                    <div style="width : 90%; margin-left: 25px;">                      
                                                
                        <table id="newspapertable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Address</th>
                                    <th>Pages</th>
                                    <th>ISSN</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    echo '<h1 style="margin-top: 25px;">Newspaper Table</h1>';
                                    for($x = 0; $x < $counternewspaper; $x++){
                                        echo 
                                        '<tr>
                                            <td>'.escape($idnewspaper[$x]).'</td>
                                            <td>'.escape($titlenewspaper[$x]).'</td>
                                            <td>'.escape($monthnewspaper[$x]).'</td>
                                            <td>'.escape($yearnewspaper[$x]).'</td>
                                            <td>'.escape($notesnewspaper[$x]).'</td>
                                            <td>'.escape($urlnewspaper[$x]).'</td>
                                            <td>'.escape($keynewspaper[$x]).'</td>
                                            <td>'.escape($publishernewspaper[$x]).'</td>
                                            <td>'.escape($addressnewspaper[$x]).'</td>
                                            <td>'.escape($pagesnewspaper[$x]).'</td>
                                            <td>'.escape($issnnewspaper[$x]).'</td>
                                        </tr>';
                                    }
                                        

                                ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Address</th>
                                    <th>Pages</th>
                                    <th>ISSN</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                            $('#newspapertable').DataTable();
                            } );
                        </script>
                        <hr style="height:10px;color:gray;background-color:gray;max-width: 100%;">
                    </div>

                    <!--Catalog-->    
                    <div style="width : 90%; margin-left: 25px;">                      
                                                
                        <table id="catalogtable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Chapter</th>
                                    <th>Edition</th>
                                    <th>Pages</th>
                                    <th>Address</th>
                                    <th>ISSN</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    echo '<h1 style="margin-top: 25px;">Catalog Table</h1>';
                                    for($x = 0; $x < $countercatalog; $x++){
                                        echo 
                                        '<tr>
                                            <td>'.escape($idcatalog[$x]).'</td>
                                            <td>'.escape($titlecatalog[$x]).'</td>
                                            <td>'.escape($monthcatalog[$x]).'</td>
                                            <td>'.escape($yearcatalog[$x]).'</td>
                                            <td>'.escape($notescatalog[$x]).'</td>
                                            <td>'.escape($urlcatalog[$x]).'</td>
                                            <td>'.escape($keycatalog[$x]).'</td>
                                            <td>'.escape($publishercatalog[$x]).'</td>
                                            <td>'.escape($chaptercatalog[$x]).'</td>
                                            <td>'.escape($editioncatalog[$x]).'</td>
                                            <td>'.escape($pagescatalog[$x]).'</td>
                                            <td>'.escape($addresscatalog[$x]).'</td>
                                            <td>'.escape($issncatalog[$x]).'</td>

                                        </tr>';
                                    }
                                ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Notes</th>
                                    <th>URL</th>
                                    <th>KEY</th>
                                    <th>Publisher</th>
                                    <th>Chapter</th>
                                    <th>Edition</th>
                                    <th>Pages</th>
                                    <th>Address</th>
                                    <th>ISSN</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                            $('#catalogtable').DataTable();
                            } );
                        </script>
                        <hr style="height:10px;color:gray;background-color:gray;max-width: 100%;">
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
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
    </body>
</html>
