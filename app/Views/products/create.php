<div class="container py-5">
    <h1>Criar Produto</h1>
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="/products/save">
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product->name ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea class="form-control" id="description" name="description"><?= htmlspecialchars($product->description ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Preço</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product->price ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="stock_quantity" class="form-label">Quantidade em Estoque</label>
            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product->stock_quantity ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/products" class="btn btn-secondary">Cancelar</a>
    </form>
</div>