---
layout: post
title: poj 1716 Integer Intervals (差分约束)
category : acmicpc
tags : [acmicpc, poj]
---

<pre>/*  
  poj 1716 Integer Intervals  
  题意：给出区间[a,b] (a&lt;b), 要求a，b之间至少存在2个不同的数字的。  
  要你输出这一集合的个数最少。  
  
  第一感觉：跟poj1201很像啊，改一下试试.  

  1716	Accepted	560K	63MS	C++	1979B	2011-05-01 12:11:13  
  
  此题是1201的弱数据版~  
  代码：  
*/</pre>  
<!--more-->  
<pre>  
#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  

const int INT_MAX = (unsigned)(1&lt;&lt;31) - 1;  
const int maxn = 10000+8;  

struct Edge{  
    int v, w, next;  
};  
Edge e[maxn*3];  
int n, es, st, en, vv[maxn];  
int q[maxn], head, tail, dis[maxn];  
bool used[maxn];  

int spfa()  
{  
    int u, v, w, total;  
    total = en - st + 1;  
    for (int i = st; i &lt;= en; i++)  
        dis[i] = -INT_MAX;  
    memset(used, false, sizeof(used));  
    dis[st] = 0;  
    used[st] = true;  
    q[0] = st;  
    head = 0;  
    tail = 1;  
    while (head != tail){  
        u = q[head++];  
        used[u] = false;  
        if (head &gt;= total)  
            head %= total;  
        for (int i = vv[u]; i != -1; i = e[i].next){  
            v = e[i].v;  
            w = e[i].w;  
            if (dis[v] &lt; dis[u] + w){  
                dis[v] = dis[u] + w;  
                if (!used[v]){  
                    used[v] = true;  
                    q[tail++] = v;  
                    if (tail &gt;= total)  
                        tail %= total;  
                }  
            }  
        }  
    }  
    return dis[en];  
}  
int main()  
{  
    int u, v;  
    scanf("%d", &amp;n);// printf("%dn", n);  
    es = 0;  
    st = INT_MAX;  
    en = -INT_MAX;  
    memset(vv, -1, sizeof(vv));  
    for (int i = 0; i &lt; n; i++){  
        scanf("%d %d", &amp;u, &amp;v);//printf("%d, %dn", u, v);  
        st = st&lt;u?st:u;  
        en = en&gt;1+v?en:1+v;  
        e[es].v = v+1;  
        e[es].w = 2; /// 题目的间隔是2个不同的，TMD的又是英语不好造成的  
        e[es].next = vv[u];  
        vv[u] = es;  
        es++;  
    }//printf("%d -&gt; %dn", st, en);  
    for (int i = st; i &lt; en; i++){  
        e[es].v = i+1;  
        e[es].w = 0;  
        e[es].next = vv[i];  
        vv[i] = es;  
        es++;  
        e[es].v = i;  
        e[es].w = -1;  
        e[es].next = vv[i+1];  
        vv[i+1] = es;  
        es++;  
    }  
    spfa();  
    printf("%dn", dis[en]);  
    return 0;  
}</pre>  
