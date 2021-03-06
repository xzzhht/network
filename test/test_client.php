<?php
/**
 * @link https://github.com/yxdj
 * @copyright Copyright (c) 2014 xuyuan All rights reserved.
 * @author xuyuan <1184411413@qq.com>
 */


//composer autoload
require(dirname(dirname(dirname(__DIR__))).'/autoload.php'); 


use yxdj\network\Api;
use yxdj\network\Cli;


$args = Cli::parseArgs($argv, $argc);

/*
if (empty($args['s'])) {
    exit('please input `-s`.');
}

$uploadfile = $args['s'];
*/

if ($argc < 2 || empty($argv[1])) {
    exit('Error: please input upload file');
}

$uploadfile = $uploadfile_o = $argv[1];

/*
$uploadfile = Cli::ask('please input path for upload file:');
//print_r($args);exit;

$uploadfile = './' .$uploadfile; 
*/
if (!is_file($uploadfile)) {
    $uploadfile = './' .$uploadfile; 
    if (!is_file($uploadfile)) {
        exit("not find this file: ".$uploadfile_o);
    }
}

$filename = basename($uploadfile);

echo Api::getStream()->request([
    'method' => 'POST',
    //'url' => 'http://localhost/index.php',
    //'url' => 'http://192.168.1.59:37/test_server.php',
    //'url' => 'http://ys.com:90/test_server.php',
    'url' => 'http://192.168.1.59:37/test_server.php',
    'row' => ['Xuyuan' => 'test'],
    'get' => ['get1'=>'param2', 'get2'=>['a'=>'param2a','b'=>'param2b']],
    'post' => ['post1'=>'param2', 'post2'=>['a'=>'param2a','b'=>'param2b']],
    'cookie' => ['cookie1'=>'param2', 'cookie2'=>['a'=>'param2a','b'=>'param2b']],
    'file' => [
        //'file1' => ['name'=>'xxx.txt','value'=>file_get_contents('C:\Users\Administrator\Desktop\index.php')],
        'file1' => ['name'=>$filename,'value'=>file_get_contents($uploadfile)],
        //'file2[a]' => ['name'=>'aaa.xxx','value'=>'xxxxxx'],
        //'file2[b]' => ['name'=>'bbb.yyy','value'=>'yyyyyy'],
    ],
])->getContent();

