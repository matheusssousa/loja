# 🛒 Sistema de E-commerce Laravel

Um sistema completo de e-commerce desenvolvido em Laravel com funcionalidades modernas de carrinho de compras, cupons de desconto, gestão de estoque e processamento de pedidos.

## 📋 Funcionalidades

- ✅ **Gestão de Produtos**: CRUD completo com variações e controle de estoque
- 🛒 **Carrinho de Compras**: Adicionar, remover, ajustar quantidades
- 🎟️ **Sistema de Cupons**: Desconto com validação de expiração e valor mínimo
- 📦 **Controle de Estoque**: Verificação automática de disponibilidade
- 🚚 **Cálculo de Frete**: Baseado no valor do pedido
- 📧 **Notificações por Email**: Confirmação de pedidos
- 🔄 **Webhooks**: Para atualizações de status de pedidos
- 🎨 **Interface Responsiva**: Bootstrap 5 com design moderno
- 🔍 **Sistema de Busca**: Pesquisa de produtos com paginação

## 🚀 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 16.0
- **MySQL** >= 8.0
- **Git**

## 📥 Instalação

### 1. Clone o repositório

```bash
git clone [url-do-repositorio]
cd loja
```

### 2. Instale as dependências do PHP

```bash
composer install
```

### 3. Instale as dependências do JavaScript

```bash
npm install
```

### 4. Configure o ambiente

```bash
# Copie o arquivo de configuração
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 5. Configure o banco de dados

Edite o arquivo `.env` com suas credenciais do banco:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loja
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 6. Configure o email (opcional)

Para funcionalidade de email, configure no `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@gmail.com
MAIL_PASSWORD=sua_senha_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu_email@gmail.com
MAIL_FROM_NAME="Loja Online"
```

## 🗄️ Configuração do Banco de Dados

### 1. Crie o banco de dados

```sql
CREATE DATABASE loja CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Execute as migrações

```bash
php artisan migrate --seed
```

## 🏃‍♂️ Executando a Aplicação

### 1. Compile os assets

```bash
# Para desenvolvimento
npm run dev

# Para produção
npm run build
```

### 2. Inicie o servidor

```bash
php artisan serve
```

A aplicação estará disponível em: `http://localhost:8000`

## 📖 Comandos Úteis

### Desenvolvimento

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Recriar banco e popular dados
php artisan migrate:fresh --seed

# Executar apenas seeders específicos
php artisan db:seed --class=ProdutoSeeder
php artisan db:seed --class=CupomSeeder

# Gerar novos seeders/controllers/models
php artisan make:seeder NomeSeeder
php artisan make:controller NomeController
php artisan make:model NomeModel
```

### Banco de Dados

```bash
# Verificar status das migrações
php artisan migrate:status

# Rollback da última migração
php artisan migrate:rollback

# Resetar todas as migrações
php artisan migrate:reset

# Verificar conexão com banco
php artisan tinker
> DB::connection()->getPdo();
```

### Assets e Cache

```bash
# Compilar assets em tempo real
npm run watch

# Otimizar para produção
php artisan optimize
php artisan config:cache
php artisan route:cache
npm run build
```

## 🗂️ Estrutura do Projeto

```
loja/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controladores
│   │   └── Requests/            # Validações de formulário
│   ├── Models/                  # Modelos Eloquent
│   ├── Mail/                   # Classes de email
│   └── Repositories/           # Repositórios (padrão Repository)
├── database/
│   ├── migrations/             # Migrações do banco
│   └── seeders/               # Seeders com dados de exemplo
├── resources/
│   ├── views/                 # Templates Blade
│   ├── css/                   # Estilos CSS
│   └── js/                    # JavaScript
├── routes/
│   └── web.php               # Rotas da aplicação
└── public/                   # Arquivos públicos
```

## 🧪 Testando a Aplicação

### Dados de Teste

Após executar `php artisan db:seed`, você terá:

**Produtos:**
- Camiseta Básica (R$ 29,99) - Variações: P, M, G, GG
- Calça Jeans (R$ 89,90) - Variações: 36, 38, 40, 42, 44
- Tênis Esportivo (R$ 199,99) - Variações: 37, 38, 39, 40, 41, 42

**Cupons:**
- `DESCONTO10` - 10% desconto (mín. R$ 50)
- `FRETE15` - R$ 15 desconto (mín. R$ 100)
- `PROMO25` - 25% desconto (mín. R$ 200)
- `WELCOME20` - R$ 20 desconto (mín. R$ 80)

### Fluxo de Teste

1. **Produtos**: Acesse `/produtos` para ver a listagem
2. **Carrinho**: Adicione produtos ao carrinho
3. **Cupons**: Teste cupons válidos na página do carrinho
4. **Pedidos**: Finalize um pedido e verifique o email
5. **Webhook**: Teste atualizações via `/webhook/pedido/{id}/status`

## 🔧 Solução de Problemas

### Erro de Permissão

```bash
# Linux/Mac
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Windows
icacls storage /grant Users:F /t
icacls bootstrap\cache /grant Users:F /t
```

### Erro de Conexão com Banco

```bash
# Verificar se MySQL está rodando
mysql -u root -p

# Testar conexão via artisan
php artisan tinker
> DB::connection()->getPdo();
```

### Assets não carregam

```bash
# Limpar e recompilar
npm run clean
npm install
npm run dev
```