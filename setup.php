<?php
require 'database.php';

try
{
    $bdd = new PDO($DB_DSN, $DB_USER, $_DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
    $bdd->query("DROP DATABASE IF EXISTS espace_commentaires");
	$bdd->query("CREATE DATABASE espace_commentaires");
    $bdd->query("use espace_commentaires");
    
    //table articles
    $bdd->query("CREATE TABLE articles(
                id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                contenu TEXT NOT NULL)");


    //table commentaire
    $bdd->query("CREATE TABLE commentaires(
                id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                pseudo VARCHAR(255) NOT NULL,
                commentaire TEXT NOT NULL,
                id_article INT (11) NOT NULL,
                creation DATETIME NOT NULL)"); ///id_articles qui sert a lier le commentaire et l'articles

    //table like
    $bdd->query("CREATE TABLE likes(
                id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                id_article INT (11) NOT NULL,
                id_membre INT (11) NOT NULL)");

    //table dislike
    $bdd->query("CREATE TABLE dislikes(
                id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                id_article INT (11) NOT NULL,
                id_membre INT (11) NOT NULL)");
}
catch (Exception $error)
{
    print "Error while connecting to the new database !: " . $error->getMessage() . "<br/>";
	die();
}
?>
