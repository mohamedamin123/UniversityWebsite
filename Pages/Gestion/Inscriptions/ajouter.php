<!--maaneha fyha (CIN, nomprenom less9yn, Role)
     button tee l'addition excel Import Excel table Ajouter Inscription-->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        session_start();
        $securityRole = 0;
        require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
        include(ROOT."/Pipes/get_login.php");
    ?>

    <title><?= $authName ?> - Ajouter Inscription </title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Assets/css/secondary_form.css">
    <link rel="stylesheet" href="/Assets/css/general.css">
</head>
<body>
    <?php
        $message = "";
        if (isset($_POST["confirm_btn"])) {
 
            if (isset($_POST["nomprenom"]) && (isset($_POST["cin"]) && is_numeric($_POST["cin"])) && isset($_POST["role"]) && isset($_POST["department"])) {
                
                $cin = $_POST["cin"];
                $post_dep = $_POST["department"];
                if (strlen((string)$cin) != 8) {
                    $message = "<p class = 'red_alert'>Erreur! La longeur de CIN doit être 8 digits!</p>";
                } elseif ($post_dep < 1 && $post_dep > 4) {
                    $message = "<p class = 'red_alert'>Erreur! Cette department n'existe pas.</p>";
                } else {
                    require_once(ROOT."/Classes/Database/InscriptionDB.php");
                    $inscriptionDB = new InscriptionDB();

                    if ($inscriptionDB->exists($cin)) {
                        $message = "<p class = 'red_alert'>Cette CIN déja existe dans la liste d'inscriptions</p>";
                    } else {
                        require_once(ROOT."/Classes/Database/UtilisateurDB.php");
                        $inscriptionDB->insert($_POST["cin"], $_POST["nomprenom"], $post_dep, $_POST["role"]);
                        $message = "<p class = 'green_alert'>La CIN est ajouté avec succes.</p>";
                    }
                }
            } else {
                $message = "<p class = 'red_alert'>La formulaire est erroné</p>";
            }
        }
    ?>
         <!--logo and name--> 
    <div>
        <img src="/Assets/imgs/LOGO.png" alt="LOGO" id="logo">
        <h1 id="nom_uni"> <?= NOM_SITE ?> </h1>
    </div>
    <!--form-->
    <div id="container" style = "top: 15%;">
        <form action="" method="post" id="f_first">
            <div>
                <h1 class = "inscr_form_title"> Ajouter Inscription: </h1>

                <?= $message ?>

                <label for="prenom" class="lab_form"> Nom & Prenom :</label>
                <input type="text" class="lab_in_txt" name = "nomprenom" required>

                <label for="prenom" class="lab_form"> CIN </label>
                <input type="text" class="lab_in_txt" name = "cin" maxlength='8' required>
                
                <label for="department" class="lab_form"> Department :</label>
                <select id="department" class="drop_form" name="department">
                    <?php
                        require_once(ROOT."/Classes/Database/DepartmentDB.php");
                        $departmentDB = new DepartmentDB();
                        foreach ($departmentDB->getAll() as $row) {
                            echo "<option value='".$row["id"]."'>".$row["nom"]."</option>";
                        }
                    ?>
                </select>

                <label for="role" class="lab_form"> Role :</label>
                <select id="role" class="drop_form" name="role">
                    <?php
                        require_once(ROOT."/Classes/Roles.php");
                        foreach (Roles::getAll() as $id => $name) {
                            echo "<option value='$id'>$name</option>";
                        }
                    ?>
                </select>
            
                <br>
                <div class = "form_btns">
                    <input type="submit" value="Ajouter" id="Confirmer" name="confirm_btn" onclick="return confirm('Confirmer?');">
                    <span> <a href = "index.php" class = "go_back"> Retourner </a> <a href = "#">Importer un Excel</a>
                </div>
            </div>
          </form>
      </div>
      
  
      <!--the img-->
      <img src="/Assets/imgs/person_form.png" alt="person" id="form_img">
  
  </body>
  </html>
