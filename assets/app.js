/*!
 * Números da Sorte v1.0 (https://whatysonneves.com/numeros-da-sorte/)
 * Copyright 2018 Whatyson Neves (https://whatysonneves.com/)
 */

var loop = 3;
var current = 0;
var jogos = [
	{
		"endpoint": "lotofacil",
		"name": "Lotofácil",
		"class": "btn-info",
	},
	{
		"endpoint": "mega-sena",
		"name": "Mega-Sena",
		"class": "btn-success",
	},
	{
		"endpoint": "quina",
		"name": "Quina",
		"class": "btn-primary",
	},
];
var resultados = {
	"jogo": {},
	"jogos": [],
	"numeros": [],
};

var getContent = function(endpoint, concurso = false) {
	var concurso = ( concurso === false ? "" : "/" +concurso );
	var url = "https://whatysonneves.com/numeros-da-sorte/api.php?endpoint=" + endpoint + concurso;
	$.ajax({
		method: "GET",
		url: url,
		timeout: 5000,
		dataType: "JSON",
		cache: false,
	}).fail(function() {
		alert("Houve erro no servidor ao tentar recuperar dados de: " + url);
		$(".buttonJogo").attr("disabled", false);
		resultados.jogo = {};
		resultados.jogos = [];
		resultados.numeros = [];
	}).done(function(json) {
		current++;
		if(json.status) {
			setResultados(json);
		} else {
			alert("A ferramenta está com problemas");
		}
	});
}

var getJogos = function(jogo) {
	$(".buttonJogo").attr("disabled", true);
	var concurso = false;
	if(jogo !== resultados.jogo) {
		resultados.jogo = jogo;
		resultados.jogos = [];
		resultados.numeros = [];
	} else {
		concurso = resultados.jogos[resultados.jogos.length-1].concurso-1;
	}
	getContent(jogo.endpoint, concurso);
}

var run = function() {
	var jogo = jogos[$(this).data("jogo")];
	getJogos(jogo);
}

var loadJogos = function(jogos) {
	var html = "";
	$.each(jogos, function(k, v) {
		html += '<button type="button" class="btn ' + v.class + ' btn-md buttonJogo" data-jogo="' + k + '">' + v.name + '</button>';
	});
	$("#jogosButtons").html(html);
}

var setResultados = function(json) {
	resultados.jogos.push({"concurso": json.numero, "numeros": json.sorteio});
	$.each(json.sorteio, function(k, v) {
		if(typeof resultados.numeros[v] !== 'number') {
			resultados.numeros[v] = 1;
		} else {
			resultados.numeros[v]++;
		}
	});
	if(current < loop) {
		concurso = resultados.jogos[resultados.jogos.length-1].concurso-1;
		getContent(resultados.jogo.endpoint, concurso);
	} else {
		current = 0;
		setNome();
		setJogos();
		setNumeros();
		$(".buttonJogo").attr("disabled", false);
	}
}

var setNome = function() {
	var nome = $("#tableJogoNome");
	nome.html(resultados.jogo.name);
}

var setJogos = function() {
	var jogos = $("#tableJogos");
	var html = "";
	$.each(resultados.jogos, function(k, v) {
		html += '<tr><th scope="row">'+(k+1)+'</th><td>'+v.concurso+'</td><td>'+toStringNumeros(v.numeros).toString()+'</td></tr>';
	});
	jogos.html(html);
}

var toStringNumeros = function(numeros) {
	if(typeof numeros === 'number') {
		if(numeros < 10) {
			numeros = "0"+numeros;
		}
	} else {
		$.each(numeros, function(k, v) {
			if(typeof v !== 'string') {
				if(v < 10) {
					numeros[k] = "0"+v;
				}
			}
		});
	}
	return numeros;
}

var setNumeros = function() {
	var numeros = $("#tableNumeros");
	var html = "";
	var novosNumeros = [];
	$.each(resultados.numeros, function(k, v) {
		if(typeof v !== 'undefined') { novosNumeros.push({"numero": k, "repeticoes": v}); }
	});
	novosNumeros.sort(function(a, b) { return b.repeticoes-a.repeticoes });
	$.each(novosNumeros, function(k, v) {
		html += '<tr><th scope="row">'+(k+1)+'</th><td>'+toStringNumeros(v.numero)+'</td><td>'+v.repeticoes+'</td></tr>';
	});
	numeros.html(html);
}

$(document).ready(function() {
	loadJogos(jogos);
	$(".buttonJogo").on("click", run);
	getJogos(jogos[0]);
});