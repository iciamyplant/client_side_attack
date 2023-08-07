<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
</head>
<body>
    <h1>Mon super moteur de recherche</h1>
    
    <form type="get" action="">
        <input type="text" name="keyword" />
        <input type="submit" value="Rechercher" />
    </form>
    
    <?php
    if(!empty($_GET['keyword']))
    {
        echo "Résultat(s) pour le mot-clé : ".$_GET['keyword']; // executer le doc en lancant un serveur php avec php -S localhost:8080
    }
    ?>
</body>
</html>