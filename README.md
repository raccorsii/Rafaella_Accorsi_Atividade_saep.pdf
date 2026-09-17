Sistema de Eleição — CRUD de Eleitores e Candidatos

Trabalho desenvolvido por nós, alunos, para a disciplina, com o objetivo de praticar a construção de um CRUD (Create, Read, Update, Delete) usando PHP + MySQL.

O sistema permite cadastrar, listar, editar e excluir eleitores e candidatos. Optamos por PHP puro (sem framework), usando PDO para acessar o banco de dados e HTML/CSS simples para a interface, já que o foco do trabalho era entender bem a lógica do CRUD e a comunicação com o banco.

O que implementamos
Eleitores
Listagem com busca por nome, número do título ou cidade
Cadastro de novo eleitor
Edição de eleitor existente
Exclusão de eleitor
Candidatos
Listagem com busca por nome, número, cargo ou partido (fictício)
Cadastro de novo candidato
Edição de candidato existente
Exclusão de candidato
Validação de campos obrigatórios e verificação de duplicidade (número de título / número de candidato), para não deixar cadastro repetido
Mensagens de sucesso e erro exibidas na tela, para dar feedback ao usuário
Cuidados básicos de segurança que aprendemos em aula: escapamos a saída com htmlspecialchars (contra XSS) e usamos consultas preparadas com PDO (contra SQL Injection)
Como organizamos o projeto
.
├── index.php               # Listagem/busca de eleitores (página inicial)
├── eleitor_criar.php        # Formulário e criação de eleitor
├── eleitor_editar.php       # Formulário e atualização de eleitor
├── eleitor_excluir.php      # Exclusão de eleitor
├── candidatos.php           # Listagem/busca de candidatos
├── candidato_criar.php       # Formulário e criação de candidato
├── candidato_editar.php      # Formulário e atualização de candidato
├── candidato_excluir.php     # Exclusão de candidato
├── db.php                   # Conexão PDO com o banco de dados
├── functions.php            # Funções auxiliares (limpar/escapar saída, redirecionar)
├── schema.sql                # Script de criação das tabelas e dados iniciais
└── css/
    └── style.css             # Estilos da interface
Requisitos
PHP 7.4 ou superior (com extensão pdo_mysql habilitada)
MySQL ou MariaDB
Servidor web (Apache, Nginx) ou o servidor embutido do PHP
Instalação e configuração
1. Clonar/copiar os arquivos

Coloque todos os arquivos do projeto na pasta pública do seu servidor (ex: htdocs, www ou public_html), mantendo a pasta css/ com o style.css dentro dela.

2. Criar o banco de dados

Crie um banco chamado eleicao e importe o script schema.sql:

bash
mysql -u root -p -e "CREATE DATABASE eleicao"
mysql -u root -p eleicao < schema.sql

⚠️ Atenção: o script schema.sql cria a tabela com o nome candidato (singular) e insere dados na tabela candidatos (plural), enquanto todo o código PHP (candidatos.php, candidato_criar.php, etc.) consulta a tabela candidatos (plural). Ajuste o CREATE TABLE para candidatos (ou renomeie a tabela após criá-la) antes de importar, para evitar erros de "tabela não encontrada".

3. Configurar a conexão com o banco

Edite o arquivo db.php com as credenciais do seu ambiente:

php
$host   = 'localhost';
$dbname = 'eleicao';
$user   = 'root';
$pass   = 'sua_senha_aqui';

⚠️ Segurança: não deixe credenciais reais (usuário/senha) commitadas no repositório. Prefira usar variáveis de ambiente (getenv()) ou um arquivo de configuração fora do controle de versão (.gitignore).

4. Executar o projeto

Usando o servidor embutido do PHP, a partir da pasta do projeto:

bash
php -S localhost:8000

Depois acesse no navegador:

http://localhost:8000/index.php
Banco de dados

O sistema utiliza duas tabelas principais:

Tabela	Campo	Descrição
eleitor	id_eleitor	ID do eleitor (chave primária)
	nome	Nome do eleitor
	numero_titulo	Número do título de eleitor (único)
	cidade	Cidade do eleitor
candidatos	id_candidato	ID do candidato (chave primária)
	nome	Nome do candidato
	numero_candidato	Número do candidato (único)
	cargo	Cargo pretendido
	partido_ficticio	Partido fictício associado
Tecnologias utilizadas
PHP (PDO)
MySQL
HTML5 / CSS3
Melhorias futuras sugeridas
Corrigir a inconsistência de nomenclatura da tabela de candidatos no schema.sql
Adicionar paginação nas listagens
Mover credenciais do banco para variáveis de ambiente
Adicionar autenticação de usuários
Escrever testes automatizados
