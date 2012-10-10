---
layout: post
title: poj 3083 Children of the Candy Corn (DFS  BFS 靠墙走)
category : acmicpc
tags : [acmicpc, bfs, dfs]
---

<pre>/* poj 3083 Children of the Candy Corn
   题意:给一个棋盘，有些地方有障碍，给出起点S，终点E。
   求出分别靠左走，靠右走，最短路到达E点的距离。

   关键是靠墙走的实现！

这是关键数组：   
  const int left[4][2] =  { {-1,0}, {0, 1}, {1, 0}, {0,-1} }; /// 方向数组乃是精髓
  const int right[4][2] = { {-1,0}, {0,-1}, {1, 0}, {0, 1} }; ///
DFS时取的方向：
  op2 = (i+op+3)%4;  /// (op+3)%4 乃是靠墙精髓

注意一下left，right数组的数据，这个很关键，可以自己模拟一下，会发现这个设计真的很巧啊！

代码：
*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

const int left[4][2] =  { {-1,0}, {0, 1}, {1, 0}, {0,-1} }; /// 方向数组乃是精髓
const int right[4][2] = { {-1,0}, {0,-1}, {1, 0}, {0, 1} }; ///

struct Q{
    char x, y;
    int step;
};
Q q[4096], S, E, qt;
bool vis[64][64];

char mm[64][64];
int t, r, c;

int dfs(int x, int y, int op, const int dir[][2])
{   //printf("%d %dn", x, y);
    if (mm[x][y] == 'E'){        
        return 1;
    }
    int xt, yt, op2, step = 0;  
    for (int i = 0; i &lt; 4; i++){
        op2 = (i+op+3)%4;  /// (op+3)%4 乃是靠墙精髓
        xt = x + dir[op2][0];
        yt = y + dir[op2][1];
        if (0 &lt;= xt &amp;&amp; xt &lt; r &amp;&amp; 0 &lt;= yt &amp;&amp; yt &lt; c &amp;&amp;
            (mm[xt][yt] == '.' || mm[xt][yt] == 'E')){
            return step = dfs(xt, yt, op2, dir) + 1;
        }
    }
    return step;
}
int bfs()
{
    memset(vis, false, sizeof(vis));
    int head = 0, tail = 1;
    q[0].x = S.x;
    q[0].y = S.y;
    q[0].step = 1;
    vis[S.x][S.y] = true;

    while (head &lt; tail){        
        for (int i = 0; i &lt; 4; i++){
            qt = q[head];
            qt.x += right[i][0];
            qt.y += right[i][1];
            qt.step++;
            if (!vis[qt.x][qt.y] &amp;&amp; (mm[qt.x][qt.y] == '.' || mm[qt.x][qt.y] == 'E')){
                vis[qt.x][qt.y] = true;
                q[tail++] = qt;
                if (mm[qt.x][qt.y] == 'E'){
                    return qt.step;
                }
            }
        }
        head++;
    }
    return -1;
}

int main()
{
    scanf("%d", &amp;t);
    while (t--){
        scanf("%d %d", &amp;c, &amp;r);
        for (int i = 0; i &lt; r; i++){
            scanf("%s", mm[i]); //printf("%sn", mm[i]);
            for (int j = 0; mm[i][j]; j++){
                if (mm[i][j] == 'S'){
                    S.x = i;
                    S.y = j;
                }
            }
        }
        printf("%d %d %dn", dfs(S.x, S.y, 0, left), dfs(S.x, S.y, 0, right), bfs());
    }
    return 0;
}</pre>
