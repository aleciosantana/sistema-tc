<div class="container-fluid p-0">
    <!-- Hero Section -->
    <section class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4"><?= $title ?></h1>
            <p class="lead"><?= $message ?></p>
            <a href="/products" class="btn btn-light btn-lg mt-3">Explore Nossos Produtos</a>
        </div>
    </section>

    <!-- Recursos -->
    <!-- <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Por que Escolher Nosso Sistema?</h2>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Gestão de Pedidos</h5>
                            <p class="card-text">Controle pedidos de forma eficiente, do recebimento à entrega.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Controle de Estoque</h5>
                            <p class="card-text">Monitore o estoque em tempo real para evitar rupturas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Gerenciamento de Clientes</h5>
                            <p class="card-text">Mantenha um cadastro organizado e atualizado dos clientes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Rastreio de Entregas</h5>
                            <p class="card-text">Acompanhe as entregas com status atualizados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Produtos em Destaque (Dados Mocados) -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Produtos em Destaque</h2>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product->name ?></h5>
                                <p class="card-text"><?= $product->description ?></p>
                                <p class="card-text"><strong>R$ <?= number_format($product->price, 2, ',', '.') ?></strong></p>
                                <a href="/products/view/<?php echo $product->id; ?>" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-primary text-white text-center py-5">
        <div class="container">
            <h2 class="mb-4">Pronto para Modernizar sua Gestão?</h2>
            <a href="/products" class="btn btn-light btn-lg">Comece Agora</a>
        </div>
    </section>
</div>