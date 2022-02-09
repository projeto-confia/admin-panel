# Painel administrativo

O painel administrativo é uma apliação web cuja finalidade é expor visões estratégicas com os dados coletados pelo AUTOMATA.

## Dependências com Componentes do Ambiente
Esta aplicação depende do componente [database](https://github.com/projeto-confia/database).
## Requisitos
 
 - [Docker](https://docs.docker.com/get-docker/)
 - [Docker Compose](https://docs.docker.com/compose/install/)
 - [Node JS ^12.0.0](https://nodejs.org/en/download/releases/)

## Instalação
Todos os comandos são executados a partir do diretório raiz do projeto.
### 1. Criar arquivo `.env`:

No arquivo criado, altere o valor das variáveis `ADMIN_EMAIL` e `ADMIN_PASSWORD` para um email e senha de sua escolha. 
Caso esteja usando um ambiente Linux, no mesmo arquivo, altere o valor da variável `USER` para o nome do seu usuário e o valor da variável `UID` para o resultado de:
```bash
id -u
```
### 2. Criar containers Docker:
```bash
docker-compose up -d
```
### 3. Instalar as dependências:
```bash
docker-compose exec app composer install
```
### 4. Criar chave da aplicação:
```bash
docker-compose exec app php artisan key:generate
```  
### 5. Criar as tabelas usadas no schema admin_panel:
```bash
docker-compose exec app php artisan migrate
```
### 6. Inserir os dados iniciais da aplicação:
```bash
docker-compose exec app php artisan db:seed
```
### 7. Instalar as dependências do frontend:
```bash
npm install
```
### 8. Compilar os arquivos estilo e script:
```bash
npm run dev
```

Caso esteja trabalhando com arquivos do frontend, recomenda-se  a execução do seguinte comando para observar as alterações feitas nesses arquivos e realizar a compilação automáticamente:

```bash
npm run watch
```

Para acessar a aplicação, acesse o endereço no seu browser: [http://localhost:8000](http://localhost:8000).

## Licença
[MIT](https://choosealicense.com/licenses/mit/)
