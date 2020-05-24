<?php
  session_start();

  function showAllResults(){

    $dbc = mysqli_connect('localhost','root','arjun007','movie_hunger') or die("Couldn't connect to databse");

    if(isset($_GET['genreId'])){
      $query = "SELECT m.id, title, description , CONCAT(d.firstName, ' ', d.lastName) AS dirName, g.name FROM movies as m, director as d, genres as g, movie_genre as mg
                WHERE m.director_id=d.id AND m.id=mg.movie_id AND mg.genre_id=g.id AND g.id=".$_GET['genreId'];
    }else{
      $query = "SELECT * FROM movies";
    }
    $results = mysqli_query($dbc, $query);
    $noOfResults = mysqli_num_rows($results);

    $stepSize = 10;
    if(!isset($_GET['curPage']))
      $curPage = 0;
    else
      $curPage = $_GET['curPage'] - 1;

    $from = $curPage * $stepSize;
    $reqPages = ceil($noOfResults / $stepSize);

    $query = "SELECT movies.id, title, description , CONCAT(director.firstName, ' ', director.lastName) AS dirName FROM movies, director WHERE movies.director_id=director.id LIMIT ".$from.", ".$stepSize;
    $results = mysqli_query($dbc, $query);

    echo '<div class="container">';
?>
    <div class="dropdown float-right">
      Sort by:  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Genre</button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <a class="dropdown-item" href="userSearch.php?genreId=1">Action</a>
        <a class="dropdown-item" href="userSearch.php?genreId=2">Adventure</a>
        <a class="dropdown-item" href="userSearch.php?genreId=8">Animation</a>
        <a class="dropdown-item" href="userSearch.php?genreId=12">Biography</a>
        <a class="dropdown-item" href="userSearch.php?genreId=3">Comedy</a>
        <a class="dropdown-item" href="userSearch.php?genreId=9">Crime</a>
        <a class="dropdown-item" href="userSearch.php?genreId=6">Drama</a>
        <a class="dropdown-item" href="userSearch.php?genreId=14">Family</a>
        <a class="dropdown-item" href="userSearch.php?genreId=7">Fantasy</a>
        <a class="dropdown-item" href="userSearch.php?genreId=15">History</a>
        <a class="dropdown-item" href="userSearch.php?genreId=13">Horror</a>
        <a class="dropdown-item" href="userSearch.php?genreId=17">Musical</a>
        <a class="dropdown-item" href="userSearch.php?genreId=11">Mystery</a>
        <a class="dropdown-item" href="userSearch.php?genreId=4">Romance</a>
        <a class="dropdown-item" href="userSearch.php?genreId=5">Sci-Fi</a>
        <a class="dropdown-item" href="userSearch.php?genreId=18">Short</a>
        <a class="dropdown-item" href="userSearch.php?genreId=10">Thriller</a>
        <a class="dropdown-item" href="userSearch.php?genreId=16">War</a>
      </div>
    </div>
    <br><br>
<?php
    if(isset($_GET['genreId'])){
      $query = "SELECT m.id, title, description , CONCAT(d.firstName, ' ', d.lastName) AS dirName, g.name FROM movies as m, director as d, genres as g, movie_genre as mg
                WHERE m.director_id=d.id AND m.id=mg.movie_id AND mg.genre_id=g.id AND g.id=".$_GET['genreId']." LIMIT ".$from.", ".$stepSize;
      $extendUrl = "genreId=".$_GET['genreId'];
    }else{
      $query = "SELECT movies.id, title, description , CONCAT(director.firstName, ' ', director.lastName) AS dirName FROM movies, director
                WHERE movies.director_id=director.id LIMIT ".$from.", ".$stepSize;
      $extendUrl = "";
    }
    $results = mysqli_query($dbc, $query);
    foreach ($results as $row) {
?>
        <a href="userView.php?movieId=<?php echo $row['id']; ?>">
            <div class="media mb-3">
                <img style=" width:100px; " class="mr-3 align-self-center" src="../images/posters/<?php echo $row['title']."(main).jpg"; ?>">
                <div class="media-body  text-white">
                    <h5><?php  echo $row['title']; ?></h5>
                    <div class="text-secondary"><?php echo $row['description']; ?></div>
                </div>
            </div>
        </a>

<?php
    }
?>
      <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end">
              <li class="page-item  <?php if($curPage+1 == 1) echo " disabled"; ?>">
                  <a class="page-link" href="userSearch.php?curPage=<?php echo $curPage; ?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                  </a>
              </li>
<?php
              for($i=1; $i <= $reqPages; $i++){

                if($curPage+1 != $i)
                  echo '<li class="page-item"><a class="page-link" href="userSearch.php?curPage='.$i.'">'.$i.'</a></li>';
                else
                  echo '<li class="page-item active"><a class="page-link" href="userSearch.php?curPage='.$i.'">'.$i.'</a></li>';

              }
?>
              <li class="page-item<?php if($curPage+1 == $reqPages) echo " disabled"; ?>">
                  <a class="page-link" href="userSearch.php?curPage=<?php echo $curPage+2; ?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                  </a>
              </li>
          </ul>
      </nav>
  </div>

<?php
  }
?>

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
<?php if(!empty($_SESSION['email'])){ ?>
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
          <input type="text" name="searchString" class="form-control mr-2" placeholder="Search...">
          <button name="searchSubmit" class="btn btn-outline-light">Search</button>
        </form>
      </div>
    </div>
  </nav>

<?php

    $dbc = mysqli_connect('localhost','root','arjun007','movie_hunger') or die("Couldn't connect to databse at line 20");

    if(empty($_GET['searchString'])){

      showAllResults();

    }else if(isset($_GET['searchString'])){

       $searchStringDup = $_GET['searchString'];
       $searchString = $_GET['searchString'];
       $searchKeywords = explode(" ", $searchString);
       $replaceWith = "%'"." OR title LIKE "."'%";
       $searchString = implode($replaceWith, $searchKeywords);

       $query = "SELECT * FROM movies WHERE title LIKE '%".$searchString."%'";
       // echo $query;
       // exit;
       $results = mysqli_query($dbc, $query) or die("Cant' isuue SELECT query at line 142");

       if(mysqli_num_rows($results)>1){

         $noOfResults = mysqli_num_rows($results);
         $stepSize = 10;
         if(!isset($_GET['searchCurPage']))
           $searchCurPage = 0;
         else
           $searchCurPage = $_GET['searchCurPage'] - 1;
         $from = $searchCurPage * $stepSize;
         $reqPages = ceil($noOfResults / $stepSize);

         $searchString = $searchString.'%\' LIMIT '.$from.', '.$stepSize;
         $query = "SELECT * FROM movies WHERE title LIKE '%".$searchString;
         $results = mysqli_query($dbc, $query);

         echo '<div class="container">';
            while($row = mysqli_fetch_array($results)){
?>
              <a href="userView.php?movieId=<?php echo $row['id']; ?>">
                  <div class="media mb-3">
                      <img style=" width:100px; " class="mr-3 align-self-center" src="../images/posters/<?php echo $row['title']."(main).jpg"; ?>">
                      <div class="media-body  text-white">
                          <h5><?php  echo $row['title']; ?></h5>
                          <div class="text-secondary"><?php echo $row['description']; ?></div>
                      </div>
                  </div>
              </a>

<?php
            }
?>
          <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                  <li class="page-item  <?php if($searchCurPage+1 == 1) echo " disabled"; ?>">
                      <a class="page-link" href="userSearch.php?searchString=<?php echo $searchStringDup ?>&searchCurPage=<?php echo $searchCurPage; ?>" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                      </a>
                  </li>
          <?php
                  for($i=1; $i <= $reqPages; $i++){

                    if($searchCurPage+1 != $i)
                      echo '<li class="page-item"><a class="page-link" href="userSearch.php?searchString='.$searchStringDup.'&searchCurPage='.$i.'">'.$i.'</a></li>';
                    else
                      echo '<li class="page-item active"><a class="page-link" href="userSearch.php?searchString='.$searchStringDup.'&searchCurPage='.$i.'">'.$i.'</a></li>';

                  }
          ?>
                  <li class="page-item<?php if($searchCurPage+1 == $reqPages) echo " disabled"; ?>">
                      <a class="page-link" href="userSearch.php?searchString=<?php echo $searchStringDup ?>&amp;searchCurPage=<?php echo $searchCurPage+2; ?>" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                      </a>
                  </li>
              </ul>
          </nav>
         </div>
<?php
       }else if(mysqli_num_rows($results) == 1){

         $row = mysqli_fetch_array($results);
         $home_url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/userView.php?movieId='.$row['id'];
         header('Location:'.$home_url);

       }else{

         echo '<div class="alert alert-danger" role="alert"><strong>UH! OH!</strong> Seems like we don\'t have such a movie in the database. No Wories you have lot more than that. </div>';
         showAllResults();

       }

    }else if(isset($_GET['curPage'])){

      showAllResults();

    }
  }else{
    echo '<div class="alert alert-danger" role="alert"><strong>OOPS!</strong> Session expired you need to login first/again.<a href="../index.php"> Home</a></div>';
  }
?>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
