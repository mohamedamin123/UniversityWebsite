<!DOCTYPE html>

<!DOCTYPE html>
<html>
  <head>
      <?php
          session_start();
          if (isset($_SESSION["login"])) {
              header("location: /Pages/User/index.php");
          }
          require_once("config.php");
      ?>
      <link rel="stylesheet" href="/Assets/css/login.css">
      <title>Reenvoyer comfirmation</title>
  </head>
<body>
  <?php
    if (isset($_POST["confirm"])) {
      if (isset($_POST["email"])) {
        $email = $_POST["email"];

          // check if email exists.
          if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            require_once("Classes/Database/UtilisateurDB.php");
            $utilisateurDB = new UtilisateurDB();
            $user = $utilisateurDB->emailExists($email, 1);
            
            if (!empty($user)) {
                if ($user["isActive"] == false) {
                  require_once("Classes/Emailer.php");
                  $emailer = new Emailer($email);
                  $emailer->email_activation_again($user["activationCode"]);
                  $result = $emailer->send();
                  
                  $message = "<p class = 'green_alert'>Vous avez envoyé la lien de confirmation. Verifier votre e-mail.</p>";
                } else {
                  $message = "<p class = 'red_alert'>Cette compte est déja activé.</p>";
                }
            } else {
              $message = "<p class = 'red_alert'>Error. Cette e-mail n'existe pas dans la base de données.</p>";
            }
          } else {
            $message = "<p class = 'red_alert'>Cette format d'email n'est pas valide.</p>";
          }
        } else {
          $message = "<p class = 'red_alert'>Error. La formulaire est erroné.</p>";
        }
      }
  ?>

<div class="imgcontainer">
      <header id="header"><?= NOM_SITE ?></header>
      <img src="/Assets/imgs/logo.png" alt="logo" class="logo">
    </div>

    <form class="formulaire" method = "post">  
        <div style = "margin-top: 50px; margin-bottom: 20px;">
            <span class="forgot_header"> Reenvoyer la lien de confimation?</span>
        </div>
        <div class="container">
          <p class = "forgot_info">Presenter votre Email. Si le compte existe on te l'envoyer par mail.</p>
          
          <br>
          <?php if (isset($message)) { echo "$message"; } ?>
          <label for="email"></label>
          <input type="text" placeholder="Email" name="email" required><br>
          <button type="submit" name = "confirm" class = "login_btn">Envoyer</button> 
          
        </div>
        </form>
        <div style = "margin-bottom:auto;">
          <p class="psw">
              Vous pouvez de retourner? <a href="/login.php">Cliquer ici.</a>
          </p>
      </div>

        <div class = "login_imgs">
          <img src="/Assets/imgs/oublier_pass.png" alt="logleft" class="logleft">
        </div>



</body>
</html>