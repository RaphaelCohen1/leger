<?php
session_start();
require 'database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <form method="post" class="bg-white p-6 rounded-lg shadow-md w-80 space-y-4">
        <h2 class="text-2xl font-bold text-blue-600">🔐 Connexion</h2>
        <?php if ($error): ?>
            <p class="text-red-500"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <input type="email" name="email" placeholder="Email" required class="w-full border p-2 rounded">
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required class="w-full border p-2 rounded">
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Se connecter</button>
    </form>
</body>
</html>
