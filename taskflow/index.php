<?php
require 'config/database.php';

$pageTitle = 'Dashboard';

// Total de tarefas cadastradas
$total = $pdo->query(
    'SELECT COUNT(*) FROM tarefas'
)->fetchColumn();

// Tarefas em andamento
$andamento = $pdo->query(
    "SELECT COUNT(*) FROM tarefas WHERE status = 'Em andamento'"
)->fetchColumn();

// Tarefas concluídas
$concluidas = $pdo->query(
    "SELECT COUNT(*) FROM tarefas WHERE status = 'Concluido'"
)->fetchColumn();

// Chamados abertos
$abertos = $pdo->query(
    "SELECT COUNT(*) FROM chamados WHERE status = 'Aberto'"
)->fetchColumn();

// Tarefas prioritárias: somente prioridade Alta
$prioritarias = $pdo->query(
    "SELECT COUNT(*) FROM tarefas WHERE prioridade = 'Alta'"
)->fetchColumn();

// Últimas cinco tarefas cadastradas
$recentes = $pdo->query(
    'SELECT * FROM tarefas ORDER BY id DESC LIMIT 5'
)->fetchAll();

require 'includes/header.php';
?>

<div class="head">
    <div>
        <p class="muted">VISÃO GERAL</p>
        <h1>Dashboard</h1>
        <p class="muted">
            Organize atividades e acompanhe entregas.
        </p>
    </div>

    <a class="btn" href="tarefas/form.php">
        + Nova tarefa
    </a>
</div>

<section class="stats">

    <div class="stat">
        <span class="num"><?= $total ?></span>
        Tarefas cadastradas
    </div>

    <div class="stat">
        <span class="num"><?= $andamento ?></span>
        Em andamento
    </div>

    <div class="stat">
        <span class="num"><?= $concluidas ?></span>
        Concluídas
    </div>

    <div class="stat">
        <span class="num"><?= $prioritarias ?></span>
        Tarefas prioritárias (Alta)
    </div>

    <div class="stat">
        <span class="num"><?= $abertos ?></span>
        Chamados abertos
    </div>

</section>

<section class="panel">

    <div class="head">
        <h2>Tarefas recentes</h2>

        <a class="btn gray" href="tarefas/index.php">
            Ver tarefas
        </a>
    </div>

    <div class="scroll">
        <table>
            <tr>
                <th>Tarefa</th>
                <th>Responsável</th>
                <th>Prioridade</th>
                <th>Status</th>
            </tr>

            <?php foreach ($recentes as $t): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($t['titulo']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($t['responsavel']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($t['prioridade']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($t['status']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>

</section>

<section class="panel">

    <h2>Central de chamados</h2>

    <p>
        Reproduza a falha, investigue o código,
        corrija e registre os testes no fechamento.
    </p>

    <a class="btn gray" href="chamados/index.php">
        Consultar chamados
    </a>

</section>

<?php require 'includes/footer.php'; ?>
