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
    $newaccount = "Make a new Account!";
   
    if(isset($_SESSION['username'])){
        header ("Location: index.php");
        exit;
    }
        
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $password  = $_POST["password"];
        $typeofuser  = $_POST["typeofuser"];
        $firstname  = $_POST["firstname"];
        $lastname  = $_POST["lastname"];
        $orcid = $_POST["orcid"];
        $site = $_POST["site"];
        $typeofauthor = $_POST["typeofauthor"];
        $active = 1;
        // Set session variables
       

        
        if($username === "" or $password === "" or $typeofuser === "" or $firstname === "" or $lastname=== "" ){
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
                $stmt = $conn->prepare("INSERT INTO Users (typeofuser , username , password , firstname , lastname, orcid, site, typeofauthor, active) 
                VALUES (:typeofuser, :username, :password, :firstname, :lastname, :orcid, :site, :typeofauthor, :active)");
                $stmt->bindParam(':typeofuser', $typeofuser);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':orcid', $orcid);
                $stmt->bindParam(':site', $site);
                $stmt->bindParam(':typeofauthor', $typeofauthor);
                $stmt->bindParam(':active', $active);

                $stmt->execute();

                $stmt = $conn->query("select * from Users where active = 1 ");
                
                while ($row = $stmt->fetch()) {
                    if($username === $row['username'] && $password === $row['password'] && $typeofuser === $row['typeofuser'])  {
                        //echo "WELCOME MASTER!";
                        $_SESSION['userid'] = $row['id'];
                        $_SESSION['username'] = $username;
                        $_SESSION['typeofuser'] = $typeofuser;
                        $_SESSION['firstname'] = $row['firstname'];
                        $_SESSION['lastname'] = $row['lastname'];
                        $_SESSION['orcid'] = $row['orcid'];
                        $_SESSION['site'] = $row['site'];
                        $_SESSION['typeofauthor'] = $row['typeofauthor'];
                        $_SESSION['active'] = $row['active'];
                        
                        $_SESSION['start'] = time(); // Taking now logged in time.
                        $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);// Ending a session in 30 minutes from the starting time.



                        header("Location: http://publications.epizy.com/index.php");
                        exit;
                        }
                }


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
        <title>Publications Sign Up</title>
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
                            <button style="height:60px;width:140px; margin:15px;margin-left: 40px;" class="btn btn-success" onclick="document.location = 'http://publications.epizy.com/index.php'">Main</button>
                            <button style="height:60px;width:140px; margin:15px;margin-left: 40px;" class="btn btn-success" onclick="document.location = 'http://publications.epizy.com/signin.php'">Sign in</button>
                        </div>
						
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4"><?php echo $newaccount ?></h1>
                        
                       
                        <form method="post">

                            <table>
                                <tr>
                                    <th><h5>Username:</h5><input required type="text" name="username" value=""></th>
                                    <th><h5>Password:</h5><input required type="text" name="password" value=""></th>
                                </tr>
                                <tr>
                                    <th><h5>First Name:</h5><input required type="text" name="firstname" value=""></th>
                                    <th><h5>Last Name:</h5><input required type="text" name="lastname" value=""></th>
                                </tr>
                                <tr>
                                    <th><h5>Orcid:</h5><input type="text" name="orcid" value="<?php echo $orcid;?>"></th>
                                    <th><h5>Personal Site:</h5><input type="text" name="site" value="<?php echo $site;?>"></th>
                                </tr>
                                
                            </table>
                            
                            <label style="margin-top: 15px;" for="typeofuser"><h5>Choose a type of user:</h5></label>
                            
                            <select name="typeofuser">
                                <option value="Publisher">Publisher</option>
                                <option value="Manager">Manager</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <br>
                            <label for="typeofauthor"><h5>Choose a type of author:</h5></label>
                            <select name="typeofauthor">
                                <option value="Professor">Professor</option>
                                <option value="Researcher">Researcher</option>
                                <option value="Technical Staff">Technical Staff</option>
                                <option value="Research Staff">Research Staff</option>
                            </select>

                            
                            <br>
                            <span class="error"><?= $validation_error;?></span>
                            <br>
                            <input type="submit" class="btn btn-warning" value="Make a new account">
                        
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
