<?php
require_once 'controllers/UserController.php';
require_once 'controllers/FormController.php';
require_once 'controllers/WebpagesController.php';
require_once 'controllers/AnswerController.php';
require_once 'controllers/AdminController.php';
$router = Router::getInstance();

//SIMPLE PAGES RENDERING ROUTES 
$router->addRoute('GET', '/^\/login$/', function() {
    (new WebpagesController())->showLoginForm();
    exit;
});

$router->addRoute('GET', '/^\/contact$/', function() {
    (new WebpagesController())->showContactPage();
    exit;
});

$router->addRoute('GET', '/^\/email$/', function() {
    (new WebpagesController())->showEmailPage();
    exit;
});

$router->addRoute('GET', '/^\/wheel$/', function() {
    (new WebpagesController())->showWheel();
    exit;
});


$router->addRoute('GET', '/^\/admin$/', function() {
    (new WebpagesController())->showAdminPage();
    exit;
});

$router->addRoute('GET', '/^\/inbox$/', function() {
    $adminController = new AdminController();
    $messages = $adminController->getAllMessages();
    (new WebpagesController())->showInboxPage($messages);
    exit;
});

$router->addRoute('POST', '/^\/import-database$/', function() {
    (new AdminController())->importDatabase();
    (new WebpagesController())->showAdminPage();
    exit;
});

$router->addRoute('POST', '/^\/send-response$/', function() {
    (new AdminController())->sendResponse();
    exit;
});

$router->addRoute('GET', '/^\/export-database$/', function() {
    (new AdminController())->exportDatabase();
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

$router->addRoute('POST', '/^\/send-email$/', function() {
    (new UserController())->sendEmailFromContactPage();
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





//form-related routes
$router->addRoute('POST', '/^\/create-form$/', function() {
    (new FormController())->createForm();
    exit;
});

$router->addRoute('POST', '/^\/submit-feedback$/', function() {
    $id = $_POST['form_id'] ?? null;
    (new AnswerController())->answerForm($id);
    exit;
});

$router->addRoute('GET', '/^\/form-history$/', function() {
    $formController = new FormController();
    $forms = $formController->getFormsByLoggedUser();
    (new WebpagesController())->showMyFormsPage($forms);
    exit;
});

$router->addRoute('GET', '/^\/home$/', function() {
    $formController = new FormController();
    $forms = $formController->getLatestForms();
    (new WebpagesController())->showHomePage($forms);
    exit;
});

$router->addRoute('GET', '/^\/$/', function() {
    $formController = new FormController();
    $forms = $formController->getLatestForms();
    (new WebpagesController())->showHomePage($forms);
    exit;
});

$router->addRoute('GET', '/^\/delete-form$/', function() {
    $id = $_GET['id'] ?? null;
    (new FormController())->deleteForm($id);
    exit;
});

$router->addRoute('GET', '/^\/view-form$/', function() {
    $id = $_GET['id'] ?? null;
    $formController = new FormController();
    $answerController = new AnswerController();
    $form = $formController->getFormById($id);
    $answers = $answerController->getAnswersByFormId($id);
    (new WebpagesController())->showViewFormPage($form, $answers);
    exit;
});

$router->addRoute('GET', '/^\/view-profile$/', function() {
    $id = $_GET['id'] ?? null;
    $formController = new FormController();
    $userController = new UserController();
    $forms = $formController->getFormsByUserId($id);
    $user = $userController->getUserById($id);
    (new WebpagesController())->showViewProfilePage($forms, $user);
    exit;
});

$router->addRoute('GET', '/^\/answer-form$/', function() {
    $id = $_GET['id'] ?? null;
    $formController = new FormController();
    $form = $formController->getFormById($id);
    (new WebpagesController())->showAnswerFormPage($form);
    exit;
});

$router->addRoute('GET', '/^\/report-form$/', function() {
    $id = $_GET['id'] ?? null;
    $formController = new FormController();
    $report = $formController->reportForm($id);
    exit;
});

$router->addRoute('GET', '/^\/view-statistics$/', function() {
    $id = $_GET['id'] ?? null;
    $answerController = new AnswerController();
    $formController = new FormController();
    $form = $formController->getFormById($id);
    $statistics = $answerController->getStatisticsByFormId($id);
    (new WebpagesController())->showStatisticsPage($statistics, $form);
    exit;
});

$router->addRoute('GET', '/^\/export$/', function() {
    $formId = $_GET['id'] ?? null;
    $type = $_GET['type'] ?? null;

    $answerController = new AnswerController();
    $formController = new FormController();
    $form = $formController->getFormById($formId);
    if ($form) {
        $statistics = $answerController->getStatisticsByFormId($formId);
        if ($statistics) {
            $exportData = $answerController->exportStatistics($statistics, $formId, $type);
            if ($exportData !== false) {
                header("Content-Type: application/octet-stream");
                header("Content-Disposition: attachment; filename=statistics_export.$type");

                echo $exportData;
                exit;
            }
        }
    }
    $this->redirect("view-statistics?id=$formId");

});

$router->route();
?>