<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulador de Empregabilidade</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Fonte padrão App -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=SUSE:wght@100..800&display=swap" rel="stylesheet">
    <!-- Fonte Escrita ID -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap JavaScript Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>

    <script>
        window.env = {
            EMAILJS_SERVICE_ID: '{{ env('EMAILJS_SERVICE_ID') }}',
            EMAILJS_TEMPLATE_ID: '{{ env('EMAILJS_TEMPLATE_ID') }}',
            EMAILJS_USER_EMAIL: '{{ env('EMAILJS_USER_EMAIL') }}',
            EMAILJS_API_KEY: '{{ env('EMAILJS_API_KEY') }}',
        };

        emailjs.init(window.env.EMAILJS_API_KEY); // Inicializa o EmailJS com a API key
    </script>

</head>
<body>
    <div class="BodyContainer">
        <h1>Simulador de Empregabilidade</h1>
        <div class="corpo">
            <header class="header">
                <p>Essa aplicação traça uma lista de usuários. <br>Você pode filtrar suas habilidades e experiências de trabalho, para definir se é a pessoa correta para o cargo!</p>
            </header>
            <!-- Filtros por Habilidades e Cargos -->
            <nav class="navbar">
                <form method="GET" action="/users">
                    <label for="key_skill">Filtrar por Habilidade:</label>
                    <select name="key_skill" id="key_skill">
                        <option value="">Selecione</option>
                        @foreach($skills as $skill)
                            <option value="{{ $skill }}" {{ request('key_skill') == $skill ? 'selected' : '' }}>
                                {{ $skill }}
                            </option>
                        @endforeach
                    </select>
                    <br>
                    <label for="title">Filtrar por Cargo:</label>
                    <input type="text" name="title" id="title" value="{{ request('title') }}">
                    <br>
                    <button type="submit" class="button-82-pushable" role="button">
                        <span class="button-82-shadow"></span>
                        <span class="button-82-edge"></span>
                        <span class="button-82-front text">
                            FILTRAR
                        </span>
                    </button>
                </form>
            </nav>
            <!-- Exibição dos Usuários -->
            <div class="users-list">
                @if(count($users) > 0)
                    @foreach ($users as $user)
                        <div class="user-card"
                             data-email="{{ $user['email'] }}"
                             data-phone="{{ $user['phone_number'] }}"
                             data-dob="{{ $user['date_of_birth'] }}"
                             data-address="{{ $user['address']['street_address'] }}, {{ $user['address']['city'] }}, {{ $user['address']['state'] }}, {{ $user['address']['country'] }}"
                             data-key-skill="{{ $user['employment']['key_skill'] }}">
                            <div class="areaIMG">
                                <img src="{{ $user['avatar'] }}" alt="Avatar" style="width:100px;height:100px;">
                                <h2>{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
                            </div>
                            <div class="areaInfo">
                                <h3>Experiência:</h3>
                                <p>• {{ $user['employment']['title'] }}</p>

                                <h3>Habilidade:</h3>
                                <p>• {{ $user['employment']['key_skill'] }}</p>

                                <h3>Endereço:</h3>
                                <p>• {{ $user['address']['city'] }}, {{ $user['address']['state'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>Nenhum usuário encontrado com os filtros aplicados.</h4>
                @endif
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Detalhes do Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Conteúdo do Modal será preenchido pelo JavaScript -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="recommendButton">Recomendar Usuário</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/scripts.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
