# Gerenciador de Usuários

Este é um pequeno projeto de um gerenciador de usuários feito com Laravel e VueJS

Versões das tecnologias usadas:
* PHP: v8.3.9
* NodeJS v20.17.0

## Execução local

Para iniciar execute os comandos abaixo:

```shell
    cp .env.example .env
	composer install
	npm install
	php artisan key:generate
	npx mix
```

Esses são todos os comandos básicos necessários para executar o projeto.

Caso deseje, o projeto possui um docker-compose com mysql e php já configurados e para facilitar foi feito um Makefile onde basta executar o comando `make docker` que irá inicializar os services configurados, expondo o projeto laravel na porta 8000 e o banco na porta 3306.

Caso não deseje usar o docker, basta configurar a conexão do mysql no arquivo .env e executar `php artisan serve`, por padrão o laravel iniciará o servidor web no endereço 127.0.0.1:8000.

### Front End

O front foi feito em VueJS e para compilá-lo o projeto usa o laravel-mix. Para compilar os arquivos do front end, basta executar o comando `npx mix` ou `npx mix watch` para que ele fico observando por alterações nos arquivos da pasta resource.

### Banco de dados:

O mysql irá salvar os dados na pasta mysql na raiz do projeto, mas esse local pode ser alterado na configuração de volumes do serviço mysql no docker compose do projeto.

Após subir o docker compose do projeto, acesse o banco de dados com o comando `make mysql-cli`, um atalho para conectar no docker do mysql e iniciar o mysql cli. A senha do root é a configurada no MYSQL_ROOT_PASSWORD. Depois disso execute os comandos abaixo para criar o banco, usuário e as permissões dele no novo banco:

```sql
CREATE DATABASE user_management;
CREATE USER 'manager'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON user_management.* TO 'manager'@'%';
FLUSH PRIVILEGES;
```
**Importante:** Espere alguns segundos após a finalização do build do docker-compose para evitar erros ao tentar conectar no mysql-cli.

Após isso, confirme se as credenciais do env condizem com o dos comandos acima e execute o comando `php artisan migrate --fresh` (acrescente "--seed" ao final do comando caso queira que o laravel carregue 100 usuários com dados de exemplo no banco para você).

Caso esteja usando docker, execute o comando `make php` e rode o migrate dentro do docker do php. Lembrando que ele usa o .env.docker para carregar as variáveis de ambiente, por isso, caso tenha alterado os valores dos comandos de exemplo, lembre-se de alterar neste .env também.
