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
							<li class="nav-item">
									<a class="nav-link" href="userPersonalize.php">Personalize</a>
							</li>
							<li class="nav-item active">
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

	  	if(isset($_GET['actorId'])){

				$actorId = $_GET['actorId'];
				$query = "SELECT * FROM actors WHERE id=".$actorId;
				$actorDetails = mysqli_query($dbc, $query);
				$row = mysqli_fetch_array($actorDetails);
?>
				<div class="container">
					<div class=" row">
						<img style=" max-height: 150px; " class=" img-thumbnail mr-4 mt-4" src="../images/utill/<?php echo $row['gender'] ?>.png" alt="Thumbnail image">
						<div class=" lato col">
							<h1 class=" col-xs-10 mt-4 col-sm-14 col-md-7 col-lg-8 col-lg-offset-1 display-4 mb-0 "><?php echo $row['firstName']." ".$row['lastName']; ?></h1><br>
							<h5><?php echo $row['bio']."<br>"; ?></h5>
						</div>
					</div>
					<hr>
<?php
						$query = "SELECT * FROM actors AS a, movies AS m, movie_actors AS ma WHERE a.id=ma.actor_id AND ma.movie_id=m.id AND a.id=".$actorId;
						$actorDetails = mysqli_query($dbc, $query);
						if(mysqli_num_rows($actorDetails) > 0){

							echo '<div class="lato display-4 mb-3">Other Movies</div>';

							while($row = mysqli_fetch_array($actorDetails))
								echo '<a href=userView.php?movieId='.$row['id'].'><div class="media mb-2"><img class="mr-3 align-self-center" style="max-height: 100px;" src="../images/posters/'.$row['title'].'(main).jpg"><div class="media-body"><h5>'.$row['title'].'</h5></div></div></a>';

						}
?>
				</div>
<?php

	    }else if(isset($_GET['directorId'])){

				$directorId = $_GET['directorId'];
				$query = "SELECT * FROM director WHERE id=".$directorId;
				$directorDetails = mysqli_query($dbc, $query);
				$row = mysqli_fetch_array($directorDetails);
?>
				<div class="container">
					<div class=" row">
						<img style=" max-height: 150px; " class=" img-thumbnail mr-4 mt-4" src="../images/utill/<?php echo $row['gender'] ?>.png" alt="Thumbnail image">
						<div class=" lato col">
							<h1 class=" col-xs-10 mt-4 col-sm-14 col-md-7 col-lg-8 col-lg-offset-1 display-4 mb-0 "><?php echo $row['firstName']." ".$row['lastName']; ?></h1><br>
							<h5><?php echo $row['bio']."<br>"; ?></h5>
						</div>
					</div>
					<hr>
<?php
						$query = "SELECT * FROM director AS d, movies AS m WHERE m.director_id=d.id AND d.id=".$directorId;
						$directorDetails = mysqli_query($dbc, $query);
						if(mysqli_num_rows($directorDetails) > 0){

							echo '<div class="lato display-4 mb-3">Other Movies</div>';

							while($row = mysqli_fetch_array($directorDetails))
								echo '<a href=userView.php?movieId='.$row['id'].'><div class="media mb-2"><img class="mr-3 align-self-center" style="max-height: 100px;" src="../images/posters/'.$row['title'].'(main).jpg"><div class="media-body"><h5>'.$row['title'].'</h5></div></div></a>';

						}
?>
				</div>
<?php

	    }else if(isset($_GET['movieId'])){

				$query = "SELECT * FROM movies, director WHERE movies.director_id=director.id AND movies.id=".$_GET['movieId'];
				$results = mysqli_query($dbc, $query);
				$movieDirector = mysqli_fetch_array($results);

				$query = "SELECT * FROM movies m, movie_actors ma, actors a WHERE m.id=ma.movie_id AND ma.actor_id=a.id AND m.id=".$_GET['movieId'];
				$results = mysqli_query($dbc, $query);
				$movieActors = $results;

				$query = "SELECT title, g.name FROM movies m, movie_genre mg, genres g WHERE m.id=mg.movie_id AND mg.genre_id=g.id AND m.id=".$_GET['movieId'];
				$results = mysqli_query($dbc, $query) or die("cant issue query");
				$movieGenres = $results;

?>
				<div class="container" style="margin-bottom: 50px;">
					<div class="row">
						<img style=" max-height: 400px; " class="img-thumbnail mr-4 mt-4" src="../images/posters/<?php echo $movieDirector['title'] ?>(main).jpg" alt="Thumbnail image">
						<div class="col-xs-10 mt-4 col-sm-14 col-md-7 col-lg-8 col-lg-offset-1">
							<h1 class="display-4 mb-0"><?php echo $movieDirector['title'] ?></h1><br>
							<h5><?php echo $movieDirector['releasedYear']."<br>";
								while($genre = mysqli_fetch_array($results))
								echo $genre['name']." / ";
								echo '<br><br>';
								echo $movieDirector['description']; ?>
							</h5>
						</div>
					</div>

					<div class="h4 mb-3 mt-3">Screenshots</div>
					<hr>

					<div class="row">
						<div class="col-6">
							<img class="img-fluid" src="../images/screenshots/<?php echo $movieDirector['title'] ?>.jpg">
						</div>
						<div class="col-6">
							<img class="img-fluid" src="../images/screenshots/<?php echo $movieDirector['title']?>(1).jpg">
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="h4 mb-3">Director</div><hr>
							<a href="userView.php?directorId=<?php echo $movieDirector['director_id']; ?>"><?php echo $movieDirector['firstName']." ".$movieDirector['lastName']; ?></a>
						</div>
						<div class="col-xs-12 col-sm-9 col-md-6">
							<div class="h4 mb-3">Main Cast</div><hr>
							<?php
							while($actor = mysqli_fetch_array($movieActors)){

								echo '<div  class="mb-2"><a href="userView.php?actorId='.$actor['id'].'">'.$actor['firstName'].' '.$actor['lastName'].'</a> <span class="mr-2 ml-2" >as</span> <span class="text-muted">'.$actor['played'].'</span></div>';

							}

						?>
					</div>
				 </div>

			</div>
<?php
	    }
		}else{
			echo '<div class="alert alert-danger" role="alert"><strong>OOPS!</strong> Session expired you need to login first/again.<a href="../index.php"> Home</a></div>';
		}
?>
</body>
