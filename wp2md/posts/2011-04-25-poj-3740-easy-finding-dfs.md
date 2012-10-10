---
layout: post
title: poj 3740 Easy Finding (DFS)
category : acmicpc
tags : [acmicpc, dfs, poj]
---

<pre>/*poj 3740 Easy Finding    
    
  纯DFS，非常简单的剪枝。    
      
  3740	Accepted	1352K	579MS	GCC	1435B	2011-04-25 22:55:41    
      
  顺便我想骂一句，这题数据太卑鄙了 数据范围是  (M ≤ 16, N ≤ 300)。    
  但是我设置 M 32 N 512 ，就是不过，这无耻啊！    
  兴许是我弄错了，也最好是我错了。    
  代码：    
*/</pre>    
<!--more-->    
<pre>    
#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
    
#define M 512    
#define N 512    
    
int mm[M][N];    
int m, n, can;    
int sum[N];    
    
int match()    
{    
    int i;    
    for (i = 0; i &lt; n; i++)    
        if (sum[i] != 1)    
            return 0;    
    return 1;    
}    
void dfs(int x)    
{    
    int i;        
    for (i = 0; i &lt; n; i++) /// 剪枝    
        if (sum[i] &gt; 1){    
            return;    
        }    
        
    if (mm[x][n] &gt; 0){    
        for (i = 0; i &lt; n; i++) /// 选取这行    
            sum[i] += mm[x][i];    
            
        if (match()){ /// 答案    
            can = 1;    
            return;    
        }    
        if (x+1 &lt; m)    
            dfs(x+1);    
        if (can &gt; 0)    
            return;    
        for (i = 0; i &lt; n; i++) /// 不取这行    
            sum[i] -= mm[x][i];    
    }    
    if (x+1 &lt; m &amp;&amp; !can)    
        dfs(x+1);    
}    
    
int main()    
{    
    int  i, j;    
    while (2 == scanf("%d %d", &amp;m, &amp;n)){    
        memset(mm, 0, sizeof(int)*M*N);    
        for (i = 0; i &lt; m; i++){    
            for (j = 0; j &lt; n; j++){    
                scanf("%d", &amp;mm[i][j]);    
                mm[i][n] += mm[i][j];    
            }    
        }    
            
        memset(sum, 0, sizeof(int)*M);    
            
        can = 0;    
        dfs(0);    
        //for (i = 0; i &lt; n; i++) printf("%d ", sum[i]);printf("n");    
        if (can &gt; 0)    
            printf("Yes, I found itn");    
        else     
            printf("It is impossiblen");    
    }    
    return 0;    
}</pre>