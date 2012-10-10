---
layout: post
title: poj 2531 Network Saboteur (DFS)
category: acm-icpc
tags: [acm-icpc, poj]
---

<pre>// poj 2531 Network Saboteur
/*
  题意：给出所有i节点到j的耗费，问你如何将节点分为A集合和B集合，
　　　使得所有在A集合的节点到B集合的各节点的耗费的总和最大。
  其实题目也很好理解的，O(∩_∩)O~。

  求最大，顺着最大的思路做。
  单纯的DFS，但是比枚举状态的效率高一些，其实是减少了一些重复的操作，
　因为有些分法是有重叠的，而DFS刚好减少了重叠部分的计算
*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const bool A = true;
const bool B = false;

int c[32][32];
int n, ans;
bool set[32];

void dfs(int depth, int sum)
{
    if (depth &gt;= n){
        if (sum &gt; ans){
            ans = sum;
        }
        return;
    }

    int t = 0;
    set[depth] = A;
    for (int i = 0; i &lt; depth; i++)
        if (set[i] == B){
            t += c[depth][i];
        }
    dfs(depth+1, sum+t);

    t = 0;
    set[depth] = B;
    for (int i = 0; i &lt; depth; i++)
        if (set[i] == A){
            t += c[i][depth];
        }
    dfs(depth+1, sum+t);

}

int main()
{
    scanf("%d", &amp;n);
    for (int i = 0; i &lt; n ; i++)
        for (int j = 0; j &lt; n; j++)
            scanf("%d", &amp;c[i][j]);
    ans = 0;
    set[0] = A;
    dfs(1, 0);

    printf("%dn", ans);
    return 0;
}</pre>
