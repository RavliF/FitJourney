<?php
include 'controller/middleware.php';
include 'database/connection.php';

$db = new ConnectionDatabase();
$conn = $db->connection;

$user_id = $_SESSION['user_id'];
$bmi_record = null;
$recent_exercises = [];

$bmi_query = $conn->prepare("SELECT * FROM bmi_records WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$bmi_query->bind_param("i", $user_id);
$bmi_query->execute();
$bmi_result = $bmi_query->get_result();
if ($bmi_result->num_rows > 0) {
    $bmi_record = $bmi_result->fetch_assoc();
}
$bmi_query->close();


$exercise_query = $conn->prepare("SELECT * FROM exercise_logs WHERE user_id = ? AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 5");
$exercise_query->bind_param("i", $user_id);
$exercise_query->execute();
$exercise_result = $exercise_query->get_result();
while ($row = $exercise_result->fetch_assoc()) {
    $recent_exercises[] = $row;
}
$exercise_query->close();
?>

<!DOCTYPE html>
<html lang="en">

<?php include('components/head.php') ?>

<body class="bg-gray-50">

    <?php include('components/navbar.php') ?>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Current BMI Status</h2>
                <?php if ($bmi_record): ?>
                    <div class="text-3xl font-bold text-blue-600 mb-2">
                        <?php echo number_format($bmi_record['bmi'], 1); ?>
                    </div>
                    <p class="text-gray-600">Last updated: <?php echo date('M d, Y', strtotime($bmi_record['created_at'])); ?></p>
                <?php else: ?>
                    <p class="text-gray-600">No BMI records yet.</p>
                <?php endif; ?>
                <a href="calculate_bmi.php" class="mt-4 inline-block text-blue-600 hover:text-blue-800">Update BMI →</a>
                <div class="my-6 text-center">
                    <img src="components/img/BMI-Chart.png" alt="BMI Info" class="bmi-image mx-auto">
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Recent Activities</h2>
                <?php if ($recent_exercises): ?>
                    <div class="space-y-4">
                        <?php foreach ($recent_exercises as $exercise): ?>
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <h3 class="font-medium capitalize"><?php echo str_replace('_', ' ', $exercise['exercise_type']); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo date('M d, Y', strtotime($exercise['created_at'])); ?></p>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 mr-4"><?php echo $exercise['duration']; ?> min</span>
                                    <form method="POST" action="delete_exercise.php" onsubmit="return confirm('Are you sure you want to delete this exercise?');">
                                        <input type="hidden" name="exercise_id" value="<?php echo $exercise['id']; ?>">
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-900 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">No recent exercises logged.</p>
                <?php endif; ?>
                <a href="log_exercise.php" class="mt-4 inline-block text-blue-600 hover:text-blue-800">Log New Exercise →</a>
            </div>

            

            <div class="bg-white rounded-lg shadow p-6 md:col-span-2 mx-auto max-w-lg">
                <h2 class="text-xl font-bold mb-4 text-center">Exercise Statistics</h2>
                <div class="grid grid-cols-3 gap-4">
                    <?php

                    $stats_query = $conn->prepare("SELECT COUNT(*) as total, SUM(duration) as total_duration FROM exercise_logs WHERE user_id = ?");
                    $stats_query->bind_param("i", $user_id);
                    $stats_query->execute();
                    $stats_result = $stats_query->get_result();
                    $stats = $stats_result->fetch_assoc();
                    ?>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600"><?php echo $stats['total'] ?? 0; ?></p>
                        <p class="text-gray-600">Total Workouts</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600"><?php echo $stats['total_duration'] ?? 0; ?></p>
                        <p class="text-gray-600">Total Minutes</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600"><?php echo $stats['total'] ? round($stats['total_duration'] / $stats['total']) : 0; ?></p>
                        <p class="text-gray-600">Avg Minutes/Workout</p>
                    </div>
                    <?php $stats_query->close(); ?>
                </div>
            </div>
        </div>
    </div>

<?php include('components/footer.php') ?>
</body>

<style>
    .bmi-image {
        max-width: 60%;
        height: auto; 
    }
</style>

</html>
