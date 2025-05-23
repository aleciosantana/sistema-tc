<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fábrica de Campeões</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <h1>Fábrica de Campeões</h1>
        <nav>
            <a href="/">Home</a>
            <a href="/products">Produtos</a>
            <a href="/orders">Pedidos</a>
            <a href="/clients">Clientes</a>
            <a href="/deliveries">Entregas</a>
        </nav>
    </header>
    <main>
        <?= $content; ?>
    </main>
    <footer>
        <p>&copy; 2025 Fábrica de Campeões</p>
    </footer>
    <script src="/js/main.js"></script>
</body>
</html>