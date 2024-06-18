<?php
$apiBaseUrl = 'http://localhost/web/proiect/services/UserService/';


function getAllUsers($apiBaseUrl) {
    $curl = curl_init($apiBaseUrl . 'users');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function getUserByEmail($apiBaseUrl, $email) {
    $curl = curl_init($apiBaseUrl . 'user/' . $email);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function getUserById($apiBaseUrl, $id) {
    $curl = curl_init($apiBaseUrl . 'user/' . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}


function deleteUser($apiBaseUrl, $userId) {
    $curl = curl_init($apiBaseUrl . 'user/' . $userId);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function createUser($apiBaseUrl, $userData) {
    $curl = curl_init($apiBaseUrl . 'user');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($userData));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);

    return isset($error_msg) ? $error_msg : $response;
}

function updateUser($apiBaseUrl, $userId, $userData) {
    $curl = curl_init($apiBaseUrl . 'user/' . $userId);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($userData));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);

    return isset($error_msg) ? $error_msg : $response;
}


header('Content-Type: application/json');

//TESTING REQUESTS: UNCOMMENT THE REQUESTS YOU WANT TO TEST
echo "Get All Users:\n";
echo (getAllUsers($apiBaseUrl));


echo "\nGet User with email amihaesiisimona5@gmail.com:\n";
echo (getUserByEmail($apiBaseUrl, 'amihaesiisimona5@gmail.com'));

echo "\nGet User with email 7:\n";
echo (getUserById($apiBaseUrl, 7));

//UPDATE A USER
// $updateData = [
//     'delete_account_token' => '1234567898765'
//     //include any fields you want to update
// ];
// echo "\nUpdate User with ID 28:\n";
// echo updateUser($apiBaseUrl, 28, $updateData);


//DELETE A USER
// echo "\nDelete User with ID 5:\n";
// echo deleteUser($apiBaseUrl, 5);


//CREATE A USER
// $userData = [
//     'username' => 'newuser',
//     'email' => 'newuser@example.com',
//     'password' => 'password123'
// ];

// echo "Create User:\n";
// echo createUser($apiBaseUrl, $userData);