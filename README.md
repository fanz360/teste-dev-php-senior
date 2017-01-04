# Teste para Desenvolvedor PHP Sênior

As características que definem um programador sênior não são exatas. Um mesmo desenvolvedor pode ser considerado sênior na empresa X e pleno na empresa Y. As competências variam muito. 

Queremos ter certeza que o seu perfil é exatamente [aquele que procuramos](https://gist.github.com/xthiago/bbbd615aee535190ff5adbe5bfedb871). Para isso gostariamos de te conhecer melhor através deste teste, onde você fará parte de um time de desenvolvimento fictício, resolvendo problemas comuns no dia-a-dia de qualquer empresa.

O teste será dividido em duas partes:


1. Code review do código fonte atual; *OBSERVAÇÃO: não é necessário refatorar os pontos levantados no code review, lógico que, se você fizer alguns, se destacará.*   
1. Implementação de duas novas funcionalidades.

## Instruções gerais

- Reserve entre 1 e 2 horas de seu dia para fazê-lo. 

- Faça um fork deste repositório no GitHub, BitBucket ou servidor de sua preferência. Sugerimos que a visibilidade seja definida como privada, para que outros candidatos não tenham acesso aos seus *insights*.

- Ao final, envie um e-mail para thiago.rodrigues@upx.com.br com o link para o repositório (conceda acesso de leitura ao usuário thiago.rodrigues@upx.com.br) + texto do seu code review. Quanto mais completo seu code review, maiores as suas changes de destacar-se dos outros candidatos.

- Qualquer dúvida entre em contato através do endereço de e-mail thiago.rodrigues@upx.com.br.


## O desafio

Imagine que você é desenvolvedor sênior na empresa XPTO e na semana passada surgiu um projeto urgente que nem você e nem o time tinham disponibilidade para atacá-lo. A tarefa acabou ficando sob responsabilidade do Juninho, desenvolvedor Júnior da empresa, um rapaz que aprende muito rápido, mas ainda inexperiente, sem bagagem para optar pelas melhores práticas de arquitetura e codificação.
 
A boa notícia é que a empresa possui uma cultura de coaching e code review. Você, como desenvolvedor sênior, ficou encarregado de fazer Code Review da solução adotada pelo Juninho antes que a mesma vá para produção (parte 1 do teste). 

Como trata-se de uma aplicação que será mantida por vários anos, o code review deve ter como objetivo garantir:
   
   - que padrões de codificação são adotados;
   - código de fácil entendimento;
   - que a aplicação tenha baixo nível de acoplamento;
   - boa cobertura de testes, com testes de qualidade;
   - bom design da solução (especificações, Design Patterns, SOLID, DRY, etc);
   - baixa complexidade;
   - segurança;
   - performance;
   - e qualquer coisa que você achar que a aplicação deve seguir.

Lembre-se que Juninho é inexperiente. Não basta só apontar o que está bom, tem que dar instruções claras do porquê não está bom e como resolver.

Além disso, você foi alocado para trabalhar junto com o Juninho (programação em par) para criar duas novas funcionalidades descritas na seção **Novas Funcionalidades** (parte 2 do teste). 

A sua experiência garantirá êxito na fundação do projeto e ajudará no desenvolvimento profissional do Juninho.

## A aplicação

A aplicação é um Produto Mínimo Viável (MVP) de um back-end RESTFull que gerencia tarefas. O mesmo futuramente será consumido por múltiplos front-ends (web, celular, terceiros, etc).

O código está escrito em PHP. Os dados são armazenados por ora no SQLite, mas no futuro (pós-MVP) poderão vir a ser armazenados em outro sistema, inclusive não-relacionais.
 
**Atualmente a aplicação provê:**

### Listagem das tarefas cadastradas

Requisição:

```
GET / HTTP/1.1
Host: localhost:2016
Content-Type: application/json
```
 
Resposta:

```
{"tasks":[{"id":"1","title":"The title - 1483549419"},{"id":"2","title":"The title - 1483549534"}]}
```

### Cadastro de tarefas

Requisição:

```
POST /add HTTP/1.1
Host: localhost:2016
Content-Type: application/json

{
"title": "Título da tarefa"
}
```

Resposta para requisição inválida:

```
{"message":"The title field must have 3 or more characters"}
```

Resposta para requisição válida:

```
{"id":"6","title":"T\u00edtulo da tarefa"}
```

## Novas funcionalidades

Você desenvolverá as seguintes funcionalidades:

1. Como usuário da API, quero ser capaz de adicionar tags (etiquetas) nas minhas tarefas de modo que eu possa classificá-las segundo meus critérios.
1. Como usuário da API, quero ser capaz de editar tags de modo que eu possa definir uma cor para uma dada tag e isso reflita na forma como o front-end exibe as tasks.

Critérios técnicos

- Uma tag consiste em um título e na cor (que pode ser usado pelo front-end da mesma forma como o GMail faz com marcadores).
- As tags devem aparecer na listagem de tasks. 
- Uma tag pode ser usada por 0 ou mais tasks.
- É permitida a adição de novas dependências ao projeto.

## Configuração do ambiente de desenvolvimento

Você pode configurar a aplicação em seu ambiente local (PHP 7.1) ou usar o Docker para subir com tudo já configurado.

### Provisionando o ambiente de desenvolvimento com Docker

1. Subir o container:

    `docker-compose up -d`

1. Logar terminal do container (aguarde alguns segundos):

    `docker exec -it testebackend /bin/bash`

1. Instalar as dependências do composer

    `composer install`

1. Acesse: 

    [http://localhost:2016/](http://localhost:2016/)

#### Outros comandos úteis

- Para rodar os testes unitários:

    `phpunit --debug -c /tests` (no terminal do container)

- Para derrubar o container:

    `docker-compose stop`
