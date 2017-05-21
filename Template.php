<?php

class Template {
    private $config = array(
        "templateDir" => "template/", // 模板文件目录
        "compileDir" => "compile/", // 编译文件目录
        "configDir" => "config/",   //配置文件目录
        "cacheDir" => "cache/",     //缓存文件目录

        "suffix" => ".m",           //后缀
        "cache_html" => false,      // 是否缓存文件
        "cache_suffix" => ".html",  // 缓存文件后缀
        "cache_time" => 7200        // 多久更新一次
    );

    private $value = array(); // 容纳需要注入变量的数组
    private $compileTool = null;

    public $file; //模板文件 不带路径

    public function __construct($config = array())
    {
        $this->config = array_merge($config, $this->config);
        include_once "Compile.php";
        $this->compileTool = new Compile();
    }

    //单例模式获取模板实例
    static private $instance = null;
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Template();
        }
        return self::$instance;
    }

    //设置选项
    public function setConfig($key, $value = null) {
        if (!is_array($key)) {
            $this->config = array_merge($this->config, $key);
        } else {
            if (in_array($key, $this->config)) {
                $this->config[$key] = $value;
            }
        }
    }

    //输出配置
    public function getConfig($key = null) {
        if (isset($key)) {
            return $this->config[$key];
        } else return $this->config;
    }

    // 单个注入
    public function assign($key, $value) {
        $this->value[$key] = $value;
    }

    //多个注入
    public function assignArray($array) {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $value[$key] = $value;
            }
        }
    }

    public function path() {
        return $this->config['templateDir'] . $this->file . $this->config['suffix'];
    }

    // 展示模板method
    public function show($file) {
        //1.检查是否存在模板文件 如果不存在则退出 如果存在转到下一步
        //2.检查对应模板文件是否被编译 如果没有编译 引入编译工具类 进行编译 如果编译了 转到3
        //3.读取编译后的文件。
        $this->file = $file;
        if (!is_file($this->path())) {
            exit("找不到对应的模板");
        }

        $compileFile = $this->config['compileDir'] . md5($file) . '.php';
//        var_dump($compileFile);
//        var_dump($this->path());
        //如果没有编译 先编译 然后读取 编译的文件直接读取。
        if (!is_file($compileFile)) {
            if (!is_dir($this->config['compileDir'])) {
                mkdir($this->config['compileDir']);
            }
            $this->compileTool->compile($this->path(), $compileFile);

            include_once $compileFile;
        } else {
            include_once $compileFile;
        }
    }

}