---
layout: post
title: poj 1459 Power Network (SAP BFS)
category: acm-icpc
tags: [acm-icpc, poj]
---

/*
poj 1459 Power Network

题意：痛苦的理解过程，写那么多就是废话。
给几个发电站，给几个消耗站，再给几个转发点。
发电站只发电，消耗站只消耗电，转发点只是转发电，再给各个传送线的传电能力。
问你消耗站能获得的最多电是多少。

思路：没有源点和汇点就自己加，源点到发电站，消耗站到汇点。

典型最大流.....，非常直白了。

标号法求最大流
我理解是 最短距离标号法求增广路径,拗口了，我都不知道我以后还记不记得这话。
<pre>8517296	moorage	1459	Accepted	436K	63MS	G++	3437B	2011-04-20 18:52:28</pre>
这速度真实快啊！！
*/
代码：<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int maxn = 128;

int c[maxn][maxn], f[maxn][maxn];
int n, np, nc, m;
int sink, s;
bool vis[maxn];
int pre[maxn], num[maxn], d[maxn];
int q[maxn];
int head, tail;

void init_d() /// 初始化到达汇点的最短路径,这个只是简单的操作一遍
{
    int u, v;
    memset(d, -1, sizeof(d));
    memset(num, 0, sizeof(num));
    head= 0;
    tail = 1;
    q[head] = sink;
    d[sink] = 0;
    while (head &lt; tail){
        v = q[head++];
        for (u = 0; u &lt;= sink; u++){
            if (d[u] == -1 &amp;&amp; c[u][v] &gt; 0){ /// 很简单的计算，每个顶点值计算一次
                d[u] = d[v] + 1;
                ++num[d[u]];
                q[tail++] = u;
            }
        }
    }
}

int maxflow() /// 寻找允许弧进行最大流
{
    init_d();
    int u, v, delta, flow = 0;
    u = s;
    /// d[s]小于顶点数-1，因为我这里的节点是0..sink，所以有sink+1个顶点
    /// 一个点的最远允许距离只是顶点数-1,其中汇点sink d[sink]=0
    while (d[s] &lt;= sink){
        for (v = 0; v &lt;= sink; v++) /// 寻找u到v的允许弧
            if (c[u][v] &gt; 0 &amp;&amp; d[u] == d[v]+1){
                break;
            }
        if (v &lt;= sink){ /// 找到一条允许弧
            pre[v] = u; //printf("%d-&gt;%d  ", u, v);
            u = v; /// 用于找到下一个允许弧的点
            if (v == sink){ /// 允许弧到达了汇点，可以进行更新了
                delta = (unsigned)(1&lt;&lt;30)-1;
                for (v = sink; v != s; v = pre[v]) /// 寻找最小修改量
                    delta = delta&gt;c[pre[v]][v]?c[pre[v]][v]:delta;

                for (v = sink; v != s; v = pre[v]){ /// 根据找到的最小修改量进行修改
                    c[pre[v]][v] -= delta;
                    c[v][pre[v]] += delta;
                }
                flow += delta;
                u = s; /// 修改完一条允许弧路径，就重新开始
            }
        }
        else { /// 没有找到一条允许弧(u,v), 就更新最短路(重新标号)
            if ((--num[d[u]]) == 0)
                return flow; /// 间隙优化,某路径长度不存在了，有断层,说明残余网络被分开了
            d[u] = sink+1; /// 无法构成允许弧路径，就是距离太大了，用于隔离点u
            for (v = 0; v &lt;= sink; v++) /// 尝试更新u的最短距离
                if (c[u][v] &gt; 0 &amp;&amp; d[u] &gt; d[v]+1)
                    d[u] = d[v]+1;
            if (d[u]&lt;=sink) /// 唯有成功更新了允许弧才合法
                ++num[d[u]];
            if (u != s) /// 得返回，因为u可能不在任何一条允许弧路径上了
                u = pre[u];
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
