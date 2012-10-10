---
layout: post
title: poj 3274 Gold Balanced Lineup (哈希)
category : acmicpc
tags : [acmicpc, poj]
---

<pre>/* poj 3274 Gold Balanced Lineup    
    
  题意：给几头牛，每头cow的feature不一样。找到i、j，使得i和j之间各个feature的和一样。    
  输出i j之间的cow数量。    
    
  可以使用排序或者哈希。    
  耗时：3274 Accepted 26556K 407MS G++ 2406B 2011-04-25 01:20:32    
    
  下面的代码用的是哈希法，虽然不会设计哈希函数，但是会变通，使用UNIX下的一个哈希进行转化。    
  于是解出了这一道题。    
我的代码跟解题报告有一丁点不同：就是减下标为0，报告减的是下标为k-1,但是原理都一样。</pre>    
<!--more-->    
<pre>别人的解题报告：来源可以Google到的。    
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
...    
<pre>#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
#include &lt;iostream&gt;    
#include &lt;algorithm&gt;    
using namespace std;    
    
const int maxn =  100000;    
const int prime = 120721;    
const int maxk = 32;    
const int M = prime;    
    
struct L{    
    int d[maxk];    
};    
L list[maxn+1];    
int hash[prime+maxn];    
int sum[maxn+1][maxk];    
int n, k;    
    
int ELFhash(char *key) /// 此乃UNIX系统使用的哈希，绝对有价值    
{    
    unsigned long h = 0;    
    while (*key){    
        h = (h &lt;&lt; 4) + *key++;    
        unsigned long g = h &amp; 0xf0000000L; // 1个f，7个0    
        if (g) h ^= g &gt;&gt; 24;    
        h &amp;= ~g;    
    }    
    return (h+M) % M; // M is Prime    
}    
    
int hashcode(const L&amp;a) /// 把数字的转换为字符串，进行哈希，以后就不用费心思设计哈希了    
{    
    char str[32*8];    
    char *s = (char*)(&amp;a.d[1]);    
    int i;    
    for (i = 0; i &lt; k-1; i++){    
        str[i] = 'a' + s[i];    
    }    
    str[i] = 0;    
    return ELFhash(str);    
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
    int p, i, j, t, max;    
    
    memset(sum, 0, sizeof(sum));    
    memset(list, 0, sizeof(list));    
    memset(hash, -1, sizeof(hash));    
    
    scanf("%d %d", &amp;n, &amp;k);    
    p = hashcode(list[1]);    
    hash[p] = 0;    
    max = 0;    
    for (i = 1; i &lt;= n; i++){    
        scanf("%d", &amp;t);    
        for (j = 0; j &lt; k; j++){    
            sum[i][j] += sum[i-1][j] + ((t &amp; (1 &lt;&lt; j)) &gt; 0 ? 1 : 0);    
            list[i].d[j] = sum[i][j] - sum[i][0];    
        }    
        p = hashcode(list[i]);    
        while (hash[p] != -1){    
            if (isEqual(list[i], list[hash[p]])){    
                if (max &lt; i - hash[p])    
                    max = i - hash[p];    
            }    
            p++;    
        }    
        if (hash[p] == -1)    
            hash[p] = i;    
    }    
    
    printf("%dn", max);    
    
    return 0;    
}</pre>