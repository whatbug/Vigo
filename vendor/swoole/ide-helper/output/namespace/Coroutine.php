<?php

namespace Swoole;

class Coroutine
{

    /**
     * @return mixed
     */
    public static function create(callable $func, ... $params)
    {
    }

    /**
     * @return mixed
     */
    public static function exec($command, $get_error_stream = null)
    {
    }

    /**
     * @return mixed
     */
    public static function gethostbyname($domain_name, $family = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public static function defer($callback)
    {
    }

    /**
     * @return mixed
     */
    public static function set($options)
    {
    }

    /**
     * @return mixed
     */
    public static function exists($cid)
    {
    }

    /**
     * @return mixed
     */
    public static function yield()
    {
    }

    /**
     * @return mixed
     */
    public static function suspend()
    {
    }

    /**
     * @return mixed
     */
    public static function resume($cid)
    {
    }

    /**
     * @return mixed
     */
    public static function stats()
    {
    }

    /**
     * @return mixed
     */
    public static function getCid()
    {
    }

    /**
     * @return mixed
     */
    public static function getuid()
    {
    }

    /**
     * @return mixed
     */
    public static function getPcid()
    {
    }

    /**
     * @return mixed
     */
    public static function getContext($cid = null)
    {
    }

    /**
     * @return mixed
     */
    public static function sleep($seconds)
    {
    }

    /**
     * @return mixed
     */
    public static function fread($handle, $length = null)
    {
    }

    /**
     * @return mixed
     */
    public static function fgets($handle)
    {
    }

    /**
     * @return mixed
     */
    public static function fwrite($handle, $string, $length = null)
    {
    }

    /**
     * @return mixed
     */
    public static function readFile($filename)
    {
    }

    /**
     * @return mixed
     */
    public static function writeFile($filename, $data, $flags = null)
    {
    }

    /**
     * @return mixed
     */
    public static function getaddrinfo($hostname, $family = null, $socktype = null, $protocol = null, $service = null)
    {
    }

    /**
     * @return mixed
     */
    public static function statvfs($path)
    {
    }

    /**
     * @return mixed
     */
    public static function getBackTrace($cid = null, $options = null, $limit = null)
    {
    }

    /**
     * @return mixed
     */
    public static function list()
    {
    }

    /**
     * @return mixed
     */
    public static function listCoroutines()
    {
    }


}
