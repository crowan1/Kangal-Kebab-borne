<?php
// Connexion à la base de données
include("db.php");

// Activer le mode d'affichage des erreurs PDO pour le débogage
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier si un utilisateur doit être supprimé
if (isset($_GET['delete_user_id'])) {
    $user_id = $_GET['delete_user_id'];

    // Préparer la requête pour supprimer l'utilisateur, à l'exception de l'ID 2
    if ($user_id != 2) {
        $delete_query = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
        $delete_query->execute(['user_id' => $user_id]);

        // Rediriger après suppression pour éviter de resoumettre le formulaire en rafraîchissant la page
        header("Location: user.php");
        exit();
    }
}

// Récupérer tous les utilisateurs de la base de données avec leurs points sauf celui avec l'ID 2
$query = $pdo->query("
    SELECT 
        users.id, 
        users.first_name, 
        users.last_name, 
        users.email, 
        IFNULL(user_points.points, 0) as points 
    FROM users
    LEFT JOIN user_points ON users.id = user_points.user_id
    WHERE users.id != 2
");
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .center {
            text-align: center;
        }
        .delete-btn {
            padding: 5px 10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .delete-btn:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>

<h1>Liste des utilisateurs</h1>

<table>
    <thead>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Points actuels</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td class="center"><?php echo htmlspecialchars($user['points']); ?></td>
            <td class="center">
                <a href="user.php?delete_user_id=<?php echo $user['id']; ?>" class="delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                    Supprimer
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
