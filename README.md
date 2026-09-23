# Curso CodeIgniter: catálogo e painel de livros

Projeto de estudo em **PHP + CodeIgniter 3**, rodando no XAMPP com MySQL/MariaDB.

- **Catálogo público** (`/`): vitrine com os livros ativos, sem login.
- **Login** (`/login`): entra com nome ou e-mail e senha.
- **Painel** (exige login):
  - **Livros** (`/livros`): cadastrar, editar, apagar, ativar ou desativar e enviar capa (JPG, PNG ou GIF de até 2 MB).
  - **Usuários** (`/usuarios`): cadastrar, editar (com troca de senha opcional), ativar ou desativar e apagar.

## Requisitos

- XAMPP com PHP 7.4 ou mais novo (testado com PHP 8.2) e MySQL/MariaDB
- Apache servindo a pasta `htdocs`

## Instalação

1. Coloque o projeto em `C:\xampp\htdocs\` (a pasta pode ter qualquer nome; o endereço é calculado sozinho).
2. Crie o banco e as tabelas:
   ```
   C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE curso_ci_3 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci"
   C:\xampp\mysql\bin\mysql.exe -u root curso_ci_3 < database/schema.sql
   ```
   Se preferir o phpMyAdmin, crie o banco `curso_ci_3` e importe o arquivo `database/schema.sql`.
3. Copie `application/config/database.example.php` para `application/config/database.php` e ajuste usuário, senha e nome do banco, se forem diferentes do padrão do XAMPP. O `database.php` fica fora do Git.
4. (Opcional) Importe os 9 livros de exemplo com capas:
   ```
   C:\xampp\php\php.exe database/seeds/importar-livros.php
   ```
5. Abra `http://localhost/<pasta-do-projeto>/`.

**Primeiro acesso:** `admin@teste.com` com a senha `admin123`, criado pelo `schema.sql`. Troque a senha em *Listar usuários → Editar*.

## Estrutura

| Caminho | Função |
|---|---|
| `index.php` | Porta de entrada: toda requisição passa por aqui. |
| `system/` | O framework CodeIgniter. Não edite. |
| `application/config/` | Configurações: rotas, banco, sessão, CSRF, idioma. |
| `application/core/MY_Controller.php` | Base do painel: exige login com conta ativa e oferece `avisar()` e `exigirPost()`. |
| `application/controllers/` | `Catalogo` (público), `Login`, `Livros` e `Usuarios` (os dois últimos herdam de `MY_Controller`). |
| `application/models/` | Acesso às tabelas `livros` e `usuarios`. |
| `application/views/` | Telas. `layout/topo.php` e `layout/rodape.php` envolvem as páginas do painel; `layout/aviso.php` mostra as mensagens de sucesso e erro. |
| `application/language/portuguese-br/` | Traduções das mensagens do framework (validação, upload etc.). |
| `database/schema.sql` | Estrutura do banco e usuário inicial. |
| `database/seeds/` | Livros de exemplo e script de importação. |
| `assets/capas/` | Capas de exemplo usadas quando o livro não tem imagem. |
| `uploads/livros/` | Capas enviadas pelo painel (fora do Git). |

## Como as coisas funcionam

- **Login:** a sessão guarda o usuário logado. A cada página do painel, `MY_Controller` confere no banco se a conta ainda existe e está ativa; se não estiver, o acesso cai na hora.
- **Mensagens:** depois de salvar, apagar ou mudar um status, o controller chama `$this->avisar('success', '...')` e redireciona. A mensagem aparece uma vez só (flashdata).
- **Segurança:** a proteção CSRF está ligada. Todo formulário precisa ser aberto com `form_open()` ou `form_open_multipart()`, que inserem o token automaticamente; um `<form method="post">` escrito à mão será recusado com erro 403. Ações que apagam ou alteram dados só aceitam POST.
- **Senhas:** são guardadas com `password_hash()` e conferidas com `password_verify()`.
