<div class="container-fluid p-0">
    <!-- Hero Section -->
    <section class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4"><?php echo htmlspecialchars($title); ?></h1>
            <p class="lead"><?php echo htmlspecialchars($message); ?></p>
            <a href="/products" class="btn btn-light btn-lg mt-3">Explore Nossos Produtos</a>
        </div>
    </section>

    <!-- Recursos -->
    <section class="py-5">
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
    </section>

    <!-- Produtos em Destaque (Dados Mocados) -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Produtos em Destaque</h2>
            <div class="row">
                <?php
                $mockProducts = [
                    ['id' => 1, 'name' => 'Etiqueta Adesiva', 'description' => 'Etiqueta personalizada para embalagens.', 'price' => 29.90],
                    ['id' => 2, 'name' => 'Rótulo Térmico', 'description' => 'Rótulo resistente para produtos industriais.', 'price' => 45.00],
                    ['id' => 3, 'name' => 'Tag Personalizada', 'description' => 'Tags para identificação de produtos.', 'price' => 15.50],
                ];
                foreach ($mockProducts as $product) {
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="card-text"><strong>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></strong></p>
                                <a href="/products/view/<?php echo $product['id']; ?>" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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