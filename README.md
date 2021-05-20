# Memini Web (MVC)

# Usuários

O arquivo de SQL acompanhando o projeto cadastra dois usuários no sistema, que são

<table>
  <tr>
    <th>Nome</th>
    <th>Email</th>
    <th>Senha</th>
  </tr>
  <tr>
    <td>Administrator</td>
    <td>admin@admin.com</td>
    <td>desenv</td>
  </tr>
  <tr>
    <td>User</td>
    <td>user@user.com</td>
    <td>desenv</td>
  </tr>
</table>

O *login* deve ser feito com o email e a senha.

## Observações

Os seguintes requisitos da Avaliação III não foram implementados:

* "Pelo menos três tabelas no banco de dados: usuários, perfil e produtos/serviços" - apenas as tabelas de usuários e de produtos/serviços, a saber, dos baralhos e cartas foram implementadas. O perfil do usuário é indicado por um campo booleano na tabela de usuários que representa se ele é administrador ou não;
* "Deve ser possível enviar um arquivo em um dos cadastros/alterações (upload): você pode escolher um tipo específico de arquivo, se quiser." - o envio de qualquer tipo de arquivo não foi implementado.

Além disso, as operações CRUD foram implementadas apenas para os baralhos. Ficaram faltando as cartas.
