## Sistema de Estacionamento - MYSYSPARKING

Sistema criado através do curso realizado na UDEMY - Curso de Laravel y Livewire - Crea un Sistema de Parking.

## Funcionalidades:
- Cadastro de Cliente - Em desenvolvimento.
- Cadastro de Veículos
- Cadastro de Fabricantes
- Cadastro de Modelos
- Cadastro de Empresa
- Cadastro de Usuários
- Cadastro de Perfil de Acesso*
- Cadastro de Tarifas
- Controle de Entrada de Veículos
- Controle de Ticket Extraviado
- Movimento de Caixa*
- Fechamento de Caixa*
- Dashboard de Vendas com 3 Gráficos
- Relatório de Venda diárias
- Relatório de Venda por Datas
- Relatório de Cliente Mensalistas

(*) - Itens em ajustes.

## Instalação

Clone o repositório e manualmente execute o 'composer':
git clone https://github.com/rodrigompais/sysparking.git

Os comandos acima baixam o código do sistema e instalam suas dependências. Agora é preciso configurar o sistema.

Você pode copiar o arquivo .env.example e criar um novo chamado .env, nesse arquivo ficarão as configurações do banco de dados e demais configurações do sistema.

cp .env.example .env
Abra o arquivo .env e configure-o de acordo com as informações do seu servidor.

Por fim execute o comando abaixo.

- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan serve

## Usuários Default

- Administrador
- Login: admin@mysysparking.com.br
- Senha: password

- Demo
- Login: demo@mysysparking.com.br
- Senha: password




