<?php
namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
    public function index() {
        // Zobrazení hlavní stránky
        $this->view('home');
    }
}
