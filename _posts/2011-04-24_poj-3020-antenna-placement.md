---
layout: post
title: poj 3020 Antenna Placement (二分最大匹配)
category: acm
categories: [acm]
tags: [acm, poj, %e4%ba%8c%e5%88%86%e5%9b%be%e5%8c%b9%e9%85%8d, %e5%bf%83%e5%be%97, %e8%a7%a3%e9%a2%98%e6%8a%a5%e5%91%8a]
by: wp2md(php)
---

<pre>/*
  poj 3020 Antenna Placement
  题意：给一个矩形地图，地图上有一些*点，代表城市。要放置基站，使得所有城市被覆盖。
  每个基站只能覆盖两个相邻的城市，上下或作左右相邻，问最少需要多少个基站？

  每个基站最多只能覆盖两个，所以求出最大的相邻基站匹配数，说白了就是二分最大匹配。
  因为建图的时候把所有顶点放在了左边和右边，所以求出的最大匹配数是两倍的。
  建图关键：每个城市用一个号码编号。

  答案：城市数n - 最大匹配数 / 2。

*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

char str[64][64];
bool map[64*64][64*64]; // city
int num[64][64]; // coodrate
bool mk[64*64]; // city
int match[64*64]; // city
int t, h, w, key;

bool dfs(int x)
{
    for (int i = 0; i &lt; key; i++){
        if (map[x][i] &amp;&amp; !mk[i]){
            mk[i] = true;
            if (match[i] == -1 or dfs(match[i])){
                match[i] = x;
                return true;
            }
        }
    }
    return false;
}
int hungary()
{
    int ret = 0;
    memset(match, -1, sizeof(match));
    for (int i = 0; i &lt; key; i++){
        memset(mk, false, sizeof(mk));
        mk[i] = true;
        ret += dfs(i)?1:0;
    }
    return ret;
}
int main()
{
    int x, y;
    scanf("%d", &amp;t);
    while (t--){
        key = 0;
        scanf("%d %d", &amp;h, &amp;w);
        for (int i = 0; i &lt; h; i++){
            scanf("%s", str[i]);
            for (int j = 0; j &lt; w; j++)
                if (str[i][j] == '*')
                    num[i][j] = key++;
        }
        //printf("key:%dn", key);
        memset(map, false, sizeof(map));
        for (int i = 0; i &lt; h; i++){
            for (int j = 0; j &lt; w; j++)
                if (str[i][j] == '*'){
                    if (i &gt; 0 &amp;&amp; str[i-1][j] == '*')
                        map[num[i][j]][num[i-1][j]] = true;//map[num[i-1][j]][num[i][j]] = true;
                    if (i+1 &lt; h &amp;&amp; str[i+1][j] == '*')
                        map[num[i][j]][num[i+1][j]] = true;//map[num[i+1][j]][num[i][j]] = true;
                    if (j &gt; 0 &amp;&amp; str[i][j-1] == '*')
                        map[num[i][j]][num[i][j-1]] = true;//map[num[i][j-1]][num[i][j]] = true;
                    if (j+1 &lt; w &amp;&amp; str[i][j+1] == '*')
                        map[num[i][j]][num[i][j+1]] = true;//map[num[i][j+1]][num[i][j]] = true;
                }
        }

        printf("%dn", key - hungary() / 2);

    }
    return 0;
}</pre>
