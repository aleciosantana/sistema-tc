<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="w-100" style="max-width: 800px;">
        <h1 class="mb-4 text-center fw-bold text-primary">
            <i class="bi bi-cart4"></i> Carrinho de Compras
        </h1>

        <?php if (!empty($items)): ?>
            <div class="card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th>Produto</th>
                                    <th>Preço</th>
                                    <th>Quantidade</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                <?php foreach ($items as $item): ?>
                                    <?php
                                        $subtotal = $item['product']->price * $item['quantity'];
                                        $total += $subtotal;
                                    ?>
                                    <tr class="text-center">
                                        <td class="text-start">
                                            <span class="fw-semibold"><?= htmlspecialchars($item['product']->name) ?></span>
                                        </td>
                                        <td>R$ <?= number_format($item['product']->price, 2, ',', '.') ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5">Total:</td>
                                    <td class="fw-bold fs-5">R$ <?= number_format($total, 2, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="/" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-arrow-left"></i> Continuar comprando
                        </a>
                        <a href="/checkout" class="btn btn-success btn-lg">
                            <i class="bi bi-cash-coin"></i> Finalizar compra
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card shadow-lg">
                <div class="card-body text-center p-5">
                    <i class="bi bi-cart-x display-1 text-secondary mb-3"></i>
                    <h4 class="mb-3 text-secondary">Seu carrinho está vazio.</h4>
                    <a href="/produtos" class="btn btn-primary btn-lg">
                        <i class="bi bi-bag-plus"></i> Ver produtos
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>