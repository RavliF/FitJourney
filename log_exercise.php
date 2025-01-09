<?php
session_start();
include 'database/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new ConnectionDatabase();
    $conn = $db->connection;

    $exercise_type = $_POST['exercise_type'];
    $duration = intval($_POST['duration']);
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("INSERT INTO exercise_logs (user_id, exercise_type, duration, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("isi", $_SESSION['user_id'], $exercise_type, $duration);
    $stmt->execute();

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('components/head.php') ?>

<body class="bg-gray-50">
    
    <?php include('components/navbar.php') ?>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-6">Log Exercise</h2>
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Exercise Type</label>
                    <select name="exercise_type" class="w-full p-2 border rounded" required>
                        <option value="">Select Exercise Type</option>
                        <option value="cardio">Cardio</option>
                        <option value="strength">Strength Training</option>
                        <option value="flexibility">Flexibility</option>
                        <option value="sports">Sports</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Duration (minutes)</label>
                    <input type="number" name="duration" class="w-full p-2 border rounded" required min="1">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                    Log Exercise
                </button>
            </form>
        </div>
    </div>
</body>
</html>
