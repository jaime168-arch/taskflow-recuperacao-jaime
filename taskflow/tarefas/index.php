
<?php

require '../config/database.php';

$pageTitle = 'Tarefas';

$status = $_GET['status'] ?? '';

$sql = 'SELECT * FROM tarefas';

if ($status !== '') {
    $sql .= ' WHERE status = ?';
}

$sql .= ' ORDER BY prazo';

$q = $pdo->prepare($sql);

if ($status !== '') {
    $q->execute([$status]);
} else {
    $q->execute();
}

$tarefas = $q->fetchAll(PDO::FETCH_ASSOC);

require '../includes/header.php';

?>

<div class="head">
    <div>
        <h1>Tarefas</h1>
        <p class="muted">Cadastre e acompanhe as atividades.</p>
    </div>

    <a class="btn" href="form.php">+ Nova tarefa</a>
</div>

<section class="panel">

    <form method="get" style="display:flex;gap:10px;align-items:end">

        <div class="field">
            <label>Filtrar por status</label>

            <select name="status">
                <option value="">Todos</option>

                <?php foreach (['Pendente', 'Em andamento', 'Concluída'] as $s): ?>
                    <option value="<?= htmlspecialchars($s) ?>" <?= $status === $s ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <button class="btn gray">Filtrar</button>

    </form>

    <div class="scroll">

        <table>

            <tr>
                <th>Tarefa</th>
                <th>Responsável</th>
                <th>Prazo</th>
                <th>Prioridade</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($tarefas as $t): ?>

                <tr>
                    <td><?= htmlspecialchars($t['titulo']) ?></td>

                    <td><?= htmlspecialchars($t['responsavel']) ?></td>

                    <td><?= date('d/m/Y', strtotime($t['prazo'])) ?></td>

                    <td><?= htmlspecialchars($t['prioridade']) ?></td>

                    <td><?= htmlspecialchars($t['status']) ?></td>

                    <td>
                        <a class="btn gray" href="form.php?id=<?= (int)$t['id'] ?>">Editar</a>

                        <a class="btn red" href="excluir.php?id=<?= (int)$t['id'] ?>">Excluir</a>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>

    </div>

</section>

<?php require '../includes/footer.php'; ?>
