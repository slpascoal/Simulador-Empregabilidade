<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Empregabilidade</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Simulador de Empregabilidade</h1>

        <!-- Filtros -->
        <div>
            <label for="key_skill">Filtro por Habilidade:</label>
            <input type="text" id="key_skill" placeholder="Digite uma habilidade">
            <label for="title">Filtro por Cargo:</label>
            <input type="text" id="title" placeholder="Digite um cargo">
        </div>

        <div id="users">
            @foreach ($users as $user)
                <div class="user-card">
                    <img src="{{ $user['avatar'] }}" alt="Avatar">
                    <h2>{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>
                    <p>Cargo: {{ $user['employment']['title'] }}</p>
                    <p>Habilidade Principal: {{ $user['employment']['key_skill'] }}</p>
                    <p>Email: {{ $user['email'] }}</p>
                    <p>Cidade: {{ $user['address']['city'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const users = @json($users);

        document.getElementById('key_skill').addEventListener('input', filterUsers);
        document.getElementById('title').addEventListener('input', filterUsers);

        function filterUsers() {
            const skillFilter = document.getElementById('key_skill').value.toLowerCase();
            const titleFilter = document.getElementById('title').value.toLowerCase();

            const filteredUsers = users.filter(user => {
                return user.employment.key_skill.toLowerCase().includes(skillFilter) &&
                    user.employment.title.toLowerCase().includes(titleFilter);
            });

            displayUsers(filteredUsers);
        }

        function displayUsers(users) {
            const userContainer = document.getElementById('users');
            userContainer.innerHTML = '';

            users.forEach(user => {
                userContainer.innerHTML += `
                    <div class="user-card">
                        <img src="${user.avatar}" alt="Avatar">
                        <h2>${user.first_name} ${user.last_name}</h2>
                        <p>Cargo: ${user.employment.title}</p>
                        <p>Habilidade Principal: ${user.employment.key_skill}</p>
                        <p>Email: ${user.email}</p>
                        <p>Cidade: ${user.address.city}</p>
                    </div>
                `;
            });
        }
    </script>
</body>
</html>
