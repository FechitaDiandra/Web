<?php
require_once 'BaseController.php';


class WebpagesController extends BaseController {

    public function showLoginForm() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
            $this->redirect('myaccount');
        else
            $this->render('login');
    }

    public function showRegisterForm() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
            $this->redirect('myaccount');
        else
            $this->render('register');
    }

    public function showMyAccountPage() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
            $this->render('myaccount');
        else
            $this->redirect('login');
    }

    public function showMyFormsPage() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
            $this->render('form-history');
        else
            $this->redirect('login');
    }

    public function showCreateFormPage() {
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
            $this->render('create-form');
        else
            $this->redirect('login');
    }

    public function showAboutUsPage() {
        $this->render('aboutus');
    }

    public function showHomePage() {
        $this->render('home');
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