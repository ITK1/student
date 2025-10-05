<?php
// Các hàm tiện ích: render view, url, flash message, validate

function base_url(string $path = ''): string {
    $base = rtrim(BASE_PATH, '/');
    $path = ltrim($path, '/');
    return $base . '/' . $path;
}

function h(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void {
    header('Location: ' . base_url($path));
    exit;
}

function flash_set(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_get(): ?array {
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function render_view(string $view, array $params = []): string {
    extract($params, EXTR_SKIP);
    ob_start();
    if ($view === 'layout') {
        require __DIR__ . '/../views/layout.php';
    } else {
        require __DIR__ . '/../views/' . $view . '.php';
    }
    return (string)ob_get_clean();
}

function validate(array $data, array $rules): array {
    // rules ví dụ: ['name' => 'required', 'email' => 'required|email']
    $errors = [];
    foreach ($rules as $field => $ruleStr) {
        $value = isset($data[$field]) ? trim((string)$data[$field]) : '';
        $ruleList = explode('|', $ruleStr);
        foreach ($ruleList as $rule) {
            if ($rule === 'required' && $value === '') {
                $errors[$field] = 'Trường bắt buộc';
            }
            if ($rule === 'email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = 'Email không hợp lệ';
            }
            if (str_starts_with($rule, 'max:')) {
                $max = (int)substr($rule, 4);
                if (mb_strlen($value) > $max) {
                    $errors[$field] = 'Tối đa ' . $max . ' ký tự';
                }
            }
        }
    }
    return $errors;
}





