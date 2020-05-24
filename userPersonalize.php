<?php
	session_start();

?>
<html>
	<head>
		<title>Movie Hunger - Trending Moives</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Lato:400" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../css/style2.css">
	</head>

	<body>
<?php
	if(!empty($_SESSION['email'])){
?>
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
			<div class="container">
				<a class="navbar-brand" style=" color: #f39c12; " href="#">Movie Hunger</a>
				<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
							<li class="nav-item">
									<a class="nav-link" href="userHomepage.php">Home</a>
							</li>
							<li class="nav-item active">
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
						<input type="text" class="form-control mr-2" name="searchString" placeholder="Search...">
						<button name="searchSubmit" class="btn btn-outline-light">Search</button>
					</form>
				</div>
			</div>
		</nav>

<?php

			$dbc = mysqli_connect('localhost', 'root', 'arjun007', 'movie_hunger') or die("couldn't connect to DB at line 46");

      if(isset($_POST['update'])){

          $query = "SELECT * FROM users WHERE email='".$_SESSION['email']."' AND password='".$_POST['oldPassword']."'";
          $results = mysqli_query($dbc, $query);

          if(mysqli_num_rows($results) == 1){
              if(!empty($_POST['password']) && !empty($_POST['rptPassword'])){
                  $query = "UPDATE users SET firstName='".$_POST['firstName']."', lastName='".$_POST['lastName']."', phone=".$_POST['phNo'].", password='".$_POST['password']."' WHERE email='".$_SESSION['email']."'";
                  $results = mysqli_query($dbc, $query) or die("Couldn't issue UPDATE query at line 63");
                  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>YEAH!</strong> Details updated successfully. Thankyou for Updating with us.
                        </div>';
              }else{
                  $query = "UPDATE users SET firstName='".$_POST['firstName']."', lastName='".$_POST['lastName']."', phone=".$_POST['phNo']." WHERE email='".$_SESSION['email']."'";
                  $results = mysqli_query($dbc, $query) or die("Couldn't issue UPDATE query at line 66");
                  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>YEAH!</strong> Details updated successfully. Thankyou for Updating with us.
                        </div>';
              }
          }else{
              echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>Uh Oh!</strong> Old password seems to be wrong.
                    </div>';
          }

      }

      $query = "SELECT * FROM users WHERE email='".$_SESSION['email']."'";
      $results = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($results);
?>
      <div class="container">
          <form onsubmit="return updateValidate()" name="update" action="userPersonalize.php" method="post">
              <div class="form-group">
                  <label for="name">First Name</label>
                  <input class="form-control" type="text" id="firstName" name="firstName" value="<?php echo $row['firstName']; ?>" placeholder="Enter first name">
              </div>
              <div class="form-group">
                  <label for="name">Last Name</label>
                  <input class="form-control" type="text" id="lastName" name="lastName" value="<?php echo $row['lastName']; ?>" placeholder="Enter last name">
              </div>
              <div class="form-group">
                  <label for="email">Email address</label>
                  <input class="form-control" type="email" id="email" name="email" value="<?php echo $row['email']; ?>"  placeholder="Enter email" readonly>
                  <small class="form-text text-muted">Your email cannot be changed</small>
              </div>
              <div class="form-group">
                  <label for="company">Phone</label>
                  <input class="form-control" type="number" id="phNo" name="phNo" value="<?php echo $row['phone']; ?>" placeholder="Enter phone number">
              </div>
              <div class="form-group">
                  <label for="password">Password</label>
                  <input class="form-control" type="password" id="password" name="password" placeholder="Password">
              </div>
              <div class="form-group">
                  <label for="password">Repeat Password</label>
                  <input class="form-control" type="password" id="rptPassword" name="rptPassword" placeholder="Repeat Password">
              </div>
              <hr>
              <div class="form-group">
                  <label for="password">Password</label>
                  <input class="form-control" type="password" name="oldPassword" required placeholder="Old Password">
                  <small class="form-text text-muted">You need to enter your old password to continue</small>
              </div>
              <div id="updateErrorInfo" class="text-danger">*</div>
              <button class="btn btn-light float-right" name="update" type="submit">Submit</button>
          </form>
      </div>
<?php
  }else{

    echo '<div class="alert alert-danger" role="alert"><strong>OOPS!</strong> Session expired you need to login first/again.<a href="../index.php"> Home</a></div>';

  }
?>
    <script src="../javascript/funtion.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
</html>
