<?php

namespace Helper;

use Core\App;

class Request
{

    public function __construct(
        protected array $data
    ) {}
    /**
     * Checks if the current request matches a specific route name.
     *
     * @param mixed $name The route name to check against.
     * @return bool Returns true if the route matches, false otherwise.
     */
    public function isRoute($name): bool
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];
        return App::isRoute($path, $name);
    }
    /**
     * Checks if a specific key exists in the request data.
     *
     * @param string $key The key to check for.
     * @return bool Returns true if the key exists, false otherwise.
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->data);
    }
    /**
     * Retrieves and sanitizes a value from the request data by key.
     *
     * @param string $key The key of the value to retrieve.
     * @return string Returns the sanitized value or an empty string if the key does not exist.
     */
    public function get($key): string
    {
        if (isset($this->data[$key])) {
            return htmlspecialchars(trim($this->data[$key]));
        }

        return '';
    }

    public function navigatePrevUrl()
    {
        $url = $_SERVER['HTTP_REFERER'] ?? '';

        redirect($url);
    }
}
