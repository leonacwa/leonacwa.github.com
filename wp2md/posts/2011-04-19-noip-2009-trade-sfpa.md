---
layout: post
title: NOIp 2009 trade 最优贸易 (SPFA)
category : acmicpc
tags : [noip]
---

NOIp2009是我无法忘记的回忆，因为那代表我的不成熟，不理智。    
    
那一次其实可以骗到大概60分左右的，但是我脑残没有骗，我记得我当时写的最后一题那叫一个垃圾啊。    
    
不过当我发布这篇日志的时候，最后一题仅仅得了65分，杯具！标程怎么优化的如此强悍呢，写得又是那么难懂。    
    
/*NOIp 2009 trade 3．最优贸易    
    
从1到n的路径，找到一个地方买入，另一个地方卖出，使得获利最大。    
    
不好意思，看了别人的解题报告。    
    
SPFA，但是不是单纯的SPFA。    
这已经是达到灵活运用的地步了，不管题目是如何的变形。    
更准确的说，应该是使用了SPFA的一种思想，按边进行更新最优值。    
    
思路：    
题目要求的是从1到n的路径，并在这个路径找一个买入的点和一个卖出的点，使得获利最大。    
每个点的水晶价格不一样，但是每到达一个点，这个点的最优买入价格必定是到达这个点的    
路径上的最便宜价格，然而到达这个点的最大获利，必定是路径上的有最便宜价格的点u减去    
有最大价格的点v，前提是u早于v遍历，即u在v的前面。    
    
算法：    
所有点的最优买入价格初始为该店的水晶价格，最大获利赋值为-1，表示非法。    
点1的最大获利max[1] = 0; 没有获利。    
将1加入队列，从队列头开始更新各点。x = q[head];    
对于当前用于更新的点x，遍历与x相连的点y，并按照上述方法更新y点的最优买入价格和最大获利。    
有更新的点y加入队列，用于对后面的点进行更新，当没有可用于更新的点，算法完成。    
    
邻接表存储，优化查找相连点时间。    
    
但是我想，这个还是SPFA吗？虽然别人的算法名字写着SPFA，但是我不明白啊。    
不过倒是利用了SPFA算法的框架，难道指的是这个?    
不解。下面是代码：<!--more-->    
    
*/    
<pre>#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
    
const int  M = 500000+8;    
const int  N = 100000+8;    
const int  QN = 100000+8;    
    
struct E{    
    int v;    
    E* next;    
};    
E e[M*2];    
int ei;    
E* u[N];    
    
int price[N];    
int cur[N], max[N]; // 最佳购入价格，最大利益    
int q[QN], head, tail;    
bool set[N];    
int n, m, ans;    
    
int spfa()    
{    
    int x, y, t;    
    
    // 赋值为负数,表示初始点的获利比点1的获利0小，或者说是“无法”获利，“非法”获利    
    memset(max, -1, sizeof(max));     
    memset(set, 0, sizeof(set));    
    
    head = 0;     
    tail = 1;    
    q[0] = 1;    
    set[1] = true;    
    max[1] = 0; //初始点盈利为0    
    
    for (int i = 1; i &lt;= n; i++)    
        cur[i] = price[i];    
    
    while (head != tail){    
        x = q[head];    
        head = (head+1)%QN;    
        set[x] = false;    
    
        for (E* pe = u[x]; pe; pe = pe-&gt;next){ // 按照边进行更新    
            y = pe-&gt;v;    
            if (cur[y] &gt; cur[x] || max[y] &lt; max[x]){    
    
                if (cur[y] &gt; cur[x]) // 更新购入价格    
                    cur[y] = cur[x];    
    
                if (max[y] &lt; max[x]) // 更新获利    
                    max[y] = max[x];    
    
                if ((t=price[y] - cur[y]) &gt; max[y]) // 更新获利    
                    max[y] = t;    
    
                if (!set[y]){ // 更新过的点加入队列    
                    q[tail] = y;    
                    set[y] = true;    
                    tail = (tail+1)%QN;    
                }    
            }    
    
        }    
    
    }    
    
    return max[n];    
}    
int main()    
{    
    freopen("trade.in", "r", stdin);    
    freopen("trade.out", "w", stdout);    
    
    memset(u, 0, sizeof(u));    
    
    scanf("%d %d", &amp;n, &amp;m);    
    
    for (int i = 1; i &lt;= n; i++)    
        scanf("%d", &amp;price[i]);    
    
    ei = 0;    
    for (int i = 1, x, y, z; i &lt;= m; i++){    
        scanf("%d %d %d", &amp;x, &amp;y, &amp;z);    
        //  (x-&gt;y)    
        e[ei].v = y;    
        e[ei].next = u[x];    
        u[x] = &amp;e[ei];    
        ++ei;    
        // (y-&gt;x)    
        if (2 == z){    
            e[ei].v = x;    
            e[ei].next = u[y];    
            u[y] = &amp;e[ei];    
            ++ei;    
        }    
    }    
    
    ans = 0;    
    
    ans = spfa();    
    
    if (ans &gt; 0) {    
        printf("%dn", ans);    
    }    
    else {    
        printf("0n");    
    }    
    
    fclose(stdin);    
    fclose(stdout);    
    return 0;    
}</pre>