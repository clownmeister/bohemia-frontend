<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

abstract class AbstractException extends Exception
{
    protected const HTTP_OK = 200;
    protected const HTTP_PERMANENT_REDIRECT = 301;
    protected const HTTP_TEMPORARY_REDIRECT = 302;
    protected const HTTP_BAD_REQUEST = 400;
    protected const HTTP_NOT_FOUND = 404;
    protected const HTTP_INTERNAL_SERVER_ERROR = 500;
}
