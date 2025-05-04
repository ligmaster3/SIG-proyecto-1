<?php
// Autoload básico
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/controllers/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }

    $file = __DIR__ . '/models/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Obtener controlador y acción
$controller = $_GET['controller'] ?? 'libros';
$action = $_GET['action'] ?? 'index';

// Formar nombre del controlador
$controllerClass = ucfirst($controller) . 'Controller';

// Verificar si el controlador existe
if (class_exists($controllerClass)) {
    $controllerInstance = new $controllerClass();

    // Verificar si la acción existe
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        // Error 404 - Acción no encontrada
        header("HTTP/1.0 404 Not Found");
        require_once 'views/layout/error_404.php';
    }
} else {
    // Error 404 - Controlador no encontrado
    header("HTTP/1.0 404 Not Found");
    require_once 'views/layout/error_404.php';
}