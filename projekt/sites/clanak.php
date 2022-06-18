<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/design.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <link href="//db.onlinewebfonts.com/c/d592bb492b28515987de431a85f70054?family=Marr+Sans+Cond+Web+Bold" rel="stylesheet" type="text/css"/>
    <script src="../js/bootstrap.min.js"></script>
    <title>Le Monde - Članak</title>
  </head>
  <header>

    <div class="row">
      <div class="col-md-6 offset-md-3"><img src="../img/lemonde.png" class="logo"></div>
    </div>
    

  </header>
  <body>
        <?php

            include 'connect.php';
            define('UPLPATH', '../img/');
       
            $query = "SELECT * FROM articles WHERE id=".$_GET['id']."";
            $result = mysqli_query($dbc, $query);
            $row = mysqli_fetch_array($result);
        ?>
    <nav>
      <ul class="nav">
          <li><a href="../index.php">HOME</a></li>
          <li><a <?php if($row['category'] == "Politika") echo "class='active'"; ?> href="category.php?cat=Politika">POLITIQUE</a></li>
          <li><a <?php if($row['category'] == "Sport") echo "class='active'"; ?> href="category.php?cat=Sport">SPORT</a></li>
          <li><a href="admin.php">ADMINISTRACIJA</a></li>
          <li><a href="unos.html">UNOS</a></li>
      </ul>
    </nav>

    <div class="content" style="margin-top:40px; padding-bottom:40px;">
           
        <h2 class="category"><?php
            echo "<span>".$row['category']."</span>";
        ?></h2>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h1 class="title"><?php
                    echo $row['title'];
                ?></h1>
                <p>OBJAVLJENO: <?php
                    echo "<span>".$row['date']."</span>";
                ?></p>
            </div>
            <div class="col-md-10 offset-md-1">
                <?php
                    echo '<img width="100%" src="' . UPLPATH . $row['image'] . '">';
                ?>
            </div>
            <div class="col-md-10 offset-md-1">
                <p>
                    <?php
                        echo "<i>".$row['short_desc']."</i>";
                    ?>
                </p>
            </div>
            <div class="col-md-10 offset-md-1">
                <p>
                    <?php
                       echo $row['text'];
                    ?>
                </p>
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