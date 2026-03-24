<?php
// bdd.php – connexion à la base NOBO
$host     = 'localhost';
$dbname   = 'nobo';       // nom exact de ta base
$user     = 'root';       // ton nom d’utilisateur MySQL
$password = '';           // ton mot de passe MySQL
$charset  = 'utf8';    // encodage recommandé

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    exit("Erreur connexion DB : " . $e->getMessage());
}
