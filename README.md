# Painel privado

O painel privado é uma apliação web cuja finalidade é expor visões estratégicas com os dados coletados pelo AUTOMATA.

## Requisitos
 
 - Docker;
 - Docker-Compose (versão 1.28.6);
 - Node JS (~v12)

## Instalação (Backend)

### 1. Copie o arquivo `.env.example` e cole renomeando para `.env`.

No arquivo criado, altere o valor das variáveis `ADMIN_EMAIL` e `ADMIN_PASSWORD` para um email e senha de sua escolha. Caso esteja usando um ambiente Linux, no mesmo arquivo, altere o valor da variável `USER` para o nome do seu usuário e o valor da variável
`UID` para o resultado de:

```bash
id -u
```

### 2. Para iniciar os containers rode o comando:

```bash
docker-compose up -d
```

Caso tenha problemas de permissão, crie um novo grupo (se ainda não existir), adicione o `$USER` ao grupo docker, e reinicie o serviço:

```bash
sudo groupadd docker
sudo usermod -aG docker $USER
sudo gpasswd -a $USER docker
newgrp docker
sudo service docker restart
```

### 3. Para ter acesso ao id do container `postgres`, digite no terminal o seguinte comando:  

```bash
docker ps -aqf "name=confia-admin-db"
```

Acesse a base de dados (o host será ``localhost``, na porta `5433`) com as credencias das variáveis ``DB_DATABASE, DB_USERNAME e DB_PASSWORD`` (utilize algum *client* para acesso, como a extensão `PostgreSQL Explorer`, disponível no Visual Code). Após, digite o seguinte comando no terminal (substitua os parâmetros entre '<>' pelos valores reais, sem os '<>'):

```bash
docker exec -it <db_container_id> psql -U <DB_USERNAME> <DB_DATABASE>
```
e então crie os schemas ``admin_panel`` e ``detectenv``:

```bash
CREATE SCHEMA IF NOT EXISTS detectenv;
CREATE SCHEMA IF NOT EXISTS admin-panel;
```

### 4. Restaure a base do Automata

Para que funcione corretamente as páginas com relatórios e gráficos com dados do AUTOMATA, deve-se criar a estrutura e dados no schema ``detectenv``. Para isso, rode o seguinte comando:

```bash
cat db_script_automata.sql | docker exec -i <db_container_id> psql -U <DB_USERNAME> <DB_DATABASE>
```

### 5- Para instalar as dependências do projeto, rode o comando:
```bash
docker-compose exec app composer install
```
### 6- Para criar chave da aplicação, rode o comando:
```bash
docker-compose exec app php artisan key:generate
```  
### 7- Para criar as tabelas na base de dados do painel, rode o comando:
```bash
docker-compose exec app php artisan migrate
```
Para inserir os dados iniciais da aplicação rode o comando
```bash
docker-compose exec app php artisan db:seed
```

## Instalação (Frontend)

### 1. Instale as dependências do projeto com o comando:
```bash
npm install
```

### 2. Para compilar os arquivos sass/css e javascript, execute:
```bash
npm run dev
```

Caso esteja trabalhando com arquivos do frontend, recomenda-se  a execução do seguinte comando para observar as alterações feitas nesses arquivos e atualizá-las as respectivas páginas web automaticamente:

```bash
npm run watch
```

### 3- Para acessar a aplicação, digite o seguinte endereço no seu browser: ``http://localhost:8000``.


## Licença
[MIT](https://choosealicense.com/licenses/mit/)
