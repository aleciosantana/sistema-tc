<?php
namespace App\Core;

class View
{
    public static function render($view, $layout = 'layouts/main', $data = [])
    {
        // Inicia o buffer de saída para capturar o conteúdo da view
        ob_start();
        extract($data);
        require_once __DIR__ . '/../Views/' . $view . '.php';
        $content = ob_get_clean();

        // Renderiza o layout com o conteúdo da view
        require_once __DIR__ . '/../Views/' . $layout . '.php';
    }
}