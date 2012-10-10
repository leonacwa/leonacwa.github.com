---
layout: post
title: Ubuntu下7z工具简单使用
category : linux
tags : [7z]
---

我用的是Ubuntu10.10，系统自带的压缩包管理工具不好用，支持格式少，对中文支持很差，所以找了一个好工具7z，唯一缺点是只支持命令行调用。  
7z解压缩命令，更多命令请看 7z --help  
命令格式：  
7z &lt;command&gt; [&lt;switches&gt;...] &lt;archive_name&gt; [&lt;file_names&gt;...]  

常用命令：  
7z x -o{Directory}  &lt;archive_name&gt;  :解压&lt;archive_name&gt;到{Directory}中，并且保持解压缩后的目录结构，如果不指定-o{Directory}，输出到当前目录.注意-o{Directory}中的-o必须于目录名紧贴。  

7z a -o{Directory} &lt;archive_name&gt;  &lt;fiile_names&gt;... :创建压缩包&lt;archive_name&gt; , 添加文件&lt;file_names&gt;, -o{Directory},输出到{Directory}，未指定{Directory}，输出到当前目录。  

7z l  &lt;archive_name&gt; :列出&lt;archive_name&gt;中的文件。  
