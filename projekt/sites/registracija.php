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
          <li><a href="admin.php">ADMINISTRACIJA</a></li>
          <li><a class="active" href="unos.html">UNOS</a></li>
      </ul>
    </nav>

    <div class="content">
        <div class="forma">
            

            
            <?php

                include 'connect.php';
                
               

                if(isset($_POST['ime']) && isset($_POST['prezime']) && isset($_POST['username']) && isset($_POST['pass'])){

                    $ime = $_POST['ime']; 
                    $prezime = $_POST['prezime'];
                    $username = $_POST['username']; 
                    $lozinka = $_POST['pass']; 
                    $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH); 
                    $razina = 0; $registriranKorisnik = ''; 
                    //Provjera postoji li u bazi već korisnik s tim korisničkim imenom 
                    $sql = "SELECT username FROM users WHERE username = ?"; 
                    $stmt = mysqli_stmt_init($dbc); 
                    if (mysqli_stmt_prepare($stmt, $sql)) { 
                        mysqli_stmt_bind_param($stmt, 's', $username); 
                        mysqli_stmt_execute($stmt); 
                        mysqli_stmt_store_result($stmt); 
                    } 

                    if(mysqli_stmt_num_rows($stmt) > 0){ 
                        $msg='Korisničko ime već postoji!'; 
                    } else { 
                    // Ako ne postoji korisnik s tim korisničkim imenom - Registracija korisnika u bazi pazeći na SQL injection 
                    $sql = "INSERT INTO users (ime, prezime, username, password, admin) VALUES (?, ?, ?, ?, ?)"; 
                    $stmt = mysqli_stmt_init($dbc); 
                    if (mysqli_stmt_prepare($stmt, $sql)) {
                            mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina);
                            mysqli_stmt_execute($stmt); $registriranKorisnik = true; } 
                    } 
                    mysqli_close($dbc);
                } else  {
                    $registriranKorisnik = false;
                    $msg = "";
                }
                ?>
                
                <?php
                //Registracija je prošla uspješno
                if($registriranKorisnik == true) {
                    echo '<p>Korisnik je uspješno registriran!</p>';
                } else {
                //registracija nije protekla uspješno ili je korisnik prvi put došao na stranicu
                ?>

                <section role="main">
                    <form enctype="multipart/form-data" action="" method="POST">
                        <div class="form-item">
                            <span id="porukaIme" class="bojaPoruke"></span>
                            <label for="title">Ime: </label>
                            <div class="form-field">
                                <input type="text" name="ime" id="ime" class="form-fieldtextual">
                            </div>
                        </div>
                        <div class="form-item">
                            <span id="porukaPrezime" class="bojaPoruke"></span>
                            <label for="about">Prezime: </label>
                            <div class="form-field">
                                <input type="text" name="prezime" id="prezime" class="formfield-textual">
                            </div>
                        </div>
                        <div class="form-item">
                            <span id="porukaUsername" class="bojaPoruke"></span>

                            <label for="content">Korisničko ime:</label>
                            <!-- Ispis poruke nakon provjere korisničkog imena u bazi -->
                            <?php echo '<br><span class="bojaPoruke">'.$msg.'</span>'; ?>
                            <div class="form-field">
                                <input type="text" name="username" id="username" class="formfield-textual">
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
                            <span id="porukaPassRep" class="bojaPoruke"></span>
                            <label for="pphoto">Ponovite lozinku: </label>
                            <div class="form-field">
                                <input type="password" name="passRep" id="passRep"
                            class="form-field-textual">
                            </div>
                        </div>

                        <div class="form-item">
                            <br>
                            <button type="submit" value="Prijava"
                            id="slanje">Registriracija</button>
                        </div>
                    </form>

                </section>
                <script type="text/javascript">
                    document.getElementById("slanje").onclick = function(event) {

                        var slanjeForme = true;

                        // Ime korisnika mora biti uneseno
                        var poljeIme = document.getElementById("ime");
                        var ime = document.getElementById("ime").value;

                        if (ime.length == 0) {
                            slanjeForme = false;
                            poljeIme.style.border="1px dashed red";
                            document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>";
                        } else {
                            poljeIme.style.border="1px solid green";
                            document.getElementById("porukaIme").innerHTML="";
                        }

                        // Prezime korisnika mora biti uneseno
                        var poljePrezime = document.getElementById("prezime");
                        var prezime = document.getElementById("prezime").value;
                        if (prezime.length == 0) {
                            slanjeForme = false;

                            poljePrezime.style.border="1px dashed red";

                            document.getElementById("porukaPrezime").innerHTML="<br>Unesite Prezime!<br>";
                        } else {
                            poljePrezime.style.border="1px solid green";
                            document.getElementById("porukaPrezime").innerHTML="";
                        }

                        // Korisničko ime mora biti uneseno
                        var poljeUsername = document.getElementById("username");
                        var username = document.getElementById("username").value;
                        if (username.length == 0) {
                            slanjeForme = false;
                            poljeUsername.style.border="1px dashed red";

                            document.getElementById("porukaUsername").innerHTML="<br>Unesite korisničko ime!<br>";
                        } else {
                            poljeUsername.style.border="1px solid green";
                            document.getElementById("porukaUsername").innerHTML="";
                        }

                        // Provjera podudaranja lozinki
                        var poljePass = document.getElementById("pass");
                        var pass = document.getElementById("pass").value;
                        var poljePassRep = document.getElementById("passRep");
                        var passRep = document.getElementById("passRep").value;
                        if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
                            slanjeForme = false;
                            poljePass.style.border="1px dashed red";
                            poljePassRep.style.border="1px dashed red";
                            document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>";

                            document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>";
                        } else {
                            poljePass.style.border="1px solid green";
                            poljePassRep.style.border="1px solid green";
                            document.getElementById("porukaPass").innerHTML="";
                            document.getElementById("porukaPassRep").innerHTML="";
                        }

                        if (slanjeForme != true) {
                        event.preventDefault();
                        }
                    };

            </script>
            <?php
            }
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