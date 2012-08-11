---
layout: post
title: 在windowns下像EXE和BAT一样运行python脚本
category : life 
tags : [time]
---
我是在这个博客看到的，[来源](http://star23.yo2.cn/articles/%E5%9C%A8windowns%E4%B8%8B%E5%83%8Fexe%E5%92%8Cbat%E4%B8%80%E6%A0%B7%E8%BF%90%E8%A1%8Cpython%E8%84%9A%E6%9C%AC.html)  

在windowns下像EXE和BAT一样运行python脚本  
只要修改两个环境变量就行了  
1. PATH，把C:\python25\scripts加上（假设你的python2.5安装在c盘）  
2.PATHEXT，添加扩展名.PY;.PYW  
然后你就可随便执行你的python脚本了，就像EXE或BAT一样  

当然，也可以用这种方式添加快捷方式的运行，比如我在运行里运行cygwin，就把.lnk加到PATHEXT中，把一个cygwin.lnk复制到windows目录即可。

