# Nome do Api Task Symfony

API RESTful desenvolvida com Symfony 6.4 e API Platform para gerenciamento de usuários e tarefas, com autenticação JWT e painel administrativo.

---

## Tecnologias Utilizadas

- **PHP 8.1+** — Linguagem principal do backend.  
- **Symfony 6.4** — Framework PHP moderno para desenvolvimento web robusto e flexível.  
- **API Platform** — Ferramenta para construção rápida de APIs REST e GraphQL com Symfony e Doctrine ORM.  
- **Doctrine ORM** — Mapeamento objeto-relacional para gerenciamento do banco de dados.  
- **Lexik JWT Authentication Bundle** — Autenticação via tokens JWT para APIs seguras.  
- **Nelmio CORS Bundle** — Configuração de CORS para permitir chamadas cross-origin.  
- **EasyAdmin Bundle** — Painel administrativo para gerenciamento dos dados.  
- **Twig** — Template engine para renderização das views.  
- **PHPUnit** — Framework para testes automatizados em PHP.  
- **Symfony Maker Bundle** — Ferramentas para geração de código automatizada (controllers, entidades, etc.).  
- **Symfony Web Profiler & Debug Bundle** — Ferramentas para análise e debug da aplicação.  

---

## Funcionalidades

- Autenticação via JWT com login.  
- CRUD completo para entidades Usuário e Tarefa.  
- Painel administrativo para gerenciamento de usuários e tarefas.  
- Configuração CORS para comunicação com frontend.  
- Testes automatizados com PHPUnit.  

---

## Endpoints principais

### Autenticação

| Método | Rota        | Descrição                       |
|--------|-------------|--------------------------------|
| POST   | `/api/login` | Cria um token JWT para o usuário |

### Tarefas

| Método | Rota                | Descrição                     |
|--------|---------------------|-------------------------------|
| GET    | `/api/tasks`        | Lista todas as tarefas         |
| POST   | `/api/tasks`        | Cria uma nova tarefa           |
| GET    | `/api/tasks/{id}`   | Recupera uma tarefa específica |
| PUT    | `/api/tasks/{id}`   | Substitui uma tarefa           |
| PATCH  | `/api/tasks/{id}`   | Atualiza parcialmente uma tarefa |
| DELETE | `/api/tasks/{id}`   | Remove uma tarefa              |

### Usuários

| Método | Rota               | Descrição                     |
|--------|--------------------|-------------------------------|
| GET    | `/api/users`       | Lista todos os usuários        |
| POST   | `/api/users`       | Cria um novo usuário           |
| GET    | `/api/users/{id}`  | Recupera um usuário específico |
| PUT    | `/api/users/{id}`  | Substitui um usuário           |
| PATCH  | `/api/users/{id}`  | Atualiza parcialmente um usuário |
| DELETE | `/api/users/{id}`  | Remove um usuário              |

---

## Como rodar o projeto

### Pré-requisitos

- PHP 8.1 ou superior  
- Composer  
- Banco de dados configurado (exemplo: MySQL, PostgreSQL, SQLite)

### Passos para executar

1. Clone o repositório

```bash
git clone https://seu-repositorio.git
cd nome-do-projeto
```

2. Instale as dependências
   
```bash
composer install
```
3. Configure as variáveis de ambiente
-Copie o arquivo .env e edite conforme seu ambiente, ou crie .env.local com as configurações locais.

4. Configure o banco de dados e rode as migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

```
5. Gere a chave JWT (se aplicável)

```bash
# Gere as chaves se ainda não existirem
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
6. Execute o servidor
```bash
symfony server
```
