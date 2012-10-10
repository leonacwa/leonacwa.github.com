---
layout: post
title: Github博客，jekyll的一些笔记
category : git 
tags : [git, jekyll]
---

特殊字符
category tags  不能有中文和特殊的%字符
post的title可以有  % ' + - & $ ! ，但是 \[ \{ 不确定
tags category 名字不能太长???
tags不能太多???
post内容不能出现jekyll的liquid的关键字，如\{\{ \{%，要用空格隔开

默认是根目录。

#### _config.yml  
在这里配置站点，可以用site.setting_name获取配置的值  

#### 目录 category显示格式
<pre name=code class=jekyll>
{ % for category in site.categories % } // 遍历目录
	{ { category | first } } ({ { category | last | size } })  // 目录使用方法
</pre>

c++代码测试
<pre name=code class=cpp>
#include <iostream>
using namespaces std;

int main() {
	cout << "Helle World!" << endl;
	return 0;
}

</pre>

