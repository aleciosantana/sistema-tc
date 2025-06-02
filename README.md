# Sistema TC - Fábrica de Campeões

Sistema web para gestão de pedidos, produtos, estoque, clientes e entregas, desenvolvido para a Fábrica de Campeões.

## Funcionalidades

- Cadastro e autenticação de clientes e usuários administrativos
- Gerenciamento de produtos (CRUD)
- Carrinho de compras e finalização de pedidos
- Controle de estoque
- Painel administrativo separado
- Interface responsiva com Bootstrap

## Estrutura do Projeto

- `public/` - Frontend da loja (clientes)
- `admin/` - Painel administrativo (usuários internos)
- `app/` - Código-fonte principal (Controllers, Models, Views, Core)
- `sql/` - Scripts SQL para criação do banco de dados
- `Dockerfile`, `docker-compose.yml` - Arquivos para execução com Docker

## Pré-requisitos

- [Docker](https://www.docker.com/) e [Docker Compose](https://docs.docker.com/compose/) instalados

## Como Executar

1. **Clone o repositório:**
   ```sh
   git clone <url-do-repositorio>
   cd sistema-tc
   ```

2. **Configure as variáveis de ambiente:**
   - O arquivo `.env` já está configurado para uso local com Docker.

3. **Suba os containers:**
   ```sh
   docker-compose up --build
   ```

4. **Acesse o sistema:**
   - Loja (cliente): [http://localhost](http://localhost)
   - Admin: [http://admin.localhost](http://admin.localhost)

   > Para acessar o painel admin, adicione `admin.localhost` ao seu arquivo `/etc/hosts`:
   ```
   127.0.0.1 admin.localhost
   ```

5. **Usuários de exemplo:**
   - Admin:  
     - E-mail: `admin@fabrica.com`  
     - Senha: `admin`
   - Cliente:  
     - E-mail: `cliente@exemplo.com`  
     - Senha: `cliente123`

## Banco de Dados

O banco é criado automaticamente ao subir o container MySQL, usando o script [`sql/db.sql`](sql/db.sql).

## Licença

Este projeto é apenas para fins educacionais.
