
<?php

require '../config/database.php';

$id = (int)($_GET['id'] ?? 0);

$t = [
    'titulo' => '',
    'descricao' => '',
    'responsavel' => '',
    'categoria' => 'Geral',
    'prazo' => date('Y-m-d'),
    'prioridade' => 'Média',
    'status' => 'Pendente'
];

if ($id) {
    $q = $pdo->prepare('SELECT * FROM tarefas WHERE id=?');
    $q->execute([$id]);
    $t = $q->fetch(PDO::FETCH_ASSOC) ?: $t;
}

$pageTitle = $id ? 'Editar tarefa' : 'Nova tarefa';

require '../includes/header.php';

?>

<div class="head">
    <h1><?= $pageTitle ?></h1>
    <a class="btn gray" href="index.php">Voltar</a>
</div>

<?php if (isset($_GET['erro'])): ?>
    <p class="alert">Erro ao gravar. Verifique os dados.</p>
<?php endif; ?>

<section class="panel">

    <form method="post" action="salvar.php" class="grid">

        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="field full">
            <label>Título *</label>
            <input
                name="titulo"
                required
                value="<?= htmlspecialchars($t['titulo'], ENT_QUOTES, 'UTF-8') ?>"
            >
        </div>

        <div class="field full">
            <label>Descrição</label>
            <textarea name="descricao"><?= htmlspecialchars($t['descricao'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="field">
            <label>Responsável *</label>
            <input
                name="responsavel"
                required
                value="<?= htmlspecialchars($t['responsavel'], ENT_QUOTES, 'UTF-8') ?>"
            >
        </div>

        <div class="field">
            <label>Categoria</label>
            <select name="categoria">
                <?php foreach (['Geral', 'Desenvolvimento', 'Documentação', 'Suporte', 'Qualidade'] as $v): ?>
                    <option value="<?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>" <?= $t['categoria'] === $v ? 'selected' : '' ?>>
                        <?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label>Prazo *</label>
            <input
                type="date"
                name="prazo"
                required
                value="<?= htmlspecialchars($t['prazo'], ENT_QUOTES, 'UTF-8') ?>"
            >
        </div>

        <div class="field">
            <label>Prioridade</label>
            <select name="prioridade">
                <?php foreach (['Baixa', 'Média', 'Alta'] as $v): ?>
                    <option value="<?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>" <?= $t['prioridade'] === $v ? 'selected' : '' ?>>
                        <?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label>Status</label>
            <select name="status">
                <?php foreach (['Pendente', 'Em andamento', 'Concluída'] as $v): ?>
                    <option value="<?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>" <?= $t['status'] === $v ? 'selected' : '' ?>>
                        <?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field full">
            <button class="btn">Gravar tarefa</button>
        </div>

    </form>

</section>

<?php require '../includes/footer.php'; ?>
