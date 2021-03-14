<?php 


    session_start();

    $validation_error = "";
    $username = "";
    $password  = "";
    $typeofuser  = "";
    $firstname  = "";
    $lastname  = "";
    $orcid = "";
    $site = "";
    $typeofauthor = "";
    $message = '<h1 style="margin: 20px;">Make a new Unit!</h1>';

    function escape($value){//XSS attacks protection
        return htmlspecialchars($value , ENT_QUOTES,'UTF-8');
    }


    if(empty($_SESSION['typeofuser']) or $_SESSION['typeofuser'] !== "Admin"  ){
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
   
        
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $typeofunit  = $_POST["typeofunit"];
        $nameofinstitution  = $_POST["nameofinstitution"];
        $description  = $_POST["description"];
        $site  = $_POST["site"];
        // Set session variables
       

        
        if($name === "" or $typeofunit === "" or $nameofinstitution === "" or $site === ""){
                $validation_error = "Fill all the required fields";

        }else{



            $hostname = "sql313.epizy.com";//used to have localhost
            $dbusername = "epiz_25763156";//used to have id12758451_labreservations
            $dbpassword = "0kSBbmCf2qv4E";//used to have LabReservations
            $db = "epiz_25763156_publications";//used to have id12758451_labreservations


            try {
                $conn = new PDO("mysql:host=$hostname;dbname=$db", $dbusername, $dbpassword);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // prepare sql and bind parameters
                $stmt = $conn->prepare("INSERT INTO Unit (name , typeofunit , nameofinstitution , site , description ) 
                VALUES (:name, :typeofunit, :nameofinstitution, :site, :description)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':typeofunit', $typeofunit);
                $stmt->bindParam(':nameofinstitution', $nameofinstitution);
                $stmt->bindParam(':site', $site);
                $stmt->bindParam(':description', $description);

                $stmt->execute();

                
                

 
                $message = '<div class="p-3 mb-2 bg-success text-white">You successfully made a new Unit!!!</div>';
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
        <title>Publications New Unit</title>
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
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/index.php'\">Main</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location='http://publications.epizy.com/current-publications.php'\">Current Publications</button>

                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/statistics.php'\">Statistics</button>";

                        $adminbuttons = "
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/edit-user.php'\">Edit User</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/create-user.php'\">Create User</button>";

                        $loggedin ="<button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location = 'http://publications.epizy.com/newpublication.php'\">New Publication</button>

                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location = 'http://publications.epizy.com/update-publication.php'\">Update Publications</button>
                        
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-danger\" onclick=\"document.location = 'http://publications.epizy.com/logout.php'\">Log out</button>";

                            

                            echo $standardbuttons;
                            if(isset($_SESSION['typeofuser']) and $_SESSION['typeofuser'] === "Admin"  ){
                                echo $adminbuttons;
                            }
                            echo $loggedin;

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
                    <?php echo $message ?>
                    <div class="container-fluid">
                    
                        
                        
                       
                        <form method="post">
                            <table>
                                <tr>
                                    <th><h5>Name:</h5><input required type="text" name="name" value="" required></th>
                                    <th><h5>Name of institution:</h5><input required type="text" name="nameofinstitution" value="" required></th>
                                </tr>
                                <tr>
                                    <th><h5>Site:</h5><input required type="text" name="site" value="" required></th>
                                    <th><h5>Description:</h5><input type="text" name="description" value=""></th>
                                </tr>
                            </table>
                            
                            <label style="margin-top: 15px;" for="typeofunit"><h5>Lab/Department:</h5></label>
                            
                            <select name="typeofunit">
                                <option value="Lab">Lab</option>
                                <option value="Department">Department</option>
                            </select>

                            
                            <br>
                            <span class="error"><?= $validation_error;?></span>
                            <br>
                            <input type="submit" class="btn btn-warning" value="Make a new Unit">
                        
                        </form>
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
