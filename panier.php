<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'bdd.php';


if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['maj_quantite'])) {
    foreach ($_POST['quantite'] as $id_produit => $quantite) {
        $quantite = (int)$quantite;
        if ($quantite <= 0) {
            unset($_SESSION['panier'][$id_produit]);
        } elseif (isset($_SESSION['panier'][$id_produit])) {
            $_SESSION['panier'][$id_produit]['quantite'] = $quantite;
        }
    }
    header('Location: panier.php');
    exit;
}


if (isset($_GET['supprimer'])) {
    $id_produit = (int)$_GET['supprimer'];
    unset($_SESSION['panier'][$id_produit]);
    header('Location: panier.php');
    exit;
}


if (isset($_GET['vider'])) {
    $_SESSION['panier'] = [];
    header('Location: panier.php');
    exit;
}


$total = 0;
foreach ($_SESSION['panier'] as $item) {
    $total += $item['prix'] * $item['quantite'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>NOBO – Mon panier</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <style>
    .cart-page {
      max-width: 900px;
      margin: 40px auto;
      padding: 0 20px;
    }
    .cart-page h1 {
      margin-bottom: 30px;
    }
    .cart-item {
      display: flex;
      align-items: center;
      gap: 20px;
      padding: 15px 0;
      border-bottom: 1px solid #eee;
    }
    .cart-item img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
    }
    .cart-item-info {
      flex: 1;
    }
    .cart-item-info h3 {
      margin: 0 0 5px;
      font-size: 1.1em;
    }
    .cart-item-info .unit-price {
      color: #777;
      font-size: 0.9em;
    }
    .cart-item-qty input {
      width: 60px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      text-align: center;
    }
    .cart-item-total {
      min-width: 90px;
      text-align: right;
      font-weight: bold;
    }
    .cart-item-remove {
      color: #e74c3c;
      text-decoration: none;
      font-size: 0.9em;
    }
    .cart-summary {
      margin-top: 30px;
      padding-top: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cart-total {
      font-size: 1.4em;
      font-weight: bold;
    }
    .btn-vider {
      background: #fdecea;
      color: #c0392b;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 15px;
      text-decoration: none;
      display: inline-block;
      font-size: 0.95em;
    }
    .btn-checkout {
      background: #1e1e2e;
      color: #fff;
      border: none;
      padding: 14px 28px;
      border-radius: 6px;
      font-size: 1em;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }
    .empty-cart {
      text-align: center;
      padding: 60px 20px;
      color: #777;
    }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<main class="cart-page">
  <h1>Mon panier</h1>

  <?php if (empty($_SESSION['panier'])): ?>
    <div class="empty-cart">
      <p>Votre panier est vide.</p>
      <a href="produits.php" class="btn">Voir la boutique</a>
    </div>
  <?php else: ?>
    <form method="POST" action="panier.php">
      <?php foreach ($_SESSION['panier'] as $id_produit => $item): ?>
        <div class="cart-item">
          <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['nom']) ?>">
          <div class="cart-item-info">
            <h3><?= htmlspecialchars($item['nom']) ?></h3>
            <span class="unit-price"><?= number_format($item['prix'], 2, ',', ' ') ?> € / unité</span>
          </div>
          <div class="cart-item-qty">
            <input type="number" name="quantite[<?= $id_produit ?>]" value="<?= $item['quantite'] ?>" min="0" max="20">
          </div>
          <div class="cart-item-total">
            <?= number_format($item['prix'] * $item['quantite'], 2, ',', ' ') ?> €
          </div>
          <a href="panier.php?supprimer=<?= $id_produit ?>" class="cart-item-remove">Supprimer</a>
        </div>
      <?php endforeach; ?>

      <a href="panier.php?vider=1"
         onclick="return confirm('Vider tout le panier ?');"
         class="btn-vider">Vider le panier</a>

      <div class="cart-summary">
        <span class="cart-total">Total : <?= number_format($total, 2, ',', ' ') ?> €</span>
        <a href="commande.php" class="btn-checkout">Valider la commande</a>
      </div>
    </form>
  <?php endif; ?>
</main>

<?php include 'footer.php'; ?>

</body>
</html>