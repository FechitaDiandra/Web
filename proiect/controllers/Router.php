<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Router {
    private $routes;
    private static $instance = null;

    public function __construct() {
        $this->routes = [
            '/' => ['HomeController', 'index'],
            '/index.php' => ['HomeController', 'index'],
            '/home.php' => ['HomeController', 'index'],
            '/logout.php' => ['LogoutController', 'index'],
            '/aboutus.php' => ['AboutUsController', 'index'],
            '/admin.php' => ['AdminController', 'index'],
            '/answer-form.php' => ['AnswerFormController', 'index'],
            '/created-form-confirmation.php' => ['CreatedFormConfirmationController', 'index'],
            '/create-form.php' => ['CreateFormController', 'index'],
            '/form-history.php' => ['FormHistoryController', 'index'],
            '/login.php' => ['LoginController', 'index'],
            '/signup.php' => ['SignUpController', 'index'],
            '/myaccount.php' => ['MyAccountController', 'index'],
            '/submitted.php' => ['SubmittedFeedbackController', 'index'],
            '/view-statistics.php' => ['ViewStatisticsController', 'index'],
            '/new-email-form.php' => ['MyAccountController', 'index'],
            '/change-email.php' => ['ChangeEmailController', 'index'],
            '/delete-account.php' => ['DeleteAccountController', 'index'],
            '/reset-password.php' => ['ResetPasswordController', 'index']
            // Eliminat: '/delete-form.php' => ['DeleteController', 'delete']
        ];
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function route() {
        $requestPath = $_SERVER['REQUEST_URI'];
        $path = strtolower(strtok($requestPath, '?'));

        $basePath = strtolower(str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']));
        $path = str_replace(' ', '', str_replace($basePath, '', $path));

        if (isset($this->routes[$path])) {
            $controllerName = $this->routes[$path][0];
            $methodName = $this->routes[$path][1];
            $this->loadController($controllerName, $methodName);
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }

    private function loadController($controller, $method) {
        require_once 'controllers/' . $controller . '.php';
        if (class_exists($controller)) {
            $controllerInstance = new $controller();
            if (method_exists($controllerInstance, $method)) {
                call_user_func([$controllerInstance, $method]);
            } else {
                echo '404 Not Found: Method Not Found';
            }
        } else {
            echo '404 Not Found: Controller Not Found';
        }
    }
}
?>
