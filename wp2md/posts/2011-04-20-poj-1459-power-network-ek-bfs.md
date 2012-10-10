---
layout: post
title: poj 1459 Power Network (EK BFS)
category : acmicpc
tags : [acmicpc, poj]
---

/*    
poj 1459 Power Network    
    
题意：痛苦的理解过程，写那么多就是废话。    
给几个发电站，给几个消耗站，再给几个转发点。    
发电站只发电，消耗站只消耗电，转发点只是转发电，再给各个传送线的传电能力。    
问你消耗站能获得的最多电是多少。    
    
思路：没有源点和汇点就自己加，源点到发电站，消耗站到汇点。    
    
典型最大流.....，非常直白了。    
    
EK算法，就是BFS求最短增广路的的最大流算法。    
<pre>8516937	moorage	1459	Accepted	496K	329MS	G++	2413B	2011-04-20 17:33:12</pre>    
这速度还行。    
    
代码：    
    
*/<!--more-->    
<pre>     
    
#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
    
const int maxn = 128;    
    
int c[maxn][maxn], f[maxn][maxn];    
int n, np, nc, m;    
int sink, s;    
bool vis[maxn];    
int pre[maxn], low[maxn];    
int q[4096];    
int head, tail;    
    
int maxflow()    
{    
    int u, v, flow = 0;    
    memset(f, 0, sizeof(f));    
    do{    
        /// bfs 找一条最短的增广路    
        memset(vis, 0, sizeof(vis)); /// vis[] 记录节点是否访问    
        vis[s] = true;    
        low[s] = 999999999; /// 初始化源点s的“前驱”到s的可行流修改量无限大    
        low[sink] = 0; /// 这个初始化千万不要忘记了，因为可能找不到路啊    
        head = 0; tail = 1;    
        q[head] = s;    
        while (head &lt; tail){    
            u = q[head++];     
            for (v = 0; v &lt;= sink; v++)    
            if (!vis[v] &amp;&amp; c[u][v] &gt; f[u][v]){ /// 节点v没有被访问，而且当前最大可行流f可以修改    
                vis[v] = true;    
                pre[v] = u;    
                q[tail++] = v;    
                low[v] = c[u][v] - f[u][v]; /// 可行流的修改量    
                if (low[v] &gt; low[u])  /// 只能取路径上最小的修改量    
                    low[v] = low[u];    
            }    
        }    
        ///  寻找最短路结束    
        /// 开始更新可行流    
        if (low[sink]&gt;0){    
            v = sink; /// 从汇点开始更新可行流    
            while (v != s){ ///     
                f[pre[v]][v] += low[sink];    
                f[v][pre[v]] -= low[sink];    
                v = pre[v];    
            }    
            flow += low[sink]; /// 网络中的最大流修改(增加)    
        }    
    
    } while (low[sink]&gt;0); /// 上一次修改过了，下一次可能还有修改，没有修改则算法结束    
    
    return flow;    
}    
int main()    
{    
    int u=0, v=0, z=0;    
    while (4 == scanf("%d %d %d %d", &amp;n, &amp;np, &amp;nc, &amp;m)){    
    
        memset(c, 0, sizeof(c)); // 网络中的边(管道)的容量    
    
        s = n;    
        sink = n+1;    
    
        for (int i = 0; i &lt; m; i++){ //     
            while (getchar() != '(') ; // 杯具啊，没有好好了解scanf的输入啊    
            scanf("%d,%d)%d", &amp;u, &amp;v, &amp;z);    
            c[u][v] = z;    
        }    
        for (int i = 0; i &lt; np; i++){ // power    
            while (getchar() != '(') ; // 杯具啊，没有好好了解scanf的输入啊    
            scanf("%d)%d", &amp;u, &amp;z);    
            c[s][u] = z;    
        }    
        for (int i = 0; i &lt; nc; i++){ // consumer    
            while (getchar() != '(') ; // 杯具啊，没有好好了解scanf的输入啊    
            scanf("%d)%d", &amp;u, &amp;z);    
            c[u][sink] = z;    
        }    
    
        printf("%dn", maxflow());    
    }    
    return 0;    
}</pre>