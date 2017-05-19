<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Exceptions\InvalidCredentialsException;
use App\Http\Repositories\UserRepository;
use Illuminate\Cookie\CookieJar;
use Illuminate\Foundation\Application;
use Illuminate\Cookie;

/**
 * Class LoginProxy
 * @package App\Http\Controllers\Api\Auth
 */
class LoginProxy
{

    const REFRESH_TOKEN = 'refreshToken';

    /**
     * @var mixed
     */
    private $apiConsumer;

    /**
     * @var mixed
     */
    private $auth;

    /**
     * @var CookieJar
     */
    private $cookieJar;

    /**
     * @var mixed
     */
    private $db;

    /**
     * @var mixed
     */
    private $request;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * LoginProxy constructor.
     * @param Application $app
     * @param UserRepository $userRepository
     */
    public function __construct(
        Application $app,
        CookieJar $cookieJar,
        UserRepository $userRepository

    ) {
        $this->cookieJar = $cookieJar;
        $this->userRepository = $userRepository;


        $this->apiConsumer = $app->make('apiconsumer');
        $this->auth = $app->make('auth');
        $this->db = $app->make('db');
        $this->request = $app->make('request');
    }

    /**
     * Attempt to create an access token using user credentials
     *
     * @param string $email
     * @param string $password
     */
    public function attemptLogin($email, $password)
    {
        $user = $this->userRepository->findWhere('email', $email)->first();

        if (!is_null($user)) {
            return $this->proxy('password', [
                'username' => $email,
                'password' => $password
            ]);
        }

        throw new InvalidCredentialsException();
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function attemptRefresh()
    {
        $refreshToken = $this->request->cookie(self::REFRESH_TOKEN);

        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied
     * @param array $data the data to send to the server
     */
    public function proxy($grantType, array $data = [])
    {
        /*
        We take whatever passed data and add the client credentials
        that we saved earlier in .env. So when we refresh we send client
        credentials plus our refresh token, and when we use the password
        grant we pass the client credentials plus user credentials.
        */
        $data = array_merge($data, [
            'client_id'     => '1',
            'client_secret' => 'jGFuvv664fHTBTdPVCVVtRub8LIYXIad2xcbdy9f',
            'grant_type'    => $grantType
        ]);

        /*
        We use Optimus\ApiConsumer to make an "internal" API request.
        More on this below.
        */
        $response = $this->apiConsumer->post('/oauth/token', $data);

        /*
        If a token was not created, for whatever reason we throw
        a InvalidCredentialsException. This will return a 401
        status code to the client so that the user can take
        appropriate action.
        */
        if (!$response->isSuccessful()) {
            throw new InvalidCredentialsException();
        }

        $data = json_decode($response->getContent());

        /*
        We save the refresh token in a HttpOnly cookie. This
        will be attached to the response in the form of a
        Set-Cookie header. Now the client will have this cookie
        saved and can use it to request new access tokens when
        the old ones expire.
        */
        $this->cookieJar->queue(
            self::REFRESH_TOKEN,
            $data->refresh_token,
            864000, // 10 days
            null,
            null,
            false,
            true // HttpOnly
        );

        return [
            'access_token' => $data->access_token,
            'expires_in' => $data->expires_in
        ];
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout()
    {
        $accessToken = $this->auth->user()->token();

        $refreshToken = $this->db
            ->table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));
    }

}
