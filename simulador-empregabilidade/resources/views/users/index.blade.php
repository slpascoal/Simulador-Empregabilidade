<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Empregabilidade</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Simulador de Empregabilidade</h1>
    <p>Essa aplilcação traça uma lista de usuários. <br>Você pode filtrar suas habilidades e experiências de trabalho, para difinir se é a pesoa correta para o cargo!</p>

    <!-- Filtros por Habilidades e Títulos -->
    <form method="GET" action="/users">
        <label for="key_skill">Filtrar por Habilidade:</label>
        <select name="key_skill" id="key_skill">
            <option value="">-- Selecione uma habilidade --</option>
            @foreach($skills as $skill)
                <option value="{{ $skill }}" {{ request('key_skill') == $skill ? 'selected' : '' }}>
                    {{ $skill }}
                </option>
            @endforeach
        </select>

        <label for="title">Filtrar por Posição:</label>
        <input type="text" name="title" id="title" value="{{ request('title') }}">

        <button type="submit">Filtrar</button>
    </form>

    <!-- Exibição dos Usuários -->
    <div class="users-list">
        @foreach ($users as $user)
            <div class="user-card">
                <img src="{{ $user['avatar'] }}" alt="Avatar">
                <h2>{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
                <p>{{ $user['employment']['title'] }} - Habilidade: {{ $user['employment']['key_skill'] }}</p>
                <p>{{ $user['address']['city'] }}, {{ $user['address']['state'] }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>
