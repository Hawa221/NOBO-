<?php

session_start();


require_once 'bdd.php';


if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'sales') {
    header('Location: connexion.php');
    exit;
}


$requete = $pdo->prepare("SELECT id_produit, nom, description, prix, image FROM produits ORDER BY id_produit");
$requete->execute();
$produits = $requete->fetchAll();


header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="produits_nobo.json"');


echo json_encode($produits, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;