---
layout: post
title: poj 3253 Fence Repair (贪心 哈夫曼 堆排序)
category: acm-icpc
tags: [acm-icpc, poj]
---

<pre>/* poj 3253 Fence Repair
   题意:给几根木板，要你把他们连接起来，每一次连接的花费是他们的长度之和。
   问最少需要多少钱？

   哈夫曼编码，其实也不是，应该算是贪心吧，只是哈夫曼编码跟这个相似。
   贪心就是每次只取两块长度最小的木板，统计一下每次合并的费用就可以了。
   注意结果会很大，请哟个__int64.
   自己手写的堆排序，呵呵，还好记得住啊~就是出现了bug。
  代码：
*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int maxn = 20000+2;

int l[maxn];
int n, h, min;
__int64 ans;

void heap_sort(int x)
{
    int lg, lr, t;
    while ((x&lt;&lt;1) &lt;= h){ ///真悲剧，就是忘记写了个=号
        lg = x &lt;&lt; 1;
        lr = (x&lt;&lt;1)+1;
        if (lr &lt;= h &amp;&amp; l[lg] &gt; l[lr])
            lg = lr;
        if (l[x] &gt; l[lg]){
            t = l[x];
            l[x] = l[lg];
            l[lg] = t;
            x = lg;
        }
        else
            break;
    }
}
int main()
{
    int i;
while (1==  scanf("%d", &amp;n)){
    for (i = 1; i &lt;= n; i++)
        scanf("%d", &amp;l[i]);

    h = n;
    for (i = n/2; i &gt; 0; i--)
        heap_sort(i);

    ans = 0;

    while (h &gt; 1){
        min = l[1];
        l[1] = l[h];
        h--;
        heap_sort(1);

        min += l[1];
        l[1] = min;
        heap_sort(1);

        ans += min;
    }
    printf("%I64dn", ans);
}
    return 0;
}</pre>
