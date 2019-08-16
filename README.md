# Descrição

Esse sistema está sendo desenvolvido para praticar TDD e Doctrine DBAL.

O sistema tem por objetivo prover a criação de senhas de atendimento para empresas que possuem postos de atendimento ao cliente, mas que ficam limitadas a apenas a emissão de senhas de papel sem uso o sistemas para automatizar e centralizar o atendimento.

O sistema será composto do backend e [frontend](https://github.com/arielalvesdutra/attendance-password-system-frontend).

## Métodos

Senha de Atendimento:

| URL  | Tipo |  Descrição |
| ---- | ---- |---- |
| /attendance-passwords  | GET  | Retorna todas as Senhas de Atendimento
| /attendance-passwords/{id}  | GET  | Retorna a Senha de Atendimento pelo ID
| /attendance-passwords/search/retrieve-10-last-finished  | GET  | Retorna 10 últimos atendimentos concluídos ou cancelados
| /attendance-passwords/search/retrieve-awaiting  | GET  | Retorna senhas aguardando atendimento
| /attendance-passwords/search/retrieve-in-progress  | GET  | Retorna senhas em atendimento
| /attendance-passwords/search/retrieve-last-in-progress  | GET  | Retorna última senha a ser atendinda
| /attendance-passwords/users/{id}/retrieve-in-progress | GET  | Retorna o atendimento em andamento pelo usuário, caso ele possua um
| /attendance-passwords/actions/attend-password  | PATCH | Atualiza o status da senha para "Em andamento", seta um Guichê e um Usuário para a senha
| /attendance-passwords/actions/{id}/cancel-password  | PATCH | Atualiza o status da senha para "Cancelado"
| /attendance-passwords/actions/{id}/conclude-password  | PATCH | Atualiza o status da senha para "Concluído"
| /attendance-passwords  | POST | Criar uma Senha de Atendimento

Categoria de Senha de Atendimento:

| URL  | Tipo |  Descrição |
| ---- | ---- |---- |
| /attendance-categories/{id}  | DELETE | Remove uma Categoria de Senha de Atendimento pelo ID
| /attendance-categories  | GET  | Retorna todas as Categorias de Senhas de Atendimento
| /attendance-categories/{id}  | GET  | Retorna a Categoria de Senha de Atendimento pelo ID
| /attendance-categories  | POST  | Cria uma Categoria de Senha de Atendimento
| /attendance-categories/{id}  | PUT | Atualiza uma Categoria de Senha de Atendimento pelo ID

Status de Senha de Atendimento:

| URL  | Tipo |  Descrição |
| ---- | ---- |---- |
| /attendance-status/{id}  | DELETE | Remove um Status de Senha de Atendimento pelo ID
| /attendance-status | GET| Retorna todos os Status de Senha de Atendimento
| /attendance-status/{id}  | GET | Retorna um Status de Senha de Atendimento pelo ID
| /attendance-status  | POST | Cria um Status de Senha de Atendimento
| /attendance-status/{id}  | PUT | Atualiza um Status de Senha de Atendimento pelo ID

Guichê:

| URL  | Tipo |  Descrição |
| ---- | ---- |---- |
| /ticket-window/{id}  | DELETE | Remove um Guichê pelo ID
| /ticket-window  | GET | Retorna todos os Guichês
| /ticket-window/{id}  | GET | Retorna um Guichê pelo ID
| /ticket-window  | POST | Cria um Guichê

Uso do Guichê:

| URL  | Tipo |  Descrição |
| ---- | ---- |---- |
| /ticket-window-use/retrieve-user-ticket-window/{id}  | GET | Retorna Guichê em uso pelo usuário ou array vazio
| /ticket-window-use/use  | POST | Usuário reserva um Guichê para uso
| /ticket-window-use/relese | POST | Usuário libera um Guichê para uso
| /ticket-window-use/retrive-unused-ticket-window | POST | Retorna Guichês que não estão sendo utilizados.

Usuário:

| URL  | Tipo |  Descrição |
| ---- | ---- |---- |
| /users/{id} | DELETE | Remove um Usuário pelo ID
| /users | GET | Retorna todos os Usuários
| /users/{id} | GET | Retorna um Usuário pelo ID
| /users | POST | Cria um Usuário
| /users/{id} | PATCH | Atualiza um Usuário pelo ID

Auth:

| URL  | Tipo |  Descrição |
| ---- | ---- |---- |
| /signin | POST | Retorna token JWT de autenticação

### Exemplos de uso dos métodos POST

Senha de atendimento - /attendance-passwords:

```json
{
  "categoryId" : 1
}
```

Categoria de Senha de Atendimento - /attendance-categories:

```json
{
  "name" : "Planejamento",
  "code" : "PLAN"
}
```

Status de Senha de Atendimento - /attendance-status:

```json
{
  "name" : "Aguardando Gerente",
  "code" : "AWAITING_MANAGER"
}
```

Guichê - /ticket-window

```json
{
  "name" : "CAIXA - 001"
}
```
Uso do Guichê - /ticket-window-use/use

```json
{
  "userId": 1,
  "ticketWindowId": 1
}
```

Uso do Guichê - /ticket-window-use/release

```json
{
  "userId": 1,
  "ticketWindowId": 1
}
```

Usuário - /users

```json
{
  "name" : "Night King",
  "email": "night.king@whitewalkers.com",
  "password": "brandonstark"
}
```

Auth - /signin

```json
{
  "email": "night.king@whitewalkers.com",
  "password": "brandonstark"
}
```

### Exemplos de uso dos métodos PUT

Categoria de Senha de Atendimento - /attendance-categories/1:

```json
{
  "name" : "Planejamento",
  "code" : "PLAN"
}
```

Status de Senha de Atendimento - /attendance-status/1:

```json
{
  "name" : "Aguardando Gerente",
  "code" : "AWAITING_MANAGER"
}
```

### Exemplos de uso dos métodos PATCH

Usuário - /users/1

```json
{
  "name" : "Night King",
  "password": "brandonstark",
  "admin": true
}
```

- Obs. 1: o e-mail não é atualizado

Senha de Atendimento - /attendance-passwords/actions/attend-password

```json
{
  "ticketWindowId": 2,
  "userId": 1
}
```

Senha de Atendimento - /attendance-passwords/actions/1/cancel-password

`Não precisa de body.`

Senha de Atendimento - /attendance-passwords/actions/1/conclude-password

`Não precisa de body.`
