<?php
session_start();
include 'database/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new ConnectionDatabase();
    $conn = $db->connection;

    $height = floatval($_POST['height']);
    $weight = floatval($_POST['weight']);
    
    $height_m = $height / 100;
    $bmi = $weight / ($height_m * $height_m);
    
    $stmt = $conn->prepare("SELECT id FROM bmi_records WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE bmi_records SET height = ?, weight = ?, bmi = ?, created_at = NOW() WHERE user_id = ?");
        $stmt->bind_param("dddi", $height, $weight, $bmi, $_SESSION['user_id']);
    } else {
        $stmt = $conn->prepare("INSERT INTO bmi_records (user_id, height, weight, bmi, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iddd", $_SESSION['user_id'], $height, $weight, $bmi);
    }
    $stmt->execute();

    $stmt->close();
    $db->closeConnection();

    header('Location: index.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="bg-gray-50">
    
    <?php include 'components/navbar.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-6">BMI Calculator</h2>
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Height (cm)</label>
                    <input type="number" name="height" value="<?php echo $user['height']; ?>" 
                           class="w-full p-2 border rounded" required min="100" max="250">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Weight (kg)</label>
                    <input type="number" name="weight" value="<?php echo $user['weight']; ?>" 
                           class="w-full p-2 border rounded" required min="30" max="300">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                    Calculate BMI
                </button>
            </form>
        </div>
    </div>
</body>
</html>