# API de vendas de produtos

## Introdução

Este projeto é um desafio técnico desenvolvido para demonstrar habilidades em PHP.<br>
O projeto consiste em uma aplicação simples com algumas funcionalidades específicas descritas abaixo.

## Requisitos

Para executar este projeto, você precisará ter instalado em sua máquina:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Instalação

### 1. Clonar o Repositório

Clone este repositório em sua máquina local:

```bash
git clone https://github.com/viniciusjose/product-api.git
cd product-api
```

### 2. Configuração do Ambiente
Crie um arquivo .env na raiz do projeto e adicione as seguintes variáveis conforme necessário:

```bash
 cp .env.example .env
```
```dotenv
DB_NAME=product
DB_USER=root
DB_PASSWORD=root
DB_HOST=product-postgres
DB_PORT=5432
DB_DRIVER=pdo_pgsql
```

### 3. Iniciar o Ambiente
Neste processo a imagem será gerada e os containers serão iniciados.<br/>
O ambiente será disponibilizado em http://localhost:8000/api
```bash
docker compose up -d --build
```

### 4. Instalar Dependências
```bash
docker exec -it product-app composer install
```

### 5. Executar as Migrações
```bash
docker exec -it product-app composer migrate
```

### 6. Testes unitários
Para  executar os testes unitários, execute o comando abaixo:
```bash
docker exec -it product-app composer test
```

### 7. Tecnologias Utilizadas
- [PHP](https://www.php.net/releases/8.3/en.php)
- [Slim Router](https://www.slimframework.com/docs/v4/objects/routing.html)
- [Doctrine Migration](https://www.doctrine-project.org/projects/doctrine-migrations/en/3.8/index.html)
- [PostgreSQL](https://www.postgresql.org/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Pest](https://pestphp.com/docs)

### 8. Arquitetura
- [Clean Architecture](https://fullcycle.com.br/o-que-e-clean-architecture/)

### 9. Documentação da API

A documentação das rotas está disponível em um arquivo [Insomnia](https://insomnia.rest/) na raiz do projeto.

#### 1. Cadastro de Vendas
- Rota: POST /sales
- Rota: GET /sales
- Rota: GET /sales/{id}
- Rota: PUT /sales/{id}
- Rota: DELETE /sales/{id}
- Rota: POST /sales/{id}/products

#### 2. Cadastro de Produtos
- Rota: POST /products
- Rotas: GET /products
- Rota: GET /products/{id}
- Rota: PUT /products/{id}
- Rota: DELETE /products/{id}

#### 3. Cadastro de Categorias
- Rota: POST /types
- Rota: GET /types
- Rota: GET /types/{id}
- Rota: PUT /types/{id}
- Rota: DELETE /types/{id}

#### 4. Cadastro de impostos
- Rota: POST /taxes
- Rota: GET /taxes
- Rota: GET /taxes/{id}
- Rota: PUT /taxes/{id}
- Rota: DELETE /taxes/{id}

## Pontos Desenvolvidos

- Cadastro de vendas
- Cadastro de produtos
- Cadastro de categorias
- Cadastro de impostos
- Testes unitários
- Migrations
- API Restful

## Pontos a serem desenvolvidos

- Autenticação
- Cadastro de clientes
- Cesta de compras
- Testes de integração
- Testes de aceitação
- Documentação da API (Swagger)
- CI/CD
- Deploy em ambiente de produção
- Observabilidade
- Melhorias nas validações das requisições
