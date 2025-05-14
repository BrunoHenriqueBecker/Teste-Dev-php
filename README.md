# API de Cadastro de Clientes

API para cadastro de clientes com validação de CPF e CEP, desenvolvida em Laravel 10.x, configurada com Docker para facilitar o desenvolvimento.

---

## 🧰 Funcionalidades

- Cadastro de clientes com validação de CPF e CEP
- Atualização de dados do cliente
- Exclusão de clientes
- Listagem de clientes com filtros
- Consulta de cliente por ID

---

## ⚙️ Requisitos

- PHP 8.x
- Laravel 10.x
- MySQL 8.0
- Composer
- Docker & Docker Compose

---

## 🚀 Instalação com Docker

Clone o repositório:

```bash
git clone https://github.com/seu-usuario/seu-projeto.git
cd seu-projeto
```

Copie o arquivo de ambiente:

```bash
cp .env.example .env
```

Configure o banco de dados no `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=clientes_db
DB_USERNAME=root
DB_PASSWORD=root
```

Suba os containers com Docker:

```bash
docker-compose up -d --build
```

Acesse o container da aplicação:

```bash
docker exec -it laravel_app bash
```

Instale as dependências:

```bash
composer install
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Execute as migrations:

```bash
php artisan migrate
```

---

## 🌐 Acessando a API

Acesse no navegador:

```
http://localhost:8000
```

---

## 📡 Endpoints

### 1. Cadastrar Cliente
**POST /clientes**

**Requisição:**
```json
{
  "nome_completo": "João da Silva",
  "cpf": "123.456.789-00",
  "email": "joao@example.com",
  "telefone": "11987654321",
  "cep": "12345678"
}
```

**Resposta:**
```json
{
  "id": 1,
  "nome_completo": "João da Silva",
  "cpf": "123.456.789-00",
  "email": "joao@example.com",
  "telefone": "11987654321",
  "cep": "12345678",
  "logradouro": "Rua Exemplo",
  "bairro": "Centro",
  "cidade": "São Paulo",
  "estado": "SP"
}
```

### 2. Atualizar Cliente
**PUT /clientes/{id}**

```json
{
  "nome_completo": "João da Silva Filho",
  "cpf": "123.456.789-00",
  "email": "joao@novomail.com",
  "telefone": "11987654322",
  "cep": "87654321"
}
```

### 3. Excluir Cliente
**DELETE /clientes/{id}**

**Resposta:**
```json
{ "message": "Cliente excluído com sucesso" }
```

### 4. Listar Clientes
**GET /clientes**

**Parâmetros de filtro:**
- nome_completo
- cpf
- cep

### 5. Buscar Cliente por ID
**GET /clientes/{id}**

---

## 🧪 Testes

Use ferramentas como [Postman](https://www.postman.com/) para testar os endpoints.

---

## 📂 Containers Docker

- `app`: Laravel (PHP-FPM)
- `db`: MySQL 8
- `nginx`: Servidor web (porta 8000)

---

## 🧼 Parar o ambiente

```bash
docker-compose down
```

Com volumes:

```bash
docker-compose down -v
```

---