---
layout: post
title: POJ 1013 Counterfeit Dollar (枚举)
category : acmicpc
tags : [acmicpc, poj]
---

<pre>/*
    POJ 1013 Counterfeit Dollar
    
    题意：给你三次称量的结果，问你那个硬币是假的，是轻是重。
    
    简单枚举硬币和它的质量。
    
    注意细节.
    代码
*/</pre>
<!--more-->
<pre>
#include &lt;stdio.h&gt;
#include &lt;string.h&gt;

bool a[32], ans;
char w[3][3][32];

int main()
{
    int i, j, t, wt, ws, len;
    char c;
    scanf("%d", &amp;t);
    
    while (t--)
    {
       memset(a, false, sizeof(a));
        for (i = 0; i &lt; 3; i++)
        {
            scanf("%s %s %s", w[i][0], w[i][1], w[i][2]);
            len = strlen(w[i][0]);
            for (j = 0; j &lt; len; j++){
                a[w[i][0][j] - 'A'] = true;
                a[w[i][1][j] - 'A'] = true;
            }
        } /* Input */
        
        /*枚举每一个可疑的coin，并枚举他们的重量*/
        for (i = 0; i &lt; 26; i++) /// coin
        if (a[i]){
            c = 'A' + i;
            for (wt = 0; wt &lt; 2; wt++){ /// weight   0 light  1 heavy
                ans = true; /// 草，枚举硬币和重量，结果初始化应该在这里的
                for (ws = 0; ws &lt; 3 &amp;&amp; ans; ws++){ /// description 
                     if (strchr(w[ws][0], c)){ /// left
                         if ((wt == 0 &amp;&amp; 0 == strcmp(w[ws][2], "down"))
                          || (wt == 1 &amp;&amp; 0 == strcmp(w[ws][2], "up")))
                             ;
                         else{
                             ans = false;
                             break;
                         }
                     }
                     else 
                     if (strchr(w[ws][1], c)){ /// right
                         if ((wt == 1 &amp;&amp; 0 == strcmp(w[ws][2], "down"))
                          || (wt == 0 &amp;&amp; 0 == strcmp(w[ws][2], "up")))
                             ;
                        else{
                            ans = false;
                            break;
                        }
                     }
                     else { /// none
                         if (strcmp(w[ws][2], "even") == 0)
                         ;
                         else{
                            ans = false;
                            break;
                         }
                     }
                } /// for conditions
                if (ans) /// get answer
                    break;
            } /// for weight
            if (ans) // get answer
                break;
            
        } /// coins
        printf("%c is the counterfeit coin and it is %s.n", 'A'+i, (wt == 1) ? "heavy" : "light");
    }
    return 0;
}</pre>
