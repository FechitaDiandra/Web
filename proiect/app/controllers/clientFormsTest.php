<?php
$apiBaseUrl = 'http://localhost/web/proiect/services/FormService/';

function createForm($apiBaseUrl, $formData, $fileUpload = null) {
    $curl = curl_init($apiBaseUrl . 'form');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if ($fileUpload && $fileUpload['error'] == 0) {
        $fileContent = base64_encode(file_get_contents($fileUpload['tmp_name']));
        $formData['file'] = 'data:' . $fileUpload['type'] . ';base64,' . $fileContent;
    }

    $jsonData = json_encode($formData);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function getAnswersByFormId($apiBaseUrl, $formId) {
    $curl = curl_init($apiBaseUrl . 'answers/' . $formId);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function getStatisticsByFormId($formId) {
    $curl = curl_init('http://localhost/web/proiect/services/AnswerService/get-statistics/' . $formId);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function addAnswer($apiBaseUrl, $answerData) {
    $curl = curl_init($apiBaseUrl . 'answer');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $jsonData = json_encode($answerData);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;

}


function getAllForms($apiBaseUrl) {
    $curl = curl_init($apiBaseUrl . 'forms');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function getPublicForms($apiBaseUrl) {
    $curl = curl_init($apiBaseUrl . 'public-forms');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function getReportedForms($apiBaseUrl) {
    $curl = curl_init($apiBaseUrl . 'reported-forms');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function getFormsByUserId($apiBaseUrl, $userId) {
    $curl = curl_init($apiBaseUrl . 'users-forms/' . $userId);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function getFormById($apiBaseUrl, $formId) {
    $curl = curl_init($apiBaseUrl . 'form/' . $formId);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function reportForm($apiBaseUrl, $formId) {
    $curl = curl_init($apiBaseUrl . 'report-form/' . $formId);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function deleteForm($apiBaseUrl, $formId) {
    $curl = curl_init($apiBaseUrl . 'form/' . $formId);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}

function deleteFormsByUserId($apiBaseUrl, $userId) {
    $curl = curl_init($apiBaseUrl . 'users-forms/' . $userId);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    return isset($error_msg) ? $error_msg : $response;
}


header('Content-Type: application/json');


// $formDataWithoutFile = [
//     'user_id' => 1,
//     'title' => 'Form without Picture',
//     'description' => 'This form does not include a picture.',
//     'is_published' => '0',
//     'feedback_type' => 'suggestions',
//     'answer_time' => '2024-06-20 12:00:00'
// ];

// echo "Create Form without Picture:\n";
// echo createForm($apiBaseUrl, $formDataWithoutFile);

// $formDataWithFile = [
//     'user_id' => 1,
//     'title' => 'Form with Picture',
//     'description' => 'This form includes a picture.',
//     'is_published' => '0',
//     'feedback_type' => 'suggestions',
//     'answer_time' => '2024-06-20 12:00:00'
// ];

// $fileUpload = [
//     'error' => 0,
//     'tmp_name' => '/path/to/temporary/file', // Replace with the path to your temporary file
//     'type' => 'image/jpeg',
//     'name' => 'uploaded_image.jpg'
// ];

// echo "Create Form with Picture:\n";
// echo createForm($apiBaseUrl, $formDataWithFile, $fileUpload);



echo "Get All Forms:\n";
echo getAllForms($apiBaseUrl);

echo "Get Public Forms:\n";
echo getPublicForms($apiBaseUrl);

// echo "Get Reported Forms:\n";
// echo getReportedForms($apiBaseUrl);

// echo "\nGet Forms by User ID 3:\n";
// echo getFormsByUserId($apiBaseUrl, 3);

// echo "\nGet Form by Form ID 1:\n";
// echo getFormById($apiBaseUrl, 1);

// echo "\nReport Form with ID 6:\n";
// echo reportForm($apiBaseUrl, 6);

// echo "\nReport Form with ID 15:\n";
// echo reportForm($apiBaseUrl, 15);

// echo "\nDelete Form with ID 1:\n";
// echo deleteForm($apiBaseUrl, 1);

// echo "\nDelete Forms by User ID 1:\n";
// echo deleteFormsByUserId($apiBaseUrl, 1);

$answerData = [
    'form_id' => 2,
    'users_age' => 15,
    'content' => 'This is an answer to form 2.',
    'emotion_type' => 'Joy'
];

echo "Add Answer:\n";
echo addAnswer($apiBaseUrl, $answerData);

echo "Get Answers by Form ID 1:\n";
echo getAnswersByFormId($apiBaseUrl, 1);

echo "Get Statistics by Form ID 2:\n";
echo getStatisticsByFormId(2);

?>

