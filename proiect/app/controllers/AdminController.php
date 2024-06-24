<?php
require_once 'BaseController.php';
require_once 'models/AdminModel.php';

class AdminController extends BaseController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }


    public function importDatabase() {
        if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['sql_file']['tmp_name'];
            
            $fileExtension = pathinfo($_FILES['sql_file']['name'], PATHINFO_EXTENSION);
        if ($fileExtension === 'sql') {
            $sqlContent = file_get_contents($fileTmpPath);
            
            $importResult = $this->adminModel->importDatabase($sqlContent);
            
            if ($importResult['success']) {
                $_SESSION['message'] = "Database imported successfully!";
            } else {
                $_SESSION['message'] =  "Failed to import database.";
            }
        } else {
            $_SESSION['message'] =  "Invalid file format. Please upload a SQL file.";
        }
        }
    }

    public function exportDatabase() {
        $exportedSqlContent = $this->adminModel->exportDatabase();
        
        if ($exportedSqlContent['success']) {
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="exported_database.sql"');
            echo $exportedSqlContent['message']; // Întregul conținut SQL al bazei de date
            return true;
            exit;
        } else {
            return false;
        }
    }

    public function getAllMessages() {
        $messagesResponse = $this->adminModel->getEmailInbox();
        $messages = json_decode($messagesResponse, true);

        return $messages['message'];
    }

    public function sendResponse() {
        $index = $_POST['index'];
        $email = $_POST['email'];
        $response = $_POST['response'];

        $message= $this->adminModel->sendResponse($index, $email, $response);
        $message = json_decode($message, true);

        $_SESSION['message'] = $message['message'];
        $this->redirect('inbox');
    }
}
?>