---
layout: post
title:  poj 1416 Shredding Company (DFS)
category: acm-icpc
tags: [acm-icpc, dfs, poj]
---

<pre>/*
  poj 1416 Shredding Company

  题意：给一个目标数字t，给一个初始数字n，(t和n都不超过6位)。
  问如何分割n，使得各部分的和非常的接近t。
  有多个最优解的输出rejected，没有解的输出error。

  DFS深搜。
  这样就不断分割n.这个说起来麻烦，还不如直接看代码。

  代码：
*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

int target, num;
char str[8];
bool rejected, error;
int ans[8], alen, bns[8], blen, asum, bsum;

void dfs(int x, int xlen)
{
    if (x == 0){
        blen = xlen;
        if (asum &lt; bsum &amp;&amp; bsum &lt;= target){
            asum = bsum;
            alen = blen;
            rejected = false; /// 没有相同答案
            error = false; /// 可以有新的解
             for (int i = 0; i &lt;= alen; i++)
                 ans[i] = bns[i];
        }
        else if (asum == bsum &amp;&amp; bsum &lt;= target)
            rejected = true; /// 有相同的答案
        return;
    }

    if (x + bsum &lt; asum) /// 简单的优化
        return;

    for (int dec = 10; dec &lt;= x*10; dec*=10){ /// 这个x*10很重要啊
        bsum += x % dec;
        bns[xlen] = x % dec;
        dfs(x / dec, xlen+1);
        bsum -= x % dec;
    }
    return;
}

int main()
{
    while (2 == scanf("%d %d", &amp;target, &amp;num) &amp;&amp; target &amp;&amp; num){
        rejected = false; /// 有同样的答案
        error = true; /// 没有一个解

        bsum = 0;
        asum = 0;
        dfs(num, 0);

        if (rejected &amp;&amp; !error){
            printf("rejectedn");
        }
        else if (error){
            printf("errorn");
        }
        else {
            printf("%d", asum);
            for (int i = alen - 1; i &gt;= 0; i--)
                printf(" %d", ans[i]);
            printf("n");
        }
    }
    return 0;
}</pre>
