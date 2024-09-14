<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Empregabilidade</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Perfis de Usuários</h1>

    <!-- Filtros por Habilidades e Títulos -->
    <form method="GET" action="/users">
        <label for="key_skill">Filtrar por Habilidade:</label>
        <select name="key_skill" id="key_skill">
            <option value="">Selecione</option>
            <option value="Teamwork">Teamwork</option>
            <option value="Communication">Communication</option>
            <!-- Adicionar mais opções conforme necessário -->
        </select>

        <label for="title">Filtrar por Posição:</label>
        <input type="text" name="title" id="title" placeholder="Digite o título do emprego">

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
