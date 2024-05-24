<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;

class AuthController extends Controller
{
    public function handleProviderCallback(Request $request)
    {
        $provider = new GenericProvider([
            'clientId'                => env('ONEDRIVE_CLIENT_ID'),
            'clientSecret'            => env('ONEDRIVE_CLIENT_SECRET'),
            'redirectUri'             => env('ONEDRIVE_REDIRECT_URI'),
            'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
        ]);

        $code = $request->input('code');

        try {
            // Tentar obter um token de acesso usando o código de autorização
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $code
            ]);

            // Armazenar o token de acesso e usá-lo para chamadas subsequentes ao OneDrive
            // ...

            return redirect('/')->with('message', 'Autenticação bem-sucedida!');
        } catch (\Exception $e) {
            // Tratar falhas de autenticação
            return redirect('/')->with('error', 'Falha na autenticação!');
        }
    }
}
