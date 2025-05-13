API de Cadastro de Clientes - README
Descrição
API para cadastro de clientes com validação de CPF e CEP, desenvolvida em Laravel 10.x.

Funcionalidades
Cadastro de clientes com validação de CPF e CEP

Atualização de dados do cliente

Exclusão de clientes

Listagem de clientes com filtros

Consulta de cliente por ID

Requisitos
PHP 8.x

Laravel 10.x

MySQL ou PostgreSQL

Composer

Instalação
Clone o repositório:
git clone https://github.com/seu-usuario/projeto.git
cd projeto

Instale as dependências:
composer install

Configure o ambiente:
cp .env.example .env

Configure o banco de dados no arquivo .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
Execute as migrations:
php artisan migrate

Como Executar
Inicie o servidor Laravel:
php artisan serve
A API estará disponível em: http://localhost:8000

Endpoints
1. Cadastrar Cliente
POST /clientes
Exemplo de requisição:

> json

{"nome_completo": "João da Silva", "cpf": "123.456.789-00", "email": "joao@example.com", "telefone": "11987654321", "cep": "12345678"}
Resposta de sucesso:

> json

{"id": 1, "nome_completo": "João da Silva", "cpf": "123.456.789-00", "email": "joao@example.com", "telefone": "11987654321", "cep": "12345678", "logradouro": "Rua Exemplo", "bairro": "Centro", "cidade": "São Paulo", "estado": "SP", "created_at": "2023-06-19T10:00:00.000000Z", "updated_at": "2023-06-19T10:00:00.000000Z"}

2. Atualizar Cliente
PUT /clientes/{id}
Exemplo de requisição:

> json

{"nome_completo": "João da Silva Filho", "cpf": "123.456.789-00", "email": "joao@novomail.com", "telefone": "11987654322", "cep": "87654321"}
Resposta de sucesso:

> json

{"id": 1, "nome_completo": "João da Silva Filho", "cpf": "123.456.789-00", "email": "joao@novomail.com", "telefone": "11987654322", "cep": "87654321", "logradouro": "Rua Exemplo Novo", "bairro": "Centro", "cidade": "São Paulo", "estado": "SP", "created_at": "2023-06-19T10:00:00.000000Z", "updated_at": "2023-06-19T10:30:00.000000Z"}

3. Excluir Cliente
DELETE /clientes/{id}
Resposta de sucesso:

> json

{"message": "Cliente excluído com sucesso"}

4. Listar Clientes
GET /clientes
Parâmetros de filtro:

nome_completo: Filtro por nome

cpf: Filtro por CPF

cep: Filtro por CEP

Exemplo de requisição:
GET /clientes?nome_completo=João

Resposta:

> json

[{"id": 1, "nome_completo": "João da Silva", "cpf": "123.456.789-00", "email": "joao@example.com", "telefone": "11987654321", "cep": "12345678", "logradouro": "Rua Exemplo", "bairro": "Centro", "cidade": "São Paulo", "estado": "SP"}]

5. Buscar Cliente por ID
GET /clientes/{id}
Exemplo de requisição:
GET /clientes/1

Resposta:

> json

{"id": 1, "nome_completo": "João da Silva", "cpf": "123.456.789-00", "email": "joao@example.com", "telefone": "11987654321", "cep": "12345678", "logradouro": "Rua Exemplo", "bairro": "Centro", "cidade": "São Paulo", "estado": "SP"}
Testando a API
Recomenda-se utilizar o Postman ou similar para testar os endpoints da API.