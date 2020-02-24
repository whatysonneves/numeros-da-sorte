# Números da Sorte

Vai fazer uma 'fezinha'? Use esse formulário para ver os últimos números sorteados de cada jogo e a frequência de cada um deles.

## Índice

- [Índice](#índice "Índice")
- [Tecnologias](#tecnologias "Tecnologias")
- [Como funciona](#como-funciona "Como funciona")
- [Porque tem PHP](#porque-tem-php "Porque tem PHP")
- [Como usar](#como-usar "Como usar")

## Tecnologias

- [Bootstrap](https://getbootstrap.com/ "Twitter Bootstrap")
- [jQuery](https://jquery.com/ "jQuery")
- [VueJS](https://vuejs.org/ "VueJS")
- Biblioteca [cURL](https://github.com/ixudra/curl "cURL por Ixudra") por Ixudra
- Biblioteca [phpdotenv](https://github.com/vlucas/phpdotenv "phpdotenv do vlucas") do vlucas

## Como funciona

Um sistema simples que usa principalmente Javascript para puxar os dados da API do [Lotodicas](https://www.lotodicas.com.br/ "Lotodicas"), montar um conjunto com os últimos jogos, e mostrar a frequência de cada número.

## Porque tem PHP

Foi utilizado um curto script em PHP para abstrair a comunicação com a API e guardar os Tokens, este script serviu também para contornar o [CORS](https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Controle_Acesso_CORS "CORS") entre os diferentes domínios.

## Como usar

Basta acessar a ferramenta online, automaticamente ela irá puxar os últimos 3 resultados do primeiro jogo listado, fazendo assim toda a mágica.

### Criado por Whatyson Neves
