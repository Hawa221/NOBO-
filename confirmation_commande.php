<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'bdd.php';

if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}

$id_commande = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Vérifier que la commande appartient bien à l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id_commande = ? AND id_utilisateur = ?");
$stmt->execute([$id_commande, $_SESSION['utilisateur']['id']]);
$commande = $stmt->fetch();

if (!$commande) {
    header('Location: index.php');
    exit;
}

// Récupérer le détail des produits commandés
$stmt = $pdo->prepare("
    SELECT cp.quantite, cp.prix_unitaire, p.nom, p.image
    FROM commande_produits cp
    JOIN produits p ON p.id_produit = cp.id_produit
    WHERE cp.id_commande = ?
");
$stmt->execute([$id_commande]);
$lignes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>NOBO – Commande confirmée</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <style>
    .confirm-page { max-width: 700px; margin: 40px auto; padding: 0 20px; text-align: center; }
    .confirm-icon { font-size: 3em; margin-bottom: 10px; }
    .confirm-page h1 { margin-bottom: 10px; }
    .order-summary { background: #fff; border: 1px solid #eee; border-radius: 10px; padding: 25px; margin: 25px 0; text-align: left; }
    .order-line { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
    .order-total { display: flex; justify-content: space-between; font-size: 1.3em; font-weight: bold; margin-top: 15px; padding-top: 15px; border-top: 2px solid #1e1e2e; }
    .btn { display: inline-block; padding: 12px 24px; background: #1e1e2e; color: #fff; text-decoration: none; border-radius: 6px; }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<main class="confirm-page">
  <div class="confirm-icon">✅</div>
  <h1>Merci pour votre commande !</h1>
  <p>Votre commande n°<?= $commande['id_commande'] ?> a bien été enregistrée.</p>

  <div class="order-summary">
    <h3>Récapitulatif</h3>
    <?php foreach ($lignes as $ligne): ?>
      <div class="order-line">
        <span><?= htmlspecialchars($ligne['nom']) ?> x<?= $ligne['quantite'] ?></span>
        <span><?= number_format($ligne['prix_unitaire'] * $ligne['quantite'], 2, ',', ' ') ?> €</span>
      </div>
    <?php endforeach; ?>
    <div class="order-total">
      <span>Total</span>
      <span><?= number_format($commande['total'], 2, ',', ' ') ?> €</span>
    </div>
  </div>

  <a href="produits.php" class="btn">Continuer mes achats</a>
</main>

<?php include 'footer.php'; ?>

</body>
</html>