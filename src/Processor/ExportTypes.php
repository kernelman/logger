<?php
/**
 * Created by IntelliJ IDEA.
 * User: kernel Huang
 * Email: kernelman79@gmail.com
 * Date: 2018/11/26
 * Time: 10:35 PM
 */

namespace Processor;


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
     * @return false|string
     * @throws UnFormattedException
     */
    public function json($models) {
        $makes = $this->make($models);
        return Formatted::toJson($makes);
    }

    /**
     * @param $models
     * @param string $level
     * @return bool|string
     */
    public function text($models, $level = 'debug') {
        $makes = $this->make($models, $level);
        if ($makes) {
            return $this->build($makes);
        }

        return false;
    }

    /**
     * @param $models
     * @return array
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

            $models->file = $value['file'] ?? '';
            $models->line = $value['line'] ?? '';

            $getVars    = get_object_vars($models);
            $properties = array_keys(array_filter($getVars));

            foreach ($properties as $property) {
                $makes[$key][$property] = $models->{$property};
            }
        }

        return $makes;
    }

    /**
     * @param $models
     * @return array
     */
    private function makeInfo($models) {
        $makes  = [];
        $info   = $models->content;

        if (is_object($info)) {

            foreach ($info as $key => $value) {
                $models->content = '{'  . $key . ':' . $value . '}';

                $getVars    = get_object_vars($models);
                $properties = array_keys(array_filter($getVars));

                foreach ($properties as $property) {
                    $makes[$key][$property] = $models->{$property};
                }
            }
        }

        if (is_string($info)) {
            $models->content = $info;

            $getVars    = get_object_vars($models);
            $properties = array_keys(array_filter($getVars));

            foreach ($properties as $property) {
                $makes[$property] = $models->{$property};
            }
        }

        return $makes;
    }

    /**
     * @param $models
     * @param string $debug
     * @return array|bool
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
     * @return string
     */
    private function build($makes) {
        $build = '';

        foreach ($makes as $make) {

            $content = '';
            foreach ($make as $type => $value) {
                $content .= $this->export($type, $value) ?: $this->export($type, $value);
            }

            $build .= $content . PHP_EOL;
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
