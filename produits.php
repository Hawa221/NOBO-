<?php
require_once 'bdd.php';

$stmt = $pdo->query("
    SELECT id_produit, nom, description, prix, image
    FROM produits
    ORDER BY id_produit DESC
");
$produits = $stmt->fetchAll();
?>
<?php include 'header.php'; ?>

<style>
  /* Grille responsive */
  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px,1fr));
    gap:20px;
    padding:20px;
  }
  .product-card {
    border:1px solid #ddd;
    border-radius:8px;
    overflow:hidden;
    background:#fff;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
  }
  .product-card img {
    width:100%;
    height:auto;
  }
  .product-card h3 {
    margin:10px;
    font-size:1.2em;
  }
  .product-card .price {
    font-weight:bold;
    color:#222;
    margin:0 10px 10px;
  }
  .btn {
    display:inline-block;
    padding:8px 16px;
    margin:10px;
    background:#000;
    color:#fff;
    text-decoration:none;
    text-align:center;
    border-radius:4px;
  }
  @media(max-width:600px){
    .product-grid{grid-template-columns:1fr;}
  }
</style>

<main>
  <h2 style="text-align:center; margin:20px 0;">Boutique NOBO</h2>
  <div class="product-grid">
    <?php foreach ($produits as $prod): ?>
      <div class="product-card">
       <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['nom']) ?>">
       <h3><?= htmlspecialchars($prod['nom']) ?></h3>

        <p class="price"><?= number_format($prod['prix'], 2, ',', ' ') ?> €</p>
        <p style="padding:0 10px; flex-grow:1;">
          <?= nl2br(htmlspecialchars(substr($prod['description'], 0, 100))) ?>…
        </p>
        <a href="produit.php?id=<?= $prod['id_produit'] ?>" class="btn">Voir le produit</a>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php include 'footer.php'; ?>