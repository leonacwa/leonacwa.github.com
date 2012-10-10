---
layout: post
title: poj 3274 Gold Balanced Lineup (排序)
category : acmicpc
tags : [acmicpc, poj]
---

<pre>/* poj 3274 Gold Balanced Lineup  

  题意：给几头牛，每头cow的feature不一样。找到i、j，使得i和j之间各个feature的和一样。  
  输出i j之间的cow数量。  

  可以使用排序或者哈希。  
  耗时：3274 Accepted 26108K 563MS G++ 1962B 2011-04-25 00:50:39  

别人的解题报告：来源可以Google到的。  
这个题目的转化有点困难，看了别人的报告才明白是怎么回事。  
给出SAMPLE  
7 3  
7  
6  
7  
2  
1  
4  
2  
先转化成二进制：  
1 1 1  
1 1 0  
1 1 1  
0 1 0  
0 0 1  
1 0 0  
0 1 0  
然后在列上进行累加：  
1 1 1  
2 2 1&lt;----  
3 3 2  
3 4 2  
3 4 3  
4 4 3&lt;----  
4 5 3  
上面这两步转化还好想。答案是4，是因为两个箭头所指的行列上的差相等。  
然后在行上，所有值减去最右边的数：  
0 0 0  
1 1 0&lt;----  
1 1 0  
1 2 0  
0 1 0  
1 1 0&lt;----  
1 2 0  
这一步转化推一下就知道，不过实在不好想。  
然后找出两个一样的行，使他们的距离最远。答案就是最远的距离。  

代码：  
*/</pre>  
<!--more-->  
<pre>#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  
#include &lt;iostream&gt;  
#include &lt;algorithm&gt;  
using namespace std;  

const int maxn = 100000;  
const int maxk = 32;  

struct L{  
    int p;  
    int d[maxk];  
};  
L list[maxn+1];  
int sum[maxn+1][maxk];  
int n, k;  

bool cmp(const L&amp; a, const L&amp;b) /// 注意cmp函数的书写  
{  
    int i;  
    for (i = 1; i &lt; k; i++)  
        if (a.d[i] != b.d[i])  
            return a.d[i] &lt; b.d[i];  
    return a.p &lt; b.p;  
}  

bool isEqual(const L&amp; a, const L&amp; b) /// 注意这个函数  
{  
    int i;  
    for (i = 1; i &lt; k; i++){  
        if (a.d[i] != b.d[i])  
        return false;  
    }  
    return true;  
}  

int main()  
{  
    int i, j, t;  
    memset(sum, 0, sizeof(sum));  
    memset(list, 0, sizeof(list));  

    scanf("%d %d", &amp;n, &amp;k);  

    for (i = 1; i &lt;= n; i++){  
        scanf("%d", &amp;t);  
        list[i].p = i;  
        for (j = 0; j &lt; k; j++){  
            sum[i][j] += sum[i-1][j] + ((t &amp; (1 &lt;&lt; j)) &gt; 0 ? 1 : 0);  
            list[i].d[j] = sum[i][j] - sum[i][0];  
        }  
    }  
    /// sort 的作用仅仅是为了把有同样feature的cow集中起来，用哈希的话也一样  
    sort(list, list+1+n, cmp); /// 需要从0开始，这个请参考全部为1的时候  
    //for (int j = 1; j &lt;= n; j++){for (int i = 0; i &lt; k; i++)printf("%d ", list[j].d[i]); printf("%dn", list[j].p);}  
    int max = 0;  
    i = j = 0;   /// 需要从0开始，这个请参考全部为1的时候  
    while (i &lt;= n){  
        while (j &lt;= n &amp;&amp; isEqual(list[i], list[j]))  
            j++;  
        //printf("n%d %dn", i, j);  
        int t = list[j-1].p - list[i].p;  
        t = t&gt;=0?t:-t;  
        max = max&gt;t?max:t;  
        i = j;  
    }  

    printf("%dn", max);  

    return 0;  
}</pre>  
