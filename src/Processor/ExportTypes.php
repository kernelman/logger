<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/26
 * Time: 10:35 PM
 */

namespace Logs\Processor;


use Common\JsonFormat;
use Common\Property;
use Exceptions\UnFormattedException;

/**
 * 导出数据类型
 *
 * Class ExportTypes
 * @package Processor
 */
class ExportTypes {

    private const EXPORT_CLASS      = 'class';
    private const EXPORT_FUNCTION   = 'function';

    /**
     * @param $models
     * @param $level
     * @return false|string
     * @throws UnFormattedException
     * @throws \Exceptions\InvalidArgumentException
     */
    public function json($models, $level) {
        $makes = $this->make($models, $level);
        return JsonFormat::toJson($makes);
    }

    /**
     * @param $models
     * @param string $level
     * @return bool|string
     * @throws \Exceptions\InvalidArgumentException
     */
    public function text($models, $level = 'debug') {
        $makes = $this->make($models, $level);
        if ($makes) {
            return $this->build($makes, $level);
        }

        return false;
    }

    /**
     * @param $models
     * @return array
     * @throws \Exceptions\InvalidArgumentException
     */
    private function makeDebug($models) {
        $makes  = [];
        $info   = \debug_backtrace();

        foreach ($info as $key => $value) {
            $class      = $value[self::EXPORT_CLASS]    ?? false;
            $type       = $value['type']                ?? false;
            $function   = $value[self::EXPORT_FUNCTION] ?? false;

            if ($class && $type && $function) {
                $models->methond = $class . $type . $function . '()';
            }

            $models->file   = $value['file'] ?? '';
            $models->line   = $value['line'] ?? '';
            $properties     = Property::filterNullProperty($models);

            foreach ($properties as $property) {
                $makes[$key][$property] = $models->{$property};
            }
        }

        return $makes;
    }

    /**
     * @param $models
     * @return array
     * @throws \Exceptions\InvalidArgumentException
     */
    private function makeInfo($models) {
        $makes  = [];

        if (is_array($models->content) || is_object($models->content)) {
            $info = var_export($models->content, true);

        } else {
            $info = $models->content;
        }

        $models->content = $info;
        $properties = Property::filterNullProperty($models);

        foreach ($properties as $property) {
            $makes[$property] = $models->{$property};
        }

        return $makes;
    }

    /**
     * @param $models
     * @param string $debug
     * @return array|bool
     * @throws \Exceptions\InvalidArgumentException
     */
    private function make($models, $debug = 'debug') {
        if (!is_object($models)) {
            return false;
        }

        switch ($debug) {

            case 'info':
                $makes = $this->makeInfo($models);
                break;

            case 'error':
                $makes = $this->makeDebug($models);
                break;

            default:
                $makes = $this->makeDebug($models);
                break;
        }

        return $makes;
    }

    /**
     * @param $makes
     * @param $level
     * @return string
     */
    private function build($makes, $level) {
        $build = '';

        if (isset($makes['content']) && ($level == 'info')) {

            $content = '';
            foreach ($makes as $type => $value) {
                $content .= $this->export($type, $value);
            }
            $build .= $content . PHP_EOL;

        } else {

            foreach ($makes as $make) {

                $content = '';
                foreach ($make as $type => $value) {
                    $content .= $this->export($type, $value);
                }

                $build .= $content . PHP_EOL;
            }
        }

        return $build;
    }

    /**
     * @param $type
     * @param $value
     * @return bool|string
     */
    private function export($type, $value) {
        if ($type != self::EXPORT_CLASS || $type != 'type' || $type != self::EXPORT_FUNCTION || $type != 'line') {
            return '[' . $type . ': ' . $value . ']';
        }

        return false;
    }
}
