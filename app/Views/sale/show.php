<div class="container my-5">
    <!-- Produto principal estilo vitrine -->
    <div class="row bg-white shadow-sm rounded-4 py-3 align-items-center mb-5">
        <div class="col-md-5 text-center">
            <?php if (!empty($product->image)): ?>
                <img src="<?= htmlspecialchars($product->image) ?>" class="img-fluid rounded-4 border" style="max-height:340px;object-fit:contain;background:#f8f9fa;" alt="<?= htmlspecialchars($product->name) ?>">
            <?php else: ?>
                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height:340px;">
                    <span class="text-muted">Sem imagem</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-7">
            <h2 class="fw-bold mb-3"><?= htmlspecialchars($product->name) ?></h2>
            <p class="text-muted mb-3 fs-5"><?= htmlspecialchars($product->description) ?></p>
            <div class="mb-4">
                <span class="fs-2 fw-bold text-success">R$ <?= number_format($product->price, 2, ',', '.') ?></span>
            </div>
            <form method="post" action="/cart/add" class="row g-2 align-items-center mb-3">
                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                <div class="col-auto">
                    <input type="number" name="quantity" value="1" min="1" class="form-control text-center" style="width:80px;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success px-5">Adicionar ao carrinho</button>
                </div>
            </form>
            <a href="/cart" class="btn btn-outline-primary btn-sm mt-2">Ir para o carrinho</a>
        </div>
    </div>

    <!-- Outros produtos estilo vitrine -->
    <?php if (!empty($otherProducts)): ?>
        <h3 class="mb-4 text-center fw-semibold text-primary">Você também pode gostar</h3>
        <div class="row g-4">
            <?php foreach ($otherProducts as $other): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 hover-shadow">
                        <?php if (!empty($other->image)): ?>
                            <img src="<?= htmlspecialchars($other->image) ?>" class="card-img-top p-3 rounded-4" style="object-fit:contain;max-height:180px;background:#f8f9fa;" alt="<?= htmlspecialchars($other->name) ?>">
                        <?php else: ?>
                            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height:180px;">
                                <span class="text-muted">Sem imagem</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column text-center">
                            <h6 class="card-title mb-2"><?= htmlspecialchars($other->name) ?></h6>
                            <div class="mb-2 text-success fw-bold">R$ <?= number_format($other->price, 2, ',', '.') ?></div>
                            <a href="/product/<?= $other->id ?>" class="btn btn-outline-primary btn-sm mt-auto">Ver detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>