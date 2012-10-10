---
layout: post
title: poj 2503 Babelfish (trie树)
category : acmicpc
tags : [acmicpc, poj]
---

<pre>// poj 2503 Babelfish    
/*    
  题意：给你一个A语言到B语言的映射的字典库，然后让你翻译B语言的单词为A语言，    
　　　没有翻译成功的输出eh。    
  这题就是一个查找，关键是字典库的的设计，有哈希和trie树两种方法做。    
    
  看一下我的这个trie树吧，参照黑书上的提示做的二叉树版trie树：左儿子右兄弟。    
*/</pre>    
<!--more-->    
<pre>#include &lt;stdio.h&gt;    
#include &lt;string.h&gt;    
    
const int maxn = 100000+1;    
const int prime = 120721;    
    
struct Trie{    
    char c;    
    int key;    
    Trie *l, *r;    
};    
    
Trie TrieBuf[maxn*2*12];    
int trien;    
Trie* trie;    
    
char buf[maxn*2][12];    
int key;    
    
void ins(char*s) // 为什么trie树写得这么失败啊    
{    
    if (trie == NULL){    
        trie = &amp;TrieBuf[trien++];    
        trie-&gt;c = *s;    
        trie-&gt;key = 0;    
        trie-&gt;l = trie-&gt;r = 0;    
    }    
    Trie *p = trie, **pre, *father;    
    while (*s){    
        if (p &amp;&amp; p-&gt;c == *s){    
            ++s;    
            father = p;    
            pre = &amp;(p-&gt;l);    
            p = p-&gt;l;    
        }    
        else if (p){    
            father = p;    
            pre = &amp;(p-&gt;r);    
            p = p-&gt;r;    
        }    
        else{    
            p = &amp;TrieBuf[trien++];    
            p-&gt;c = *s++;    
            p-&gt;key = 0;    
            p-&gt;l = p-&gt;r = 0;    
    
            *pre = p;    
    
            father = p; // 是这个位置失败，忘记更新了    
            pre = &amp;(p-&gt;l); //trie还是写得杯具    
    
            p = p-&gt;l;    
        }    
    }    
    
    if (father-&gt;key == 0)    
        father-&gt;key = key+1;    
}    
    
int search(char*s)    
{    
    Trie *p = trie, *father;    
    while (*s &amp;&amp; p){    
        if (p-&gt;c == *s){    
            ++s;    
            father = p;    
            p = p-&gt;l;    
        }    
        else if (p){    
            father = p;    
            p = p-&gt;r;    
        }    
        else{    
            return -1;    
        }    
    }    
    if (*s == 0)    
        return father-&gt;key;    
    return -1;    
}    
    
int main()    
{    
    int i, j;    
    key = 0;    
    trien = 0;    
    char str[64], *b;    
    
    while (gets(str) &amp;&amp; strlen(str)){     
    
        i = 0; j = 0;    
        for (;str[i] != ' ';i++)    
            buf[key][j++] = str[i];    
        buf[key][j] = 0;    
    
        for (;str[i] == ' '; i++)    
        ;    
    
        j = 0;    
        for (;str[i] != ' ' &amp;&amp; str[i];i++)    
            buf[key+1][j++] = str[i];    
        buf[key+1][j] = 0;    
    
        ins(buf[key+1]);    
       // printf("new key:%dn", search(buf[key+1]));    
        key += 2;    
    
        str[0] = 0;    
    }    
    
    while (1 == scanf("%s", str)){    
       int p = search(str); //  printf(" key %d:", p);    
       if (p != -1)    
           printf("%sn", buf[p-1]);    
       else    
           printf("ehn");    
    }    
    
    return 0;    
}</pre>