/*!
 * Números da Sorte v1.3 (https://whatysonneves.com/numeros-da-sorte/)
 * Copyright 2020 Whatyson Neves (https://whatysonneves.com/)
 */

var server = "https://whatysonneves.com";
if(app_env == "local") {
	server = "http://dev.whatysonneves.com";
}

var app = new Vue({
	el: "#app",
	data: {
		loop: 3,
		current: 0,
		jogosApp: [
			{ endpoint: "lotofacil", name: "Lotofácil", class: "btn-info" },
			{ endpoint: "mega-sena", name: "Mega-Sena", class: "btn-success" },
			{ endpoint: "quina", name: "Quina", class: "btn-primary" },
		],
		jogo: 0,
		nome: "Aguarde",
		jogos: [],
		numeros: {}
	},
	mounted: function() {
		this.resetApp(0);
		this.getJogos(0);
	},
	methods: {
		jogosButtons: function(e) {
			this.getJogos($(e.target).data("jogo"));
		},
		resetApp: function(jogo = null, nome = null) {
			this.jogo = (jogo == null ? 0 : jogo);
			this.nome = (nome == null ? (jogo == null ? "Aguarde" : this.jogosApp[jogo].name) : nome);
			this.jogos = [];
			this.numeros = {};
		},
		getJogos: function(jogo) {
			$(".buttonJogo").attr("disabled", true);
			var concurso = false;
			if(jogo !== this.jogo) {
				this.resetApp(jogo);
			} else {
				concurso = this.getConcurso(jogo);
			}
			this.getContent(this.jogosApp[jogo].endpoint, concurso);
		},
		getContent: function(endpoint, concurso = false) {
			var concurso = ( concurso === false ? "" : "/" + concurso );
			var url = server + "/numeros-da-sorte/api.php?endpoint=" + endpoint + concurso;
			$.ajax({
				method: "GET",
				url: url,
				timeout: 5000,
				dataType: "JSON",
				cache: false,
			}).fail(function() {
				alert("Houve erro no servidor ao tentar recuperar dados de: " + url);
				$(".buttonJogo").attr("disabled", false);
				app.resetApp(null, "Clique em um dos botões acima");
			}).done(function(json) {
				app.current++;
				if(json.status) {
					app.setResultados(json);
				} else {
					alert("A ferramenta está com problemas");
				}
			});
		},
		setResultados: function(json) {
			this.jogos.push({ concurso: json.numero, numeros: app._toStringNumeros(json.sorteio).toString() });
			this.setNumeros(json.sorteio);
			if(this.current < this.loop) {
				concurso = this.getConcurso(app.jogo);
				this.getContent(this.jogosApp[this.jogo].endpoint, concurso);
			} else {
				this.current = 0;
				$(".buttonJogo").attr("disabled", false);
			}
		},
		setNumeros: function(sorteio) {
			$.each(sorteio, function(k, v) {
				if(typeof app.numeros[v] !== 'number') {
					app.numeros[v] = 1;
				} else {
					app.numeros[v]++;
				}
			});
		},
		getNumeros: function() {
			var novosNumeros = [];
			$.each(this.numeros, function(k, v) {
				if(typeof v !== 'undefined') { novosNumeros.push({"numero": k, "frequencia": v}); }
			});
			return novosNumeros.sort(function(a, b) { return b.frequencia-a.frequencia });
		},
		getConcurso: function() {
			if(this.jogos.length === 0) {
				return false;
			}
			return this.jogos[this.jogos.length-1].concurso-1;
		},
		_toStringNumeros: function(numeros) {
			if(typeof numeros === 'number') {
				if(numeros < 10) {
					numeros = "0" + numeros;
				}
			} else {
				$.each(numeros, function(k, v) {
					if(typeof v !== 'string') {
						if(v < 10) {
							numeros[k] = "0" + v;
						}
					}
				});
			}
			return numeros;
		}
	}
});
