---
layout: post
title: poj 2833 The Average (模拟)
category: acm
tags: [acm, poj, %e6%a8%a1%e6%8b%9f, %e8%a7%a3%e9%a2%98%e6%8a%a5%e5%91%8a]
---

<pre>/**
   poj 2833 The Average
   题意：去掉最大的n1个数，最小的n2个数，求剩余数的平均值。

   解法：
   开两个数组维护最大和最小。
   先初始化读入两个数组，然后读剩下是数。
   对于每个数a，先用它更新两个数组，得到介于他们中间的数，然后累加该数。
   使用__int64类型的数据累加和。

   但是只过了C和C++，郁闷。
   2833	Accepted	184K	2704MS	C	1526B	2011-05-07 08:49:02
   2833	Accepted	180K	2813MS	C++	1526B	2011-05-07 08:48:12
代码：
*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;
#include &lt;stdlib.h&gt;

int Max[16], Min[16], a, s[32];
int n1, n2, n, rest;

int int_cmp(const void *a, const void *b)
{
    return *(int*)a - *(int*)b;
}
int main()
{
    int i, j, lMax, lMin, t, k;
    __int64 sum;
    double avg;
    while (3 == scanf("%d %d %dn", &amp;n1, &amp;n2, &amp;n)){
        if (n1 == 0 &amp;&amp; n2 == 0 &amp;&amp; n == 0)
            break;
        rest = n - n1 - n2;
        avg = 0;
        sum = 0;
        lMax = lMin = 0;
        memset(Max, -1, sizeof(Max));
        memset(Min, -1, sizeof(Min));
        for (i = n1+n2-1; i &gt;= 0; i--){
            scanf("%d", &amp;s[i]);
        }
        qsort(s, n1+n2, sizeof(int), int_cmp);
        for (i = 0; i &lt; n2; i++)
            Min[i] = s[i];
        for (i = 0; i &lt; n1; i++)
            Max[i] = s[n2+i];

        for (i = 0; i &lt; rest; i++){
            scanf("%d", &amp;a);
            for (j = 0, k = 0; j &lt; n1; j++)
                if (Max[k]&gt; Max[j])
                    k = j;
            if (a &gt; Max[k]){
                t = a;
                a = Max[k];
                Max[k] = t;
            }
            for (j = 0, k = 0; j &lt; n2; j++)
                if (Min[k] &lt; Min[j])
                    k = j;
            if (a &lt; Min[k]){
                t = a;
                a = Min[k];
                Min[k] = t;
            }
            sum += a;
        }
        printf("%.6lfn", (double)sum / rest);
    }
    return 0;
}</pre>
