---
layout: post
title: poj 2503 Babelfish(哈希)
category : acmicpc
tags : [acmicpc, poj]
---

<pre>// poj 2503 Babelfish  
/*  
   题意：给你一个A语言到B语言的映射的字典库，然后让你翻译B语言的单词为A语言，  
　　　没有翻译成功的输出eh。  
  这题就是一个查找，关键是字典库的的设计，有哈希和trie树两种方法做。  

  关键是字符串的哈希函数，有现成的，直接抄就可以，不行就用C++的map，好像是这个把，我没用过。  
  然后就是输入了，由于有空行和空格，所以要控制好。用gets输入整行，然后分割.  
  赞一个这个哈希函数，用于UNINX的ELF可执行文件：  

int ELFhash(char * key)  
{  
    unsigned int h = 0;  
    while (*key){  
        h = (h &lt;&lt; 4) + *key++;  
        unsigned int g = h &amp; 0xf0000000L;  
        if (g) h ^= g &gt;&gt; 24;  
        h &amp;= ~g;  
    }  
    return h % prime;  
}  

*/</pre>  
<!--more-->  
<pre>#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  

const int maxn = 100000+1;  
const int prime = 120721;  

struct Hash{  
    char *s1, *s2;  
    Hash *next;  
};  

Hash *hash[prime+1], *ph;  
char buf[maxn*2][12];  
int key, p;  

int ELFhash(char * key)  
{  
    unsigned int h = 0;  
    while (*key){  
        h = (h &lt;&lt; 4) + *key++;  
        unsigned int g = h &amp; 0xf0000000L;  
        if (g) h ^= g &gt;&gt; 24;  
        h &amp;= ~g;  
    }  
    return h % prime;  
}  

int main()  
{  
    int i, j;  
    key = 0;  
    char str[64], *b;  

    while (gets(str) &amp;&amp; strlen(str)){ //printf("%s:", str);  

        i = 0; j = 0;  
        for (;str[i] != ' ';i++)  
            buf[key][j++] = str[i];  
        buf[key][j] = 0;  

        for (;str[i] == ' '; i++)  
        ;  
        //printf("%s", &amp;str[i]);  
        j = 0;  
        for (;str[i] != ' ' &amp;&amp; str[i];i++)  
            buf[key+1][j++] = str[i];  

        buf[key+1][j] = 0;  

     //  printf("%s %s.  ", buf[key], buf[key+1]);  

        p = ELFhash(buf[key+1]); // printf("key:%dn", p);  
        ph = new Hash;  
        ph-&gt;s1 = buf[key];  
        ph-&gt;s2 = buf[key+1];  
        ph-&gt;next = hash[p];  
        hash[p] = ph;  
        key += 2;  

        str[0] = 0;  
    }  

    while (1 == scanf("n%s", str)){//  printf("%s _&gt; ", str);  
        p = ELFhash(str);  
        ph = hash[p];  
        while (ph){  
            if (0 == strcmp(str, ph-&gt;s2)){  
                printf("%sn", ph-&gt;s1);  
                break;  
            }  
            ph = ph-&gt;next;  
        }  
        if (!ph)  
            printf("ehn");  
    }  

    return 0;  
}</pre>  
