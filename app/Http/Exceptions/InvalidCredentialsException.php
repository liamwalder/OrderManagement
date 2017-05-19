<?php
namespace App\Http\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class InvalidCredentialsException
 * @package App\Http\Exceptions
 */
class InvalidCredentialsException extends UnauthorizedHttpException
{
    /**
     * InvalidCredentialsException constructor.
     * @param null $message
     * @param \Exception|null $previous
     * @param int $code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct('', $message, $previous, $code);
    }
}