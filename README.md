# Gestão de Brinquedos

Sistema web feito em PHP e MySQL para gerenciar os brinquedos de uma loja. Foi desenvolvido como atividade de recuperação sobre CRUD, Prepared Statements e correção de erros em PHP.

## Informações de cada brinquedo

- ID
- Nome
- Categoria
- Faixa etária
- Preço
- Quantidade em estoque

## O que o sistema faz

- Cadastrar um novo brinquedo
- Listar os brinquedos cadastrados
- Editar os dados de um brinquedo
- Excluir um brinquedo

## Requisitos atendidos

- **Prepared Statements:** todas as operações com o banco (listar, buscar, cadastrar, editar e excluir) usam `mysqli_prepare`, sem colocar os valores digitados direto no SQL.
- **Validação dos dados:** nenhum campo pode ficar vazio, os textos tem tamanho máximo, o preço precisa ser um número maior ou igual a zero e o estoque precisa ser um número inteiro maior ou igual a zero. O id que vem pela URL também é conferido.
- **Tratamento de erros:** se a conexão, a consulta ou a execução falhar, aparece uma mensagem na tela. O sistema avisa se o brinquedo não existir..
- **Organização:** os arquivos ficam separados em pastas por função.

## Tecnologias

- PHP (extensão mysqli)
- MySQL
- HTML e CSS
- XAMPP

## Estrutura de pastas


- database/db.sql: código utilizado no phpmyadmin para criar o banco de dados.
- infra/conexao.php: faz a conexão com o banco.
- public/: telas de cadastrar e editar, e o arquivo que exclui.
- index.php: página inicial, com a lista de brinquedos.

## Como usar

1. Na página inicial aparece a lista de brinquedos cadastrados.
2. Clique em **Cadastrar Brinquedo**, preencha os campos e envie.
3. Na lista, clique em **Editar** para alterar os dados de um brinquedo.
4. Clique em **Excluir** para apagar um brinquedo (o sistema pede confirmação).

## Banco de dados

O banco se chama "gestao_brinquedos" e tem uma tabela chamadas "brinquedos" com as colunas:

- id: número inteiro, chave primária, auto increment;
- nome: texto de até 100 caracteres;
- categoria: texto de até 100 caracteres;
- faixa_etaria: texto de até 50 caracteres;
- preco: decimal com 2 casas;
- quantidade_estoque: número inteiro.