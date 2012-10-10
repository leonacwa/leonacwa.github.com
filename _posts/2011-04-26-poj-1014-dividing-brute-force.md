---
layout: post
title: poj 1014 Dividing (枚举,应该是)
category: acm
tags: [acm, poj, %e5%bf%83%e5%be%97, %e6%9e%9a%e4%b8%be, %e8%a7%a3%e9%a2%98%e6%8a%a5%e5%91%8a]
---

<pre>/*
  poj 1014 Dividing
  题意：给出价值分别为1..6的大理石的不同数量，问能否将他们分成价值相同的两堆。

  先判断总价值是否sum是否是偶数，奇数是并不可能平分的。
  然后就用那些大理石产生数，最后判断是否存在sum/2即可。

  1014	Accepted 732K 391MS G++	1458B 2011-04-26 00:02:04
代码：
*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

bool a[20000*21+8];
int n[6], sum;

int main()
{
    int r = 0;
    while (6 == scanf("%d %d %d %d %d %d", &amp;n[0], &amp;n[1], &amp;n[2], &amp;n[3], &amp;n[4], &amp;n[5])){
        sum = n[0]*1 + n[1]*2 + n[2]*3 + n[3]*4 + n[4]*5 + n[5]*6;
        if (sum == 0)
            break;
        printf("Collection #%d:n", ++r);
        if (sum%2){
            printf("Can't be divided.nn");
            continue;
        }
        memset(a, 0, sizeof(a));
        a[0] = true;
        for (int i = 0; i &lt; 6; i++) /// 大理石
            if (n[i]){ /// 有大理石
                for (int j = sum/2 - (i+1); j &gt;= 0; j--) /// 改一下这个起始循环点就过了，不然超时
                if (a[j]){  /// 有这个价值
                    for (int k = 1; k &lt;= n[i]; k++){ /// 不同数量
                        a[j+(i+1)*k] = true;
                        if (a[sum/2]){
                            j = -1; /// 写了四句多余的代码啊，哈哈
                            k = 999999;
                            i = 999999;
                            goto ANS; /// 这句就足够了
                            break;
                        }
                    }
                }
            }
    ANS:
        if (a[sum/2])
            printf("Can be divided.nn");
        else
            printf("Can't be divided.nn");
    }
    return 0;
}</pre>
