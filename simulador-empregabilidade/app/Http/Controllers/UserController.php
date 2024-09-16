<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Como usei a versão 7.2 do PHP, foi necessário usar o Guzzle para fazer a requisição à API de usuários;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function index(Request $request)
    {
        /*
            Primeiro obtemos os parâmetros de consulta enviados na URL, usamos array_filter() para remover
            parâmetros vazios ou nulos e então edireciona a requisição para a rota users.index, removendo esses parâmetros da URL.
            Fiz isso para resolver um bug com os parâmetros vazios;
        */
        $queryParams = $request->query();

        $cleanedParams = array_filter($queryParams, function ($value) {
            return $value !== null && $value !== '';
        });

        if (count($cleanedParams) !== count($queryParams)) {
            return redirect()->route('users.index', $cleanedParams);
        }

        // Com isso, faço a requisição da API Pública através do Cliente (que vem do Guzzle) e armazeno as informações JSON em $users
        $client = new Client([
            'verify' => false
        ]);

        $response = $client->get('https://random-data-api.com/api/v2/users?size=100');
        $users = json_decode($response->getBody()->getContents(), true);

        /*
            Uso array_column() duas vezes para extrair o campo key_skill de cada usuári(suas habilidades);
            array_unique() remove duplicatas;
        */
        $skills = array_unique(array_column(array_column($users, 'employment'), 'key_skill'));

        // Verificar se os usuários foram corretamente recebidos (em caso de não ter usuário ou API não retornar um array)
        if (!$users || !is_array($users)) {
            return view('users.index', compact('users', 'skills'))->withErrors(['error' => 'Nenhum usuário encontrado ou erro na API.']);
        }

        // filteredUsers recebe users, para servir de "auxiliar", mas não alterar os usuários recebidos em $users
        $filteredUsers = $users;

        /*
            Após isso, começo a filtragem, com base na busca do usuário. Se o parâmetro key_skill estiver presente
            na requisição e não for vazio, é filtrado por habilidades...
        */
        if ($request->has('key_skill') && $request->key_skill !== '') {
            $filteredUsers = array_filter($filteredUsers, function($user) use ($request) {
                return isset($user['employment']['key_skill']) && $user['employment']['key_skill'] === $request->key_skill;
            });
        }

        // ... O mesmo processo é aplicado ao campo title (simboliza o cargo), onde (se fornecido) é realizado o filtro;
        if ($request->has('title') && $request->title !== '') {
            $filteredUsers = array_filter($filteredUsers, function($user) use ($request) {
                return isset($user['employment']['title']) && stripos($user['employment']['title'], $request->title) !== false;
            });
        }

        // Após isso, retorna a view users.index com os usuários filtrados e as habilidades extraídas para a listagem vista em index.blade.php.
        return view('users.index', ['users' => $filteredUsers, 'skills' => $skills]);
    }
}
