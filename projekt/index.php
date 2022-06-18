<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <link href="//db.onlinewebfonts.com/c/d592bb492b28515987de431a85f70054?family=Marr+Sans+Cond+Web+Bold" rel="stylesheet" type="text/css"/>
    <script src="js/bootstrap.min.js"></script>
    <title>Le Monde - Home</title>
  </head>
  <header>

    <div class="row">
      <div class="col-md-6 offset-md-3"><img src="img/lemonde.png" class="logo"></div>
    </div>
    

  </header>
  <body>
    <nav>
      <ul class="nav">
          <li><a class="active" href="index.php">HOME</a></li>
          <li><a href="sites/category.php?cat=Politika">POLITIQUE</a></li>
          <li><a href="sites/category.php?cat=Sport">SPORT</a></li>
          <li><a href="sites/admin.php">ADMINISTRACIJA</a></li>
          <li><a href="sites/unos.html">UNOS</a></li>
      </ul>
    </nav>

    <div class="content">
    <?php
      include 'sites/connect.php';
      define('UPLPATH', 'img/');
    ?>

      <div class="category">
        <h1>Politique</h1>
        <div class="row">
        <?php
          $query = "SELECT * FROM articles WHERE archive=0 AND category='politika' LIMIT 3";
          $result = mysqli_query($dbc, $query);
          $i=0;
          while($row = mysqli_fetch_array($result)) {
          
          echo'<div class="article col-md-4">';
          echo '<a href="sites/clanak.php?id='.$row['id'].'">';
          echo '<img src="' . UPLPATH . $row['image'] . '">';
          echo '<h2>';
          echo $row['title'];
          echo '</h2></a>';
          echo '</div>';
          
        }
      ?> 
          
          
    
        </div>
      </div>
      <div class="category">
        <h1>Sport</h1>
        <div class="row">
        <?php
          $query = "SELECT * FROM articles WHERE archive=0 AND category='sport' LIMIT 3";
          $result = mysqli_query($dbc, $query);
          $i=0;
          while($row = mysqli_fetch_array($result)) {
          
          echo'<div class="article col-md-4">';
          echo '<a href="sites/clanak.php?id='.$row['id'].'">';
          echo '<img src="' . UPLPATH . $row['image'] . '">';
          echo '<h2>';
          echo $row['title'];
          echo '</h2></a>';
          echo '</div>';
          
        }
      ?> 
        </div>
      </div>
      
    </div>
    
  </body>

  <footer>
    <div class="row">
      <div class="col-md-2"><p>Dorian Hajnić, 2022</p></div>
      <div class="col-md-2 offset-md-8" ><p style="float:right">dhajnic@tvz.hr</p></div>
    </div>
  </footer>

</html>