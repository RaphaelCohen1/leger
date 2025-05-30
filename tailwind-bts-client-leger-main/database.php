<?php
try {
    // Création (ou ouverture) de la base de données SQLite
    $pdo = new PDO("sqlite:db/database.sqlite");//Crée ou ouvre automatiquement un fichier SQLite appelé database.sqlite situé dans un dossier db/,et toutes les données (tes tâches, etc.) sont sauvegardées dedans.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Configure PDO pour afficher les erreurs comme des exceptions, pratique pour le débogage.
    //PDO signifie PHP Data Objects, c’est une interface PHP qui permet de gérer la connexion et les requêtes vers une base de données de façon sécurisée et uniforme.
    // Requête pour créer la table si elle n'existe pas encore
    $sql = "CREATE TABLE IF NOT EXISTS taches (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT NOT NULL,
        statut INTEGER DEFAULT 0,
        email TEXT UNIQUE NOT NULL,
        mot_de_passe TEXT NOT NULL
    )";
    // Table des utilisateurs
    $sql2 = "CREATE TABLE IF NOT EXISTS utilisateurs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT UNIQUE NOT NULL,
        mot_de_passe TEXT NOT NULL
    )";
    $pdo->exec($sql2);

    $email = 'admin@example.com';
    $mot_de_passe = password_hash('admin123', PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT OR IGNORE INTO utilisateurs (email, mot_de_passe) VALUES (?, ?)");
    $stmt->execute([$email, $mot_de_passe]);

    // Exécution de la requête
    $pdo->exec($sql);

    echo "✅ Base de données et table créées avec succès !";
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>

