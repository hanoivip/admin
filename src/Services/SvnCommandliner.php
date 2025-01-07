<?php

namespace Hanoivip\Admin\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SvnCommandliner implements ISvn
{
    /**
     * Test binary /usr/bin/svn
     */
    private function test() {
        $cmd = "sudo /usr/bin/svn help";
        $out = [];
        $ret = 0;
        exec($cmd, $out, $ret);
        //Log::error("Test svn command: " . print_r($out, true));
        //Log::error("Test svn command: " . $ret);
        return empty($ret) && !empty($out);
    }
    
    public function update($url, $dir, $username, $password)
    {
        if (!$this->test()) {
            return __("hanoivip.admin::gameops.svn.command-not-found");
        }
        $cmd = "sudo /usr/bin/svn update --username $username --password $password $dir";
        $out = [];
        $ret = 0;
        exec($cmd, $out, $ret);
        //Log::error("Update svn command: " . print_r($out, true));
        //Log::error("Update svn command: " . $cmd);
        //Log::error("Update svn command: " . $ret);
        return empty($ret);
    }

    public function list($dir, $username, $password)
    {
        if (!$this->test()) {
            return __("hanoivip.admin::gameops.svn.command-not-found");
        }
        $cmd = "sudo /usr/bin/svn --recursive list --username $username --password $password $dir";
        $out = [];
        $ret = 0;
        $files = [];
        exec($cmd, $out, $ret);
        //Log::error("List svn command: " . print_r($out, true));
        //Log::error("List svn command: " . $cmd);
        //Log::error("List svn command: " . $ret);
        if (empty($ret) && !empty($out)) {
            foreach ($out as $path) {
                $p = "$dir/$path";
                if (File::exists($p) && File::isFile($p)) {
                    $files[] = $p;
                }
            }
        }
        return $files;
    }

    public function checkout($url, $dir, $username, $password)
    {
        if (!$this->test()) {
            return __("hanoivip.admin::gameops.svn.command-not-found");
        }
        $cmd = "sudo /usr/bin/svn checkout $url --username $username --password $password $dir";
        $out = [];
        $ret = 0;
        exec($cmd, $out, $ret);
        return empty($ret);
    }
}