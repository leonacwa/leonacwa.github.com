---
layout: post
title: NOIP 2009  sudoku 靶形数独 (DFS 仅仅得到65分)
category : acmicpc
tags : [noip]
---

/* NOIP 2009 sudoku 靶形数独  
DFS。把分数表打印出来，然后就没什么好说的了.  
但是悲剧的WA了差不多一半的测试点，这个DFS太单纯啊。  

NOIp2009是我无法忘记的回忆，因为那代表我的不成熟，不理智。  
那一次其实可以骗到大概60分左右的，但是我脑残没有骗，我记得我当时写的最后一题那叫一个垃圾啊。  
不过当我发布这篇日志的时候，最后一题仅仅得了65分，杯具！标程怎么优化的如此强悍呢，写得又是那么难懂。  

下面是我的65分代码：<!--more-->  
*/  
<pre>#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  

const int score[9][9] ={  
{6, 6, 6, 6, 6, 6, 6, 6, 6},  
{6, 7, 7, 7, 7, 7, 7, 7, 6},  
{6, 7, 8, 8, 8, 8, 8, 7, 6},  
{6, 7, 8, 9, 9, 9, 8, 7, 6},  
{6, 7, 8, 9, 10,9, 8, 7, 6},  
{6, 7, 8, 9, 9, 9, 8, 7, 6},  
{6, 7, 8, 8, 8, 8, 8, 7, 6},  
{6, 7, 7, 7, 7, 7, 7, 7, 6},  
{6, 6, 6, 6, 6, 6, 6, 6, 6}  
};  

struct Pos{  
    int x, y;  
};  
Pos p[9*9+1], pt;  
int pi;  

int sd[9][32];  
bool sq[3][3][10], r[9][10], c[9][10];  
int sum, max;  

void dfs(int s, int sum)  
{  
    if (s &gt;= pi){  
        if (max &lt; sum)  
            max = sum;  
        return;  
    }  

    for (int i = 9; i &gt;= 1; i--)  
    if (!sq[p[s].x/3][p[s].y/3][i] &amp;&amp; !r[p[s].x][i] &amp;&amp; !c[p[s].y][i]){  

        sd[p[s].x][p[s].y] = i;  
        sq[p[s].x/3][p[s].y/3][i] = true;  
        r[p[s].x][i] = true;  
        c[p[s].y][i] = true;  

        dfs(s+1, sum+score[p[s].x][p[s].y]*i);  

        sd[p[s].x][p[s].y] = 0;  
        sq[p[s].x/3][p[s].y/3][i] = false;  
        r[p[s].x][i] = false;  
        c[p[s].y][i] = false;  
    }  
}  
int main()  
{  
    freopen("sudoku.in", "r", stdin);  
    freopen("sudoku.out", "w", stdout);  

    memset(sq, 0, sizeof(sq));  
    memset(r, 0, sizeof(r));  
    memset(c, 0, sizeof(c));  

    pi = 0; sum = 0;  

    for (int i = 0; i &lt; 9; i++){  

        for (int j = 0; j &lt; 9; j++){  
            scanf("%d", &amp;sd[i][j]);  

            sq[i/3][j/3][sd[i][j]] = true;  
            r[i][sd[i][j]] = true;  
            c[j][sd[i][j]] = true;  

            sum += sd[i][j]*score[i][j];  

            if (sd[i][j] == 0){  
                p[pi].x = i;  
                p[pi].y = j;  
                pi++;  
            }  
        }  
    }  

    for (int i = 0, k; i &lt; pi-1; i++){  
        k = i;  
        for (int j = i+1; j &lt; pi; j++){  
             // 人品吗？改为分数低的在前，就过了好多点  
            if (score[p[k].x][p[k].y] &gt; score[p[j].x][p[j].y])  
                k = j;  
        }  
        pt = p[i];  
        p[i] = p[k];  
        p[k] = pt;  
    }  

    max = -1;  
    for (int i = 9; i &gt;= 1; i--){  
    if (!sq[p[0].x/3][p[0].y/3][i] &amp;&amp; !r[p[0].x][i] &amp;&amp; !c[p[0].y][i]){  

        sd[p[0].x][p[0].y] = i;  
        sq[p[0].x/3][p[0].y/3][i] = true;  
        r[p[0].x][i] = true;  
        c[p[0].y][i] = true;  

        dfs(1, sum+score[p[0].x][p[0].y]*i);  

        sd[p[0].x][p[0].y] = 0;  
        sq[p[0].x/3][p[0].y/3][i] = false;  
        r[p[0].x][i] = false;  
        c[p[0].y][i] = false;  
    }  
    }  

    printf("%dn", max);  

    fclose(stdin);  
    fclose(stdout);  

    return 0;  
}</pre>  
