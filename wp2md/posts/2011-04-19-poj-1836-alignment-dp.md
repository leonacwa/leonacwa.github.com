---
layout: post
title: poj 1836 Alignment (DP)
category : acmicpc
tags : [acmicpc, dp]
---

<pre> /* poj 1836 Alignment    
    
  先是看不懂题目，英语真他妈的悲催！    
    
  题意:给一个队伍，要去掉最少的人，使得中间高，两遍矮，并且两两不能等高。    
    
  动态规划，分别求解从左和从右的最优值（保留人数最多），然后枚举中间点，取得留下最多的人数，答案就是n-max。    
    
  详情将代码。    
*/</pre>    
<!--more-->    
<pre>#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
    
const int maxn = 1001;    
const double eps = 10e-8;    
double h[maxn+1];    
int dp1[maxn+1];    
int dp2[maxn+1];    
int n, max;    
    
double abs(double a)    
{return a&gt;0?a:-a;}    
int main()    
{    
    while (EOF != scanf("%d", &amp;n)){    
        for (int i = 1; i &lt;= n; i++)    
            scanf("%lf", h+i);    
    
        memset(dp1, 0, sizeof(dp1));    
        for (int i = 1; i &lt;= n; i++){    
            dp1[i] = 1;    
            for (int j = 1; j &lt; i; j++){    
                if (h[j] &lt; h[i] &amp;&amp; dp1[i] &lt; dp1[j]+1)    
                    dp1[i] = dp1[j]+1;    
            }    
        }    
    
        memset(dp2, 0, sizeof(dp2));    
        for (int i = n; i &gt; 0; i--){    
            dp2[i] = 1;    
            for (int j = n; j &gt; i; j--){    
                if (h[i] &gt; h[j] &amp;&amp; dp2[i] &lt; dp2[j]+1)    
                    dp2[i] = dp2[j]+1;    
            }    
        }    
    
        max = 0;    
        for (int k = 1, t1, t2; k &lt;= n; k++){    
            t1 = t2 = 0;    
            for (int i = 1; i &lt;= k; i++)    
            if (t1 &lt; dp1[i])    
                t1 = dp1[i];    
            for (int i = k+1; i &lt;= n; i++)    
            if (t2 &lt; dp2[i])    
                t2 = dp2[i];    
            if (max &lt; t1+t2)    
                max =  t1+t2;    
        }    
    
        printf("%dn", n-max);    
    }    
    
    return 0;    
}</pre>