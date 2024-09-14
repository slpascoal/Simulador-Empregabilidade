<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client([
            'verify' => false
        ]);

        $response = $client->get('https://random-data-api.com/api/v2/users?size=100');
        $users = json_decode($response->getBody()->getContents(), true);

        // Extrair habilidades únicas
        $skills = array_unique(array_column(array_column($users, 'employment'), 'key_skill'));

        if ($request->has('key_skill')) {
            $users = array_filter($users, function($user) use ($request) {
                return $user['employment']['key_skill'] == $request->key_skill;
            });
        }

        if ($request->has('title')) {
            $users = array_filter($users, function($user) use ($request) {
                return stripos($user['employment']['title'], $request->title) !== false;
            });
        }

        return view('users.index', compact('users', 'skills'));
    }
}
