---
layout: post
title: 网络流学习资料 [转载]
category: acm
tags: [acm, algorithm, %e7%bc%96%e7%a8%8b, %e7%bd%91%e7%bb%9c%e6%b5%81, zz]
---

网络是一个各条边都有权值和方向的图,网络流是满足以下性质的网络：
1.每一条边拥有一个最大容量c，即该条边可以容纳的最大流量。
2.f是流过该边的实际流量，且总有f&lt;=c。
3.每个顶点（源点s和汇点t除外）都有流出的流量等于流入的流量。图中只有一个源点一个汇点，且对于源点来说其流入量为0，对于汇点来说流出量为0，源点的流出量等于汇点的流入量，对于最大流问题既是要找出流入汇点的最大流量值。

网络流的实际应用：运输货物的物流问题，水流问题，匹配问题（最大二分匹配）等。

求最大流的算法：
<strong>1.EK算法：</strong>
    EK算法中涉及的三个关键词：残留网络，增广路径，割。
    残留网络，假定我们已经找到了一个可行的流，那么对于每条边如果流量小于容量，则表示该条边有剩余，以流的流量我们也可以看成是反向的残留，得到一个残留网络。
    增广路径：在残留网络中如果可以找到一条从源点到汇点的路，即为增广路，我们就可以将流值增加这条增广路上的最小边。
    割：把网络分成两部分，一部分包含源点s，另一部分包含汇点t，从源集合到汇集合之间的正向流量之和即为割。网络的割中最小的那个，称之为最小割。
    EK算法就是在残留网络中寻找增广路使得流值不断增大，直至达到最大为止。Ek算法由于在寻找增广路时具有盲目性(运用广度优先搜索)，算法效率不高。


<strong>2.Dinic算法：</strong>
    基于EK算法的思想，再从源点到汇点做bfs来寻找路时，对各点标一个层次值表示从源点到该点所需的最小步数，然后在这些层次的基础上再做dfs，dfs的时候只能到其下一层的点，且容量需要比已流流量大，然后重复上述过程即可得到解。步骤如下：
    1、初始化流量，计算出剩余图
    2、根据剩余图计算层次图。若汇点不在层次图内，则算法结束
    3、在层次图内用一次dfs过程增广
    4、转步骤2
算法模板：
<!--more-->

<pre>//时间复杂度O（V^2E)  Dinic 算法
#include&lt;iostream&gt;
#define Max 210
int flow[Max][Max], d[Max];  //flow is the network
int sta, end, N;  //sta is the sourse ,end is the,N is the number of vector
bool bfs(int s)
{
               int front=0,rear=0; int q[Max];
               memset(d,-1,sizeof(d));  //d[] is the deep
               q[rear++]=s;  d[s]=0;
               while(front&lt;rear)
               {
                       int k=q[front++];
                       for(int i=0;i&lt;=N;i++)
                          if(flow[k][i]&gt;0&amp;&amp;d[i]==-1){
                             d[i]=d[k]+1;
                             q[rear++]=i;
                          }
               }
               if(d[end]&gt;=0)   return true;
               return false;
}
int dinic(int k,int sum)  //k is the sourse
{
              if(k==end)    return sum;
              int os=sum;
              for(int i=0;i&lt;=N&amp;&amp;sum;i++)
              if(d[i]==d[k]+1&amp;&amp;flow[k][i]&gt;0)
              {
                        int a=dinic(i,min(sum,flow[k][i])); //Deep to the end.
                        flow[k][i]-=a;
                        flow[i][k]+=a;
                        sum-=a;
               }
              return os-sum;
}
int main()
{
              int ret=0;
              while(bfs(sta))
                  ret+=dinic(sta,INT_MAX);
              printf("%dn",ret);
              return 0;
}</pre>
最大流最小割定理：一个网络的最小割等于最大流。(网络流运用得好坏的精髓)

问题扩展：
<strong>最小费用最大流</strong>： 在保证最大流的情形下，网络中的边，可能不只有流量还有费用，那么如果我们一方面希望网络拥有最大流，另一方面我们要求费用达到最小，这就是一个费用流的问题了。
对于费用流的问题，事实上我们可以这么考虑，首先我们必须要找到的是最大流，另一方面我们需要费用最小，而在找最大流的时候我们总是在寻找增广路来增广，来使得我们能得到一个比现在更大的流，那么另一方面要求费用最小，所以我们可以在<strong>寻找增广路的时候找一条费用最小路来增广</strong>，而费用我们也可以看成是距离类的东西，也就是这样的话，我们可以用最短路，来找出这样一个最小费用的路来进行增广，而不断增广，即可得到最大流，这样我们就可以得到最小费用最大流。
