<?php
session_start();
include 'database/connection.php';

class ExerciseController {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function delete($id) {
        $query = "UPDATE `exercise_logs` SET `deleted_at` = CURRENT_TIMESTAMP() WHERE id = ?";

        $process = $this->database->connection->prepare($query);

        if ($process) {
            $process->bind_param('i', $id);
            $process->execute();
        } else {
            $error = $this->database->connection->errno . ' ' . $this->database->connection->error;
            echo $error;
        }

        $process->close();
        $this->database->closeConnection();

        return true;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise_id = intval($_POST['exercise_id']);
    $user_id = $_SESSION['user_id'];

    $db = new ConnectionDatabase();
    $conn = $db->connection;

    $stmt = $conn->prepare("SELECT id FROM exercise_logs WHERE id = ? AND user_id = ? AND deleted_at IS NULL");
    $stmt->bind_param("ii", $exercise_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        $exerciseController = new ExerciseController($db);
        $exerciseController->delete($exercise_id);

        $_SESSION['success_message'] = "Exercise log deleted successfully.";
    } else {
        $_SESSION['error_message'] = "You do not have permission to delete this log.";
    }

    $stmt->close();
    $db->closeConnection();

    header('Location: index.php');
    exit();
}
?>
