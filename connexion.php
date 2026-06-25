<?php
session_start();

// Si déjà connecté, rediriger
if (isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit;
}

require_once 'bdd.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mdp   = $_POST['mot_de_passe'] ?? '';

    if (empty($email) || empty($mdp)) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            // Connexion réussie
            $_SESSION['utilisateur'] = [
                'id'     => $user['id_utilisateur'],
                'nom'    => $user['nom'],
                'prenom' => $user['prenom'],
                'email'  => $user['email'],
                'role'   => $user['role'],
            ];

            // Redirection selon le rôle
            if ($user['role'] === 'admin') {
                header('Location: admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<?php include 'header.php'; ?>

<main class="auth-page">
    <div class="auth-container">
        <h1>Connexion</h1>

        <?php if ($erreur): ?>
            <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form method="POST" action="connexion.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit" class="btn-submit">Se connecter</button>
        </form>

        <p class="auth-link">Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
    </div>
</main>

<?php include 'footer.php'; ?>
