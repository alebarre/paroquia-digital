# ⛪ Paróquia Digital

Sistema de gestão para paróquias católicas desenvolvido com **Laravel 12**, cobrindo o ciclo completo de administração pastoral: fiéis, sacramentos com emissão de certidão em PDF, grupos pastorais, eventos e finanças.

---

## 📋 Índice

- [Funcionalidades](#-funcionalidades)
- [Stack de Tecnologias](#-stack-de-tecnologias)
- [Requisitos do Sistema](#-requisitos-do-sistema)
- [Instalação e Configuração](#-instalação-e-configuração)
- [Variáveis de Ambiente](#️-variáveis-de-ambiente)
- [Build & Execução](#-build--execução)
- [Rodando em Desenvolvimento](#-rodando-em-desenvolvimento)
- [Testes](#-testes)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Rotas Disponíveis](#-rotas-disponíveis)
- [Banco de Dados](#-banco-de-dados)

---

## ✨ Funcionalidades

| Módulo | Descrição |
|---|---|
| **Autenticação** | Login, registro e recuperação de senha (Laravel Breeze) |
| **Dashboard** | Painel com resumo gerencial |
| **Fiéis** | Cadastro completo de paroquianos e famílias |
| **Sacramentos** | Registro de batismo, crisma, casamento, etc. com emissão de certidão em PDF |
| **Grupos** | Criação e gestão de grupos pastorais com membros |
| **Eventos** | Calendário de eventos da paróquia |
| **Finanças** | Lançamento de receitas e despesas por categoria |
| **Permissões** | Controle de acesso baseado em papéis (Spatie Laravel Permission) |

---

## 🛠 Stack de Tecnologias

**Back-end**
- [PHP](https://php.net) `^8.2`
- [Laravel](https://laravel.com) `^12.0`
- [Laravel Breeze](https://github.com/laravel/breeze) `^2.3` — autenticação
- [Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf) `^3.1` — geração de PDFs
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) `^7.2` — papéis e permissões
- [Laravel Tinker](https://github.com/laravel/tinker) `^2.10`

**Front-end**
- [Tailwind CSS](https://tailwindcss.com) `^3.x`
- [Alpine.js](https://alpinejs.dev) `^3.x`
- [Vite](https://vite.dev) `^7.x` + [laravel-vite-plugin](https://github.com/laravel/vite-plugin)
- [Axios](https://axios-http.com) `^1.x`

**Banco de Dados**
- SQLite *(padrão, zero configuração)*
- MySQL / MariaDB / PostgreSQL *(suportados via variáveis de ambiente)*

---

## ⚙ Requisitos do Sistema

- **PHP** `>= 8.2` com as extensões: `pdo`, `pdo_sqlite` (ou `pdo_mysql`), `mbstring`, `xml`, `curl`, `fileinfo`, `openssl`
- **Composer** `>= 2.x`
- **Node.js** `>= 20.x` e **npm** `>= 10.x`
- **SQLite3** (ou servidor MySQL/PostgreSQL se preferir)
- Git

### Verificando os requisitos

```bash
php -v          # >= 8.2
composer -V     # >= 2.x
node -v         # >= 20
npm -v          # >= 10
```

---

## 🚀 Instalação e Configuração

### 1. Clonar o repositório

```bash
git clone https://github.com/seu-usuario/paroquia-digital.git
cd paroquia-digital
```

### 2. Instalação rápida (script automático)

O `composer.json` inclui um script `setup` que executa todas as etapas de uma só vez:

```bash
composer run setup
```

Este comando executa internamente:
1. `composer install` — instala dependências PHP
2. Copia `.env.example` → `.env` (se ainda não existir)
3. `php artisan key:generate` — gera a chave da aplicação
4. `php artisan migrate --force` — cria as tabelas no banco
5. `npm install` — instala dependências Node.js
6. `npm run build` — compila os assets

### 3. Instalação manual (passo a passo)

Caso prefira ter controle de cada etapa:

```bash
# 1. Dependências PHP
composer install

# 2. Arquivo de ambiente
cp .env.example .env

# 3. Chave da aplicação
php artisan key:generate

# 4. (Opcional) Criar o banco SQLite — necessário apenas se DB_CONNECTION=sqlite
touch database/database.sqlite

# 5. Executar as migrations
php artisan migrate

# 6. (Opcional) Popular com dados iniciais
php artisan db:seed

# 7. Dependências Node.js
npm install

# 8. Compilar assets para produção
npm run build
```

---

## 🗺️ Variáveis de Ambiente

Copie `.env.example` para `.env` e ajuste conforme o seu ambiente:

```dotenv
# -----------------------------------------------
# Aplicação
# -----------------------------------------------
APP_NAME="Paróquia Digital"
APP_ENV=local          # local | production
APP_KEY=               # gerada via: php artisan key:generate
APP_DEBUG=true         # false em produção
APP_URL=http://localhost:8000
APP_LOCALE=pt_BR

# -----------------------------------------------
# Banco de Dados
# -----------------------------------------------
# --- SQLite (padrão, sem servidor necessário) ---
DB_CONNECTION=sqlite
# DB_DATABASE=/caminho/absoluto/para/database/database.sqlite

# --- MySQL (descomente e preencha se necessário) ---
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=paroquia_digital
# DB_USERNAME=root
# DB_PASSWORD=

# --- PostgreSQL ---
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=paroquia_digital
# DB_USERNAME=postgres
# DB_PASSWORD=

# -----------------------------------------------
# Sessão / Cache / Filas
# -----------------------------------------------
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

# -----------------------------------------------
# E-mail (log para dev, configure SMTP em produção)
# -----------------------------------------------
MAIL_MAILER=log
# MAIL_MAILER=smtp
# MAIL_HOST=smtp.mailgun.org
# MAIL_PORT=587
# MAIL_USERNAME=null
# MAIL_PASSWORD=null
# MAIL_FROM_ADDRESS="paroquia@exemplo.com"
# MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🏗 Build & Execução

### Assets Front-end

```bash
# Desenvolvimento (com hot-reload via Vite)
npm run dev

# Produção (bundle otimizado em public/build/)
npm run build
```

### Servidor PHP

```bash
# Servidor de desenvolvimento embutido
php artisan serve

# Porta customizada
php artisan serve --port=8080
```

### Filas (Queue Worker)

O sistema utiliza filas de banco de dados. Em desenvolvimento, o script `composer run dev` já as inicia. Em produção, use:

```bash
php artisan queue:work --tries=3
```

---

## 💻 Rodando em Desenvolvimento

O comando abaixo inicializa **todos os serviços** de uma só vez — servidor PHP, worker de filas, log em tempo real (Pail) e Vite — usando processos coloridos:

```bash
composer run dev
```

Acesse em: **http://localhost:8000**

---

## 🧪 Testes

```bash
# Executar a suíte completa
composer run test

# Ou diretamente via Artisan
php artisan test

# Apenas um arquivo ou método específico
php artisan test --filter NomeDoTeste

# Com cobertura (requer Xdebug ou PCOV)
php artisan test --coverage
```

---

## 📁 Estrutura do Projeto

```
paroquia-digital/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # DashboardController, FielController, SacramentoController,
│   │   │                      # GrupoController, EventoController, FinancaController…
│   │   └── Middleware/
│   ├── Models/                # User, Fiel, Familia, Sacramento, Grupo, Evento, Financa…
│   ├── Providers/
│   └── View/
├── database/
│   ├── migrations/            # Todas as migrations do projeto
│   ├── seeders/
│   └── database.sqlite        # Banco SQLite (criado automaticamente)
├── public/                    # Ponto de entrada (index.php) e assets compilados
├── resources/
│   ├── css/                   # app.css (Tailwind)
│   ├── js/                    # app.js (Alpine.js + Axios)
│   └── views/
│       ├── layouts/           # app.blade.php, guest.blade.php
│       ├── dashboard.blade.php
│       ├── fieis/
│       ├── sacramentos/
│       ├── grupos/
│       ├── eventos/
│       └── financas/
├── routes/
│   ├── web.php                # Rotas principais
│   └── auth.php               # Rotas de autenticação (Breeze)
├── storage/
├── .env.example
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js
```

---

## 🗺 Rotas Disponíveis

Todas as rotas abaixo exigem **autenticação** (`auth` + `verified`).

| Método | URI | Nome | Descrição |
|---|---|---|---|
| GET | `/dashboard` | `dashboard` | Painel principal |
| GET/POST | `/fieis` | `fieis.index / store` | Lista e cadastro de fiéis |
| GET/PUT/DELETE | `/fieis/{fiel}` | `fieis.show / update / destroy` | Detalhe, edição e exclusão |
| GET/POST | `/sacramentos` | `sacramentos.index / store` | Lista e registro de sacramentos |
| GET | `/sacramentos/{sacramento}/certidao` | `sacramentos.certidao` | PDF da certidão |
| GET/POST | `/grupos` | `grupos.index / store` | Lista e criação de grupos |
| GET/POST | `/eventos` | `eventos.index / store` | Lista e criação de eventos |
| GET/POST | `/financas` | `financas.index / store` | Lista e lançamento financeiro |
| GET/PATCH/DELETE | `/profile` | `profile.edit / update / destroy` | Gerenciamento do perfil do usuário |

Para listar todas as rotas registradas:

```bash
php artisan route:list
```

---

## 🗄 Banco de Dados

### Migrations incluídas

| Migration | Tabela | Descrição |
|---|---|---|
| `create_users_table` | `users` | Usuários do sistema |
| `create_cache_table` | `cache` | Cache em banco |
| `create_jobs_table` | `jobs` | Filas de jobs |
| `create_permission_tables` | `roles`, `permissions`… | Spatie Permission |
| `create_familias_table` | `familias` | Famílias de paroquianos |
| `create_fieis_table` | `fieis` | Fiéis / paroquianos |
| `create_grupos_table` | `grupos` | Grupos pastorais |
| `create_sacramentos_table` | `sacramentos` | Registros de sacramentos |
| `create_categorias_financas_table` | `categorias_financas` | Categorias financeiras |
| `create_eventos_table` | `eventos` | Eventos da paróquia |
| `create_financas_table` | `financas` | Lançamentos financeiros |
| `create_membros_grupos_table` | `membros_grupos` | Membros de grupos (pivot) |
| `create_missas_table` | `missas` | Registro de missas |

### Executar as migrations

```bash
# Criar/atualizar todas as tabelas
php artisan migrate

# Recriar toda a estrutura (⚠️ apaga todos os dados)
php artisan migrate:fresh

# Recriar e popular com dados de teste
php artisan migrate:fresh --seed
```

---

## 🔐 Permissões e Papéis

O sistema utiliza o pacote **Spatie Laravel Permission**. Para criar papéis e permissões via Artisan Tinker:

```bash
php artisan tinker
```

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Criar papéis
$admin = Role::create(['name' => 'admin']);
$secretaria = Role::create(['name' => 'secretaria']);

// Criar permissões
Permission::create(['name' => 'gerenciar fieis']);
Permission::create(['name' => 'gerar certidao']);

// Atribuir permissão ao papel
$admin->givePermissionTo(Permission::all());

// Atribuir papel ao usuário
$user = \App\Models\User::find(1);
$user->assignRole('admin');
```

---

## 📄 Licença

Este projeto está licenciado sob a licença [MIT](https://opensource.org/licenses/MIT).
