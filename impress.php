<?php

require "bootstrap.php";

header("Content-Type: text/html; Charset=UTF-8");

$numerosDaSorte = new numerosDaSorte;
$lotofacil = json_decode($numerosDaSorte->get("lotofacil", "last"), true);
$numerosDaSorte->setToken();
$mega_sena = json_decode($numerosDaSorte->get("mega_sena", "last"), true);
$numerosDaSorte->setToken();
$quina = json_decode($numerosDaSorte->get("quina", "last"), true);
$numerosDaSorte->setToken();

$resultados = [
	"lotofacil" => array_merge(["nome" => "Lotofácil"], $lotofacil),
	"mega_sena" => array_merge(["nome" => "Mega-Sena"], $mega_sena),
	"quina" => array_merge(["nome" => "Quina"], $quina),
];

?><!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="author" content="Whatyson Neves" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Últimos resultados das principais loterias do Brasil." />
	<meta name="keywords" content="Resultado da loteria, Resultado das loterias, Resultado da Lotofacil, Resultado da Lotofácil, Resultado da Mega-Sena, Resultado da Mega, Resultado da Sena, Resultado da Quina, Último Resultado da Lotofacil, Último Resultado da Lotofácil, Último Resultado da Mega-Sena, Último Resultado da Mega, Último Resultado da Sena, Último Resultado da Quina, Últimos Resultados da Lotofacil, Últimos Resultados da Lotofácil, Últimos Resultados da Mega-Sena, Últimos Resultados da Mega, Últimos Resultados da Sena, Últimos Resultados da Quina" />
	<title>Últimos resultados das Loterias - Números da Sorte - Whatyson Neves - v1.3.3</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/materia/bootstrap.min.css" />
	<style type="text/css">
		body {
			background-color: #fff;
		}
		.roll-paper {
			max-width: 80mm !important;
		}
		.result-size {
			font-size: 16pt;
		}
		hr {
			border: 1px dashed #000000;
		}
	</style>
</head>
<body class="d-flex flex-column">

	<div class="container text-center roll-paper">
		<h1>Resultados</h1>
<?php foreach($resultados as $resultado) { ?>
<?php if($resultado["status"]) { ?>
		<hr />
		<h2><?php echo $resultado["nome"]; ?></h2>
		<p><strong>Concurso:</strong> <?php echo $resultado["numero"]; ?></p>
		<div class="row px-4 py-2">
<?php foreach($resultado["sorteio"] as $numero) { ?>
			<div class="col-sm"><span class="result-size"><?php echo ( $numero < 10 ? "0".$numero : $numero ); ?></span></div>
<?php } ?>
		</div>
<?php } ?>
<?php } ?>
		<hr />
		<small>Copyright &copy; WhatysonNeves.com</small>
		<small>https://whatysonneves.com/numeros-da-sorte/</small>
		<hr />
	</div>

</body>
</html>
