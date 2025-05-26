<div class="container py-5">
    <h1>Usuários</h1>
    <a href="/users/create" class="btn btn-primary mb-3">Adicionar Usuário</a>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!isset($users) || empty($users)): ?>
        <p>Nenhum usuário cadastrado.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Papel</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->id) ?></td>
                        <td><?= htmlspecialchars($user->name) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>
                        <td><?= htmlspecialchars($user->role) ?></td>
                        <td>
                            <a href="/users/edit/<?= htmlspecialchars($user->id) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form action="/users/delete/<?= htmlspecialchars($user->id) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir o usuário <?= htmlspecialchars($user->name) ?>?');">
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>