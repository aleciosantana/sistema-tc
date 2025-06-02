<div class="container py-5">
    <h1>Produtos</h1>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    <a href="/products/create" class="btn btn-primary mb-3">Adicionar Produto</a>
    <?php if (empty($products)): ?>
        <p>Nenhum produto disponível.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product->id) ?></td>
                        <td><?= htmlspecialchars($product->name) ?></td>
                        <td><?= htmlspecialchars($product->description) ?></td>
                        <td>R$ <?= number_format($product->price, 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($product->stock_quantity) ?></td>
                        <td>
                            <a href="/products/edit/<?= htmlspecialchars($product->id) ?>" class="btn btn-warning btn-sm">Editar</a>
                            <form action="/products/delete/<?= htmlspecialchars($product->id) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>