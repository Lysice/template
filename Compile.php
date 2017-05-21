<?php

class Compile {
    private $template; //待编译文件
    private $content;  //需要替换的文本
    private $compileFile;//编译后的文件

    private $left = "{"; //左定界符
    private $right = "}";//右定界符
    private $value = array(); //值栈
    // 分别代表匹配规则和替换规则
    private $T_P = array();
    private $T_R = array();


    public function __construct()
    {
        // $data foreach if/
        $this->T_P[] = "#\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z_\x7f-\xff]*)\}#";
        $this->T_P[] = "#\{(foreach|loop) \\$([a-zA-Z_\x7f-\xff][a-zA-Z_0-9\x7f-\xff]*)\}#";
        $this->T_P[] = "#{([K|V])}#";
        $this->T_P[] = "#\{\/(foreach|loop|if)\}#";

        $this->T_P[] = "#\{if (.*?)\}#";
        $this->T_P[] = "#\{elseif (.*?)\}#";
        $this->T_P[] = "#\{else(\s?)\}#";

        $this->T_R[] = "<?php echo \$this->value['\\1']?>";
        $this->T_R[] = "<?php foreach((array)\$\\2 as \$K => \$V) {?>";
        $this->T_R[] = "<?php echo \$this->value['\\1']?>";
        $this->T_R[] = "<?php }?>";
        $this->T_R[] = "<?php if(\\1) {?>";
        $this->T_R[] = "<?php }elseif(\\1){?>";
        $this->T_R[] = "<?php }else{?>";
    }

    //该编译方法是一个临时方法 只是起到一个将文件复制作为已编译文件的作用。具体实现需要到下一步
    public function compile($source, $destFile) {
        $this->content = file_get_contents($source);
        $this->content = preg_replace($this->T_P, $this->T_R, $this->content);
        file_put_contents($destFile, $this->content);
    }

}