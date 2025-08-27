# Teste Digital One

Informações para o processo seletivo de desenvolvedor

## Funcionalidades

A aplicação permite que o usuário execute as seguintes operações:

### 1. **Registro e Login**
   - **Cadastro**: O usuário pode se registrar no sistema informando seu e-mail e senha.
   - **Login**: O usuário pode realizar login com seu e-mail e senha previamente cadastrados.
   - **Recuperação de senha**: Caso o usuário esqueça a senha, ele pode recuperá-la. O sistema verifica se o e-mail fornecido existe na base de dados e permite ao usuário alterar sua senha.
### 2. **Perfil de Usuário**
   - O usuário pode acessar o seu próprio perfil onde poderá:
     - **Alterar o nome**: O nome exibido no perfil pode ser atualizado.
     - **Alterar o e-mail**: O e-mail exibido no perfil pode ser atualizado.
     - **Alterar a senha**: O usuário pode modificar sua senha.

### 3. **Página "Feed"**
   - O usuário logado pode acessar uma página de **Feed**, onde será possível:
     - **Publicar**: Criar novas publicações. Cada publicação deve ter uma descrição.
     - **Visualizar**: Visualizar as publicações de outros usuários no feed.

### 4. **Edição e Exclusão de Publicações**
   - Se o usuário logado for o **autor** de uma publicação:
     - Ele poderá **editar** a publicação.
     - Ele poderá **excluir** a publicação.
   
   Caso o usuário não seja o autor da publicação, ele não terá a opção de editar ou excluir.

---

## Estrutura do Projeto


### Backend
   - **Tecnologia**: Laravel.
   - **Banco de Dados**: MySQL/phpMyAdmin.

### Frontend
   - **Tecnologia**: Blade (ferramenta Laravel).
   - **Componentes principais**:
     - **Login**: Formulário de login.
     - **Registro**: Formulário de registro.
     - **Perfil**: Página do perfil com a funcionalidade de alteração de nome, e-mail e senha.
     - **Feed**: Página principal onde as publicações podem ser visualizadas e criadas.
     - **Post**: Componente de publicação individual com opções de edição e exclusão.
