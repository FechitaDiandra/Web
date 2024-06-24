<?php
require_once 'BaseController.php';


class WebpagesController extends BaseController {

    public function showLoginForm() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
            $this->redirect('myaccount');
        else
            $this->render('login');
    }

    public function showAdminPage() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] === 'admin')
            $this->render('admin');
        else
        $this->redirect('login');
    }

    public function showContactPage() {
        $this->render('contact');
    }

    public function showEmailPage() {
        $this->render('email');
    }

    public function showWheel() {
        $this->render('wheel');
    }

    public function showRegisterForm() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
            $this->redirect('myaccount');
        else
            $this->render('register');
    }

    public function showMyAccountPage() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] != 'admin')
            $this->render('myaccount');
        else
            $this->redirect('home');
    }

    public function showMyFormsPage($forms) {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] != 'admin') {
            $this->render('form-history', ['forms' => $forms]);
        } else
            $this->redirect('login');
    }

    public function showInboxPage($messages) {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] === 'admin') {
            $this->render('inbox', ['messages' => $messages]);
        } else
            $this->redirect('login');
    }

    public function showCreateFormPage() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] != 'admin') {
            $this->render('create-form');
        } else
            $this->redirect('login');
    }

    public function showViewFormPage($form, $answers) {
        if (isset($_SESSION['isLogged']) && $_SESSION['isLogged']) {
            if (isset($_SESSION['id']) &&  $_SESSION['id'] === $form['user_id'] || $_SESSION['role'] === 'admin') {
                $this->render('view-form', ['form' => $form, 'answers' => $answers]);
            } else {
                $this->render('view-form', ['form' => $form, 'answers' => '']);
            }
        } else {
            $this->render('view-form', ['form' => $form, 'answers' => '']);
        }
    }

    public function showViewProfilePage($forms, $user) {
        if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
            if (isset($_SESSION['id']) &&  $_SESSION['id'] === $user['user_id'] || $_SESSION['role'] === 'admin') {
                $this->render('view-profile', ['forms' => $forms, 'user' => $user]);
            } else {
                $this->redirect('login');
            }
        else {
            $this->redirect('login');
        }
    }

    public function showStatisticsPage($statistics, $form) {
        if (isset($_SESSION['isLogged']) && $_SESSION['isLogged']) {
            if (isset($_SESSION['id']) &&  $_SESSION['id'] === $form['user_id'] || $_SESSION['role'] === 'admin') {
                $this->render('view-statistics', ['statistics' => $statistics, 'form' => $form]);
            } else {
                $this->render('view-form', ['form' => $form, 'answers' => '']);
            }
        } else {
            $this->render('view-form', ['form' => $form, 'answers' => '']);
        }
    }

    public function showHomePage($forms) {
        $this->render('home', ['forms' => $forms]);
    }

    public function showAboutUsPage() {
        $this->render('aboutus');
    }

    public function showAnswerFormPage($form) {
        $answerTime = new DateTime($form['answer_time']);
        $currentTime = new DateTime();
        $formId = $form['form_id'] ?? '';
        
        if ($currentTime > $answerTime) {
            $_SESSION['message'] = 'The feedback collection period has ended.';
            $this->redirect("view-form?id=$formId");
        }
        
        $this->render('answer-form', ['form' => $form]);
    }
    

    public function showChangeEmailForm($token) {
        $this->render('new-email-form', ['token' => $token]);
    }

    public function showResetPasswordForm($token) {
        $this->render('new-password-form', ['token' => $token]);
    }

    public function showForgotPasswordPage() {
        $this->render('forgot-password');
    }

    public function showConfirmAccountDeletionPage($token) {
        $this->render('confirm-account-deletion', ['token' => $token]);
    }
}