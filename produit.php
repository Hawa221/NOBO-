<?php
require_once 'bdd.php'; // Connexion PDO

// Sécurisation de l'ID via GET
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('Produit non spécifié ou ID invalide.');
}

// Requête préparée
$stmt = $pdo->prepare("SELECT id_produit, nom, description, prix, image FROM produits WHERE id_produit = ?");
$stmt->execute([$id]);
$prod = $stmt->fetch();

if (!$prod) {
    exit('Produit introuvable.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($prod['nom']) ?> – NOBO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <style>
    .product-detail {
      max-width: 800px;
      margin: 40px auto;
      padding: 0 20px;
    }
    .product-detail img {
      width: 100%;
      max-width: 400px;
      height: auto;
      display: block;
      margin-bottom: 20px;
    }
    .product-info h1 {
      font-size: 2em;
      margin-bottom: 10px;
    }
    .product-info p.description {
      margin: 20px 0;
      line-height: 1.6;
    }
    .product-info p.price {
      font-size: 1.5em;
      font-weight: bold;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background: #000;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<main class="product-detail">
  <!-- Correction ici : plus de dossier 'assets/img/' -->
  <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['nom']) ?>">
  <div class="product-info">
    <h1><?= htmlspecialchars($prod['nom']) ?></h1>
    <p class="price"><?= number_format($prod['prix'], 2, ',', ' ') ?> €</p>
    <p class="description"><?= nl2br(htmlspecialchars($prod['description'])) ?></p>
    <a href="panier.php?action=ajout&id=<?= $prod['id_produit'] ?>" class="btn">Ajouter au panier</a>
  </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
