<?php
$servername = "db"; // le nom du service MySQL dans docker-compose
$username = "user";
$password = "userpassword";
$dbname = "test_db";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la table si elle n'existe pas
    $conn->exec("CREATE TABLE IF NOT EXISTS test_table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        value VARCHAR(30) NOT NULL
    )");

    // Insertion d'une nouvelle ligne dans la table
    $newValue = "TestValue_" . rand(1, 100);
    $stmt = $conn->prepare("INSERT INTO test_table (value) VALUES (:value)");
    $stmt->bindParam(':value', $newValue);
    $stmt->execute();

    // Sélection des données
    $stmt = $conn->prepare("SELECT * FROM test_table");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Contenu de la table test_table :</h2>";
    foreach ($result as $row) {
        echo "ID: " . $row['id'] . " - Value: " . $row['value'] . "<br>";
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
