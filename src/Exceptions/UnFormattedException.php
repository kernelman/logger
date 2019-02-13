<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/24
 * Time: 2:34 PM
 */

namespace Exceptions;


use Exception;
use Processor\Message;
use Throwable;

class UnFormattedException extends Exception {
    public function __construct(string $message = null, int $code = null, Throwable $previous = null) {
        parent::__construct(Message::ERR_JSON_EN . $message, $code, $previous);
    }
}