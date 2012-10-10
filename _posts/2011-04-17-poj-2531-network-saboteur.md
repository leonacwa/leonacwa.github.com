---
layout: post
title: poj 2531 Network Saboteur (DFS+逆向求解+定界)
category: acm-icpc
tags: [acm-icpc, poj]
---

<pre>// poj 2531 Network Saboteur
/*
  题意：给出所有i节点到j的耗费，问你如何将节点分为A集合和B集合，
　　　　使得所有在A集合的节点到B集合的各节点的耗费的总和最大。
  其实题目也很好理解的，O(∩_∩)O~。

  题目求最大,逆向思维，从最小的求。
  思考：
　对于耗费最大的集合A和B，在A和B各自内部的耗费和必然最小；
　如果不是最小，外部最大耗费还可以据需增加的。
  所以可以求出集合最小内部耗费，然后以总花费减去最小花费即可。
  这样的好处是可以使用最小值进行优化，而且还可以界定最小耗费的(随机)上界。

  这个想法是参考网上大牛的代码，不过是在poj上找到的.
*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const bool A = true;
const bool B = false;

int c[32][32];
int in[32], out[32];
int n, ans, sum, p;
bool set[32];

void dfs(int k, int s, int ni, int no) // A B 集合内部最小花费
{
    if (s &gt; ans)
        return;

    if (k &gt;= n){
        if (s &lt; ans)
            ans = s;
        return;
    }

    int t = 0;
    in[ni] = k;
    for (int i = 0; i &lt; ni; i++){
        t += c[in[i]][k];
    }
    dfs(k+1, s+t, ni+1, no);

    t = 0;
    out[no] = k;
    for (int i = 0; i &lt; no; i++){
        t += c[out[i]][k];
    }
    dfs(k+1, s+t, ni, no+1);

}

int main()
{
    scanf("%d", &amp;n);
    sum = 0;
    for (int i = 0; i &lt; n ; i++)
        for (int j = 0; j &lt; n; j++){
            scanf("%d", &amp;c[i][j]);
            sum += c[i][j];
        }
    sum /= 2;  // 这个是所有的耗费
    // 取1..n/2 和 1+n/2..n作为一个最小内部花费界限范围
    p = 0;
    for (int i = 0; i &lt; n/2; i++){
        for (int j = 0; j &lt; n/2; j++)
            p += c[i][j];
    }
    for (int i = n/2; i &lt; n; i++){
        for (int j = n/2; j &lt; n; j++)
            p += c[i][j];
    }
    p /= 2; // 这个是假定的最小耗费上限，用来定界，强啊

    ans = p;
    in[0] = 0;
    dfs(1, 0, 1, 0);

    printf("%dn", sum - ans);
    return 0;
}</pre>
