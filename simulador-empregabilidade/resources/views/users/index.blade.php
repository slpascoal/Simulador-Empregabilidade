<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Empregabilidade</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=SUSE:wght@100..800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="BodyContainer">
        <div class="corpo">
            <header class="header">
                <h1>Simulador de Empregabilidade</h1>
                <p>Essa aplicação traça uma lista de usuários. <br>Você pode filtrar suas habilidades e experiências de trabalho, para difinir se é a pesoa correta para o cargo!</p>
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
                    <button type="submit">Filtrar</button>
                </form>
            </nav>
            <!-- Exibição dos Usuários -->
            <div class="users-list">
                @if(count($users) > 0)
                    @foreach ($users as $user)
                        <div class="user-card">
                            <img src="{{ $user['avatar'] }}" alt="Avatar" style="width:100px;height:100px;">
                            <h2>{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
                            <p>{{ $user['employment']['title'] }} - Habilidade: {{ $user['employment']['key_skill'] }}</p>
                            <p>{{ $user['address']['city'] }}, {{ $user['address']['state'] }}</p>
                        </div>
                    @endforeach
                @else
                    <p>Nenhum usuário encontrado com os filtros aplicados.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
