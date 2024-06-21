<?php
class AnswerModel {
    private $serviceUrl;

    public function __construct() {
        $this->serviceUrl = 'http://localhost/web/proiect/services/AnswerService/';
    }

    public function answerForm($formData) {
        $curl = curl_init($this->serviceUrl . 'answer');
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

    public function getAnswersByFormId($id) {
        $curl = curl_init($this->serviceUrl . 'answers/' . $id);
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

        return json_encode(['success' => false, 'message' => "Retrieving the answers for your form from the database didn't work as expected."]);
    }
    
    public function getStatisticsByFormId($id) {
        $curl = curl_init($this->serviceUrl . 'get-statistics/' . $id);
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

        return json_encode(['success' => false, 'message' => "Retrieving the statistics for your form from the database didn't work as expected."]);
    }
}