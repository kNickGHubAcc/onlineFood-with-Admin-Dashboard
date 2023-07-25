<!DOCTYPE html>
<html lang="en">
    <?php
        include("../connection/connect.php");

        error_reporting(0);       //Απενεργοποιεί τα μηνύματα σφαλμάτων, ώστε να αποκρύπτονται από τους χρήστες της εφαρμογής
        session_start();

        if(isset($_POST['submit']))          //Αν ο χρήστης πατήσει το κουμπί 'Save'
        {
            if(empty($_POST['d_name'])||empty($_POST['about'])||$_POST['price']==''||$_POST['res_name']=='')     //Αν δεν έχουν δωθεί τιμές σε συγκεκριμένα πεδία
            {	
                $error='<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>All fields must be fill up.</strong>
                        </div>';                 
            }
            else{
                $fname = $_FILES['file']['name'];           //Αποθήκευση των στοιχείων της εικόνας σε κατάλληλες μεταβλητές
                $temp = $_FILES['file']['tmp_name'];
                $fsize = $_FILES['file']['size'];
                $extension = explode('.',$fname);           //Χρηση της explode με σκοπό τον διαχωρισμό του ονόματος της εικόνας από την κατάληξη του αρχείου (π.χ png)
                $extension = strtolower(end($extension));   //Χρήση της strtolower με σκοπό την μετατροπή όλων των καταλήξεων των αρχείων εικόνας σε πεζά
                $fnew = uniqid().'.'.$extension;            //Χρήση της uniqid με σκοπό την δημιουργία ενός μοναδικού ονόματος για το αρχείο της εικόνας
                $store = "Res_img/dishes/".basename($fnew);     //Η τελική τοποθεσία αποθήκευσης του αρχείου της εικόνας         

                if($extension == 'jpg'||$extension == 'png'||$extension == 'gif')
                {        
                    if($fsize>=1000000){            //Αν το μέγεθος της εικόνας είναι > 1ΜΒ
                        $error='<div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Max image size is 1ΜΒ. </strong> Try different image.
                                </div>';
                    }
                    else{   
                        $sql = "INSERT INTO dishes(rs_id,title,slogan,price,img) VALUE('".$_POST['res_name']."','".$_POST['d_name']."','".$_POST['about']."','".$_POST['price']."','".$fnew."')";   //Εισαγωγή του νέου dish (με τα εισαχθέντα στοιχεία) στην βάση
                        mysqli_query($db, $sql); 
                        move_uploaded_file($temp, $store);      //Μεταφορά του αρχείου της εικόνας στο store, με σκοπό την μόνιμη αποθήκευση της στον διακομιστή
                        $success='<div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    New Dish added successfully!
                                </div>';
                    }
                }
                elseif($extension == ''){           //Αν η εικόνα που προσπαθεί να ανεβάσει ο χρήστης έχει κενή επέκταση
                    $error='<div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Select image.</strong>
                            </div>';
                }else{          //Αν η εικόνα που προσπαθεί να ανεβάσει ο χρήστης έιναι διάφορη των jpg, png, και gif
                    $error='<div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Invalid extension!</strong>pngs, jpgs and gifs are accepted.
                            </div>';
                }               
            }
        }
    ?>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">   
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
        <title>Add Menu</title>
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    </head>


    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>
        <div id="main-wrapper">
            <div class="header bg-dark">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">
                    <div class="navbar-header bg-dark">
                        <a class="navbar-brand" href="dashboard.php"> <span style="color:#fff; font-weight:bold">myOnlineDelivery</span> </a>
                    </div>
                    <div class="navbar-collapse">
                        <ul class="navbar-nav mr-auto mt-md-0"></ul>
                        <ul class="navbar-nav my-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/bookingSystem/user-icn.png" alt="user" class="profile-pic" /></a>
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
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Home</li>
                            <li> <a href="dashboard.php"><i class="fa fa-tachometer text-white"></i><span class="text-white">Dashboard</span></a></li>
                            <li class="nav-label">Log</li>
                            <li> <a href="all_users.php">  <span><i class="fa fa-user f-s-20 text-white"></i></span><span class="text-white">Users</span></a></li>
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
                    <?php  
                        echo $error;
                        echo $success; 
                    ?>
                    <div class="col-lg-12">
                        <div class="card card-outline-primary bg-dark">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white text-center">Add Dish</h4>
                            </div>
                            <div class="card-body">
                                <form action='' method='post'  enctype="multipart/form-data">
                                    <div class="form-body">
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Dish Name</label>
                                                    <input type="text" name="d_name" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Description</label>
                                                    <input type="text" name="about" class="form-control form-control-danger" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Price</label>
                                                    <input type="text" name="price" class="form-control" placeholder="€">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Image</label>
                                                    <input type="file" name="file"  id="lastName" class="form-control form-control-danger" placeholder="12n">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Restaurant</label>
                                                    <select name="res_name" class="form-control custom-select bg-white" data-placeholder="Choose a Category" tabindex="1">
                                                        <option>--Select--</option>
                                                        <?php
                                                            $ssql ="select * from restaurant";
                                                            $res=mysqli_query($db, $ssql); 
                                                            while($row=mysqli_fetch_array($res))  
                                                            {
                                                                echo' <option value="'.$row['rs_id'].'">'.$row['title'].'</option>';;
                                                            }  
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-primary" value="Save"> 
                                        <a href="add_menu.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    
        <script src="js/lib/jquery/jquery.min.js"></script>
        <script src="js/lib/bootstrap/js/popper.min.js"></script>
        <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery.slimscroll.js"></script>
        <script src="js/sidebarmenu.js"></script>
        <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="js/custom.min.js"></script>
    </body>
</html>