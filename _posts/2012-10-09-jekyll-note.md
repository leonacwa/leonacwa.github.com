---
layout: post
title: Github博客，jekyll的一些笔记
category : git 
tags : [time]
---

默认是根目录。

#### _config.yml  
在这里配置站点，可以用site.setting_name获取配置的值  

#### 目录 category显示格式
<pre name=code class=jekyll>
{ % for category in site.categories % } // 遍历目录
	{ { category | first } } ({ { category | last | size } })  // 目录使用方法
</pre>

