<?php

namespace Core;

class View
{
    public function __construct(
        protected string $view,
        protected array $params = []
    ) {}

    public static function show(string $view, array $params = []): void
    {
        $response = new self($view, $params);
        echo $response->render();
        exit();
    }

    public static function DBException(array $e): void
    {
        http_response_code(500);
        $e['code'] = http_response_code();
        $error = new self('error/error', $e);
        echo $error->render(true);
        exit();
    }

    public static function NotFound(string $errorBody = 'Page not found.'): void
    {

        http_response_code(404);
        $info = [
            'title' => 'Not found',
            'error' => $errorBody,
            'code' => http_response_code(),
        ];
        $error = new self('error/error', $info);
        echo $error->render(true);
        exit();
    }

    public static function Forbidden(): void
    {
        http_response_code(403);
        $info = [
            'title' => 'Forbidden',
            'error' => 'Access to the requested resource is forbidden.',
            'code' => http_response_code()
        ];
        $error = new self('error/error', $info);
        echo $error->render(true);
        exit();
    }

    public static function renderEmail(string $view, array $params = []): string
    {
        extract($params);
        $slot = VIEWS_PATH . "{$view}.php";
        ob_start();

        if (file_exists($slot)) {
            include $slot;
        } else {
            ob_get_clean();
            self::NotFound('View not found');
        }

        return ob_get_clean();
    }

    protected function render(bool $exception = false): void
    {
        $title = $this->params['title'] ?? "Default";
        $slot = VIEWS_PATH . "{$this->view}.php";
        $layout = VIEWS_PATH . "layout.php";
        extract($this->params);
        // Views for exceptions 500,404,403 doesn't have layout.
        if ($exception) {
            $layout = $slot;
        }

        if (file_exists($slot)) {
            include $layout;
        } else {
            self::NotFound('View not found');
        }
    }
}
