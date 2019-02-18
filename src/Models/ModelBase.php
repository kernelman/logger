<?php
/**
 * Class ModelBase
 *
 * Author:  Kernel Huang
 * Mail:    kernelman79@gmail.com
 * Date:    11/29/18
 * Time:    9:49 PM
 */

namespace Logs\Models;

use Logs\Adapter\ModelAdapter;
use Common\ClientIp;
use Services\Config;

/**
 * 日志系统抽象基础模型
 *
 * Class LogSystem
 * @package Models
 */
abstract class ModelBase implements ModelAdapter {

    protected $env      = '';   // 日志系统环境，pro为生产环境, dev为开发环境
    public $timestamp   = '';   // 生成记录时间
    public $statusCode  = '';   // api状态码
    public $level       = '';   // 日志报错等级
    public $schema      = '';   // 项目名/业务系统名, 必须有
    public $module      = '';   // 模块, 必须有
    public $url         = '';   // 接口url地址
    public $size        = '';   // 数据量大小
    public $message     = '';   // api提示消息
    public $user        = '';   // 用户账号
    public $runtime     = '';   // 运行时间
    public $client      = '';   // pc/wap/app 获取客户端类型
    public $ip          = '';   // 客户端ip地址
    public $class       = '';   // 正在执行的类
    public $function    = '';   // 函数
    public $type        = '';   // 方法类型 // 动态/静态方法
    public $method      = '';   // 方法
    public $file        = '';   // 文件路径
    public $line        = '';   // 行数
    public $content     = '';   // 记录内容

    /**
     * ModelBase constructor.
     *
     * @param $logProperty
     * @param $level
     * @param string $env
     */
    public function __construct($logProperty, $level, $env = 'pro') {
        $this->env          = $env;
        $this->level        = $level;
        $this->url          = $this->addProperty($logProperty, 'url')           ?: $this->url;
        $this->user         = $this->addProperty($logProperty, 'user')          ?: $this->user;
        $this->size         = $this->addProperty($logProperty, 'size')          ?: $this->size;
        $this->client       = $this->addProperty($logProperty, 'client')        ?: $this->client;
        $this->schema       = $this->addProperty($logProperty, 'schema')        ?: $this->schema;
        $this->module       = $this->addProperty($logProperty, 'module')        ?: $this->module;
        $this->runtime      = $this->addProperty($logProperty, 'runtime')       ?: $this->runtime;
        $this->content      = $this->addProperty($logProperty, 'content')       ?: $this->content;
        $this->message      = $this->addProperty($logProperty, 'message')       ?: $this->message;
        $this->statusCode   = $this->addProperty($logProperty, 'statusCode')    ?: $this->statusCode;

        $this->setTime();
        $this->setUser();
        $this->setIp();
        $this->setStatusCode();
    }

    /**
     * 设置日志记录时间
     */
    public function setTime() {
        $this->timestamp = date('Y-m-d H:i:s', time());
    }

    /**
     * 设置用户
     */
    public function setUser() {
        if ($this->user == '') {
            $this->user = $_SERVER['USER'];
        }
    }

    /**
     * 设置用户IP
     */
    public function setIp() {
        if ($this->ip == '') {
            $this->ip = ClientIp::get();
        }
    }

    /**
     * 设置状态码
     */
    public function setStatusCode() {
        if ($this->statusCode == '') {
            $this->statusCode = Config::statusCode()::get($this->level);
        }
    }

    /**
     * 判断日志模型属性是否存在, 如设置就添加到日志模型
     *
     * @param $object
     * @param $property
     * @return bool
     */
    private function addProperty($object, $property) {
        if (property_exists($object, $property)) {
            return $object->{$property};
        }

        return false;
    }
}
