<!DOCTYPE html>
<html lang="en">
    <?php
        include("../connection/connect.php");

        error_reporting(0);
        session_start();
    ?>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>All Users</title>
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    </head>


    <body class="fix-header fix-sidebar">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>
        <div id="main-wrapper">
            <div class="header bg-dark">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">
                    <div class="navbar-header bg-dark">
                        <a class="navbar-brand" href="dashboard.php">
                            <span style="color:#fff; font-weight:bold">myOnlineDelivery</span>
                        </a>
                    </div>
                    <div class="navbar-collapse">
                        <ul class="navbar-nav mr-auto mt-md-0"></ul>
                        <ul class="navbar-nav my-lg-0">
                            <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/bookingSystem/user-icn.png" alt="user" class="profile-pic" /></a>
                                <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                    <ul class="dropdown-user">
                                        <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
    
            <div class="left-sidebar">
                <div class="scroll-sidebar bg-dark">
                    <nav class="sidebar-nav bg-dark">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Home</li>
                            <li> <a href="dashboard.php"><i class="fa fa-tachometer text-white"></i><span class="text-white">Dashboard</span></a></li>
                            <li class="nav-label">Log</li>
                            <li> <a href="all_users.php">  <span><i class="fa fa-user f-s-20"></i></span><span>Users</span></a></li>
                            <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-archive f-s-20 text-white"></i><span class="hide-menu text-white">Restaurant</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="all_restaurant.php" class="text-white">All Restaurants</a></li>
                                    <li><a href="add_category.php" class="text-white">Add Category</a></li>
                                    <li><a href="add_restaurant.php" class="text-white">Add Restaurant</a></li>
                                </ul>
                            </li>
                            <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery text-white" aria-hidden="true"></i><span class="hide-menu text-white">Menu</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="all_menu.php" class="text-white">All Menues</a></li>
                                    <li><a href="add_menu.php" class="text-white">Add Menu</a></li>
                                </ul>
                            </li>
                            <li> <a href="all_orders.php"><i class="fa fa-shopping-cart text-white" aria-hidden="true"></i><span class="text-white">Orders</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12">
                                <div class="card card-outline-primary">
                                    <div class="card-header">
                                        <h4 class="m-b-0 text-white text-center">All Users</h4>
                                    </div>
                                    <div class="table-responsive m-t-40">
                                        <table id="myTable" class="table table-bordered table-striped table-hover bg-dark">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Username</th>
                                                    <th>FirstName</th>
                                                    <th>LastName</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>												
                                                    <th>Registration Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql="SELECT * FROM users order by u_id desc";      //Ανάκτηση όλων των χρηστών με φθίνουσα σειρά των id
                                                    $query=mysqli_query($db,$sql);
                                                    
                                                    if(!mysqli_num_rows($query) > 0 ){          //Αν δεν υπάρχουν χρήστες στη βάση δεδομένων
                                                        echo '<td colspan="7"><center>There are no users.</center></td>';
                                                    }
                                                    else{				
                                                        while($rows=mysqli_fetch_array($query)){       //Για κάθε χρήστη που υπάρχει στη βάση
                                                            echo'<tr>
                                                                    <td>'.$rows['username'].'</td>
                                                                    <td>'.$rows['f_name'].'</td>
                                                                    <td>'.$rows['l_name'].'</td>
                                                                    <td>'.$rows['email'].'</td>
                                                                    <td>'.$rows['phone'].'</td>
                                                                    <td>'.$rows['address'].'</td>																								
                                                                    <td>'.$rows['date'].'</td>
                                                                    <td>
                                                                        <a href="update_users.php?user_upd='.$rows['u_id'].'" " class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit"></i></a>
                                                                        <a href="delete_users.php?user_del='.$rows['u_id'].'" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
                                                                    </td>
                                                                </tr>';
                                                        }	
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer bg-dark text-white"> © 2022 - myOnlineDelivery</footer>
        
        <script src="js/lib/jquery/jquery.min.js"></script>>
        <script src="js/lib/bootstrap/js/popper.min.js"></script>
        <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery.slimscroll.js"></script>
        <script src="js/sidebarmenu.js"></script>
        <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="js/custom.min.js"></script>
    </body>
</html>