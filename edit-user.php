<?php 

    session_start();

    
    $authorid = $_SESSION['userid'];
    $error = 0;
    $choice = 0;
    $message ='';

    if(empty($_SESSION['typeofuser']) or $_SESSION['typeofuser'] !== "Admin"  ){
        header ("Location: index.php");
        exit;
    }

    function escape($value){//XSS attacks protection
        return htmlspecialchars($value , ENT_QUOTES,'UTF-8');
    }

    if (isset($_SESSION['username'])) {
        
        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            
            header("Location:http://publications.epizy.com/logout.php");
            exit;
        }
    
    }

    $id = array();
    $usernamearray = array();
    $typeofuserarray = array();
    $counter = 0;

    $hostname = "sql313.epizy.com";//used to have localhost
    $dbusername = "epiz_25763156";//used to have id12758451_labreservations
    $dbpassword = "0kSBbmCf2qv4E";//used to have LabReservations
    $db = "epiz_25763156_publications";//used to have id12758451_labreservations



    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$db", $dbusername, $dbpassword);
        // set the PDO error mode to exception
                
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("select * from Users");
        $stmt->execute();

        while ($row = $stmt->fetch()) {

            $idarray[$counter] = $row['id'];
            $usernamearray [$counter] = $row['username'];
            $typeofuserarray [$counter] = $row['typeofuser'];
            $counter++;

        }



        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_POST['id'];

           

            if (in_array($id, $idarray)) {
                //echo 'was found';

                if($_POST['action'] === 'Update'){
                    
                    $id = $_POST["id"];
                    $typeofuser  = $_POST["typeofuser"];

                    $stmt = $conn->prepare("UPDATE Users SET typeofuser= :typeofuser WHERE id = :id");
                    $stmt->bindParam(':typeofuser', $typeofuser);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();

                    $message = '<div class="p-3 mb-2 bg-success text-white">You successfully changed the role of user!!!</div>';
                        
                }else if($_POST['action'] === 'Delete'){
                    
                    $id = $_POST['id'];

                    $stmt = $conn->prepare("delete from Users where id = :id");
                    $stmt->bindParam(':id',$id);
                    $stmt->execute();

                    $message = '<div class="p-3 mb-2 bg-success text-white">You successfully deleted that user!!!</div>';
                }
            }else{
                $message =  '<div class="p-3 mb-2 bg-danger text-white">ID of user was not found</div>';
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
        <title>Edit Accounts</title>
        
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
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/create-user.php'\">Create User</button>
                        <button style=\"height:60px;width:140px; margin:15px;margin-left: 40px;\" class=\" btn btn-success\" onclick=\"document.location='http://publications.epizy.com/newunit.php'\">New Unit</button>";

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
                    <div class="container-fluid">
                        
                    </div>

                    <?php
                        echo $message;
                    ?>         
                                  
                   <div style="width : 90%; margin-left: 25px;">                      
                                                
                        <table id="usertable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Type of user</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    echo '<h1 style="margin-top: 25px;">Edit User Account</h1>';
                                    for($x = 0; $x < $counter; $x++){
                                        echo 
                                        '<tr>
                                            <td>'.escape($idarray[$x]).'</td>
                                            <td>'.escape($usernamearray[$x]).'</td>
                                            <td id="td'.escape($idarray[$x]).'" >'.$typeofuserarray[$x].'</td>
                                        </tr>';
                                    }
                                ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Type of user</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                            $('#usertable').DataTable();
                            } );
                        </script>
                    </div>





                    <div style= "margin:20px;">

                        <form method="post" onsubmit='updateTable();'>
                            <h3>Give ID of user you want to change role</h3>
                            <h5>ID:</h5><input type="number" id="idnum" name="id" value="" min="0" max="1000000" style="height: 40px;width: 100px;" required>
                            
                            <select name="typeofuser" id="typeof" style="height: 40px;width: 105px;">
                                <option value="Publisher">Publisher</option>
                                <option value="Manager">Manager</option>
                                <option value="Admin">Admin</option>
                            </select>

                            <input class="btn btn-secondary" type="submit" name="action" value="Update" style="height: 40px;">
                                
                        </form>
                        <br><br>

                        <form method="post">
                            <h3>Give ID of user you want to delete</h3>
                            <h5>ID:</h5><input type="number" name="id" value="" min="0" max="1000000" style="height: 40px;width: 100px;" required>

                            <input class="btn btn-secondary" type="submit" name="action" value="Delete" style="height: 40px;">
                                
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
        <script>
            function updateTable(){
                var id= document.getElementById('idnum').value;
                var type = document.getElementById('typeof');
                var selection = type.options[type.selectedIndex].value;
                document.getElementById('td'+id).innerHTML = selection;
            }
        </script>
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
    </body>
</html>
