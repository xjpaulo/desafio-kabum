# desafio-kabum

Um gerenciador de clientes com login e operações CRUD desenvolvido em PHP sem utilização de frameworks, utilizando scripts em jQuery e Ajax com banco de dados MySQL.

## Pré-requisitos

 - [docker](https://docs.docker.com/)
 - [docker-compose](https://docs.docker.com/compose/)

## Infraestrutura

 - Gateway - Foi utilizado o Nginx para permitir e controlar processos simultâneos;
 - PHP - Website desenvolvido em PHP com scripts em jQuery e Ajax;
 - Banco de dados - Grava os dados dentro de um banco MySQL;
 - Docker - Utiliza três containers: um para o PHP, um para o servidor web, e outro para o banco de dados.

## Configuração
Para iniciar, execute o docker-compose na pasta raiz:
```
$ docker-compose up --detach --build
```
Os logs podem ser acompanhados pelo comando:  
```
$ docker-compose logs --folow
```

**Comandos MySQL**

 - Dar privilégios ao usuário admin na database desafio em localhost:
```
GRANT ALL PRIVILEGES ON desafio.* TO 'admin'@'localhost';
```
 - Criar a tabela usuarios na database desafio:
``` 
create table usuarios (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, login VARCHAR(20) NOT NULL UNIQUE KEY, senha VARCHAR(200) NOT NULL);
```
 - Inserir os dados para login:
``` 
insert into usuarios (login, senha) values ('admin', md5('kabum'));
```
 - Criar a tabela clientes:
``` 
create table clientes (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, nome VARCHAR(100) NOT NULL, data_nascimento VARCHAR(10) NOT NULL, cpf CHAR(11) NOT NULL UNIQUE KEY, rg VARCHAR(14) NOT NULL UNIQUE KEY, telefone VARCHAR(14) NOT NULL);
```
 - Criar a tabela clientes_enderecos:
``` 
create table clientes_enderecos (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, clientes_id INT NOT NULL, cep CHAR(8) NOT NULL, logradouro VARCHAR(150) NOT NULL, bairro VARCHAR(150) NOT NULL, numero
VARCHAR(10) NOT NULL, complemento VARCHAR(150), cidade VARCHAR(50) NOT NULL, estado VARCHAR(50) NOT NULL);
```

## Funcionamento

Após a instalação o website ficará disponível através do endereço abaixo utilizando o login *admin* e senha *kabum*:

``http://localhost:8080/desafio/``

É recomendável o uso do navegador Firefox para melhor visualização.
