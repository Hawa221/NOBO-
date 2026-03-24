<?php include('header.php'); ?>
<?php include("bdd.php"); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact (nom, prenom, email, message)
            VALUES (:nom, :prenom, :email, :message)";

    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        echo "<p>✅ Votre message a bien été envoyé !</p>";
    } else {
        echo "<p>❌ Erreur lors de l'envoi du message.</p>";
    }
}
?>

    <section class="contact-page">
    <h1>Contactez-nous</h1>

    <div class="contact-container">
    <form method="POST" action="contact.php">
            Nom:  <input type="text" name="nom" placeholder="Votre nom" required><br>
            Prenom:  <input type="text" name="prenom" placeholder="Votre prenom" required><br>
            Email:  <input type="email" name="email" placeholder="Votre email" required><br>
            Message:  <textarea name="message" placeholder="Votre message" rows="6" required></textarea><br>
            <button type="submit" values="envoyer le message">Envoyer</button>
        </form>

        <div class="infos">
            <h2>Nos coordonnées</h2>
            <p>1 rue sainte marie, 92400 Courbevoie, France</p> 
            <p> +33 1 12 23 45 56</p>
            <p> nobo@noboundaries.com</p>
            <h2>Nos réseaux</h2>
            <p>Instagram: nobo028 </p>
            <p>Tiktok: story43256 </p>
        </div>

        <di> 
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5246.344090305405!2d2.2559406761888403!3d48.89305827133683!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6657358dd892f%3A0x2cd1ff2b18fbf9fa!2s1%20Rue%20Sainte-Marie%2C%2092400%20Courbevoie!5e0!3m2!1sfr!2sfr!4v1744021166931!5m2!1sfr!2sfr" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

    <?php include('footer.php'); ?>
