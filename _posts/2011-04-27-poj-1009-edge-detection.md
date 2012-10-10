---
layout: post
title: poj 1009 Edge Detection (对暴力的优化)
category : acmicpc
tags : [acmicpc, poj, optimization]
---

<pre>/*   
  poj 1009 Edge Detection  

  题意：给一张图，用每个像素与周围8个像素值差的最大绝对值代替这个像素，构成一张新图。  
  并按照输入数据的格式输出答案。  

  10^9， 明显不能暴力。  
  只能找优化了。  
  因为最多只有1000对的(像素值，个数)，所以会有很多重复计算，要减去重复计算。  
  我的优化是：  
  1.三行重复的优化。  
  2.多行重复数据的优化。  
  我花了一节课的时间想这个优化，然后又花了两个小时敲代码，真他妈的废啊，bug多啊。  
  我发现自己的表达能力有限啊，都不知道如何表述解决方法。  
  网上好的解题报告挺多的，又配有图。  
  我查过解题报告，不过也只是知道要优化，因为当时我已经烦了，看不下解题报告，只看见优化。  
  所以，建议大家自己想优化，因为并不难，只是编码麻烦。  

  所以我认为这是难题,及其考验人的编码能力。  
  去掉一些重复部分，我写了7k的代码，真TMD多啊！  
  再加上一些解释什么的。10k了，杯具啊~！  

  写了太多的函数，也调用太多函数，外加有些考虑不周，bug频出。  

  各种get函数杯具，尤其是getUp,getDown之类的，容易WA。  

  C语言版情况：  
  1009	Accepted	340K	16MS	G++	8791B	2011-04-27 13:04:43  
  1009	Accepted	112K	16MS	C++	8792B	2011-04-27 13:05:56  
  C++，使用C++的max，abs，min库函数 #include &lt;iostream&gt; &lt;algorithm&gt;  
  1009	Accepted	648K	0MS	G++	8598B	2011-04-27 12:59:53 使用标准库  
  看着时间和空间，杯具啊  
看看写了很多的代码：  
*/</pre>  
<!--more-->  
<pre>#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  

struct Pair{  
    int a, b, s;  
};  
struct Pair p[1024];  
int w, ps, pos, pre, pres, totalLen;  

int abs(int a)  
{  
    return a&gt;=0?a:-a;  
}  
int max(int a, int b)  
{  
    return a&gt;=b?a:b;  
}  
int min(int a, int b)  
{  
    return a&lt;=b?a:b;  
}  

int getUp(int pos)  
{  
    int tpos = pos - w;  
    if (tpos &lt; 0)  
        tpos = pos;  
    return tpos;  
}  
int getDown(int pos)  
{  
    int tpos = pos + w;  
    if (tpos &gt;= totalLen)  
        tpos = pos;  
    return tpos;  
}  
int getLeft(int pos)  
{  
    int tpos = pos - 1;  
    if (tpos/w != pos/w)  
        tpos = pos;  
    return tpos;  
}  
int getRight(int pos)  
{  
    int tpos = pos + 1;  
    if (tpos/w != pos/w || tpos &gt;= totalLen)  
        tpos = pos;  
    return tpos;  
}  
int getLeftUp(int pos)  
{  
    int tpos = pos - w - 1;  
    if (tpos &lt; 0 || tpos/w+1 != pos/w)  
        tpos = pos;  
    return tpos;  
}  
int getLeftDown(int pos)  
{  
    int tpos = pos + w - 1;  
    if (tpos/w == pos/w || tpos &gt;= totalLen)  
        tpos = pos;  
    return tpos;  
}  
int getRightUp(int pos)  
{  
    int tpos = pos - w + 1;  
    if (tpos &lt; 0 || tpos/w == pos/w)  
        tpos = pos;  
    return tpos;  
}  
int getRightDown(int pos)  
{  
    int tpos = pos + w + 1;  
    if (tpos &gt;= totalLen || pos/w+1 != tpos/w)  
        tpos = pos;  
    return tpos;  
}  
int getValue(int pos) /// binary search  
{   //printf("getValue: %dn", pos);  
    pos++;  
    int l = 1, r = ps-1, mid = ps / 2;  
    while (l &lt; r){  
        if (p[mid-1].s &lt; pos &amp;&amp; pos &lt;= p[mid].s)  
            break;  
        if (pos &lt;= p[mid].s)  
            r = mid;  
        else  
            l = mid+1;  
        mid =  (l+r) / 2; //printf("getValue mid : #%d %d %d %dn", p[mid].s, p[l].s, pos, p[r].s);  
    }  
    return p[mid].a;  
}  
int getLenPos(int pos) /// binary search , 得到某个位置(0..)的相同值的最长  
{ //printf("getLenPos %dn", pos);  
    pos++;  
    int l = 1, r = ps-1, mid = ps / 2;  
    while (l &lt; r){  
        if (p[mid-1].s &lt; pos &amp;&amp; pos &lt;= p[mid].s)  
            break;  
        if (pos &lt;= p[mid].s)  
            r = mid;  
        else  
            l = mid + 1;  
        mid =  (l+r) / 2;  
    }  
    return p[mid].s;  
}  

int getLen(int pos)  
{  
    int tpos = getLenPos(pos) - 1;  
    if (pos/w != tpos/w)  
        tpos =  pos + w - pos%w - 1;  
    return tpos - pos + 1;    
}  

int getMax(int pos)  
{  
    int value = getValue(pos);  
    int a = 0;  
    /*  /// 这个是不判重的取最大值  
    /// 1009	Accepted	648K	16MS	G++	7500B	2011-04-27 08:01:05  
    /// 耗时增加啊  
    a = abs(value - getValue(getUp(pos)));  
    a = max(a, abs(value  - getValue(getDown(pos))));  
    a = max(a, abs(value  - getValue(getLeft(pos))));  
    a = max(a, abs(value  - getValue(getRight(pos))));  

    a = max(a, abs(value  - getValue(getLeftUp(pos))));  
    a = max(a, abs(value  - getValue(getLeftDown(pos))));  
    a = max(a, abs(value  - getValue(getRightUp(pos))));  
    a = max(a, abs(value  - getValue(getRightDown(pos))));  
    */  
    /// 下面是加入一些判重优化，二分查找也是花时间的 C++语言的时候  
    /// 1009	Accepted	648K	0MS	G++	8598B	2011-04-27 12:59:53  
    /// 这就是效率啊  
    int tpos;   
    tpos = getUp(pos);  
    if (pos != tpos)  
        a = abs(value - getValue(tpos));        
    tpos = getDown(pos);  
    if (pos != tpos)  
        a = max(a, abs(value  - getValue(tpos)));  
    tpos = getLeft(pos);  
    if (pos != tpos)  
        a = max(a, abs(value  - getValue(tpos)));  
    tpos = getRight(pos);  
    if (pos != tpos)  
        a = max(a, abs(value  - getValue(tpos)));  
    tpos = getLeftUp(pos);  
    if (pos != tpos)  
        a = max(a, abs(value  - getValue(tpos)));  
    tpos = getLeftDown(pos);  
    if (pos != tpos)  
        a = max(a, abs(value  - getValue(tpos)));  
    tpos = getRightUp(pos);  
    if (pos != tpos)  
        a = max(a, abs(value  - getValue(tpos)));  
    tpos = getRightDown(pos);  
    if (pos != tpos)  
        a = max(a, abs(value  - getValue(tpos)));  

    return a;  
}  
void test(int pos)  
{  
    printf("test  %d : %dn", pos, getMax(pos));  
    printf("u%d d%d l%d r%d lu%d ld%d ru%d rd%dn",   
           getUp(pos), getDown(pos), getLeft(pos), getRight(pos),   
           getLeftUp(pos), getLeftDown(pos), getRightUp(pos), getRightDown(pos));  

}  
int getMidMax(int pos)  
{  
    int value = getValue(pos);  
    int a = abs(value - getValue(getUp(pos)));  
    return max(a, abs(value - getValue(getDown(pos))));  
}  
int main()  
{  
    while (1 == scanf("%d", &amp;w) &amp;&amp; w){  
        int a, b, c;  
        p[0].s = 0;  
        ps = 1;  
        while (2 == scanf("%d %d", &amp;a, &amp;b) &amp;&amp; !(a==0 &amp;&amp; b==0)){ /// WA这个!(a==0 &amp;&amp; b==0)，没有弄好题目啊  
            p[ps].a = a;  
            p[ps].b = b;  
            p[ps].s = p[ps-1].s + b;  
            ps++;  
        }  

        totalLen = p[ps-1].s;  

        //test(9);  
       //printf("totalLen:%dn", totalLen);  

        printf("%dn", w);  

        int value = p[1].a;//getValue(0);  
        pres = 1;  
        pre = abs(value - getValue(getDown(0)));  
        pre = max(pre, abs(value - getValue(getRight(0))));  
        pre = max(pre, abs(value - getValue(getRightDown(0))));  
        //printf("pre:%d %dn", pre, pres);  
        pos = 1;  
        int pos_len, up_len, down_len, min_len;  
        while (pos &lt; totalLen){  
            /// 考虑很长很长的一段数字，跨越了很多行  
            if (pos-w &gt;= 0 &amp;&amp; pos % w == 0 &amp;&amp;   
                (min_len=getLenPos(pos-w)) == getLenPos(pos)){  

                min_len -= min_len % w;  
                if (min_len - pos &gt;= 2*w){  
                    a = getMax(pos);  
                    b = min_len - pos - w;  
                    if (pre == a){  
                        pres += b;  
                    }  
                    else {  
                        printf("%d %dn", pre, pres);  
                        pre = a;  
                        pres = b;  
                    }  
                    pos += b;  
                } /// very long  
            }  
            /// 一般的  
            pos_len = getLen(pos);  
            up_len = getLen(getUp(pos));  
            down_len = getLen(getDown(pos));  
            min_len = min(pos_len, min(up_len, down_len));  

            if (min_len &lt;= 0){                
                while (1)printf("error min_len:%d  pos:%dn", min_len, pos);  
            }  
            else if (min_len == 1){  

                a = getMax(pos);  
               // printf("1:%d _ %dn", pos, a);  
                if (a == pre){  
                    pres++;  
                }  
                else {  
                    printf("%d %dn", pre, pres);  
                    pre = a;  
                    pres = 1;  
                }  
                pos++;  
            }  
            else if (min_len == 2){  

                a = getMax(pos);  
                b = getMax(getRight(pos));  
               //printf("2:%d  _ %d %dn", pos, a, b);  
                if (a == pre){ /// a  
                    pres++;  
                }  
                else {  
                    printf("%d %dn", pre, pres);  
                    pre = a;  
                    pres = 1;  
                }  
                if (b == pre){ /// b  
                    pres++;  
                }  
                else {  
                    printf("%d %dn", pre, pres);  
                    pre = b;  
                    pres = 1;  
                }  
                pos += 2;  
            }  
            else { /// 3列以上 我发现，随便复制代码容易杯具，让我多调试了半个小时，~~~~(&gt;_&lt;)~~~~   

                a = getMax(pos);  
                b = getMax(pos+min_len-1);  
                c = getMidMax(pos+1);  
                //printf("3:%d %d _ %d %d %dn", pos, min_len, a, c, b);  
                if (a == pre){ /// a  
                    pres++;  
                }  
                else {  
                    printf("%d %dn", pre, pres);  
                    pre = a;  
                    pres = 1;  
                }  
                if (c == pre){ /// c  
                    pres += min_len - 2;  
                }  
                else {  
                    printf("%d %dn", pre, pres);  
                    pre = c;  
                    pres = min_len - 2;  
                }  
                if (b == pre){ /// b  
                    pres++;  
                }  
                else {  
                    printf("%d %dn", pre, pres);  
                    pre = b;  
                    pres = 1;  
                }  
                pos += min_len;  
            }  
        } /// while (pos &lt; totalLen)  
        printf("%d %dn0 0n", pre, pres);        
    }  
    printf("0n");  
    return 0;  
}</pre>  
