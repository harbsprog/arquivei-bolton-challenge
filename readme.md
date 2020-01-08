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

	O Projeto se comporta da seguinte maneira, tenho um command que roda todo dia as *00:00 AM*  e *12:00 PM*, também via endpoint `http://arquivei.test/api/syncNfe` ou com o comando `php artisan nfe:synchronization` caso queira fazer manualmente  que realiza a sincronização das NFe's. Este command schedula um job que por sua vez é gerenciado pelo beanstalkd onde o mesmo parseia os dados retornados pela api e joga para um worker que realiza a inserção no banco Mysql, a partir do momento que foi parseado irá schedular o mesmo job para parsear as próximas Nfe's sendo assim até o findar das mesmas. Terminando assim o proposto pelos itens 1 e 2.
O item número 3 pede a criação de um endpoint que dada a chave de acesso ele retorne o valor total o mesmo se encontra em `http://arquivei.test/api/nfe/{accessKey}`, caso não tenha a chave informada no banco utilizo o Guzzle para requisitar ao sandbox da arquivei a chave solicitada  guardo no banco e mostro para o usuário. Caso utilize o endpoint com o filtro ?showNfe=true ele irá exibir além do valor total a NFe com um base64_decode ou seja o xml propriamente dito, exemplo: `http://arquivei.test/nfe/{accessKey}?showNfe=true`
Ou se preferir utilizando ?showBase64Nfe=true mostrará além do valor total a NFe com base64_encode, exemplo:
`http://arquivei.test/nfe/{accessKey}?showBase64Nfe=true`
Implementei um rateLimit neste endpoint de 100 requests/min onde se o limite for ultrapassado jogo em uma fila de retry evitando perda de processamento onde o endpoint terceiro (no caso a arquivei) hora que bater o limite de requisições ira negar os requests.

## Arquitetura
![Arquitetura](https://raw.githubusercontent.com/harbsprog/arquivei-bolton-challenge/master/others/Arquitetura-Challenge.png)
**PS:** Caso queira visualizar melhor a imagem da arquitetura se encontra na pasta */others* .
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

2. cd arquivei-bolton-challenge && docker-compose up -d --build

3. Criei em seu etc/hosts (LINUX/MAC) ou no arquivo hosts se for windows uma regra do ip 127.0.0.1 para arquivei.test  

4. Acesse: http://arquivei.test/ Se apresentar a tela do laravel tudo ocorreu bem.


**PS:**  Como tenho um .sh que roda os comandos essenciais para o funcionamento do laravel/projeto como composer install, copia do .env.example para .env, php artisan migrate, php artisan queue:work, será necessário aguardar até que tudo esteja devidamente executado, para ver os processos rodando será necessário acessar o container *arquivei-php* execute:

     docker exec -it arquivei-php /bin/sh

### Para rodar os testes unitários


## Documentação API e Collection

