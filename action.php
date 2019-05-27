<?php
require 'database.php';

if (isset($_GET['t'], $_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id']))
{
    $getid = (int) $_GET['id'];
    $gett = (int) $_GET['t'];

    ///a rajouter en dynamique apres
    //$sessionid = $_SESSION['id'];
    $sessionid = 4;

    $check = $bdd->prepare("SELECT id from articles WHERE id = ?");
    $check->execute(array($getid));

    if ($check->rowCount() == 1)
    {
        if ($gett == 1)
        {
            $check_like = $bdd->prepare("SELECT id FROM likes WHERE id_article = ? AND id_membre = ?");
            $check_like->execute(array($getid, $sessionid));

            $del = $bdd->prepare("DELETE FROM dislikes WHERE id_article = ? AND id_membre = ?");
            $del->execute(array($getid, $sessionid));


            if ($check_like->rowCount() == 1)
            {
                $del = $bdd->prepare("DELETE FROM likes WHERE id_article = ? AND id_membre = ?");
                $del->execute(array($getid, $sessionid));

            }
            else
            {
                $ins = $bdd->prepare("INSERT INTO likes(id_article, id_membre) VALUES (?, ?)");
                $ins->execute(array($getid, $sessionid));
            }
        }
        else if ($gett == 2)
        {
            $check_like = $bdd->prepare("SELECT id FROM dislikes WHERE id_article = ? AND id_membre = ?");
            $check_like->execute(array($getid, $sessionid));

            $del = $bdd->prepare("DELETE FROM likes WHERE id_article = ? AND id_membre = ?");
            $del->execute(array($getid, $sessionid));

            if ($check_like->rowCount() == 1)
            {
                $del = $bdd->prepare("DELETE FROM dislikes WHERE id_article = ? AND id_membre = ?");
                $del->execute(array($getid, $sessionid));

            }
            else
            {
                $ins = $bdd->prepare("INSERT INTO dislikes(id_article, id_membre) VALUES (?, ?)");
                $ins->execute(array($getid, $sessionid));
            }

        }
        header('Location: http://localhost:8888/Espace_commentaires/index.php?id='.$getid);
    }
    else
    {
        exit('Erreur fatale . <a href="http://localhost:8888/Espace_commentaires/index.php">Revenir à l\'acceuil</a>');

    }
}
else
{
    exit('Erreur fatale . <a href="http://localhost:8888/Espace_commentaires/index.php">Revenir à l\'acceuil</a>');
}

?>