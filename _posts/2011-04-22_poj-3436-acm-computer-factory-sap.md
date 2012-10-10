---
layout: post
title:  poj 3436 ACM Computer Factory (SAP)
category: acm
categories: [acm]
tags: [acm, poj, %e5%bf%83%e5%be%97, %e6%9c%80%e5%a4%a7%e6%b5%81, %e7%bd%91%e7%bb%9c%e6%b5%81, %e8%a7%a3%e9%a2%98%e6%8a%a5%e5%91%8a]
by: wp2md(php)
---

/*
   poj 3436 ACM Computer Factory
   题意：给几台机器，再给出每台机器能处理的电脑数量、输入时能接受电脑的情况和输出后电脑的情况。
   问最多能生产多少电脑，课可生产电脑的生产线的流量又是如何。
   
   典型的最大流算法，用SAP 0ms。
   
   此题成功的关键是图的建立。
   因为每个点的接受能力有限，需要拆点.
   (但是我觉得叫做克隆点更好理解，或者是创造一个点。)
   拆点v时，把点v和它的对应点n+v连接一条流为q[v]的弧，然后用别的合法点连向v，
   用n+v出去连别的合法的点，其实就是产生一条弧用于限制流量。
   
   然后就是相关节点的连接了。可以看代码中所写的判断可连接函数。
   
   代码如下：
*/
<!--more-->
<pre>
#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int INT_MAX = (unsigned)(1&lt;&lt;31) - 1;
const int maxn = 64;
const int maxp = 16;

int p, n, s, sink;
int c[maxn][maxn], f[maxn][maxn];
int in[maxn][maxp], out[maxn][maxp], q[maxn];
int que[maxn*2], d[maxn], num[maxn], pre[maxn], low[maxn];
int ans[maxn][3], total, flow;

bool canLink(int out[maxp], int in[maxp]) /// 普通节点之间的相连
{
    for (int i = 1; i &lt;= p; i++)
        if (1 == out[i]+in[i]) /// 
            return false;
    return true;
}
bool isNULL(int in[maxp]) /// 与源点相连
{
    for (int i = 1; i &lt;= p; i++)
        if (in[i] == 1)
            return false;
    return true;
}
bool isFULL(int out[maxp]) /// 与汇点相连
{
    for (int i = 1; i &lt;= p; i++)
        if (out[i] != 1)
            return false;
    return true;
}

void init_d()
{
    memset(num, 0, sizeof(num));
    int head = 0, tail = 1, u, v;
    memset(d, -1, sizeof(d));
    d[sink] = 0;
    num[0]++;
    que[0] = sink;
    while (head &lt; tail){
        v = que[head++];
        for (u = 1; u &lt;= sink; u++){
            if (d[u] == -1 &amp;&amp; c[u][v] &gt; 0){
                d[u] = d[v] + 1;
                num[d[u]]++;
                que[tail++] = u;
            }
        }
    }
}

int maxflow()
{
    init_d();
    
    int flow = 0, u, v, delta;
    memset(f, 0, sizeof(f));
    low[s] = INT_MAX;
    u = s;
    while (d[s] &lt; sink){
        for (v = 1; v &lt;= sink; v++)
            if (d[u] == d[v]+1 &amp;&amp; c[u][v]-f[u][v] &gt; 0){
                break;
            }
        if (v &lt;= sink){ /// 找到一条允许弧
            pre[v] = u;
            low[v] = c[u][v]-f[u][v]&lt;low[u]?c[u][v]-f[u][v]:low[u];
            u = v;
            if (u == sink){
                delta = low[sink];
                do{
                    f[pre[u]][u] += delta;
                    f[u][pre[u]] -= delta;
                    u = pre[u];
                } while( u != s);
                flow += delta;
            }
        }
        else{ /// 找不到增广路
            if (--num[d[u]] == 0) /// 间隙优化
                return flow;
            d[u] = sink+1;
            for (v = 1; v &lt;= sink; v++){
                if (c[u][v]-f[u][v] &gt; 0 &amp;&amp; d[u] &gt; d[v]+1){
                    d[u] = d[v]+1;
                }
            }
            if (d[u] &lt; sink)
                num[d[u]]++;
            if (u != s)
                u = pre[u];
        }
    }
    return flow;
}
int main()
{
while (2 == scanf("%d %d", &amp;p, &amp;n)){
    //scanf("%d %d", &amp;p, &amp;n);
    for (int i = 1; i &lt;= n; i++){
        scanf("%d", &amp;q[i]);
        for (int j = 1; j &lt;= p; j++){
            scanf("%d", &amp;in[i][j]);
        }
        for (int j = 1; j &lt;= p; j++){
            scanf("%d", &amp;out[i][j]);
        }
    }
    
    s = n+n+1;
    sink = n+n+2;
    
    memset(c, 0, sizeof(c));
    
    for (int i = 1; i &lt;= n; i++){
        c[i][n+i] = q[i];
        if (isNULL(in[i])) /// 与源点相连
            c[s][i] = q[i];//
        if (isFULL(out[i])){///与汇点相连
            c[n+i][sink] += q[i];
        }
        for (int j = 1; j &lt;= n; j++)///其他点相连
        if (i != j &amp;&amp; canLink(out[i], in[j]))
                c[n+i][j] = q[i];
    }
    
    flow = maxflow();
    total = 0;
    for (int i = 1; i &lt;= n+n; i++)
        for (int j = 1; j &lt;= n+n; j++)
            if (i != j &amp;&amp; f[i][j] &gt; 0 &amp;&amp; !(i+n == j || i == n+j)){
                ans[total][0] = (n+i-1)%n + 1;
                ans[total][1] = (n+j-1)%n + 1;
                ans[total][2] = f[i][j];
                total++;
            }
    printf("%d %dn", flow, total);
    for (int i = 0; i &lt; total; i++)
        printf("%d %d %dn", ans[i][0], ans[i][1], ans[i][2]);
} 
    return 0;
}













</pre>
