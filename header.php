<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOBO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <a href="index.php">
        <img src='logonobo.jpg' alt='logo NOBO' class="logo" height="80px">
    </a>

    <nav>
        <ul class="nav-menu">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="produits.php">Boutique</a></li>
            <li><a href="marque.php">La Marque</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="article.php">Blog</a></li>
        </ul>
    </nav>

    <div class="nav-actions">
        <!-- Panier -->
        <?php
        $nb_panier = 0;
        if (isset($_SESSION['panier'])) {
            foreach ($_SESSION['panier'] as $item) {
                $nb_panier += $item['quantite'];
            }
        }
        ?>
        <a href="panier.php" class="nav-icon">
            🛒 <span class="badge"><?= $nb_panier > 0 ? $nb_panier : '' ?></span>
        </a>


        <?php if (isset($_SESSION['utilisateur'])): ?>
            <span class="nav-user">👤 <?= htmlspecialchars($_SESSION['utilisateur']['prenom']) ?></span>
            <?php if ($_SESSION['utilisateur']['role'] === 'admin'): ?>
                <a href="admin/index.php" class="nav-link">Admin</a>
            <?php endif; ?>
            <?php if ($_SESSION['utilisateur']['role'] === 'sales'): ?>
                <a href="statistiques_ventes.php" class="nav-link">Statistiques</a>
            <?php endif; ?>
            <a href="mes_commandes.php" class="nav-link">Mes commandes</a>
            <a href="deconnexion.php" class="nav-link nav-logout">Déconnexion</a>
        <?php else: ?>
            <a href="connexion.php" class="nav-link">Connexion</a>
            <a href="inscription.php" class="nav-link nav-register">Inscription</a>
        <?php endif; ?>
    </div>
</header>