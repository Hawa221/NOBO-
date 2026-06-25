<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'bdd.php';

// Doit être connecté pour commander
if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}

// Panier vide -> retour boutique
if (empty($_SESSION['panier'])) {
    header('Location: produits.php');
    exit;
}

$total = 0;
foreach ($_SESSION['panier'] as $item) {
    $total += $item['prix'] * $item['quantite'];
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmer_commande'])) {
    try {
        $pdo->beginTransaction();

        // Création de la commande
        $stmt = $pdo->prepare("INSERT INTO commandes (id_utilisateur, total, statut) VALUES (?, ?, 'validee')");
        $stmt->execute([$_SESSION['utilisateur']['id'], $total]);
        $id_commande = $pdo->lastInsertId();

        // Ajout des produits de la commande
        $stmt = $pdo->prepare("INSERT INTO commande_produits (id_commande, id_produit, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['panier'] as $id_produit => $item) {
            $stmt->execute([$id_commande, $id_produit, $item['quantite'], $item['prix']]);
        }

        $pdo->commit();

        // Vider le panier
        $_SESSION['panier'] = [];

        header('Location: confirmation_commande.php?id=' . $id_commande);
        exit;
    } catch (\Exception $e) {
        $pdo->rollBack();
        $erreur = "Une erreur est survenue lors de la validation de la commande : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>NOBO – Valider ma commande</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <style>
    .order-page { max-width: 700px; margin: 40px auto; padding: 0 20px; }
    .order-summary { background: #fff; border: 1px solid #eee; border-radius: 10px; padding: 25px; margin-bottom: 25px; }
    .order-line { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
    .order-total { display: flex; justify-content: space-between; font-size: 1.3em; font-weight: bold; margin-top: 15px; padding-top: 15px; border-top: 2px solid #1e1e2e; }
    .btn-confirm { width: 100%; padding: 16px; background: #1e1e2e; color: #fff; border: none; border-radius: 6px; font-size: 1.1em; font-weight: 600; cursor: pointer; }
    .alert-error { background: #fdecea; color: #c0392b; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<main class="order-page">
  <h1>Valider ma commande</h1>

  <?php if ($erreur): ?>
    <div class="alert-error"><?= htmlspecialchars($erreur) ?></div>
  <?php endif; ?>

  <div class="order-summary">
    <h3>Récapitulatif</h3>
    <?php foreach ($_SESSION['panier'] as $item): ?>
      <div class="order-line">
        <span><?= htmlspecialchars($item['nom']) ?> x<?= $item['quantite'] ?></span>
        <span><?= number_format($item['prix'] * $item['quantite'], 2, ',', ' ') ?> €</span>
      </div>
    <?php endforeach; ?>
    <div class="order-total">
      <span>Total</span>
      <span><?= number_format($total, 2, ',', ' ') ?> €</span>
    </div>
  </div>

  <form method="POST" action="commande.php">
    <button type="submit" name="confirmer_commande" class="btn-confirm">Confirmer la commande</button>
  </form>
</main>

<?php include 'footer.php'; ?>

</body>
</html>