---
layout: post
title: 线段树 个人小结
category : acmicpc
tags : [acmicpc, data-structure]
---

<pre>线段树 小结  

线段树，每个节点记录的都是一段半开区间[s, t)（闭区间也行的），每个节点可以附加的数据时当前区间的和，查询[s, t)区间的和的时候，从根节点开始查询，并不断统计和。  
修改某个叶子节点的值的时候，从根节点开始，不断加上增加(减小)的值，之后再递归修改子节点的值，直到叶子节点。  

zkw的线段树：  
比较特殊，每个非叶子节点存储的是一个开区间()，而最后的叶子节点存储的不是开区间，而是单个元素，即元素全部存在叶子节点，而且最底层的所有叶子节点中，第一个和最后一个节点不存数据，仅仅作为开区间的标志。  
可以自己画一棵树看一下。  

每一次查询闭区间的时候，先变为开区间。  
查询 C代码：使用~,^可以将这段代码更加简化，自己查吧。  
int query(int s, int t) // 闭区间  
{  
    int ss = 0;  
    s += M - 1; t += M + 1;  
    while (!((s ^ t) == 1)) // 无公共的父亲,不是一对左右子树，即开区间  
    {  
        if ((s&amp;1) == 0) // 是左边开区间，左树  
            ss += T[s+1];  
        if ((t&amp;1) == 1) // 是右边开区间，右树  
            ss += T[t-1];  
        s &gt;&gt;= 1; t &gt;&gt;= 1;  // 父亲节点  
    }  
    return ss;  
}  

修改 C代码：使用~,^可以将这段代码更加简化，自己查吧。  
void add(int n, int val) // 添加第n个元素的值  
{  
    n += M; // n号元素在树中的位置  
    T[n] += val;  
    while (n &gt; 1)  
    {  
        n &gt;&gt;= 1;  
        T[n] = T[n+n] + T[n+n+1];  
    }  
}</pre>  
