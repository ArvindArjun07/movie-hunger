<html>
    <head>
        <title>Welcome to Movie Hunger</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato:400" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/style2.css">
    </head>
    <body>

             <?php

                session_start();

                $dbc = mysqli_connect('localhost','root','arjun007','movie_hunger') or die("Couldn't connect to databse at line 20");

                function setUserCookie($email, $firstName, $lastName){

                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $firstName.' '.$lastName;

                }

                function navbar(){
             ?>
                    <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
                         <div class="container">
                            <a class="navbar-brand" style=" color: #f39c12; " href="#">Movie Hunger</a>
                            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="userHomepage.php">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="userPersonalize.php">Personalize</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="userSearch.php?searchString=">Search</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="logout.php">Logout <?php echo "<span class='text-muted'>(".$_SESSION['username'].")</span>"; ?></a>
                                    </li>
                                </ul>

                                <form class="form-inline ml-auto" action="userSearch.php">
                                    <input type="text" name="searchString" class="form-control mr-2" placeholder="Search...">
                                    <button name="searchSubmit" class="btn btn-outline-light">Search</button>
                                </form>
                            </div>
                        </div>
                    </nav>
             <?php
                }

                function showcase(){

                    $query = "SELECT * FROM movies LIMIT 22,3";
                    $results = mysqli_query($GLOBALS['dbc'], $query) or die("Couldn't issue SELECT query at line 66");
                    $row = mysqli_fetch_array($results);

                    $id1 = $row['id'];
                    $title1 = $row['title'];
                    $image1 = $title1."(main).jpg";
                    $description1 = $row['description'];

                    $row = mysqli_fetch_array($results);

                    $id2 = $row['id'];
                    $title2 = $row['title'];
                    $image2 = $title2."(main).jpg";
                    $description2 = $row['description'];

                    $row = mysqli_fetch_array($results);

                    $id3 = $row['id'];
                    $title3 = $row['title'];
                    $image3 = $title3."(main).jpg";
                    $description3 = $row['description'];

             ?>
                    <div class="container">

                       <div class="display-3 mb-3 text-light">Trending Movies</div>
                        <div class="card-columns">
                            <div class="card">
                                <img class="card-img-top img-fluid" src="../images/posters/<?php echo $image1; ?>" alt="">
                                <div class="card-body text-dark">
                                    <h4 class="card-title"><?php echo $title1; ?></h4>
                                    <p class="card-text"><?php echo $description1; ?></p>
                                </div>
                            </div>
                            <a href="userPersonalize.php">
                                <div class="card p-3 bg-dark text-white">
                                    <blockquote>
                                        <p class="display-4">Personalize.</p>
                                        <footer>
                                            <small>
                                                You know? you can personalize this page to show you the best picks as per your interests.
                                            </small>
                                        </footer>
                                    </blockquote>
                                </div>
                            </a>
                            <div class="card">
                                <img class="card-img-top img-fluid" src="../images/posters/<?php echo $image2; ?>" alt="">
                                <div class="card-body text-dark">
                                    <h4 class="card-title"><?php echo $title2 ?></h4>
                                    <p class="card-text"><?php echo $description2 ?></p>
                                </div>
                            </div>
                            <div class="card">
                                <img class="card-img-top img-fluid" src="../images/posters/<?php echo $image3; ?>" alt="">
                                <div class="card-body text-dark">
                                    <h4 class="card-title"><?php echo $title3 ?></h4>
                                    <p class="card-text"><?php echo $description3 ?></p>
                                </div>
                            </div>
                        </div>

                    </div>

             <?php
                }

                if(isset($_POST['signupProcess'])){

                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $phno = $_POST['phNo'];
                    $gender = $_POST['gender'];

                    $query = "INSERT INTO users(email, firstName, lastName, password, gender, phone) VALUES('$email', '$firstName', '$lastName', '$password', '$gender', '$phno')";
                    $result = mysqli_query($dbc,$query) or die("couldn't isuue INSERT query at line 26");

                    if($result){

                        echo '<div class="alert alert-success mb-0" role="alert"><strong>YEAH! You have successfully registered.</strong> The website is all yours now.</div>';
                        setUserCookie($email, $firstName, $lastName);
                        navbar();
                        showcase();

                    }else{

                        echo '<div class="alert alert-danger" role="alert"><strong>OOPS!</strong> Seems like we can\'t do that. If you are a registered user you can login directly</div>';

                    }

                }else if(isset($_POST['loginProcess']) and empty($_SESSION['email'])){

                    $email = $_POST['loginEmail'];
                    $password = $_POST['loginPassword'];

                    $query = "SELECT * FROM users WHERE email='".$email."'AND password='".$password."'";
                    $result = mysqli_query($dbc, $query) or die("couldn't issue SELECT query at line 80");
                    $row = mysqli_fetch_array($result);

                    if(!empty($row['email']) and !empty($row['password'])){

                        echo '<div class="alert alert-success mb-0" role="alert"><strong>Welcome.</strong> Login successful.</div>';
                        setUserCookie($email, $row['firstName'], $row['lastName']);
                        navbar();
                        showcase();

                    }else{

                        echo '<div class="alert alert-danger" role="alert"><strong>OOPS!</strong> Seems like we can\'t do that. If you are a registered user check the email and password. Or else you need to register first. <a href="../index.php">Home</a></div>';

                    }

                }else if(!empty($_SESSION['email'])){

                    navbar();
                    showcase();

                }else{

                    echo '<div class="alert alert-danger" role="alert"><strong>OOPS!</strong> Session expired you need to login first/again.<a href="../index.php"> Home</a></div>';

                }

            ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    </body>
</html>
