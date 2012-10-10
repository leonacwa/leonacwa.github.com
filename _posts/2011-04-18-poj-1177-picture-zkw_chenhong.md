---
layout: post
title: poj 1177 Picture (zkw线段树 and 陈宏的论文)
category : acmicpc
tags : [acmicpc, poj]
---

<pre>/* poj 1177 Picture  
题意：一些矩形随意的放在一个xOy坐标上，并保证他们的竖边与y轴平行，横边与x轴平行，问你他们构成的最终图形的边长是多少。  
使用zkw的线段树，  
参照了陈宏的论文，真佩服他的思路！  

我必须进行深刻的检讨！  
这题我写线段树写废了，线段树真他妈的他对付啊！  
插入删除区间l,r时，l和r必须一致传递下去，不能改变，我中途改了，导致久久搞不清，Fuck的线段树。  
记住，操作的区间l和r不能更改！！必须一致传递下去，要么你要传l和r的中间。  
以上是我写普通版线段树时犯的严重错误。  

下面就是我使用zkw线段树做出来的，很爽吧！  
代码中，每一个Y轴的单位区间看作是一个叶子节点处理，即坐标[y,y+1]的单位区间，按zkw同理，最外围的两个仅仅用于当做开区间。  
之后就看更改值的时候的操作了，图：？？  

去掉占满行的注释、空行、保证代码的工整，估计就130行代码吧。  
* 3640K	32MS  
*/</pre>  
<!--more-->  
<pre>#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  
#include &lt;iostream&gt;  
#include &lt;algorithm&gt;  
using namespace std;  

const int maxn =   20000;  
const int offset = 10000+1;  

struct Node{ /*因为zkw线段树的特点，故能舍弃区间标志l，r，每个节点仅仅储存有用的数据，仅有一个缺点，空间占用比普通线段树多，但是时间消耗更少了*/  
    int cover, sum, seg;  
    bool lcover, rcover;  
};  

struct YLine{  
    int x, y1, y2;  
    bool first;  
    /*  
    bool operator &lt; (Line&amp; line1) const //参照网上的代码，这样爽，不知道会不会占用太多的内存   
    {  
        return x &lt; line1.x;  
    } */  
    // 下面这个应该不会占用太多的内存吧  
    friend bool operator &lt; (const struct YLine&amp; yline1, const struct YLine&amp; yline2);  
};  

bool operator &lt; (const struct YLine&amp; yline1, const struct YLine&amp; yline2)  
{  
    return yline1.x &lt; yline2.x;  
}  
//********  
int a[maxn*2+2]; //   
int h[maxn*2+2]; //   
int total;  
//*///******  

struct Node T[maxn*8];  
struct YLine yline[maxn*2+2];  
int M;  

void make_tree() // 由于zkw线段树本身的性质，清零就是它的工作  
{  
    memset(T, 0, sizeof(struct Node)*maxn*8);  
}  
// 这个是合并版的，简洁多了,粗略算来只有30行代码  
void change(int l, int r, bool val)  
{  
    int i, j;  
    for (j = l; j &lt; r; j++){  
        i = j + M;  
        T[i].cover += (val?1:-1);  
        if (T[i].cover &gt; 0){  
            T[i].sum = h[j+1] - h[j];  
            T[i].seg = 1;  
            T[i].lcover = T[i].rcover =true;  
        }  
        else{  
            T[i].sum = 0;  
            T[i].seg = 0;  
            T[i].lcover = T[i].rcover = false;  
        }  
        while (i &gt; 1){  
            i &gt;&gt;= 1;  
            // 下面这个代码精髓，自己慢慢体会吧  
            T[i].sum = T[i+i].sum + T[i+i+1].sum;  
            T[i].seg = T[i+i].seg + T[i+i+1].seg - T[i+i].rcover * T[i+i+1].lcover;  
            T[i].lcover = T[i+i].lcover;  
            T[i].rcover = T[i+i+1].rcover;  
        }  
    }  
}   

int main()  
{  
    int n, x1, x2, y1, y2, i;  
    int ans, lastsum;  

    memset(a, 0, sizeof(int)*(maxn*2+2));  
    memset(h, 0, sizeof(int)*(maxn*2+2));  
    total = 0;  

    scanf("%d", &amp;n);  
    for (i = 0; i &lt; n; i++){  
        scanf("%d %d %d %d", &amp;x1, &amp;y1, &amp;x2, &amp;y2);  
        // 对Y 坐标进行离散化准备工作  
        if (a[y1+offset] == 0){  
            h[++total] = y1;  
            a[y1+offset] = 1;  
        }  

        if (a[y2+offset] == 0){  
            h[++total] = y2;  
            a[y2+offset] = 1;  
        }  
        // 记录下每一条竖线  
        yline[i*2].x  = x1;  
        yline[i*2].y1 = y1;  
        yline[i*2].y2 = y2;  
        yline[i*2].first = true;  

        yline[i*2+1].x  = x2;  
        yline[i*2+1].y1 = y1;  
        yline[i*2+1].y2 = y2;  
        yline[i*2+1].first = false;  
    }  

    sort(yline, yline+n*2);  

    sort(h+1, h+1+total);  
    for (i = 1; i &lt;= total; i++)  // Y 坐标  
        a[h[i]+offset] = i;  

    for (M = 1; M &lt; (total+2); M &lt;&lt;= 1)  // 用于确定底层存放元素最少需要多少空间，要保证是2的幂次方  
    ; //  ; 号加在这里的目的是为了可读性，知道这个for干什么  

    make_tree();   

    ans = 0;  
    lastsum = 0;  

    for (i = 0; i &lt; 2*n-1; i++)    {  
        change(a[yline[i].y1+offset], a[yline[i].y2+offset], yline[i].first);  
        // 下面这个代码精髓，自己慢慢体会吧  
        ans += T[1].seg*(yline[i+1].x - yline[i].x)*2;  
        ans += abs(T[1].sum - lastsum);  
        lastsum = T[1].sum;  
    }  
    //  最后一条竖线要额外处理  
    change(a[yline[2*n-1].y1+offset], a[yline[2*n-1].y2+offset], yline[2*n-1].first);  
    ans += abs(T[1].sum - lastsum);  

    printf("%dn", ans);  

    return 0;  
}</pre>  
