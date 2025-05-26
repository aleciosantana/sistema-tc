<div class="container py-5">
    <h1>Criar Usuário</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="/users/create" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user->name ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user->email ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Papel</label>
            <select class="form-control" id="role" name="role">
                <option value="admin" <?= ($user->role ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="manager" <?= ($user->role ?? '') === 'manager' ? 'selected' : '' ?>>Gerente</option>
                <option value="employee" <?= ($user->role ?? '') === 'employee' ? 'selected' : '' ?>>Funcionário</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/users" class="btn btn-secondary">Cancelar</a>
    </form>
</div>