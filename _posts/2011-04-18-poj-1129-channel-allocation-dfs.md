---
layout: post
title: poj 1129 Channel Allocation (DFS)
category : acmicpc
tags : [acmicpc, dfs, poj]
---

<p>// poj 1129 Channel Allocation<br /><br />  
/*<br /><br />  
题意：给出一张无向图，相邻的点有连接。要求相邻的两点不能有相同的频道，<br /><br />  
问最少需要多少个频道，使得相邻的两点没有共同的频道。</p>  
<p>思路：DFS, 枚举每一个节点可以放入的频道，不能放的新开一个频道放入。<br /><br />  
加入一点优化，poj上0ms<br /><br />  
*/<!--more--></p>  
<pre>#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  

bool map[32][32];  
int n;  
char str[64];  
int vis[32];  
int ans;  

void dfs(int x, int channels)  
{  
    if (channels &gt; ans) // 优化  
        return;  

    if (x &gt;= n){  
        if (ans &gt; channels)  
            ans = channels;  
        return;  
    }  

    int i, j;  
    for (i = 1; i &lt;= channels; i++){ // 枚举当前存在的频道  
        for (j = 0; j &lt; x; j++){ // 检查是否可以在i频道内  
            if ((vis[j] == i) &amp;&amp; map[x][j])  
                break;  
        }  
        if (j == x){ // 如果可以加入i频道  
            vis[x] = i;  
            dfs(x+1, channels);  
            vis[x] = 0;  
        }  
    }  
    // 将 x 放入一个新的频道  
    vis[x] = channels+1;  
    dfs(x+1, channels+1);  
    vis[x] = 0;  
}  
int main()  
{  
    while (1 == scanf("%d", &amp;n) &amp;&amp; n){  
        memset(map, 0, sizeof(map));  
        memset(vis, 0, sizeof(vis));  

        for (int i = 0; i &lt; n; i++){  
            scanf("%s", str);  
            int s = str[0] - 'A';  
            for (int j = 2; str[j]; j++)  
                map[s][str[j]-'A'] = map[str[j]-'A'][s] = true;  
        }  

        ans = 999999;  
        vis[0] = 1;  
        dfs(1, 1);  

        printf("%d channel%s needed.n", ans, ans==1?"":"s");  

    }  
    return 0;  
}</pre>  

