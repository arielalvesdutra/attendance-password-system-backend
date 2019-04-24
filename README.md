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
| /attendance-passwords/{id}/attend-password  | PATCH | Atualiza o status da senha para "Em andamento" e seta um Guichê para a senha
| /attendance-passwords/{id}/cancel-password  | PATCH | Atualiza o status da senha para "Cancelado"
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

Senha de Atendimento - /attendance-passwords/1/attend-password

```json
{
  "ticketWindowId": 2
}
```