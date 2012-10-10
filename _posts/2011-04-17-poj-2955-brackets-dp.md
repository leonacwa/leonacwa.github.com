---
layout: post
title: poj 2955 Brackets (DP)
category : acmicpc
tags : [dp, poj]
---

题意：给一段由( ) [ ] 组成的串，问最大的匹配数量是多少  
DP方程：  
for(j=1 to len-1)  
for(i=1 to len)  
dp[i][i+j] = max{dp[i][k]+dp[k+1][i+j], dp[i-1][i+j-1]+(s[i]&lt;-&gt;s[i+j]是否匹配)} | k:i...i+j-1;  
<blockquote>  
<pre>// poj 2955 Brackets  
// dp[i][i+j] = max{dp[i][k]+dp[k+1][i+j], dp[i-1][i+j-1]+(s[i]&lt;-&gt;s[i+j]是否匹配)} | k:i...i+j-1;</pre>  
<!--more-->  
<pre>#include &lt;stdio.h&gt;  
#include &lt;string.h&gt;  

const int maxn= 256;  

int dp[maxn][maxn];  
char s[maxn];  
int len, max;  
int t;  

int main()  
{  
    while (1 == scanf("%s", &amp;s)){  
        if (0 == strcmp(s, "end"))  
            break;  

        memset(dp, 0, sizeof(dp));  
        len = strlen(s);  

        max = 0;  

        for (int j = 1; j &lt; len; j++){  
            for (int i = 1; i+j &lt;= len; i++){    

                t = dp[i+1][i+j-1];  
                if ((s[i-1]=='('&amp;&amp;s[i+j-1]==')') || (s[i-1]=='['&amp;&amp;s[i+j-1]==']'))  
                    t++;  
                dp[i][i+j] = t;  
                // i..i+j的所有子段  
                for (int k = i; k &lt; i+j; k++) // 没有考虑好状态啊  
                    if (dp[i][i+j] &lt; dp[i][k]+dp[k+1][i+j])  
                        dp[i][i+j] = dp[i][k]+dp[k+1][i+j];  

                if (max &lt; dp[i][i+j])  
                    max = dp[i][i+j];  
            }  
        }  

        printf("%dn", max*2);  

        s[0] = 0;  
    }  
    return 0;  
}</pre>  
</blockquote>  
