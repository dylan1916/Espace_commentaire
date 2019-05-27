<?php
require 'database.php';

if (isset($_GET['id']) AND !empty($_GET['id']))
{
    $getid = htmlspecialchars($_GET['id']);

    $article = $bdd->prepare("SELECT * FROM articles WHERE id = ?");
    $article->execute(array($getid));
    $article = $article->fetch();

    $likes = $bdd->prepare("SELECT id FROM likes WHERE id_article = ?");
    $likes->execute(array($getid));
    $likes = $likes->rowCOunt();

    $dislikes = $bdd->prepare("SELECT id FROM dislikes WHERE id_article = ?");
    $dislikes->execute(array($getid));
    $dislikes = $dislikes->rowCOunt();



    if (isset($_POST['submit_commentaire']))
    {
        if (isset($_POST['pseudo'], $_POST['commentaire']) AND !empty($_POST['pseudo']) AND !empty($_POST['commentaire']))
        {
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $commentaire = htmlspecialchars($_POST['commentaire']);

            if (strlen($pseudo) < 25)
            {
                $ins = $bdd->prepare("INSERT INTO commentaires(pseudo, commentaire, id_article, creation) VALUE (?, ?, ?, NOW())");
                $ins->execute(array($pseudo, $commentaire, $getid));

                ?>
                    <script>
                        function myFunction() {
                        alert("Votre commentaire a bien été posté !");
                        }
                    </script>
                <?php
            }
            else
            {
                ?>
                    <script>
                        function myFunction() {
                        alert("Le pseudo doit faire moins de 25 caractères !");
                        }
                    </script>
                <?php
            }
        }
        else
        {
            ?>
                <script>
                    function myFunction() {
                    alert("Tous les champs doivent être complétés !");
                    }
                </script>
            <?php
        }
    }

    $commentaires = $bdd->prepare("SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC");
    $commentaires->execute(array($getid));

?>

<center><h2>Article:</h2></center>
<p><?= $article['contenu'];?></p>
<br/><br/>

<center>
    <h2>Système de like:</h2><br/>
    <a href="action.php?t=1&id=<?= $getid ?>">J'aime</a>(<?= $likes ?>)<br/><br/>
    <a href="action.php?t=2&id=<?= $getid ?>">Je n'aime pas</a>(<?= $dislikes ?>)
</center>
<br/><br/>


<center>
<h2>Commentaires:</h2><br/>
    <form action="" method="POST">
        <input type="text" name="pseudo" placeholder="Votre pseudo"><br/><br/>
        <textarea name="commentaire" placeholder="Votre commentaire..." cols="40" rows="10"></textarea><br/><br/><br/>
        <input type="submit" name="submit_commentaire" value="Poster votre commentaire" onclick="myFunction()">
    </form>
</center>

<br/>

<?php

while ($c = $commentaires->fetch())
{
?>

    <b><?= $c['pseudo'];?>:</b> <?= $c['commentaire'];?><br/><br/>

<?php
}

?>

<?php
}
?>