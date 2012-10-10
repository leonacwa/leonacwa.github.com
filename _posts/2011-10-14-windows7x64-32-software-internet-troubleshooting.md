---
layout: post
title: Windows 7 x64 出现32位软件无法上网的故障解决
category : tips
tags : [64, windows7, tips]
---

64位WIN7无故出现32位IE、及其它网络相关软件都无法上网的问题(但64位IE可以正常上网，说明网络或硬件是没有问题的).  

解决办法：  

以管理员身份运行命令行，在弹出的窗口中运行如下命令：  

netsh winsock reset catalog  
netsh int ip reset reset.log hit  
让被阻止了的svchost.exe进程恢复正常，以解决Windows 7 通信端口初始化失败的问题。  

假如无法使用该命令，请重启到安全模式运行。  

或者使用runas命令，如果无法使用administrator用户，在安全模式下使用net user administrator /active。  

其实到了安全模式就不用启用administrator了。。。  
