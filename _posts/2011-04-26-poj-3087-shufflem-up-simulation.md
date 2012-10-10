---
layout: post
title: poj 3087 Shuffle m Up (模拟 吧)
category : acmicpc
tags : [acmicpc, poj]
---

<pre>/* 
  poj 3087 Shuffle'm Up
(因为我杯具的英语，我从网上搜了翻译，这翻译不错，言简意赅)
  题意：已知两堆木片s1和s2的初始状态，其木片数均为c。
  按给定规则能将他们相互交叉组合成一堆木片s12，再将s12的最底下的c块木片归为s1，
  最顶的c块木片归为s2，依此循环下去。
  问经过多少次新的组合之后，s12的状态和目标状态des相同，
  若永远不可能相同，则输出"-1"。

  题目的翻译，起初我看不懂~杯具的英语
  
  一看，是模拟题，但是如何判断无法到达呢？
  再次返回到原始状态就是不行的了，呵呵。
*/</pre>
<!--more-->
<pre>
#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

char s[2][256], s12[256], ts[256], des[256];
int t, c;

int main()
{
    int times;
    scanf("%d", &amp;t);
    for (int tt = 1; tt &lt;= t; tt++){
        scanf("%d", &amp;c);
        scanf("%s", s[0]);
        scanf("%s", s[1]);
        scanf("%s", des);
        
        for (int i = 0; i &lt; 2*c; i++){
            ts[i] = s12[i] = s[(1+i)%2][i/2];
        }
        ts[2*c] = s12[2*c] = 0;  //printf("%s:desn%s:s12n", des, s12);
        times = 1;
        while (times != -1){
            for (int i = 0; i &lt; c; i++)
                s[0][i] = ts[i];
            s[0][c] = 0;
            for (int i = 0; i &lt; c; i++)
                s[1][i] = ts[c+i];
            s[1][c] = 0;
            //printf("%s _ %sn", s[0], s[1]);
            for (int i = 0; i &lt; 2*c; i++){
                ts[i] = s[(1+i)%2][i/2];
            }
            times++;
            ts[2*c] = 0;// printf("%sn", ts);
            
            if (strcmp(des, ts) == 0){
                break;
            }
            if (strcmp(ts, s12) == 0){
                times = -1;
                break;
            }
        }
        printf("%d %dn", tt, times);
    }
    
    return 0;
}</pre>
