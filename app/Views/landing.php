<div class="container py-5 text-center">
    <h1>Bem-vindo à Loja TC</h1>
    <p class="lead">Compre os melhores produtos com facilidade e segurança.</p>
    <?php if (!isset($_SESSION['auth_id'])): ?>
        <p>Crie uma conta ou faça login para começar suas compras!</p>
        <a href="/register" class="btn btn-primary">Registrar</a>
        <a href="/login" class="btn btn-outline-primary">Login</a>
    <?php else: ?>
        <p>Explore nossa loja: <a href="/products" class="btn btn-primary">Ver Produtos</a></p>
    <?php endif; ?>
</div>