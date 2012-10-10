---
layout: post
title: poj1157 LITTLE SHOP OF FLOWERS (DP)
category : acmicpc
tags : [acmicpc, dp, poj]
---

<pre>/*
  poj1157_LITTLE SHOP OF FLOWERS
  题意：给出几束花，给几个花瓶，并且给出不同花插在不同瓶子获得的价值。
  要求是必须把所有的花都插上，问能获得的最大价值是多少。

  顺便杯具的说一下我的英语，那叫一个惨啊！

  别人的解释：
  题意：插花问题。给出一个二维矩阵，要求每一行都取出一个数，使得这些数的和最大，
  并且若一个数num1的行数i大于另一个数num2的行数，则必须保证num1的列数j也大于num2的列数。

  DP1。 dp[i][j] 表示前i束花插在前j的瓶子获得的最大价值。
  dp[i][j] = max(dp[i-1][k]+a[i][j]){i-1&lt;=k&lt;j};
  这个是以花为阶段，花瓶为状态的DP。

DP2.
  dp[i][j] 前i个瓶装j束花的价值
  dp[i][j] = max(dp[i-1][j], dp[i-1][j-1]+a[j][i])

  注意边界的初始化，全部是最小值。

  经典的DP啊，必须记住！！
代码1,2：
*/</pre>
<!--more-->
<pre> DP1。 dp[i][j] 表示前i束花插在前j的瓶子获得的最大价值。
  dp[i][j] = max(dp[i-1][k]+a[i][j]){i-1&lt;=k&lt;j};
  这个是以花为阶段，花瓶为状态的DP。

#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int INT_MAX = 9999999;

int dp[128][128], a[128][128];
int f, v, max;

int myMax(int a, int b)
{
    return a&gt;b?a:b;
}
int main()
{
    scanf("%d %d", &amp;f, &amp;v);
    for (int i = 1; i &lt;= f; i++)
        for (int j = 1; j &lt;= v; j++)
            scanf("%d", &amp;a[i][j]);

    for (int i = 1; i &lt;= f; i++){ /// 100 flower
        for (int j = 1; j &lt;= v; j++){ /// 100  vase
            dp[i][j] = -INT_MAX;
            for (int k = i-1; k &lt; j; k++){
                dp[i][j] = myMax(dp[i][j], dp[i-1][k]+a[i][j]);
            }
        }
    }
    max = dp[f][1];
    for (int i = 2; i &lt;= v; i++)
        max = myMax(max, dp[f][i]);
    printf("%dn", max);
    return 0;
}

/*
DP2.
  dp[i][j] 前i个瓶装j束花的价值
  dp[i][j] = max(dp[i-1][j], dp[i-1][j-1]+a[j][i])

  经典的DP啊，必须记住！！
*/

#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int INT_MAX = 9999999;

int dp[128][128], a[128][128];
int f, v;

int myMax(int a, int b)
{
    return a&gt;b?a:b;
}
int main()
{
    scanf("%d %d", &amp;f, &amp;v);
    for (int i = 1; i &lt;= f; i++)
        for (int j = 1; j &lt;= v; j++)
            scanf("%d", &amp;a[i][j]);

    for (int i = 1; i &lt;= f; i++) /// flower
    for (int j = 0; j &lt;= v; j++) /// vase
            dp[j][i] = -INT_MAX;

    /// dp[v][f]
    for (int i = 1; i &lt;= v; i++){ /// 100 vase
        for (int j = 1; j &lt;= f &amp;&amp; j &lt;= i; j++){ /// 100  flower
            dp[i][j] = myMax(dp[i-1][j], dp[i-1][j-1]+a[j][i]);
        }
    }
    printf("%dn", dp[v][f]);
    return 0;
}</pre>
