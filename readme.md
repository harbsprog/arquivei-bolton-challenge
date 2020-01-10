
# Arquivei's Bolton Challenge

  

## Intro

  

Desafio proposto pela Arquivei em processo seletivo para vaga de Desenvolvedor Back-end com o propósito de verificar a assinatura de código do participante que concorre a vaga e consiste em desenvolver uma aplicação backend, com os requisitos:

  

- Integrar com a API da arquivei.

- Gravar chave de acesso e valor total de cada nota em banco de dados relacional.

- Criar endpoint onde o usuário insira a chave de acesso e retorne o valor total.

  

## Comportamento do Projeto

- **Autenticação**

Não foi mencionado se precisaria de autenticação porém mesmo assim implementei com token JWT onde é necessário passar no header da requisição menos nas rotas */api/auth/login* e */api/auth/register* o campo Authorization com o token gerado pela rota */api/auth/login*. Fiz o uso da biblioteca Faker para criar dados falsos aleatórios para teste da aplicação onde por sua vez as seeds criam 2 usuários para a autenticação e os e-mails podem ser visualizados na tabela users no banco arquivei e suas respectivas senhas são 123456.

  

- **Queue**

Utilizei beanstalkd como gerenciador de filas e o beanstalkd console para realizar a administração dos jobs pela familiaridade no meu atual serviço, poderia ter utilizado também como queue driver o database ou um sqs que também tenho contato diariamente.

  

- **Banco**

Utilizei migrations para a criação/gerenciamento das tabelas pela facilidade na manipulação/versionamento sem precisar tocar em código SQL, onde elas também ajudariam no caso de um crescimento do sistema.

  

O Projeto se comporta da seguinte maneira, tenho um command que roda todo dia as *00:00 AM* e *12:00 PM* ou com o comando `docker-compose exec arquivei-php php artisan nfe:synchronization` caso queira fazer manualmente que realiza a sincronização das NFe's. Este command schedula um job que por sua vez é gerenciado pelo beanstalkd onde o mesmo parseia os dados retornados pela api e joga para um worker(Event que dispara um Listener) que realiza a inserção no banco Mysql, a partir do momento que foi parseado irá schedular o mesmo job para parsear as próximas Nfe's sendo assim até o findar das mesmas. Terminando assim o proposto pelos itens 1 e 2.

O item número 3 pede a criação de um endpoint que dada a chave de acesso ele retorne o valor total o mesmo se encontra em `http://arquivei.test/api/nfe/{access_key}`, caso não tenha a chave informada no banco utilizo o Guzzle para requisitar ao sandbox da arquivei a chave solicitada guardo no banco e mostro para o usuário. Caso utilize o endpoint com o Query Param ?showNfe=true ele irá exibir além do valor total a NFe com um base64_decode ou seja o xml propriamente dito, exemplo: `http://arquivei.test/api/nfe/{access_key}?showNfe=true`

Ou se preferir utilizando ?showBase64Nfe=true mostrará além do valor total a NFe com base64_encode, exemplo:

`http://arquivei.test/api/nfe/{access_key}?showBase64Nfe=true`

Implementei um rateLimit neste endpoint de 100 requests/min que contempla o limit da Api da Arquivei, onde se o limite for ultrapassado jogo em uma fila de retry evitando perda de processamento onde o endpoint terceiro (no caso a arquivei) hora que bater o limite de requisições iria negar os requests. PS: O endpoint /api/nfe recebe uma access_key do tipo string.

  

## Arquitetura

![Arquitetura](https://raw.githubusercontent.com/harbsprog/arquivei-bolton-challenge/master/others/Arquitetura-Challenge.png)

  

## Tecnologias utilizadas

  

- Docker & Docker Compose

- NGINX

- PHP 7.2

- Mysql 5.7

- Beanstalk

- Beanstalk Console

- Laravel 6.x

- PhpUnit

## Instalação

  

### Pré-requisitos

Para rodar a aplicação é necessário somente ter instalado o Docker e Docker-Compose

O projeto foi criado com:

- Docker version 19.03.5, build 633a0ea

- docker-compose version 1.24.1, build 4667896b

  

### Etapas

O ambiente foi pensado o mais automatizado possível para sua instalação, tirando proveito do que o Docker nos oferece. Para rodar a aplicação em sua máquina siga os seguintes passos:

  

1. git clone https://github.com/harbsprog/arquivei-bolton-challenge.git

  

2. cd arquivei-bolton-challenge

  

3. cp .env.example .env

  

4. docker-compose up -d --build

  

5. chmod +x scheduler.sh && ./scheduler.sh

  

6. Criei em seu etc/hosts (LINUX/MAC) ou no arquivo hosts se for windows uma regra do ip 127.0.0.1 para arquivei.test

  

7. Acesse: http://arquivei.test/ Se apresentar a tela do laravel tudo ocorreu bem.

  
  

**PS:** O bash scheduler.sh roda os comandos essenciais para o funcionamento do laravel/projeto como composer install, copia do .env.example para .env, php artisan migrate, php artisan queue:work, será necessário aguardar até que tudo esteja devidamente executado.

  

## Testes unitários

1. Execute:
    - docker-compose exec arquivei-php vendor/phpunit/phpunit/phpunit

    Este comando irá rodar testes unitários da aplicação.
    Realizei os 3 seguintes testes unitários:
        - Teste de busca da NFe por access key (sucesso e erro).
        - Teste de validação do too many requests(Rate Limit) (sucesso e erro).
        - Teste de não autenticação (sucesso).

## Possíveis futuras implementações

    Caso fosse um projeto em produção, poderia ser implementado para uma segurança da empresa para com seus clientes logs seja com Bugsnag, no Slack ou até mesmo um Sentry da vida de falhas do sistema, ações do usuário, do sistema, de terceiros etc. Realizar implantação de outros endpoints contemplados na documentação da API da arquivei, como adicionar ou realizar update de NFes, gerar ou recuperar reports do excel, retornar as propriedas de certa conta e etc.

## Documentação API e Collection
  

- [Documentação Bolton Challenge no Swagger](https://app.swaggerhub.com/apis-docs/harbsprog/BoltonChallenge/1.0.0)

- [Collection Insomnia REST CLIENT](https://raw.githubusercontent.com/harbsprog/arquivei-bolton-challenge/master/others/BoltonChallenge.yaml)