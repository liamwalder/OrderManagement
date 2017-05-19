<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Exceptions\InvalidCredentialsException;
use App\Http\Repositories\AddressRepository;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Services\AddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api
 */
class LoginController extends Controller
{

    /**
     * @var LoginProxy
     */
    private $loginProxy;

    /**
     * LoginController constructor.
     * @param LoginProxy $loginProxy
     */
    public function __construct(LoginProxy $loginProxy)
    {
        $this->loginProxy = $loginProxy;
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     * @throws InvalidCredentialsException
     */
    public function login(LoginRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        return response($this->loginProxy->attemptLogin($email, $password))->;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function refresh(Request $request)
    {
        return $this->response($this->loginProxy->attemptRefresh());
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        $this->loginProxy->logout();

        return $this->response(null, 204);
    }

}
