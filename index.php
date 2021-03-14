<?php 

    session_start();


    if (isset($_SESSION['username'])) {
        
        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            
            header("Location:http://publications.epizy.com/logout.php");
            exit;
        }
    
    }




    $username = "";
    
    if(empty($_SESSION['username'])){
        $username = "";
    }else{
        $username = $_SESSION['username'];
    }

    function escape($value){//XSS attacks protection
        return htmlspecialchars($value , ENT_QUOTES,'UTF-8');
    }
    
?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Publications Main</title>
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
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" 
                        onclick=\"document.location='http://publications.epizy.com/current-publications.php'\">Current Publications</button>

                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\"btn btn-success\" onclick=\"document.location = 'http://publications.epizy.com/statistics.php'\">Statistics</button>";

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

                        if(isset($_SESSION['typeofuser']) and $_SESSION['typeofuser'] === "Admin"  ){
                            echo $adminbuttons;
                        }

                        echo $standardbuttons;

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
                    <div class="container-fluid">
                        <h1 class="mt-4"> 
                            <?php 
                                if($_SESSION["username"] != ""){
                                    echo "Welcome back " . escape($_SESSION["username"]);
                                }else{
                                    echo " Welcome to Publications !!!";
                                }
                            ?>
                        </h1>
                        



                       






                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    
                                </div>
                            </div>
                            
                        </div>
                        
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
