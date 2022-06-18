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
    <title>Le Monde - Unos</title>
  </head>
  <header>

    <div class="row">
      <div class="col-md-6 offset-md-3"><img src="../img/lemonde.png" class="logo"></div>
    </div>
    

  </header>
  <body>
    <nav>
      <ul class="nav">
          <li><a class="active" href="../index.php">HOME</a></li>
          <li><a href="category.php?cat=Politika">POLITIQUE</a></li>
          <li><a href="category.php?cat=Sport">SPORT</a></li>
          <li><a href="admin.php">ADMINISTRACIJA</a></li>
          <li><a href="unos.html">UNOS</a></li>
      </ul>
    </nav>

    <div class="content">
        <?php


            if(isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['content']) && isset($_FILES['image']['name'])){

              include 'connect.php';
              $picture = $_FILES['image']['name'];
              $title=$_POST['title'];
              $about=$_POST['desc'];
              $content=$_POST['content'];
              $category=$_POST['category'];
              $date=date('Y-m-d');

              if(isset($_POST['archive'])){
               $archive=1;
              }else{
               $archive=0;
              }

              $target_dir = '../img/'.$picture;
              move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir);


              $query = "INSERT INTO articles ( title, date, short_desc, text, image, category,
              archive ) VALUES ( ?, ?, ?, ?, ?, ?, ?)";

              $stmt = mysqli_stmt_init($dbc);

              if (mysqli_stmt_prepare($stmt, $query)){
                
                mysqli_stmt_bind_param($stmt,'ssssssi',$title, $date, $about, $content, $picture, $category, $archive);
                
                mysqli_stmt_execute($stmt);
              }
               
              echo "Uspješno uneseno!";

              mysqli_close($dbc);
             

            } else {
              echo "Molimo unesite sve podatke!";
            }

        ?>
    </div>
    
  </body>

  <footer>
    <div class="row">
      <div class="col-md-2"><p>Dorian Hajnić, 2022</p></div>
      <div class="col-md-2 offset-md-8" ><p style="float:right">dhajnic@tvz.hr</p></div>
    </div>
  </footer>

</html>
