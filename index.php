<?php
/**
 * Created by PhpStorm.
 * User: zhao
 * Date: 17/3/30
 * Time: 17:41
 */
// 模板引擎原理
//实现一个简单的模板引擎骨架
// 1.1 基础类骨架

//require "Template.php";
//$temp = new Template(array('test'=>true));
//var_dump($temp->getConfig("test"));
//var_dump($temp->getConfig());

// 1.2 添加变量注入和展示功能
/*
 * 在模板类中添加类变量 用来容纳注入的所有代码。
 *         添加注入方法 用来向类变量中注入代码
 */
// 2 引入编译类对模板进行编译
//3.测试
/*
 * template下新建了member.m模板文件 然后调用
*/
//require "Template.php";
//$temp = new Template();
//$temp->assign("data", "123");
//$temp->assign('a', array(1,2,3));
//$temp->show("member");
/*
 * 模板引擎要做的事情就是把逻辑层和表现层代码分离
 * 作为一个工具类 应该满足一些基本要求 其中之一就是可配置
 * 3 确定模板引擎到底需要一些什么功能
 */

// HTML中代码不能被PHP引擎认识 只有翻译成PHP代码才能被执行。
//3.模板引擎的编译
/*
 * 模板引擎的编译是一个 翻译的过程 把HTML文件转换成PHP文件。因为模板文件中有一些变量{$data} 简单的逻辑 (if() {} else)来自逻辑层,
 * 最终需要展示在浏览器中 因此就需要将这些值注入模板中,并最终转换成可以执行的PHP代码。
 */
/*3.1 实现变量标签
 * {$data} => <?php echo $data;?>
 */
