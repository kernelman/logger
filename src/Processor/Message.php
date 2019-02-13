<?php
/**
 * Created by IntelliJ IDEA.
 * User: Kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/17
 * Time: 1:53 PM
 */

namespace Processor;

use Exceptions\InvalidArgumentException;

/**
 * 消息处理器
 *
 * Class MessageHandler
 */
class Message {

    const OK                    = 'Request success: ';
    const NG                    = 'Request failed: ';
    const ERR_JSON_DE           = 'Decode JSON data format error: ';
    const ERR_JSON_EN           = 'Encode JSON data format error: ';
    const ERR_NOT_FOUND         = 'Not Found: ';
    const ERR_INVALID_ARGUMENT  = 'InvalidArgument: ';
    const ERR_UNEXPECTED        = 'Unexpected: ';
    const ERR_UNSELECTED        = 'UnSelected: ';
    const ERR_UNCONNECTED       = 'Unconnected: ';
    const ERR_UN_READABLE       = 'UnReadable: ';
    const ERR_UN_WRITABLE       = 'UnWritable: ';
    const ERR_UN_EXECUTABLE     = 'UnExecutable: ';
    const ERR_UNSAVED           = 'UnSaved: ';
    const ERR_ALREADY_EXISTS    = 'AlreadyExists: ';
    const ERR_NONEMPTY          = 'NonEmpty: ';
    const STATUS_CODE           = 'status code: ';
    const LOG_INFO              = 'info';
    const LOG_DEBUG             = 'debug';
    const LOG_ERROR             = 'error';

    /**
     * 处理消息
     *
     * @param null $message
     * @return null
     * @throws InvalidArgumentException
     */
    static public function process($message = null) {

        if ($message === null) {
            throw new InvalidArgumentException('Message required');
        }

        return $message;
    }
}
