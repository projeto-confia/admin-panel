# Painel privado

O painel privado é uma apliação web cuja finalidade é expor visões estratégicas com os dados coletados pelo AUTOMATA.

## Requisitos
 
 - Docker;
 - Docker-Compose (versão 1.28.6);
 - Node JS (~v12)

## Instalação


### Backend
Copie o arquivo `.env.example` e cole renomeando para `.env`.
No arquivo criado, altere o valor das variáveis `ADMIN_EMAIL` e `ADMIN_PASSWORD` para um email e senha de sua escolha. 

Caso esteja usando um ambiente Linux, no mesmo arquivo, altere o valor da variável `USER` para o nome do seu usuário e o valor da variável
`UID` para o resultado de:

```bash
id -u
```

Para iniciar os containers rode o comando  

```bash
docker-compose up -d
```

Para ter acesso ao id do container `postgres`, digite no terminal o seguinte comando:  

```bash
docker ps -aqf "name=confia-admin-db"
```

Acesse a base de dados (o host será ``localhost``, na porta `5433`) com as credencias das variáveis ``DB_DATABASE, DB_USERNAME e DB_PASSWORD`` (utilize algum *client* para acesso, como a extensão `PostgreSQL Explorer`, disponível no Visual Code). Após, digite o seguinte comando no terminal (substituir os parâmetros entre '<>' pelos valores reais, sem os '<>'):

```bash
docker exec -it <db_container_id> psql -U <DB_USERNAME> <DB_DATABASE>
```
e então crie os schemas ``admin_panel`` e ``detectenv``:

```bash
CREATE SCHEMA IF NOT EXISTS detectenv;
CREATE SCHEMA IF NOT EXISTS admin-panel;
```

Em seguida

- Para instalar as dependências rode o comando
    ```bash
    docker-compose exec app composer install
    ```
- Para criar chave da aplicação rode o comando
    ```bash
    docker-compose exec app php artisan key:generate
    ```  
- Para criar as tabelas rode o comando
    ```bash
    docker-compose exec app php artisan migrate
    ```
- Para inserir os dados iniciais da aplicação rode o comando
  ```bash
  docker-compose exec app php db:seed
  ```

### Frontend

Instale as dependências com o comando
```bash
npm install
```

Para compilar os arquivos sass/css e javascript rode
```bash
npm run dev
```

Caso esteja trabalhando com arquivos do frontend recomenda-se o comando 
```bash
npm run watch
```
Este comando observa alterações no arquivo e executa o a compilação sem a necessidade de fazer isso manualmente a cada alteração.


Acesse a aplicação em ``http://localhost:8000``.

Para que funcione corretamente as páginas com relatórios e gráficos com dados do AUTOMATA, deve-se criar a estrutura e dados no schema ``detectenv``. Para isso, rode o seguinte comando:

```bash
cat db_script_automata.sql | docker exec -i <db_container_id> psql -U <DB_USERNAME> <DB_DATABASE>
```

## Licença
[MIT](https://choosealicense.com/licenses/mit/)
