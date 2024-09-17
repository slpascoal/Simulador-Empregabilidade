# Simulador Empregabilidade
Esta aplicação simula um sistema de recomendação de usuários para cargos de emprego. Permite visualizar uma lista de usuários fictícios e filtrar os resultados com base em habilidades e cargos. 

Os detalhes dos usuários são exibidos em um modal, e o usuário pode recomendar um perfil via email.

![image](https://github.com/user-attachments/assets/8a1a26c8-9ec5-41b9-a34f-1fa3bb8bf3fb)


## Requisitos
Para rodar a aplicação, dentro de "simulador-empregabilidade", rode no terminal:

- `composer install` precisará instalar o Composer (https://getcomposer.org/);
- `cp .env.example .env` configurar o arquivo .env que contém informações necessárias para o funcionamento;
- `php artisan key:generate` Gerar a chave da aplicação Laravel

## EmailJS (Opcional)
Essa aplicação possui uma interação com email, sendo necessário vincular com sua conta EmailJS.

Para isso, crie uma conta em https://www.emailjs.com/ e mude os seguintes campos do arquivo ".env" para os valores da sua conta no EmailJS:

```
EMAILJS_SERVICE_ID=
EMAILJS_TEMPLATE_ID=
EMAILJS_USER_EMAIL=
EMAILJS_API_KEY=
```

É recomendado também que você crie um "Email Templates" com esse padrão:

No campo "Content":
```
Olá! 

Achamos um usuário compatível com a vaga anunciada:

{{{message}}}
 ```

E em "To Email", deixe o mesmo email que você definiu em "EMAILJS_USER_EMAIL=" no arquivo ".env"

## Rodar Aplicação
Para rodar a aplicação, basta rodar:

`php artisan serve`

Abra o navegador em:
`http://localhost:8000/`


# Descrição da Aplicação
Por fins didáticos, deixarei a explicação da minha aplicação:

## Estrutura do Projeto
- `public/` – Onde deixei os arquivos estáticos usados no Front-End (CSS e JS): arquivos para estilização, configuração do Modal e envio de email.
  - `js/` – Contém o arquivo JavaScript externo `scripts.js` para configuração do Modal e envio de email.
  - `css/` – Contém o arquivo de estilos CSS para estilização de `index.blade.php`.
- `resources/` – Onde fica os arquivos fonte do Laravel.
  - `views/` – Inclui os arquivos Blade do Laravel que definem a estrutura das páginas HTML (Front-End).
- `routes/web.php` – Define as rotas da aplicação.
- `app/` – Diretório do código principal da aplicação (Back-End), incluindo os controladores.

## Descrição do Código
### Blade Principal
`resources/views/index.blade.php`

- `<head>`:  Inclui os links para fontes e o Bootstrap, além de um arquivo CSS (app.css) e integração com API do EmailJS;
- `<body>`:
  - Header: Cabeçalho;
  - Navbar: Formulário para filtrar usuários por habilidade e cargo;
  - `users-list`: Lista os usuários em "cards". Cada card possui dados do usuário e atributos `data-*` para armazenar informações adicionais.
  - Modal: Um modal Bootstrap para exibir detalhes do usuário quando um cartão é clicado. Inclui um botão para recomendar o usuário por email ou fechar o Modal.
  - JavaScript: No final do `<body>` temos o link com nosso script externo `scripts.js` e link com outro script Bootstrap.

### JavaScript Externo 
`public/js/scripts.js`

- `DOMContentLoaded`: Quando o DOM (a página) está totalmente carregado, adiciona eventos de clique a todos os elementos com: '.user-card'
- `Evento de Clique`: Preenche o modal com informações do usuário selecionado (vindas do Back-End) e mostra o modal.
- `sendRecommendationEmail`: Função que utiliza EmailJS para enviar um email recomendando o usuário.

### CSS  
`public/css/app.css`

Basicamente, os estilos da página.

### Rotas 
`routes/web.php`

- Define uma rota GET '/' que usa o método index do UserController para retornar a lista de usuários filtrados. Ela pode ser nomeada como "users.index" (Escolhi isso para tratar um erro da API Púlbica, que não identificava QUERY PARAMETERS em branco)
- Mantenha uma rota GET com caminho '/users' como um alias, como forma também de otimizar a busca em "UserController"

### Controllers 
`app/Http/Controllers/UserController.php`

- `GuzzleHttp\Client`: Como usei a versão 7.2 do PHP, foi necessário usar o Guzzle para fazer a requisição à API de usuários;
- `index`:
  - Primeiro obtemos os parâmetros de consulta enviados na URL, usamos `array_filter()` para remover parâmetros vazios ou nulos e então edireciona a requisição para a rota `users.index`, removendo esses parâmetros da URL. Fiz isso para resolver um bug com os parâmetros vazios;
  - Com isso, faço a requisição da API Pública através do Cliente (que vem do Guzzle) e armazeno as informações JSON em $users
  - Uso `array_column()` duas vezes para extrair o campo `key_skill` de cada usuári(suas habilidades);
  - `array_unique()` remove duplicatas;
  - Após isso, começo a filtragem, com base na busca do usuário. Se o parâmetro `key_skill` estiver presente na requisição e não for vazio, é filtrado por habilidades. O mesmo processo é aplicado ao campo `title` (simboliza o cargo), onde (se fornecido) é realizado o filtro;
  - Após isso, retorna a view `users.index` com os usuários filtrados e as habilidades extraídas para a listagem vista em `index.blade.php`.
