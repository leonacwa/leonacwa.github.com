---
layout: post
title: 学生管理程序(代码)
category: cpp
categories: [cpp]
tags: []
by: wp2md(php)
---

<pre>
#include &lt;iostream&gt;

#include &lt;string&gt;

#include &lt;iomanip&gt;

#include &lt;algorithm&gt;

 

using namespace std;

enum Lesson{math, physics, english};

struct Student{

string name; // 姓名

int id;  // 学号

int grade_NO;

int class_NO;

int mathscore, physicsscore, englishscore;

Student * next;

Student&amp; operator=(const Student&amp; source);

};

class StudentsList{

public:

StudentsList():head(NULL), total(0){}

~StudentsList();  //  析构函数

Student* insert(Student* pstu);   //  插入一个学生的信息

int remove(int id);   //  根据学号删除学生

int remove(string name); // 根据姓名删除学生

Student* modify(const Student* pstu);  // 修改一个学生的信息

Student* find(string name); // 根据名字寻找一个学生<!--more-->

Student* find(int id); // 根据学号寻找学生

void printbynameorder();  // 按照姓名的字典序排序

void printbyidorder(); // 按照学号升序排序

void printbyscoreorder(Lesson lesson = math); // 按照某门课程的成绩降序排序

void printone(Student *pstu);   // 输出一个学生的信息

void printbyclass(int NO); // 输出某个班级的全部学生

void printbyidrange(int from, int to); // 输出学号范围的学生

void printtabletitle(){cout &lt;&lt; setw(12) &lt;&lt; "姓名" &lt;&lt; setw(6) &lt;&lt; "学号" &lt;&lt; setw(6) &lt;&lt; "年级" &lt;&lt; setw(6) &lt;&lt; "班级" &lt;&lt; setw(13) &lt;&lt; "入学数学成绩" &lt;&lt; setw(13) &lt;&lt; "入学物理成绩" &lt;&lt; setw(13) &lt;&lt; "入学英语成绩" &lt;&lt; endl;}

Student* input();

protected:

private:

Student *head;

int total;

};

 

bool mathscorecompare(const Student* a1, const Student* a2)   {return a1-&gt;mathscore  &gt; a2-&gt;mathscore;}

bool physicsscorecompare(const Student* a1, const Student* a2){return a1-&gt;physicsscore  &gt; a2-&gt;physicsscore;}

bool englishscorecompare(const Student* a1, const Student* a2){return a1-&gt;englishscore  &gt; a2-&gt;englishscore;}

int namecompare(const Student* a1, const Student* a2);

 

int namecompare(const Student* a1, const Student* a2)

{

const string *s1 = &amp;(a1-&gt;name), *s2 = &amp;(a2-&gt;name);

int i = 0, len1 = s1-&gt;length(), len2 = s2-&gt;length();

while (i &lt; len1 &amp;&amp; i &lt; len2 &amp;&amp; (*s1)[i] == (*s2)[i])

{

i++;

}

if (i == len1 &amp;&amp; i &lt; len2)

{

return -1;

}

else if (i &lt; len1 &amp;&amp; i == len2)

{

return 1;

}

else if (i == len1 &amp;&amp; i == len2)

{

return 0;

}

else

return ((*s1)[i] - (*s2)[i]);

}

Student&amp; Student::operator=(const Student&amp; source)

{

this-&gt;name = source.name;

this-&gt;id = source.id;

this-&gt;name = source.name;

this-&gt;grade_NO = source.grade_NO;

this-&gt;class_NO = source.class_NO;

this-&gt;mathscore = source.mathscore;

this-&gt;physicsscore = source.physicsscore;

this-&gt;englishscore = source.englishscore;

return *this;

}

 

Student* StudentsList::insert(Student *pstu)  //  按照学号的顺序进行插入

{

if (head == NULL)

{

head = pstu;

head-&gt;next = NULL;

total++;

return head;

}

if (pstu-&gt;id &lt; head-&gt;id)

{

pstu-&gt;next = head;

head = pstu;

total++;

return head;

}

Student *a1, *a2;

a1 = head;

a2 = a1-&gt;next;

 

while (a2 != NULL &amp;&amp; pstu-&gt;id &gt;= a2-&gt;id)

{

a1 = a2;

a2 = a1-&gt;next;

}

a1-&gt;next = pstu;

pstu-&gt;next = a2;

total++;

return pstu;

}

StudentsList::~StudentsList()

{

Student *a1;

while (head != NULL)

{

a1 = head;

head = a1-&gt;next;

delete a1;

total--;

}

}

 

int StudentsList::remove(int id)  //  根据学号删除学生

{

if (head == NULL)

{

cout &lt;&lt; "There is any student in the list, can not remove.n";

return 1;

}

Student *a1, *a2;

if (head-&gt;id == id)

{

a1 = head;

head = a1-&gt;next;

delete a1;

total--;

return 0;

}

else

{

a1 = head;

a2 = head-&gt;next;

while (a2 != NULL &amp;&amp; a2-&gt;id != id)

{

a1 = a2;

a2 = a2-&gt;next;

}

if (a2 != NULL &amp;&amp; a2-&gt;id == id)

{

a1-&gt;next = a2-&gt;next;

delete a2;

total--;

return 0;

}

else

return 1;

}

}

 

int StudentsList::remove(string name)  //  根据名字删除学生

{

if (head == NULL)

{

cout &lt;&lt; "There is any student in the list, can not remove.n";

return 1;

}

Student *a1, *a2;

if (head-&gt;name == name)

{

a1 = head;

head = a1-&gt;next;

delete a1;

return 0;

}

else

{

a1 = head;

a2 = head-&gt;next;

while (a2 != NULL &amp;&amp; a2-&gt;name != name)

{

a1 = a2;

a2 = a2-&gt;next;

}

if (a2 != NULL &amp;&amp; a2-&gt;name == name)

{

a1-&gt;next = a2-&gt;next;

delete a2;

return 0;

}

else

return 1;

}

}

Student* StudentsList::modify(const Student* pstu) // 修改学生信息

{

Student *a1 = head;

while (a1 != NULL &amp;&amp; a1-&gt;name != pstu-&gt;name &amp;&amp; a1-&gt;id != pstu-&gt;id)

a1 = a1-&gt;next;

if (a1-&gt;name == pstu-&gt;name &amp;&amp; a1-&gt;id == pstu-&gt;id)

{/*

a1-&gt;name = pstu-&gt;name;

a1-&gt;id = pstu-&gt;id;

a1-&gt;name = pstu-&gt;name;

a1-&gt;grade_NO = pstu-&gt;grade_NO;

a1-&gt;class_NO = pstu-&gt;class_NO;

a1-&gt;mathscore = pstu-&gt;mathscore;

a1-&gt;physicsscore = pstu-&gt;physicsscore;

a1-&gt;englishscore = pstu-&gt;englishscore;

*/

(*a1) = (*pstu);

cout &lt;&lt; "Modify succeed!" &lt;&lt; endl;

return a1;

}

cout &lt;&lt; "Can't find student, modify failure!" &lt;&lt; endl;

return NULL;

}

Student* StudentsList::find(string name)  // 根据名字寻找学生

{

Student *a1 = head;

while (a1 != NULL &amp;&amp; a1-&gt;name != name)

a1 = a1-&gt;next;

if (a1 != NULL &amp;&amp; a1-&gt;name == name)

{

return a1;

}

else

return NULL;

}

Student* StudentsList::find(int id)  // 根据学号寻找学生

{

Student *a1 = head;

while (a1 != NULL &amp;&amp; a1-&gt;id != id)

a1 = a1-&gt;next;

if (a1 != NULL &amp;&amp; a1-&gt;id == id)

{

return a1;

}

else

return NULL;

}

void StudentsList::printbynameorder()   // 按照姓名的升序进行排序

{

if (head == NULL)

{

cout &lt;&lt; "There is not exsit any student." &lt;&lt; endl;

return;

}

 

Student **a =  new Student*[total]; //  ?

Student *pstu = head;

int i = 0;

while (pstu != NULL)

{

a[i++] = pstu;

pstu = pstu-&gt;next;

}

 

sort(a, a+total, namecompare);

 

printtabletitle();

for (i = 0; i &lt; total; i++)

{

printone(a[i]);

}

cout &lt;&lt; endl;

delete [] a;

}

void StudentsList::printbyidorder() // 按照学号的升序输出学生

{

Student *pstu = head;

if (pstu == NULL)

{

cout &lt;&lt; "There is any student in the list." &lt;&lt;endl;

return;

}

 

while (pstu != NULL)

{

printone(pstu);

pstu = pstu-&gt;next;

}

}

void StudentsList::printbyscoreorder(Lesson lesson)    //  按照某一个学科的成绩降序输出学生信息，默认为数学成绩

{

if (head == NULL)

{

cout &lt;&lt; "There is not exsit any student." &lt;&lt; endl;

return;

}

if (!(math &lt;= lesson &amp;&amp; lesson &lt;= physics))

{

cout &lt;&lt; "There is not exsit leeson NO " &lt;&lt; lesson &lt;&lt; "." &lt;&lt; endl;

return;

}

Student **a =  new Student*[total]; //  ?

Student *pstu = head;

int i = 0;

while (pstu != NULL)

{

a[i++] = pstu;

pstu = pstu-&gt;next;

}

if (lesson == math)

{

sort(a, a+total, mathscorecompare);

}

else if (lesson == physics)

{

sort(a, a+total, physicsscorecompare);

}

else if (lesson == english)

{

sort(a, a+total, englishscorecompare);

}

printtabletitle();

for (i = 0; i &lt; total; i++)

{

printone(a[i]);

}

cout &lt;&lt; endl;

delete [] a;

}

void StudentsList::printone(Student* pstu)   /// 输出一个学生的信息

{/*

cout &lt;&lt; "姓名:" &lt;&lt; pstu-&gt;name &lt;&lt; " 学号:" &lt;&lt; pstu-&gt;id &lt;&lt; " 年级:" &lt;&lt; pstu-&gt;grade_NO &lt;&lt; " 班级:" &lt;&lt; pstu-&gt;class_NO

&lt;&lt; " 入学数学成绩:" &lt;&lt; pstu-&gt;mathscore &lt;&lt;  " 入学物理成绩:" &lt;&lt; pstu-&gt;physicsscore

&lt;&lt; " 入学英语成绩:" &lt;&lt; pstu-&gt;englishscore &lt;&lt; ".n";  */

cout &lt;&lt; setw(12) &lt;&lt; pstu-&gt;name &lt;&lt; setw(6) &lt;&lt; pstu-&gt;id &lt;&lt; setw(6) &lt;&lt; pstu-&gt;grade_NO &lt;&lt; setw(6) &lt;&lt; pstu-&gt;class_NO

&lt;&lt; setw(13)  &lt;&lt; pstu-&gt;mathscore &lt;&lt; setw(13) &lt;&lt; pstu-&gt;physicsscore &lt;&lt; setw(13) &lt;&lt; pstu-&gt;englishscore &lt;&lt; endl;

}

void StudentsList::printbyclass(int NO) // 输出某个班级的学生

{

Student *pstu = head;

bool flag = false;

while (pstu != NULL )

{

if (pstu-&gt;class_NO == NO)

{

if (false == flag)

{

printtabletitle();

flag = true;

}

printone(pstu);

}

pstu = pstu-&gt;next;

}

if (false == flag)

{

cout &lt;&lt; "There is not exsit class " &lt;&lt; NO &lt;&lt; endl;

}

else

{

cout &lt;&lt; endl;

}

}

void StudentsList::printbyidrange(int from, int to) //  按照学号范围输出

{

Student *pstu = head;

while (pstu != NULL &amp;&amp; pstu-&gt;id &lt; from)

pstu = pstu-&gt;next;

if (pstu == NULL)

{

cout &lt;&lt; "Can't print by id from " &lt;&lt; from &lt;&lt; " to " &lt;&lt; to &lt;&lt; endl;

return;

}

while (pstu != NULL &amp;&amp; pstu-&gt;id &lt;= to)

{

printone(pstu);

pstu = pstu-&gt;next;

}

}

Student* StudentsList::input()    //  一个简单的输入

{

Student *pstu = new Student;

cout &lt;&lt; "(Format:姓名 学号 年级 班级 入学数学成绩 入学物理成绩 入学英语成绩)nInput:";

cin &gt;&gt; pstu-&gt;name &gt;&gt; pstu-&gt;id &gt;&gt; pstu-&gt;grade_NO &gt;&gt; pstu-&gt;class_NO

&gt;&gt; pstu-&gt;mathscore &gt;&gt; pstu-&gt;physicsscore &gt;&gt; pstu-&gt;englishscore;

pstu-&gt;next = NULL;

return pstu;

//insert(pstu);

}

void view(StudentsList&amp; stulist, char c = '')

{

if (c == '')

{

cout &lt;&lt; "View by name order(n)，id order(i)，score order(s)，class(c), id range(r):";

cin &gt;&gt;c;

}

if (c == 'n')

stulist.printbynameorder();

else if (c == 'i')

stulist.printbyidorder();

else if (c == 's')

{

cout &lt;&lt; "Which lesson you want to view? math(" &lt;&lt; math &lt;&lt; "), " &lt;&lt; "physics("&lt;&lt; physics &lt;&lt; "), " &lt;&lt; "english(" &lt;&lt; english &lt;&lt; "):";

int ic; cin &gt;&gt; ic;

if (ic == english)

stulist.printbyscoreorder(english);

else if (ic == physics)

stulist.printbyscoreorder(physics);

else

stulist.printbyscoreorder();

}

else if (c == 'c')

{

cout &lt;&lt; "Please input class NO:";

int NO;

cin &gt;&gt; NO;

stulist.printbyclass(NO);

}

else if (c == 'r')

{

cout &lt;&lt; "Please input from id and to id(2 intergers):";

int from, to;

cin &gt;&gt; from &gt;&gt; to;

stulist.printbyidrange(from, to);

}

else

{

cout &lt;&lt; "Error Input!" &lt;&lt; endl;

}

}

int main()

{

Student *pstu;

StudentsList stulist;

char ch;

int id;

string name;

bool quit = false;

 

while (false == quit)

{

cout &lt;&lt; "ninsert(i), delete(d), find(f), print(p), view(v), load(l) from file, modify(m) 1 student, quit(q):";

cin &gt;&gt; ch;

 

switch (ch)

{

case 'i':

pstu = stulist.input();

stulist.insert(pstu);

break;

case 'd':

cout &lt;&lt; "Delete by name(n) or id(i):";

cin &gt;&gt; ch;

if (ch == 'i')

{

cout &lt;&lt; "Please input student's id:";

cin &gt;&gt; id;

stulist.remove(id);

}

else if (ch == 'n')

{

cout &lt;&lt; "Please input student's name:";

cin &gt;&gt; name;

stulist.remove(name);

}

else

{

cout &lt;&lt; "Error Input!" &lt;&lt; endl;

break;

}

break;

case 'f':

cout &lt;&lt; "Find by name(n) or id(i):";

cin &gt;&gt; ch;

if (ch == 'i')

{

cout &lt;&lt; "Please input student's id:";

cin &gt;&gt; id;

pstu = stulist.find(id);

}

else if (ch == 'n')

{

cout &lt;&lt; "Please input student's name:";

cin &gt;&gt; name;

pstu = stulist.find(name);

}

else

{

cout &lt;&lt; "Error Input!" &lt;&lt; endl;

break;

}

stulist.printone(pstu);

break;

case 'p':

stulist.printbyidorder();

break;

case 'v':

view(stulist);

break;

case 'q':

quit = true;

break;

case 'm':

pstu = stulist.input();

stulist.modify(pstu);

delete pstu;

break;

default:

cout &lt;&lt; "Error input!" &lt;&lt; ch &lt;&lt;endl;

break;

}

}

return 0;

}

 
</pre>
