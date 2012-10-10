---
layout: post
title: poj 1459 Power Network (DFS -> TLE)
category : acmicpc
tags : [acmicpc, poj, tle]
---

/*    
poj 1459 Power Network    
    
题意：痛苦的理解过程，写那么多就是废话。    
给几个发电站，给几个消耗站，再给几个转发点。    
发电站只发电，消耗站只消耗电，转发点只是转发电，再给各个传送线的传电能力。    
问你消耗站能获得的最多电是多少。    
    
思路：没有源点和汇点就自己加，源点到发电站，消耗站到汇点。    
    
典型最大流.....，非常直白了。    
DFS，然后很强大的TLE了，O(∩_∩)O哈哈~    
这个也算有些价值的东西，给NOIp的选手骗分用的，O(∩_∩)O哈哈~ O(∩_∩)O哈哈~    
*/    
<!--more-->    
<pre>#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
    
const int maxn = 128;    
    
int c[maxn][maxn];    
int n, np, nc, m;    
int sink, s;    
bool vis[maxn];    
    
int dfs(int x, int low) // DFS 找到一条增广路径    
{    
    if (x == sink)    
        return low;    
    vis[x] = true;    
    for (int i = 0, flow; i &lt;= sink; i++){    
        if (!vis[i] &amp;&amp; c[x][i] &amp;&amp; (flow=dfs(i, c[x][i]&gt;low?low:c[x][i]))){    
            c[x][i] -= flow;    
            c[i][x] += flow;    
            return flow;    
        }    
    }    
    vis[x] = false;    
    return 0;    
}    
int main()    
{    
    int u=0, v=0, z=0;    
    while (4 == scanf("%d %d %d %d", &amp;n, &amp;np, &amp;nc, &amp;m)){    
    
        memset(c, 0, sizeof(c));    
    
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
    
        int flow, ans = 0;    
        memset(vis, 0, sizeof(vis));    
    
        while (flow=dfs(s, (unsigned)(1&lt;&lt;31)-1)){    
            memset(vis, 0, sizeof(vis));    
            ans += flow;    
        }    
        printf("%dn", ans);    
    }    
    return 0;    
}</pre>