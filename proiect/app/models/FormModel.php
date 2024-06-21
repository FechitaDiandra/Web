<?php
class FormModel {
    private $serviceUrl;

    public function __construct() {
        $this->serviceUrl = 'http://localhost/web/proiect/services/FormService/';
    }

    public function createForm($formData) {
        $curl = curl_init($this->serviceUrl . 'form');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $jsonData = json_encode($formData);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }

        curl_close($curl);
        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        return $response;
    }

    public function sendFormLink($email, $formId) {
        $formLink = "http://" . $_SERVER['SERVER_NAME'] . "/web/proiect/app/answer-form?id=$formId";
        $to = $email;
        $subject = "Form Created Successfully!";
        $message = "Your form has been successfully created! Here is the link you can use to collect responses for your form: $formLink";
        $headers = "From: contactfeedbackoneverything@gmail.com";
    
        return mail($to, $subject, $message, $headers);
    }

    public function deleteForm($formId) {
        $curl = curl_init($this->serviceUrl . 'form/' . $formId);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        if ($httpcode === 200) {
            return $response; //returns the json encoded
        }

        return json_encode(['success' => false, 'message' => "Deleting the form didn't work as expected."]);
    }

    public function getFormsByUserId($userId) {
        $curl = curl_init($this->serviceUrl . 'users-forms/' . $userId);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        if ($httpcode === 200) {
            return $response; //returns the json encoded
        }

        return json_encode(['success' => false, 'message' => "Retrieving the user's forms from the database didn't work."]);
    }

    public function getFormById($formId) {
        $curl = curl_init($this->serviceUrl . 'form/' . $formId);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        if ($httpcode === 200) {
            return $response; //returns the json encoded
        }

        return json_encode(['success' => false, 'message' => "Retrieving the form data from the database didn't work."]);
    }

    public function getPublicAvailableForms(){
        $curl = curl_init($this->serviceUrl . 'public-forms');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        if ($httpcode === 200) {
            return $response; //returns the json encoded
        }

        return json_encode(['success' => false, 'message' => "Retrieving the public forms from the database didn't work."]);
    }

    public function reportForm($formId){
        $curl = curl_init($this->serviceUrl . 'report-form/' . $formId);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        if ($httpcode === 200) {
            return $response; //returns the json encoded
        }

        return json_encode(['success' => false, 'message' => "Reporting the form didn't work as expected."]);
    }
}
?>