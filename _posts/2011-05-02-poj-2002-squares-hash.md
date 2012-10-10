---
layout: post
title: poj 2002 Squares (哈希)
category: acm-icpc
tags: [acm-icpc, poj]
---

<pre>/*
  poj 2002 Squares
  题意：给一些点，问你用这些点能够构成多少个不同的正方形。

  枚举两个点，然后查找另外两个点。
  先按他们的坐标从小到大排序，x优先，之后是y。
  枚举正方形最左边的的两点坐标，然后计算出另外两点，这个是几何知识，自己想一下吧。
  其实也很容易想的，画一下图。
  网上都只是列出公式，没有讲解，说是从那一边开始的。我这里是从最左边的边找另外两点。

  查找可以使用二分或者哈希。
  下面的代码是哈希法写的。

*/</pre>
<!--more-->
<pre>#include &lt;stdio.h&gt;
#include &lt;string.h&gt;
#include &lt;iostream&gt;
#include &lt;algorithm&gt;
using namespace std;

const int M = 1031;
struct Point{
    int x, y;
};
Point p[1024];
int n;
int hash[M+8], next[1024];

bool cmp(const Point&amp; a, const Point&amp; b)
{
    if (a.x != b.x)
        return a.x &lt; b.x;
    return a.y &lt; b.y;
}
int hashcode(Point &amp;tp)
{
    // 以下是速度测试
    ///2002	Accepted	152K	860MS	C++	1980B	2011-05-02 00:49:34
    ///return abs(M+M+(tp.x)*M/10 + tp.y) % M;
    ///2002	Accepted	152K	844MS	C++	2150B	2011-05-02 00:51:42
    //return abs((tp.x)*M/11 + tp.y) % M;
    ///2002	Accepted	152K	719MS	C++	2192B	2011-05-02 00:52:38
    return abs(tp.x + tp.y) % M;

}
bool hash_search(Point &amp;tp)
{
    int key = hashcode(tp); 
    int i = hash[key];
    while (i != -1){
        if (tp.x == p[i].x &amp;&amp; tp.y == p[i].y)
            return true;
        i = next[i];
    }
    return false;
}
void insert_hash(int i)
{
    int key = hashcode(p[i]);
    next[i] = hash[key];
    hash[key] = i;
}
int main()
{
    Point p3, p4;                
    int dx, dy, ans;
    while (1 == scanf("%d", &amp;n) &amp;&amp; n){
        memset(hash, -1, sizeof(hash));
        memset(next, -1, sizeof(next));
        for (int i = 0; i &lt; n; i++){
            scanf("%d %d", &amp;p[i].x, &amp;p[i].y);
        }
        sort(p, p+n, cmp);
        for (int i = 0; i &lt; n ; i++) /// 排完后进行哈希
            insert_hash(i);

        ans = 0;
        for (int i = 0; i &lt; n; i++){
            for (int j = i+1; j &lt; n; j++){
                int dx = p[j].x - p[i].x;
                int dy = p[j].y - p[i].y;
                p3.x = p[i].x + dy;
                p3.y = p[i].y - dx;
                if (hash_search(p3)){
                    p4.x = p[j].x + dy;
                    p4.y = p[j].y - dx;
                    if (hash_search(p4))
                        ans++;               
                }
            }
        }
        printf("%dn", ans/2);
    }
    return 0;
}</pre>
