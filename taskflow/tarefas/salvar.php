
<?php
require '../config/database.php';

$id = (int)($_POST['id'] ?? 0);

$d = [
    trim($_POST['titulo'] ?? ''),
    trim($_POST['descricao'] ?? ''),
    trim($_POST['responsavel'] ?? ''),
    $_POST['categoria'] ?? 'Geral',
    $_POST['prazo'] ?? date('Y-m-d'),
    $_POST['prioridade'] ?? 'Média',
    $_POST['status'] ?? 'Pendente'
];

if ($d[0] === '' || $d[2] === '' || $d[4] === '') {
    header('Location: form.php?erro=1' . ($id ? '&id=' . $id : ''));
    exit;
}

try {

    if ($id) {
        $q = $pdo->prepare('UPDATE tarefas SET titulo=?,descricao=?,responsavel=?,categoria=?,prazo=?,prioridade=?,status=? WHERE id=?');
        $q->execute([$d[0], $d[1], $d[2], $d[3], $d[4], $d[5], $d[6], $id]);

    } else {
        $q = $pdo->prepare('INSERT INTO tarefas(titulo,descricao,responsavel,categoria,prazo,prioridade,status) VALUES(?,?,?,?,?,?,?)');
        $q->execute($d);
    }

    header('Location: index.php');
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());

    header('Location: form.php?erro=2' . ($id ? '&id=' . $id : ''));
    exit;
}
