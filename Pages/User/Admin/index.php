<html>
<head>
    <?php
        session_start();
        $securityRoleAbs = 2;
        require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
        include(ROOT."/Pipes/get_login.php");
    ?>

    <title> Page Principale - <?= $authName ?> </title>
    <link rel="stylesheet" href="/Assets/css/user.css">
</head>
<body>
    <?php
        include(ROOT."/Classes/Database/DepartmentDB.php");
        $departmentDB = new DepartmentDB();
        
        require_once(ROOT."/Classes/Database/BoiteDB.php");
        $boiteDB = new BoiteDB();
        $unseenMessage = $boiteDB->countUnseen($user["matricule"]);
        $hasUnseen = $unseenMessage["c"] > 0;
        $boiteDB = null;

    ?>
    <div class="logo">  
        <div class = "header_div">
            <img src="/Assets/imgs/LOGO.png">
            <h2 class = "website_title"> <?= NOM_SITE ?> </h2>
        </div>
        <h3 class = "deconnection absolute"> <a href="/Pipes/deconnexion.php">Se deconnecter</a></h3>
    </div>
        
    <div class="content">
    <h1 class = "_block">Bonjour <?= $authName ?> </h1>
        <h2 class = "_block" style = "margin-top: 0">Nom & Prenom: <?= $user["nom"]." ".$user["prenom"] ?></h2>
        <h3>Department: <?= $departmentDB->getNom($user["departmentID"]) ?><br>  </h3>
            
        <div class="carousel-slider" id="responsive">
            <div class="carousel-content" data-pagination="true">
                <aside class="slide-item">
                    <div>
                        <img src="/Assets/imgs/account_icon.png"> 
                        <a href = "/Pages/User/Account/profile.php"> <h4> Consulter votre compte </h4> </a>
                    </div>
                    <div>
                        <img src="/Assets/imgs/account_icon.png"> 
                        <a href = "/Pages/Gestion/Boite/inbox.php"> <h4> Boite de messages <?= ($hasUnseen? "(".$unseenMessage["c"].")" : "") ?> </h4> </a>
                    </div>
                    <div>
                        <img src="/Assets/imgs/adm_inscription.png" />
                        <a href = "/Pages/Gestion/PlanEtude/index.php"> <h4> Gestion de plans d'etude </h4> </a>
                    </div>
                </aside>
                <aside class="slide-item">
                    <div>
                        <img src="/Assets/imgs/account_icon.png"> 
                        <a href = "/Pages/Gestion/Salles/consulter.php"> <h4> Consulter les salles </h4> </a>
                    </div>
                </aside>
            </div>
            <button class="carousel-prev-btn">&larr;</button>
            <button class="carousel-next-btn">&rarr;</button>
            <div class="carousel-pagination"></div>
        </div>
    </div>

    <div class="image" style = "display:flex;">
        <img src="/Assets/imgs/p_interfaceETD_left.png">
        <img style = "margin-left: auto;" src="/Assets/imgs/p_interfaceETD_right.png">
    </div>

    <script src="/Assets/js/pagination.js"></script>
    <link rel="stylesheet" href="/Assets/css/pagination.css">
</body>
