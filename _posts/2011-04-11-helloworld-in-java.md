---
layout: post
title: 用Java写个HelloWorld
category: programing
tags: [helloworld, java]
---

前提：
安装JDK。我用的是1.6，建议去官网下。
给环境变量Path添加JDK的bin目录。
如果主要的class（最外边的class）添加public，则必须让class的名字和文件名一样，包括大小写。
main函数格式：public static void main(String args[])
java运行class文件时，不能加class后缀，如果class文件在当前目录，则 java  class文件名；
如果不在，则 java -classpath class文件目录 class文件名。

附加一个HelloWorld.java
<pre>
// 文件名字必须为 HelloWorld.java
public class HelloWorld {
    public static void main(String args[]) // 这个main函数也先不要乱改
   {
        System.out.println("Hello World!");
    }
}
</pre>
大概就是这样：
编译
javac java源文件
之后生成了一个class文件。
然后运行
如果class文件在当前目录
java class文件名  (Tips:class文件名不包括后缀class)
如果不在当前目录，
java  -classpath  class文件目录  class文件名
class文件名不包括后缀class。

我发现Java写个HelloWorld很麻烦的。
