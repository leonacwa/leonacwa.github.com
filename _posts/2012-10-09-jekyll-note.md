---
layout: post
title: Github博客，jekyll的一些笔记
category : git 
tags : [git, jekyll]
---

特殊字符  
category tags  不能有中文和特殊的%字符  
post的title可以有  % ' + - & $ ! ，但是 \[ \{ 不确定  
tags category 名字不能太长（被其他因素干扰，没法确定）  
tags不能太多（被其他因素干扰，没法确定）  
post内容不能出现jekyll的liquid的关键字，如\{\{ \{ %，要用空格隔开  
"\{ %" 会用于解释，所以无法去忽略中间的空格  
如果代码中需要\{\{，记得用\\来转义  
Markdown 支持以下这些符号前面加上反斜杠来帮助插入普通的符号：  
    \   反斜线  
	`   反引号  
	*   星号  
	_   底线  
	{}  花括号  
	[]  方括号  
	()  括弧  
	#   井字号  
	+   加号  
	-   减号  
	.   英文句点  
	!   惊叹号  
当然，也可以不加，因为在原始的md文件里没加  

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

