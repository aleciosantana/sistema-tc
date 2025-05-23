<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fábrica de Campeões</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Fábrica de Campeões</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/' ? 'active' : ''; ?>" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/products' ? 'active' : ''; ?>" href="/products">Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/orders' ? 'active' : ''; ?>" href="/orders">Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/clients' ? 'active' : ''; ?>" href="/clients">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/deliveries' ? 'active' : ''; ?>" href="/deliveries">Entregas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Fábrica de Campeões. Todos os direitos reservados.</p>
    </footer>
    <!-- Bootstrap 5 JS e Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</body>
</html>