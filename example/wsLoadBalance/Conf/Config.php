<?php

/**
 * Created by PhpStorm.
 * User: liu
 * Date: 16/8/10
 * Time: 15:00
 */
namespace Conf;

use Core\Component\Spl\SplArray;
use Core\AutoLoader;

class Config
{
    private static $instance;
    protected $conf;
    function __construct()
    {
        $conf = $this->sysConf()+$this->userConf();
        $this->conf = new SplArray($conf);
    }
    static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static();
        }
        return self::$instance;
    }
    function getConf($keyPath){
        return $this->conf->get($keyPath);
    }
    /*
            * 在server启动以后，无法动态的去添加，修改配置信息（进程数据独立）
    */
    function setConf($keyPath,$data){
        $this->conf->set($keyPath,$data);
    }

    private function sysConf(){
        return array(
            "SERVER"=>array(
                "LISTEN"=>"0.0.0.0",
                "SERVER_NAME"=>"",
                "WORKER_NAME"=>"",
                "TASK_NAME"=>"",
                "PORT"=>9501,
                "WS_SUPPORT"=>true,
                "CONFIG"=>array(
                    'task_worker_num' => 4, //异步任务进程
                    "task_max_request"=>200,
                    'max_request'=>3000,
                    'worker_num'=>4,
                    "dispatch_mode"=>5,//3为抢占模式 不对繁忙进程发送任务
//						'task_ipc_mode'=>2,
//                    "open_cpu_affinity"=>1,
//                    "daemonize"=>false,
//                    "user"=>"yf",
//                    "group"=>"root",
                    "log_file"=>ROOT.'/swoole_log.txt',
                    'pid_file'=>ROOT."/pid.pid",
//                    "upload_tmp_dir"=>ROOT."/Temp/"

                ),
            ),
            "DEBUG"=>array(
                "LOG"=>1,
                "DISPLAY_ERROR"=>0,
                "ENABLE"=>true,
            ),
        );
    }

    private function userConf(){
        return array(
            'REDIS'=>[
                'host'=>'127.0.0.1',
                'port'=>'6379',
                'password' => '',
                'timeout' => 5,
                'max_recount' =>3, //最大重连次数
                'pconnect' => false,
                'database' => 0,
            ]
        );
    }
}