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
  
  <body>
    <header>

      <div class="row">
        <div class="col-md-6 offset-md-3"><img src="../img/lemonde.png" class="logo"></div>
      </div>
      
  
    </header>
    <nav>
      <ul class="nav">
          <li><a href="../index.php">HOME</a></li>
          <li><a href="category.php?cat=Politika">POLITIQUE</a></li>
          <li><a href="category.php?cat=Sport">SPORT</a></li>
          <li><a class="active" href="admin.php">ADMINISTRACIJA</a></li>
          <li><a href="unos.html">UNOS</a></li>
      </ul>
    </nav>

    <div class="content">
        <div class="forma row">
            <?php
                include 'connect.php';
                define('UPLPATH', '../img/');
                
                $msg = '';

                if(isset($_POST['username']) && isset($_POST['pass'])){

                    $username = $_POST['username']; 
                    $lozinka = $_POST['pass']; 

                    //Provjera postoji li u bazi već korisnik s tim korisničkim imenom 
                    $sql = "SELECT * FROM users WHERE username = ?"; 
                    $stmt = mysqli_stmt_init($dbc); 
                    if (mysqli_stmt_prepare($stmt, $sql)) { 
                        mysqli_stmt_bind_param($stmt, 's',  $username);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt); 
                    } 
                    mysqli_stmt_bind_result($stmt, $id, $ime, $prezime, $username, $hashpass, $admin);
                    mysqli_stmt_fetch($stmt);
                    
                    if(password_verify($lozinka, $hashpass) && mysqli_stmt_num_rows($stmt) > 0){
                        
                        $_SESSION['id'] = $id;
                        $_SESSION['ime'] = $ime;
                        $_SESSION['prezime'] = $prezime;
                        $_SESSION['username'] = $username;
                        $_SESSION['admin'] = $admin;
                        $_SESSION['login'] = true;
                        
                    } else echo '<div class="col-md-12"><b>Pogrešno korisničko ime ili lozinka!</b></div>'; 
                    
                    
                } 
            ?>
            <?php         
               
                if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
            ?>
                
                <section role="main">
                    <form enctype="multipart/form-data" action="" method="POST">
                        <div class="form-item">
                            <span id="porukaUsername" class="bojaPoruke"></span>

                            <label for="content">Korisničko ime:</label>
                            <!-- Ispis poruke nakon provjere korisničkog imena u bazi -->
                            <div class="form-field">
                                <input type="text" name="username" id="username" class="formfield-textual">
                                <?php echo '<br><span class="bojaPoruke">'.$msg.'</span>'; ?>
                            </div>
                        </div>
                        <div class="form-item">
                            <span id="porukaPass" class="bojaPoruke"></span>
                            <label for="pphoto">Lozinka: </label>
                            <div class="form-field">
                                <input type="password" name="pass" id="pass" class="formfield-textual">
                            </div>
                        </div>

                        <div class="form-item">
                            <br>
                            <button type="submit" value="Prijava" id="slanje">Prijava</button>
                        </div>
                    </form>
                    Niste registrirani?
                    <a href="registracija.php">Registracija</a>
                    
                </section>
                
            <?php
            } else if($_SESSION['admin'] == 1){
                if(isset($_POST['delete'])){
                    $id=$_POST['id'];
                    $query = "DELETE FROM articles WHERE id=$id ";
                    $result = mysqli_query($dbc, $query);
                }

                if(isset($_POST['update'])){
                    if(is_uploaded_file($_FILES['pphoto']['name'])) $picture = $_FILES['pphoto']['name'];
                    $title=$_POST['title'];
                    $about=$_POST['about'];
                    $content=$_POST['content'];
                    $category=$_POST['category'];
                    if(isset($_POST['archive'])){
                     $archive=1;
                    }else{
                     $archive=0;
                    }
                    if(is_uploaded_file($_FILES['pphoto']['name'])) 
                    {   
                        $target_dir = UPLPATH.$picture;
                        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
                    }
                    $id=$_POST['id'];
                    if(is_uploaded_file($_FILES['pphoto']['name'])) $query = "UPDATE articles SET title='$title', short_desc='$about', text='$content', image='$picture', category='$category', archive='$archive' WHERE id=$id ";
                    else $query = "UPDATE articles SET title='$title', short_desc='$about', text='$content', category='$category', archive='$archive' WHERE id=$id ";
                    $result = mysqli_query($dbc, $query);
                }

                
                $query = "SELECT * FROM articles";
                $result = mysqli_query($dbc, $query);
                while($row = mysqli_fetch_array($result)) {
                //forma za administraciju

                echo '<div class="col-md-12"><form enctype="multipart/form-data" action="" method="POST">
                        <div class="form-item">
                            <label for="title">Naslov vjesti:</label>
                            <div class="form-field">
                                <input type="text" name="title" class="form-field-textual"
                                value="'.$row['title'].'">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="about">Kratki sadržaj vijesti (do 100 znakova):</label>
                            <div class="form-field">
                                <textarea name="about" id="" cols="30" rows="10" class="formfield-textual">'.$row['short_desc'].'</textarea>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="content">Sadržaj vijesti:</label>
                            <div class="form-field">
                                <textarea name="content" id="" cols="30" rows="10" class="formfield-textual">'.$row['text'].'</textarea>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="pphoto">Slika:</label>
                            <div class="form-field">
                                <input type="file" class="input-text" id="pphoto"
                                value="'.$row['image'].'" name="pphoto"/> <br><img src="' . UPLPATH .
                                $row['image'] . '" width=100px>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="category">Kategorija vijesti:</label>
                                <div class="form-field">
                                <select name="category" id="" class="form-field-textual"
                                value="'.$row['category'].'">
                                <option value="sport">Sport</option>
                                <option value="kultura">Kultura</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item">
                            <label>Spremiti u arhivu:
                            <div class="form-field">';
                                if($row['archive'] == 0) {
                                    echo '<input type="checkbox" name="archive" id="archive"/> Arhiviraj?';
                                } else {
                                    echo '<input type="checkbox" name="archive" id="archive" checked/> Arhiviraj?';
                                }
                                echo '
                                </label>
                            </div>
                        </div>
                        <div class="form-item">
                            <input type="hidden" name="id" class="form-field-textual"
                            value="'.$row['id'].'">
                            <button type="reset" value="Poništi">Poništi</button>
                            <button type="submit" name="update" value="Prihvati">Izmjeni</button>
                            <button type="submit" name="delete" value="Izbriši">Izbriši</button>
                        </div>
                     </form> </div>';
                    
                }
                
                
            } else echo '<p>Bok ' . $_SESSION['username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
            mysqli_close($dbc);
            ?>
        </div>
    </div>
    <footer>
      <div class="row">
        <div class="col-md-2"><p>Dorian Hajnić, 2022</p></div>
        <div class="col-md-2 offset-md-8" ><p style="float:right">dhajnic@tvz.hr</p></div>
      </div>
    </footer>
  </body>



</html>