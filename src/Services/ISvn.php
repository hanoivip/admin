<?php

namespace Hanoivip\Admin\Services;

interface ISvn {
    /**
     * 
     * @param string $url
     * @param string $dir
     * @param string $username
     * @param string $password
     * @return bool|string True if success, otherwise error string
     */
    public function checkout($url, $dir, $username, $password);
    /**
     *
     * @param string $url
     * @param string $dir
     * @param string $username
     * @param string $password
     * @return bool|string True if success, otherwise error string
     */
    public function update($url, $dir, $username, $password);
    /**
     * 
     * @param string $dir
     * @param string $username
     * @param string $password
     * @return array Array of file
     */
    public function list($dir, $username, $password);
}