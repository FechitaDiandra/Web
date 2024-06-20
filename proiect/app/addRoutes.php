<?php
require_once 'controllers/UserController.php';
require_once 'controllers/WebpagesController.php';
$router = Router::getInstance();

//PAGE RENDERING ROUTES
$router->addRoute('GET', '/^\/home$/', function() {
    (new WebpagesController())->showHomePage();
    exit;
});

$router->addRoute('GET', '/^\/$/', function() {
    (new WebpagesController())->showHomePage();
    exit;
});

$router->addRoute('GET', '/^\/login$/', function() {
    (new WebpagesController())->showLoginForm();
    exit;
});

$router->addRoute('GET', '/^\/aboutus$/', function() {
    (new WebpagesController())->showAboutUsPage();
    exit;
});

$router->addRoute('GET', '/^\/register$/', function() {
    (new WebpagesController())->showRegisterForm();
    exit;
});

$router->addRoute('GET', '/^\/myaccount$/', function() {
    (new WebpagesController())->showMyAccountPage();
    exit;
});

$router->addRoute('GET', '/^\/create-form$/', function() {
    (new WebpagesController())->showCreateFormPage();
    exit;
});

$router->addRoute('GET', '/^\/form-history$/', function() {
    (new WebpagesController())->showMyFormsPage();
    exit;
});

$router->addRoute('GET', '/^\/forgot-password$/', function() {
    (new WebpagesController())->showForgotPasswordPage();
    exit;
});




// User-related methods
$router->addRoute('POST', '/^\/register$/', function() {
    (new UserController())->register();
    exit;
});

$router->addRoute('POST', '/^\/login$/', function() {
    (new UserController())->login();
    exit;
});

$router->addRoute('GET', '/^\/logout$/', function() {
    (new UserController())->logout();
    exit;
});

$router->addRoute('POST', '/^\/update-username$/', function() {
    (new UserController())->updateUsername();
    exit;
});



//RESET PASSWORD ROUTES
//CHANGE PASSWORD FROM MYACCOUNT PAGE
$router->addRoute('POST', '/^\/change-password$/', function() {
    (new UserController())->changePassword();
    exit;
});

//RESET PASSWORD FROM FORGOT PASSWORD (LOGIN PAGE)
$router->addRoute('POST', '/^\/reset-password-form$/', function() {
    (new UserController())->resetPassword();
    exit;
});

//THE LINK FROM THE EMAIL IS ACCESSED
$router->addRoute('GET', '/^\/reset-password$/', function() {
    $token = $_GET['token'] ?? null;
    $userController = new UserController();
    if ($userController->isResetPasswordTokenValid($token)) {
        (new WebpagesController())->showResetPasswordForm($token);
        exit;
    } else {
        $_SESSION['message'] = 'The link is invalid or has expired.';
        (new WebpagesController())->showMyAccountPage();
        exit;
    }
});

//the form has been filled with password and password-repeat
$router->addRoute('POST', '/^\/confirm-reset-password$/', function() {
    (new UserController())->confirmResetPassword();
    exit;
});




//DELETE ACCOUNT ROUTES
//the delete account button from 'myaccount' page is pressed
$router->addRoute('POST', '/^\/delete-account$/', function() {
    (new UserController())->deleteAccount();
    exit;
});

//the link from the email is accessed
$router->addRoute('GET', '/^\/delete-account$/', function() {
    $token = $_GET['token'] ?? null;
    $userController = new UserController();
    if ($userController->isDeleteAccountTokenValid($token)) {
        (new WebpagesController())->showConfirmAccountDeletionPage($token);
        exit;
    } else {
        $_SESSION['message'] = 'The link is invalid or has expired.';
        (new WebpagesController())->showMyAccountPage();
        exit;
    }
});

//the confirm button has been pressed
$router->addRoute('POST', '/^\/confirm-account-deletion$/', function() {
    (new UserController())->confirmAccountDeletion(); //implement the deletion
    exit;
});




//CHANGE EMAIL ROUTES
//the change email button from 'myaccount' page is pressed
$router->addRoute('POST', '/^\/change-email$/', function() {
    (new UserController())->changeEmail();
    exit;
});

//the link from the email is accessed
$router->addRoute('GET', '/^\/change-email$/', function() {
    $token = $_GET['token'] ?? null;
    $userController = new UserController();
    if ($userController->isChangeEmailTokenValid($token)) {
        (new WebpagesController())->showChangeEmailForm($token);
        exit;
    } else {
        $_SESSION['message'] = 'The link is invalid or has expired.';
        (new WebpagesController())->showMyAccountPage();
        exit;
    }
});

//the submit button from the 'new email form' has been pressed
$router->addRoute('POST', '/^\/confirm-change-email$/', function() {
    (new UserController())->confirmEmailChange();
    exit;
});
$router->addRoute('POST', '#^/update-profile-picture$#', [new UserController(), 'updateProfilePicture']);
//$router->addRoute('POST', '#^/send-message$#', [new UserController(), 'handleContactFormSubmission']);
;
$router->addRoute('GET', '/^\/export_data$/', function() {
    require_once 'database/export_data.php';
    exit;
});

$router->addRoute('POST', '/^\/import_data$/', function() {
    require_once 'database/import_data.php';
    exit;
});

$router->route();
?>