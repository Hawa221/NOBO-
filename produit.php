<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'bdd.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT id_produit, nom, description, prix, image FROM produits WHERE id_produit = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if (!$produit) {
    header('Location: produits.php');
    exit;
}

$message = '';

// Ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_panier'])) {
    $quantite = max(1, (int)($_POST['quantite'] ?? 1));

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    if (isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id]['quantite'] += $quantite;
    } else {
        $_SESSION['panier'][$id] = [
            'nom'      => $produit['nom'],
            'prix'     => $produit['prix'],
            'image'    => $produit['image'],
            'quantite' => $quantite,
        ];
    }

    $message = 'ajoute';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>NOBO – <?= htmlspecialchars($produit['nom']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <style>
    .product-detail {
      display: flex;
      gap: 50px;
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px;
      flex-wrap: wrap;
    }
    .product-detail-img {
      flex: 1;
      min-width: 300px;
    }
    .product-detail-img img {
      width: 100%;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .product-detail-info {
      flex: 1;
      min-width: 300px;
    }
    .product-detail-info h1 {
      font-size: 2em;
      margin-bottom: 10px;
    }
    .product-detail-info .price {
      font-size: 1.6em;
      font-weight: bold;
      margin-bottom: 20px;
      color: #1e1e2e;
    }
    .product-detail-info .description {
      line-height: 1.6;
      color: #444;
      margin-bottom: 30px;
    }
    .add-cart-form {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .qty-input {
      width: 70px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      text-align: center;
      font-size: 1em;
    }
    .btn-add-cart {
      background: #1e1e2e;
      color: #fff;
      border: none;
      padding: 14px 28px;
      border-radius: 6px;
      font-size: 1em;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-add-cart:hover {
      background: #333;
    }
    .confirm-message {
      background: #eafaf1;
      color: #1e8449;
      padding: 12px 16px;
      border-radius: 6px;
      margin-bottom: 20px;
    }
    .back-link {
      display: inline-block;
      margin: 20px 20px 0;
      color: #555;
      text-decoration: none;
    }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<a href="produits.php" class="back-link">&larr; Retour à la boutique</a>

<main class="product-detail">
  <div class="product-detail-img">
    <img src="<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
  </div>
  <div class="product-detail-info">
    <h1><?= htmlspecialchars($produit['nom']) ?></h1>
    <p class="price"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>

    <?php if ($message === 'ajoute'): ?>
      <div class="confirm-message">
        Produit ajouté au panier ! <a href="panier.php">Voir le panier</a>
      </div>
    <?php endif; ?>

    <p class="description"><?= nl2br(htmlspecialchars($produit['description'])) ?></p>

    <form method="POST" action="produit.php?id=<?= $produit['id_produit'] ?>" class="add-cart-form">
      <input type="number" name="quantite" value="1" min="1" max="20" class="qty-input">
      <button type="submit" name="ajouter_panier" class="btn-add-cart">Ajouter au panier</button>
    </form>
  </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>