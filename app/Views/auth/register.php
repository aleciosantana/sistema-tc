<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow p-4" style="min-width: 350px; max-width: 450px; width: 100%;">
        <h2 class="mb-4 text-center">Registrar Cliente</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" action="/register">
            <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($client->name ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($client->email ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Endereço:</label>
                <input type="text" name="address" id="address" class="form-control" value="<?= htmlspecialchars($client->address ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Registrar</button>
            <div class="mt-3 text-center">
                <span>Já tem conta? <a href="/login">Entrar</a></span>
            </div>
        </form>
    </div>
</div>