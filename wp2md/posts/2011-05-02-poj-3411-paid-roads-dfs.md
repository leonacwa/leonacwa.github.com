---
layout: post
title: poj 3411 Paid Roads (DFS)
category : acmicpc
tags : [acmicpc, dfs, poj]
---

<pre>/**    
  poj 3411 Paid Roads    
  题意:从1遍历到n的最小花费，对于a-&gt;b，如果遍历过c，取p花费，不然取r花费。    
  问最小总花费是多少？    
    
  DFS。    
  方法：1.迭代DFS。    
       2.DFS，设定每个节点的最多访问次数。    
    
*/</pre>    
<!--more-->    
<pre>    
1.迭代DFS    
    
#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
    
const int INT_MAX = (unsigned)(1&lt;&lt;31) - 1;    
const int maxn = 1024;    
    
int a[maxn], c[maxn], b[maxn], p[maxn], r[maxn];    
int n, m, ans;    
int vis[maxn], limit;    
    
void dfs(int depth, int sum, int bi)    
{    
    int i;    
    if (depth &gt; limit)    
        return;    
    if (sum &gt; ans)    
        return;    
    if (bi == n){ /// Fuck，题目说的是到达n即可，我还在这里写全部遍历，英语啊    
        if (ans &gt; sum)    
            ans = sum;    
        return;    
    }    
    
    for (i = 0; i &lt; m; i++)    
    if (bi == a[i])    
    {    
        if (vis[c[i]] &gt; 0){ /// p[i]    
            vis[b[i]]++;    
            dfs(depth+1, sum+p[i], b[i]);    
            vis[b[i]]--;    
        }    
        else { /// r[i]    
            vis[b[i]]++;    
            dfs(depth+1, sum+r[i], b[i]);    
            vis[b[i]]--;    
        }    
    }    
}    
int main()    
{    
    scanf("%d %dn", &amp;n, &amp;m);    
    for (int i = 0; i &lt; m; i++)    
        scanf("%d %d %d %d %d", a+i, b+i, c+i, p+i, r+i);    
    
    ans = INT_MAX;    
    for (limit = 1; limit &lt; 32; limit++){ /// 迭代加深DFS,不知道解深度是多少，填深一些吧    
        memset(vis, 0, sizeof(vis));    
        vis[1] = 1;    
        dfs(0, 0, 1);    
    }    
    if (ans == INT_MAX)    
        printf("impossiblen");    
    else    
        printf("%dn", ans);    
    return 0;    
}    
    
2.DFS，设定每个节点的最多访问次数。    
#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
    
const int INT_MAX = (unsigned)(1&lt;&lt;31) - 1;    
const int maxn = 11;    
    
struct Edge{    
    int v, c, p, r, next;    
}e[maxn];    
int es, a, b, c, p, r, vv[maxn];    
int n, m, ans;    
int vis[maxn], limit;    
    
void dfs(int sum, int u)    
{    
    if (sum &gt; ans)    
        return;    
    if (u == n){ /** Fuck，题目说的是到达n即可，我还在这里写全部遍历，英语啊*/    
        if (ans &gt; sum)    
            ans = sum;    
        return;    
    }    
    int i, v;    
    for (i = vv[u]; i != -1; i = e[i].next){    
        v = e[i].v;    
        if (vis[e[i].c] &lt;= limit){ /** limit 设定为3*/    
            vis[v]++;    
            if (vis[e[i].c] &gt; 0)    
                dfs(sum+e[i].p, v);    
            else    
                dfs(sum+e[i].r, v);    
            vis[v]--;    
        }    
    }    
}    
int main()    
{    
    int i;    
    memset(vv, -1, sizeof(vv));    
    es = 0;    
    scanf("%d %dn", &amp;n, &amp;m);    
    for (i = 0; i &lt; m; i++){    
        scanf("%d %d %d %d %dn", &amp;a, &amp;b, &amp;c, &amp;p, &amp;r);    
        e[es].v = b;    
        e[es].c = c;    
        e[es].p = p;    
        e[es].r = r;    
        e[es].next = vv[a];    
        vv[a] = es;    
        es++;    
    }    
    
    ans = INT_MAX;    
    limit = 3;//8; /// 这个设定挺高的，网上多是3    
    memset(vis, 0, sizeof(vis));    
    vis[1] = 1;    
    dfs(0, 1);    
    
    if (ans == INT_MAX)    
        printf("impossiblen");    
    else    
        printf("%dn", ans);    
    return 0;    
}</pre>