<?php
session_start();
include '../../../config/config.php';

try {
    if (!$conn) {
        throw new Exception("Failed to connect to database.");
    }

    if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'teacher')) {
        header('Location: ../content/login.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_documents'])) {
        if (!empty($_POST['documents_id']) && is_numeric($_POST['documents_id'])) {
            $documentsId = intval($_POST['documents_id']);
            $stmt = $conn->prepare("DELETE FROM documents WHERE id = :id");
            $stmt->bindParam(':id', $documentsId, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: ../../pages/documents.php');
            exit();
        } else {
            echo "<script>console.log('Ошибка при выполнении программы: " . addslashes($ex->getMessage()) . "');</script>";
            echo "Ошибка при выполнении программы: " . htmlspecialchars($ex->getMessage());
        }
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
