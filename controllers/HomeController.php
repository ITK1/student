<?php

class HomeController {
    public function __construct(private PDO $pdo) {}

    public function index(): string {
        $content = render_view('home/index', []);
        return render_view('layout', [
            'title' => APP_NAME,
            'content' => $content,
        ]);
    }
}





