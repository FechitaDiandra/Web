<?php
require_once 'BaseController.php';
require_once 'models/FormModel.php';

class FormController extends BaseController {
    private $formModel;

    public function __construct() {
        $this->formModel = new FormModel();
    }

    public function createForm() {
        if (!isset($_POST['feedback_type'], $_POST['title'], $_POST['description'], $_POST['date'], $_POST['time'], $_POST['public'])) {
            $_SESSION['message'] = 'Missing required form fields.';
            $this->redirect('create-form');
        }
    
        $feedback_type = $_POST['feedback_type'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $is_published = $_POST['public'];
        $userEmail = $_SESSION['email'];
        $answer_time = $date . ' ' . $time;

        $formData = [
            'feedback_type' => $feedback_type,
            'user_id' => $_SESSION['id'],
            'title' => $title,
            'description' => $description,
            'answer_time' => $answer_time,
            'is_published' => $is_published === 'yes' ? 1 : 0 
        ];

        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $fileUpload = $_FILES['file'];
            $fileContent = base64_encode(file_get_contents($fileUpload['tmp_name']));
            $formData['file'] = 'data:' . $fileUpload['type'] . ';base64,' . $fileContent;
        }

        $response = $this->formModel->createForm($formData);
        $responseDecoded = json_decode($response, true);

        if ($responseDecoded['success']) {
            $formId = $responseDecoded['form_id'];
            $formLink = "http://" . $_SERVER['SERVER_NAME'] . "/web/proiect/app/view-form?id=$formId";
            $sendLink = $this->formModel->sendFormLink($userEmail, $formId);
                if ($sendLink) 
                $_SESSION['message'] = "Form created successfully! A confirmation email has been sent to you. You can also access the link here: <a href='$formLink'>View your form</a>";
                else 
                    $_SESSION['message'] = "The form was successfully created, but we couldn't send the confirmation email. You can still access the link here: <a href='$formLink'>View your form</a>";

        } else {
            $_SESSION['message'] = 'Error creating the form: ' . $responseDecoded['message'];
        }

        $this->redirect('create-form');
    }

    public function getFormsByLoggedUser() {
        $userId = $_SESSION['id'];
        $response = $this->formModel->getFormsByUserId($userId);
        $responseDecoded = json_decode($response, true);
        
        if($responseDecoded['success']) {
            return $responseDecoded['message'];
        }

        return "Error retrieving your forms.";
    }

    public function getFormsByUserId($id) {
        $response = $this->formModel->getFormsByUserId($id);
        $responseDecoded = json_decode($response, true);
        
        if($responseDecoded['success']) {
            return $responseDecoded['message'];
        }

        return "Error retrieving your forms.";
    }

    public function getLatestForms() {
        $response = $this->formModel->getPublicAvailableForms();
        $responseDecoded = json_decode($response, true);
        
        if($responseDecoded['success']) {
            return $responseDecoded['message'];
        }

        return "Error retrieving the latest forms.";
    }

    public function deleteForm($id){
        $response = $this->formModel->deleteForm($id);
        $responseDecoded = json_decode($response, true);
        
        if($responseDecoded['success']) {
            $_SESSION['message'] = $responseDecoded['message'];
        }
        else {
            $_SESSION['message'] = "There has been an error deleting the form.";
        }

        $this->redirect('form-history');
    }

    public function getFormById($id){
        $response = $this->formModel->getFormById($id);
        $responseDecoded = json_decode($response, true);
        
        if($responseDecoded['success']) {
            return $responseDecoded['message'];
        }

        return "Error retrieving the form from the database.";
    }

    public function reportForm($id){
        $response = $this->formModel->reportForm($id);
        $responseDecoded = json_decode($response, true);
        $_SESSION['message'] = $responseDecoded['message'];
        $this->redirect("answer-form?id=$id");
    }

}
?>