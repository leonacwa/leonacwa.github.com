---
layout: post
title: poj 2983 Is the Information Reliable? (差分约束)
category: acm-icpc
tags: [acm-icpc, poj]
---

<pre>/*
 poj 2983 Is the Information Reliable?
 题意：给出某两个防卫站点间的具体距离，还有一些两个防卫站点的模糊距离，但是距离&gt;=1.
 求是否存在这样的防卫站点方案，也就是情报描述是否可靠。
 
 差分约束。
 
 今天做到这题的时候，我才发现自己没有掌握差分约束！！！
 
 对于查分约束题，可以根据题目给出的条件，将个顶点之间的关系统一化成&lt;=或者&gt;=的形式。
 如果顶点关系是&lt;=那么求的就是最短路；如果顶点关系是&gt;=的形式求的就是最长路。
 这个应该容易，因为要使得所有等式满足&lt;=，那么只能找到最小的值，也就是最短路。
 &gt;=则反之。
 
 好吧，希望下次遇到此类题目的时候能够做出来！o(╯□╰)o
 
 
 参考了http://allenlsy.com/2010/07/10/poj-2983/的的代码，直接用边进行Bellman Ford 省事。
 我原来还想用SPFA来着，但是SPFA写得麻烦，既然都知道边了，就不用SPFA了。
 2983	Accepted	2492K	516MS	C++	1800B	2011-05-02 17:51:15
 
代码：
*/</pre>
<!--more-->
<pre>
#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int INT_MAX = (unsigned)(1&lt;&lt;20) - 1;
const int maxm = 100000;
const int maxn = 1024;

struct Edge{
    int u, v, w;
}e[maxm*3+1024];
int d[maxn];
int es, n, m;


bool bellman_ford()
{
    for (int i = 0; i &lt;= n; i++)
        d[i] = INT_MAX;
    d[1] = 0;
    
    bool refresh = true;
    int u, v, w;
    for (int i = 0; i &lt; n &amp;&amp; refresh; i++){
        refresh = false;
        for (int j = 0; j &lt; es; j++){
            u = e[j].u;
            v = e[j].v;
            w = e[j].w;
            if (d[v] &gt; d[u] + w){
                d[v] = d[u] + w;
                refresh = true;
            }
        }
    }
    for (int j = 0; j &lt; es; j++){
        int u = e[j].u, v = e[j].v, w = e[j].w;
        if (d[v] &gt; d[u] + w)
            return false;
    }
    return true;
}
int main()
{
    char ch;
    int u, v, w;
    while (2 == scanf("%d %dn", &amp;n, &amp;m)){
        es = 0;
        for (int i = 0; i &lt; m; i++){
            scanf("%c", &amp;ch);
            if (ch == 'P'){
                scanf("%d %d %dn", &amp;u, &amp;v, &amp;w);
                e[es].u = u;
                e[es].v = v;
                e[es].w = -w;
                es++;
                e[es].u = v;
                e[es].v = u;
                e[es].w = w;
                es++;
            }
            else {
                scanf("%d %dn", &amp;u, &amp;v);
                e[es].u = u;
                e[es].v = v;
                e[es].w = -1;
                es++;
            }
        }
        
        if (bellman_ford())
            printf("Reliablen");
        else
            printf("Unreliablen");
    }
    return 0;
}</pre>
