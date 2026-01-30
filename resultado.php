<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Votação</title>
<link rel="stylesheet" href="Estilizacao/style2.css">
 
</head>
<body>
<div class="resultado-container">
<h1>Resultado final</h1>
<?php
$arquivoVotos = 'dados/votos.txt';
$arquivoCandidatos = 'dados/dados.txt';
 
if (!file_exists($arquivoVotos) || !file_exists($arquivoCandidatos)) {
    echo "Arquivos de votação não encontrados.";
    exit;
}
 
/* 1️⃣ Lê os candidatos e cria um mapa ID => Nome */
$candidatos = [];
$linhasCandidatos = file($arquivoCandidatos, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 
foreach ($linhasCandidatos as $linha) {
    list($id, $nome) = explode('|', $linha);
    $candidatos[$id] = $nome;
}
 
/* 2️⃣ Conta os votos por ID */
$contagem = [];
$linhasVotos = file($arquivoVotos, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 
foreach ($linhasVotos as $voto) {
    list(, $idCandidato) = explode('|', $voto);
 
    if (!isset($contagem[$idCandidato])) {
        $contagem[$idCandidato] = 0;
    }
    $contagem[$idCandidato]++;
}
 
/* TABELA PARA EXIBIR OS CANDIDATOS */
 
$resultados = [];
 
foreach ($candidatos as $id => $nome) {
    $resultados[] = [
        'nome' => $nome,
        'votos' => $contagem[$id] ?? 0
    ];
}
 
/* 4️⃣ Ordena do mais votado para o menos votado */
usort($resultados, function ($a, $b) {
    return $b['votos'] <=> $a['votos'];
});
 
/* 5️⃣ Exibe a tabela ordenada */
echo "<table>";
echo "<tr><th>Candidato</th><th>Votos</th></tr>";
 
foreach ($resultados as $resultado) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($resultado['nome']) . "</td>";
    echo "<td>{$resultado['votos']}</td>";
    echo "</tr>";
}
 
echo "</table>";
 
?>
 
<a href="index.php">
    <button type="button" class="inicio-resultado"> <strong>HOME</strong></button>
    </a>
 
</body>
</html>