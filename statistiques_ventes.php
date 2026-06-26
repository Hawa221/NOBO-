<?php
// Etape 1 : démarrer la session pour savoir qui est connecté
session_start();


require_once 'bdd.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'sales') {
    header('Location: connexion.php');
    exit;
}

//  calcul du chiffre d'affaires de la semaine en cours
$requete1 = $pdo->prepare("SELECT SUM(total) AS ca FROM commandes WHERE YEARWEEK(created_at) = YEARWEEK(CURDATE())");
$requete1->execute();
$ca_semaine_actuelle = $requete1->fetch()['ca'];

//  calcul du chiffre d'affaires de la semaine précédente
$requete2 = $pdo->prepare("SELECT SUM(total) AS ca FROM commandes WHERE YEARWEEK(created_at) = YEARWEEK(CURDATE()) - 1");
$requete2->execute();
$ca_semaine_precedente = $requete2->fetch()['ca'];

// top 3 produits les plus vendus
$requete3 = $pdo->prepare("
    SELECT produits.nom, SUM(commande_produits.quantite) AS quantite_vendue
    FROM commande_produits
    JOIN produits ON produits.id_produit = commande_produits.id_produit
    GROUP BY produits.id_produit
    ORDER BY quantite_vendue DESC
    LIMIT 3
");
$requete3->execute();
$top_produits = $requete3->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des ventes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<main style="max-width:700px; margin:40px auto; padding:0 20px;">

    <h1>Statistiques des ventes</h1>

    <h2>Chiffre d'affaires de la semaine en cours</h2>
    <p><?= number_format($ca_semaine_actuelle, 2) ?> €</p>

    <h2>Chiffre d'affaires de la semaine précédente</h2>
    <p><?= number_format($ca_semaine_precedente, 2) ?> €</p>

    <h2>Top 3 des produits les plus vendus</h2>
    <ol>
        <?php foreach ($top_produits as $produit): ?>
            <li><?= htmlspecialchars($produit['nom']) ?> — <?= $produit['quantite_vendue'] ?> vendus</li>
        <?php endforeach; ?>
    </ol>

    <h2>Export des données</h2>
    <a href="export_json.php">Télécharger la liste des produits (JSON)</a>

</main>

<?php include 'footer.php'; ?>

</body>
</html>