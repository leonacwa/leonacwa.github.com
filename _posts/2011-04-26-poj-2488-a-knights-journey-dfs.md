---
layout: post
title: poj 2488 A Knight’s Journey (DFS)
category : acmicpc
tags : [acmicpc, dfs, poj]
---

<pre>/*
  poj 2488 A Knight's Journey
  题意：一个骑士按照规则走格子，问能否不重复的走完所有格子。
  
  题目要求最小的字典序，所以必须从A1 (1,1)开始。
  
  DFS，注意按照最小字典序的输出走。
  
*/</pre>
<!--more-->
<pre>
#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int dir[8][2] = { /// 字典序最小的走法顺序
    {-2,-1}, {-2,1}, {-1,-2},{-1,2},
    {1,-2},{1,2},{2,-1},{2,1}};

struct Path{
    int x, y;
};
Path path[32*32+1];
bool mm[32][32];
int p, q;

bool dfs(int x, int y, int order)
{
    mm[x][y] = true;
    path[order].x = x;
    path[order].y = y;
    if (order == p*q)
        return true;
    
    int xt, yt;
    for (int i = 0; i &lt; 8; i++){
        xt = x + dir[i][0];
        yt = y + dir[i][1];
        if (1&lt;=xt&amp;&amp;xt&lt;=q &amp;&amp; 1&lt;=yt&amp;&amp;yt&lt;=p &amp;&amp; !mm[xt][yt]){
            if (dfs(xt, yt, order+1))
                return true;
        }
    }
    mm[x][y] = false; /// 回溯时忘记修复现场了，WA，~~~~(&gt;_&lt;)~~~~ 
    return false;
}
int main()
{
    int t, cnt = 0;
    scanf("%d", &amp;t);
    while (t--){
        scanf("%d %d", &amp;p, &amp;q);
        
        memset(mm, 0, sizeof(mm));
        
        printf("Scenario #%d:n", ++cnt);
        if (!dfs(1, 1, 1)){
            printf("impossiblen");
        }
        else{
            for (int i = 1; i &lt;= p*q; i++)
                printf("%c%d", (char)(path[i].x+'A'-1), path[i].y);
            printf("n");
        }
        if (t)
            printf("n");
    }
    return 0;
}</pre>
