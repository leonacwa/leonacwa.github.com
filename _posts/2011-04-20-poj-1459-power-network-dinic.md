---
layout: post
title: poj 1459 Power Network (Dinic)
category: acm
tags: [acm, poj, %e5%bf%83%e5%be%97, %e7%bd%91%e7%bb%9c%e6%b5%81, %e8%a7%a3%e9%a2%98%e6%8a%a5%e5%91%8a]
---

/*
poj 1459 Power Network

题意：痛苦的理解过程，写那么多就是废话。
给几个发电站，给几个消耗站，再给几个转发点。
发电站只发电，消耗站只消耗电，转发点只是转发电，再给各个传送线的传电能力。
问你消耗站能获得的最多电是多少。

思路：没有源点和汇点就自己加，源点到发电站，消耗站到汇点。

典型最大流.....，非常直白了。

Dinic 算法 非递归版本的

Dinic跟SAP真的很像，可以参照一下，以后就用Dinic算法了
这题用的时间跟SAP差不多，不知道为什么。

*/
代码：
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int maxn = 128;

int c[maxn][maxn], f[maxn][maxn];
int n, np, nc, m;
int sink, s;
int pre[maxn], d[maxn], cur[maxn], low[maxn];
int q[4096];
int head, tail;

bool bfs() /// 这个就是在层次图里找允许弧的路径的东西
{
    int u, v;

    head = 0;
    tail = 1;
    q[head] = sink;
    memset(d, -1, sizeof(d));
    d[sink] = 0;

    while (head &lt; tail){
        v = q[head++];
        for (u = 0; u &lt;= sink; u++)
            if (f[u][v] &lt; c[u][v] &amp;&amp; d[u] == -1){
                d[u] = d[v] + 1;
                q[tail++] = u;
        }
        if (d[s] != -1)
            return true;
    }
    return false;
}

int maxflow() /// Dinic 算法， 跟SAP有点像
{
    int flow = 0, u, v;
    memset(f, 0, sizeof(f));

    while ( bfs() ){ /// 不断更新层次图,修改最短距离标号
        u = s;
        low[s] = (unsigned)(1&lt;&lt;31) - 1;
        /// cur,我的节点是从0开始的，记录下一个开始查找的节点,也是Dinic算法的关键
        /// 因为这个算法本来应该是递归调用的，但是被改成了非递归实现
        memset(cur, 0, sizeof(cur));

        for (;;){ /// 不断的寻找增广路

            for (v = cur[u]; v &lt;= sink; v++)
                if (f[u][v] &lt; c[u][v] &amp;&amp; d[u] == d[v]+1)
                    break;
            if (v &lt;= sink){ /// 找到一个允许弧
                cur[u] = v + 1; /// 下一次查找开始的点
                pre[v] = u;
                low[v] = c[u][v] - f[u][v]; /// 增广路上的课修改流
                if (low[v] &gt; low[u])
                    low[v] = low[u];
                u = v;
                if (u == sink){ /// 到达汇点了，可以修改流了
                    do{ /// 顺着增广路不断返回，修改可行流
                        cur[pre[u]] = u; /// 不加也对，但耗时会增加,求解？？？？
                        f[pre[u]][u] += low[sink];
                        f[u][pre[u]] -= low[sink];
                        u = pre[u];
                    } while (u != s);
                    flow += low[sink]; /// 可行流有增加了
                    low[s] = (unsigned)(1&lt;&lt;31) - 1; /// 难道是有回头的?                     
                }
            }
            else if (u != s){ /// 找不到一条，试着返回找另一条
                cur[u] = v; /// 此时点u不可能再找到一个允许弧了
                u = pre[u]; /// 返回找另一个允许弧路径                
            }
            else /// 又回到源点，找不到一条可增广的路了
                break;
        }
    }
    return flow;
}
int main()
{
    int u=0, v=0, z=0;
    while (4 == scanf("%d %d %d %d", &amp;n, &amp;np, &amp;nc, &amp;m)){

        memset(c, 0, sizeof(c)); /// 网络中的边(管道)的容量

        s = n; /// 原来的网络中没有源点，自己设一个
        sink = n+1; /// 原来的网络中没有汇点，自己设一个

        for (int i = 0; i &lt; m; i++){ // 
            while (getchar() != '(') ; /// 杯具啊，没有好好了解scanf的输入啊
            scanf("%d,%d)%d", &amp;u, &amp;v, &amp;z);
            c[u][v] = z;
        }
        for (int i = 0; i &lt; np; i++){ // power
            while (getchar() != '(') ; /// 杯具啊，没有好好了解scanf的输入啊
            scanf("%d)%d", &amp;u, &amp;z);
            c[s][u] = z;
        }
        for (int i = 0; i &lt; nc; i++){ // consumer
            while (getchar() != '(') ; /// 杯具啊，没有好好了解scanf的输入啊
            scanf("%d)%d", &amp;u, &amp;z);
            c[u][sink] = z;
        }

        printf("%dn", maxflow());
    }
    return 0;
}</pre>
