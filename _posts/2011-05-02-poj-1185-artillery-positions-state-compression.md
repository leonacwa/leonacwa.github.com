---
layout: post
title: poj 1185 炮兵阵地 (DP 状态压缩)
category: acm
categories: [acm]
tags: [acm, dp, poj, %e5%bf%83%e5%be%97, %e7%8a%b6%e6%80%81%e5%8e%8b%e7%bc%a9, %e8%a7%a3%e9%a2%98%e6%8a%a5%e5%91%8a]
by: wp2md(php)
---

<pre>/*
  poj 1185 炮兵阵地
  题意：（中文的，不解释）。

  无耻的看了别人的解题报告，不会啊！

  行为阶段，每行放置的炮兵为状态。
  因为每列最多有10个，所以使用一个int行记录状态。
  因为题目中炮兵放置的要求，所以可以计算出单独一行的可行炮兵放置方案，存在状态数组s[]中,
  sum[]记录不同状态下炮兵放置数量。
  对于i，i-1，i-2行的放置状态 s[j], s[k], s[l] ，有：
  dp[i][j][k] = max{dp[i-1][k][l] + sum[j]} 
  其中s[j]&amp;s[k] == 0, s[j]&amp;[l] ==0 s[k]&amp;s[l] == 0

  所谓的状态压缩，其实就是减少状态数量，把一些同解或者无解的忽略掉。

  1185	Accepted	2256K	375MS	C++	2086B	2011-05-02 11:02:25
代码：  
*/</pre>
<!--more-->
<pre>
#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

int dp[128][65][65];
int mm[128], n, m;
int s[65], ss, sum[65];
int Max;
char str[16];

inline int myMax(int a, int b)
{
    return a&gt;b?a:b;
}
bool can(int x) /// 判断炮兵放置的位置是否合法
{
    if (x &amp; (x&lt;&lt;1)) return false;
    if (x &amp; (x&lt;&lt;2)) return false;
    return true;
}
int getSum(int x) /// 某状态下炮兵数量
{
    int ret = 0;
    for (; x; x = x - ((-x)&amp;x))
        ret++;
    return ret;        
}
void initStatus()
{
    ss = 0;
    for (int i = 0, sm=1&lt;&lt;m; i &lt; sm; i++){
        if (can(i)){
            s[ss] = i;
            sum[ss] = getSum(i);
            ss++;
        }
    }
}

int main()
{
    int i, j, k, l;

    memset(mm, 0, sizeof(mm));
    scanf("%d %d", &amp;n, &amp;m);
    for (i = 0; i &lt; n; i++){
        scanf("%s", str);
        for (j = 0; j &lt; m; j++){
            mm[i] |= (str[j]=='H'?1:0) &lt;&lt; j; /// 山丘不可放
        }
    }
    initStatus();
    memset(dp, -1, sizeof(dp));
    Max = 0;

    for (j = 0; j &lt; ss; j++){
        if (s[j]&amp;mm[0]) continue;
        dp[0][j][0] = sum[j];
        //Max = myMax(Max, dp[0][j][0]);
    }

    for (i = 1; i &lt; n; i++){
        for (j = 0; j &lt; ss; j++){ /// i 行  j
            if (s[j] &amp; mm[i]) continue; /// i放置的炮兵不能与当前行冲突
            for (k = 0; k &lt; ss; k++){ /// i-1 row   k
                if (s[j] &amp; s[k]) continue; /// i与i-1不能冲突
                for (l = 0; l &lt; ss; l++){ /// i-2 row   l
                    if ((s[j] &amp; s[l]) || (s[k] &amp; s[l])) continue; /// i与i-2, i-1与i-2 不能冲突
                    //if (s[j]&amp;s[l]) continue;
                    if (dp[i-1][k][l] == -1) continue;
                    dp[i][j][k] = myMax(dp[i][j][k], dp[i-1][k][l] + sum[j]);///j写成了i，多了几个WA
                    //Max = myMax(Max, dp[i][j][k]);
                }
            }
        }
    }
    for (i = 0,Max = 0; i &lt; ss; i++) for (j = 0; j &lt; ss; j++) Max = myMax(Max, dp[n-1][i][j]);

    printf("%dn", Max);
    return 0;
}</pre>
