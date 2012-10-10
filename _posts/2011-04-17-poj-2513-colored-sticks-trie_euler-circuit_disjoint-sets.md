---
layout: post
title: poj 2513 Colored Sticks (trie树 欧拉回路 并查集)
category : acmicpc
tags : [acmicpc, poj]
---

题意：给一些两端有颜色的棍子，按照同色的端点连接在一起，问所给的棍子能否组成一个长棍。  
<pre>// poj 2513 Colored Sticks  
// trie树+欧拉回路+并查集  
/*  
1 我的trie写的是二叉树形式，有些麻烦，但是空间利用率高。  
2 我写并查集的find函数时，把==写成了=，真是悲催啊  
3  
*/</pre>  
<!--more-->  
<pre>#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  

const int maxn = 260000;  
const int colorlen = 16;  

struct Node{ // trie树构建成一个二叉树，左儿子右兄弟，而非传统的父节点含26个子树的树，不过我觉得这也不像二叉树了，不信你把父节点连同他的右子树以及右子树的右子树放在一条直线上看一下  
    char c;  
    int key;  
    Node *l, *r; // l 是 c 匹配成功后的下一个匹配开始，r 是 c 匹配失败后下一个匹配的字符  
};  

int euler[maxn*2+2]; /// euler path  
Node *root;  // trie tree  
int set[maxn*2+2];  
int key; // key , number  

void init()  
{  
    key = 1;  
    root = NULL;  
    memset(euler, 0, sizeof(int)*(maxn*2+2));  
    for (int i = 0; i &lt; maxn*2+2; i++ )  
        set[i] = i;  
}  
int find(int x)  
{  
    if (set[x] == x){ // Fuck，写成了 = 赋值的了  
        return x;  
    }  
    return set[x] = find(set[x]);  
}  
void union_set(int x, int y)  
{  
    int fx = find(x);  
    int fy = find(y);  
    if (fx != fy){  
        set[fy] = fx;  
    }  
}  

int search(char word[])  
{  
    int pos = 0;  
    if (root == NULL){  
        root = new Node;  
        root-&gt;key = 0;  
        root-&gt;l = root-&gt;r = NULL;  
        root-&gt;c = word[pos];  
    }  
    Node * p = root, *father = root;  
    Node ** pre = NULL;  // pre  指针的指针相当重要，他记录上一次是从父亲的哪个子树开始的,  

    while (word[pos] != ''){  
        if (p == NULL){ //printf("new Node:%cn", word[pos]);  
            p = new Node;  
            p-&gt;key = 0;  
            p-&gt;l = p-&gt;r = NULL;  
            p-&gt;c = word[pos++];  
            (*pre) = p; // printf("pre new:%xn", *pre);  
            father = p;  
            pre = &amp;(p-&gt;l); //错在的这里啊，当一个新的节点创建好后，就应该从下一个节点，即左子树开始检测，则记录相应位置的pre也要更改  
                           // pre  指针的指针,相当重要，他记录上一次是从父亲的哪个子树开始的  
            p = p-&gt;l;  
        }  
        else if (word[pos] == p-&gt;c){ // printf("Next l Node:%cn", word[pos]);  
            pre = &amp;(p-&gt;l);  // pre标明是从哪个子树开始的  
            father = p;  
            p = p-&gt;l;  
            ++pos;  
        }  
        else if (word[pos] != p-&gt;c){  // printf("Next r Node:%c  %cn", word[pos], p-&gt;c);  
            pre = &amp;(p-&gt;r);   // pre标明是从哪个子树开始的  
            father = p;  
            p = p-&gt;r;  
        }  
        else{  
           // return printf("Errorn");  
           while (1) printf("Errorn");;  
        }  
    }  

    if (father-&gt;key == 0){  
        father-&gt;key = key++;  
    }  
    return father-&gt;key;  
}  

int main()  
{  
    char str1[colorlen], str2[colorlen];  

    init();  

    while (2 == scanf("%s %s", str1, str2)){  
        int a = search(str1);   // printf("%s %dn", str1, a);  
        int b = search(str2);  //  printf("%s %dn", str2, b);  
        euler[a]++;  
        euler[b]++;  
        union_set(a, b);  
    }  

    int euler_cnt = 0;  
    int father_cnt = 1, father;  
    father = find(1);  
    for (int i = 1; i &lt; key; i++){  
        euler_cnt += (euler[i] % 2);  
        int t = find(i);  //printf("$ %d %dn", i, t);  
        father_cnt += (t != father);  
    }  
    /* 我又杯具了，结果判断这里把father和father_cnt弄反了，*/  
    //printf("father %d, euler_cnt %d key %dn", father, euler_cnt, key);  
    if (father_cnt &gt; 1 || euler_cnt &gt; 2 || euler_cnt == 1){ // 这个输出答案的时候也出错了，逻辑啊  
        printf("Impossiblen");  
    }  
    else{  // 空输入也是Possible  
        printf("Possiblen");  
    }  
    return 0;  
}</pre>  
