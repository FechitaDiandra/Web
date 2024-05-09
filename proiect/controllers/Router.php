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
        $requestPath = strtolower(strtok($requestPath, '?'));
        //echo "Request Path: $requestPath<br>";

        $basePath = strtolower(str_replace('/index.php', '', str_replace(' ', '', $_SERVER['SCRIPT_NAME'])));
        //echo "Base Path: $basePath<br>";
        
        // Eliminăm spațiile din calea primită din URL
        $requestPath = str_replace(' ', '', $requestPath);
        //echo "Modified Request Path: $requestPath<br>";

        $path = str_replace($basePath, '', $requestPath);
        //echo "Path: $path<br>";

        $controller = null;
        $method = null;
        $params = [];

        foreach ($this->routes as $route => $handler) {
            $pattern = '#^' . preg_replace('#\{[a-zA-Z]+\}#', '([a-zA-Z0-9-]+)', strtolower($route)) . '$#';
            if (preg_match($pattern, $path, $matches)) {
                $controller = $handler[0];
                $method = $handler[1];

                // Eliminăm primul element din $matches, deoarece acesta conține întreaga potrivire a șablonului de rută
                array_shift($matches);
                $params = $matches;

                break;
            }
        }

        if ($controller && $method) {
            require_once 'controllers/' . $controller . '.php';
            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $method)) {
                    call_user_func_array([$controllerInstance, $method], $params);
                } else {
                    echo '404 Not Found: Method Not Found';
                }
            } else {
                echo '404 Not Found: Controller Not Found';
            }
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }
}
