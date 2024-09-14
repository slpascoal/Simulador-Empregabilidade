<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Verificar e limpar parâmetros vazios
        $queryParams = $request->query();

        $cleanedParams = array_filter($queryParams, function ($value) {
            return $value !== null && $value !== '';
        });

        // Se houver parâmetros vazios, redireciona com parâmetros limpos
        if (count($cleanedParams) !== count($queryParams)) {
            return redirect()->route('users.index', $cleanedParams);
        }

        // Fazer a requisição para a API Random Data
        $client = new Client([
            'verify' => false
        ]);

        $response = $client->get('https://random-data-api.com/api/v2/users?size=100');
        $users = json_decode($response->getBody()->getContents(), true);

        // Extrair habilidades únicas para o dropdown
        $skills = array_unique(array_column(array_column($users, 'employment'), 'key_skill'));

        // Verificar se os usuários foram corretamente recebidos
        if (!$users || !is_array($users)) {
            return view('users.index', compact('users', 'skills'))->withErrors(['error' => 'Nenhum usuário encontrado ou erro na API.']);
        }

        // Aplicar os filtros de maneira eficiente
        $filteredUsers = $users;

        // Filtrar por habilidade se "key_skill" estiver definido
        if ($request->has('key_skill') && $request->key_skill !== '') {
            $filteredUsers = array_filter($filteredUsers, function($user) use ($request) {
                return isset($user['employment']['key_skill']) && $user['employment']['key_skill'] === $request->key_skill;
            });
        }

        // Filtrar por cargo se "title" estiver definido
        if ($request->has('title') && $request->title !== '') {
            $filteredUsers = array_filter($filteredUsers, function($user) use ($request) {
                return isset($user['employment']['title']) && stripos($user['employment']['title'], $request->title) !== false;
            });
        }

        // Retornar a view com os usuários filtrados e as habilidades para o dropdown
        return view('users.index', ['users' => $filteredUsers, 'skills' => $skills]);
    }
}
