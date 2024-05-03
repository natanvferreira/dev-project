# DevProject

## Descrição

DevProject é um projeto desenvolvido em PHP 8.1.0 utilizando SQLite como banco de dados

## Instalação

1. Clone este repositório para o seu ambiente local.

```
git clone https://github.com/natanvferreira/dev-project.git
```

2. Navegue até o diretório do projeto.

```
cd devproject
```

3. Instale as dependências do Composer.

```
composer install
```

4. Renomeie o arquivo `.env.example` para `.env`.

5. No arquivo `.env`, altere as seguintes linhas para utilizar o SQLite como banco de dados:

```
DB_CONNECTION=sqlite
DB_DATABASE="C:/Users/user/devproject/database/database.sqlite"
```

Se caso o arquivo não existir, o terminar vai perguntar se você deseja criar, basta digitar: yes

Certifique-se de fornecer o caminho absoluto para o arquivo do banco de dados SQLite.

6. Execute o comando `php artisan migrate` para migrar as tabelas do banco de dados.

7. Execute o comando `php artisan db:seed` para alimentar a tabela de categorias com algumas categorias e para alimentar a tabela de usuários com um usuário admin

8. Crie um link simbólico para a pasta de armazenamento.

```
php artisan storage:link
```

## Executando o projeto

Após a instalação e configuração, você pode iniciar o servidor embutido do PHP com o seguinte comando:

```
php artisan serve
```

Agora, você pode acessar o projeto em seu navegador através do URL fornecido pelo comando acima.

Caso apareça um tela com o erro: No application encryption key has been specified.
Basta clicar no botão: Generate app key
E depois dar F5

Se tudo ocorreu certo, você irá conseguir logar usando como email: admin@admin.com e a senha: 123123