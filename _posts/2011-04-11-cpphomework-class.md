---
layout: post
title: Cpp作业：类
category : cpp
tags : [cpphomework]
---

<div>（在WordPress里贴代码就是一个悲剧）</div>
<div>1.定义一个datatype类，能处理包含字符型，整型，浮点型三种类型的数据给出其构造函数。</div>
<div>2.1设计一个用于人事管理的“人员”类，属性有：编号，性别，出生日期，身份证号。其中出生日期声明为一个日期类的内嵌子对象。用成员函数实现对人员信息的录入和显示。要求包括：构造函数和析构函数，拷贝构造函数，内联成员函数，带默认形参值的成员函数，类的组合</div>
<div>3.定义一个tree类，有成员ages，成员函数grow(int years)对ages加上years，age（）显示tree对象的ages的值</div>
<div><span style="font-family:Georgia, 'Times New Roman', 'Bitstream Charter', Times, serif"><!--more--></span></div>
<pre>/*
定义一个datatype类，能处理包含字符型，整型，浮点型三种类型的数据
给出其构造函数
*/
#include
#include
using namespace std;

class Datatype{ // this class need string.h cc++ head file.
  public:
    enum Type{unknow_, char_, int_, double_};
      Datatype():_t(unknow_)
      {}
      Datatype(char c)
      {
          _data.c = c;
          _t = Datatype::char_;
      }
      Datatype(int i)
      {
          _data.i = i;
          _t = Datatype::int_;
      }
      Datatype(double d)
      {
          _data.d = d;
          _t = Datatype::double_;
      }
      Datatype(const Datatype&amp; data)
      {
          _data = data._data;
          _t = data._t;
      }
      void setdata(char c)
      {
          _data.c = c;
          _t = Datatype::char_;
      }
      void setdata(int i)
      {
          _data.i = i;
          _t = Datatype::int_;
      }
      void setdata(double d)
      {
          _data.d = d;
          _t = Datatype::double_;
      }
      char getdata(char&amp; c)
      {
          c = _data.c;
          return c;
      }
      int getdata(int &amp;i)
      {
          i = _data.i;
          return i;
      }
      double getdata(double&amp; d)
      {
          d = _data.d;
          return d;
      }
      Datatype::Type gettype(void)
      {
          return _t;
      }
      char* gettype(char*s)
      {
          switch(_t)
          {
            case Datatype::unknow_:
              strcpy(s, "unknow");
              break;
            case Datatype::char_:
              strcpy(s, "char");
              break;
            case Datatype::int_:
              strcpy(s, "int");
              break;
            case Datatype::double_:
              strcpy(s, "double");
              break;
            default:
                break;
          }
          return s;
      }
      ~Datatype()
      {}
  private:
    union {char c; int i;double d;}_data;
    Type _t;
};

int main()
{
    Datatype d, d2('c');
    int i;
    char c;
    double dd;
    char s[256];

    cout &lt;&lt; d.getdata(i) &lt;&lt; "  " &lt;&lt; d.gettype(s) &lt;&lt; endl;

    d.setdata(0.0001);

    cout &lt;&lt; d.getdata(dd) &lt;&lt; "  " &lt;&lt; d.gettype(s) &lt;&lt; endl;

    cout &lt;&lt; d2.getdata(c) &lt;&lt; "  " &lt;&lt; d2.gettype(s) &lt;&lt; endl;

    return 0;
}

/*
1设计一个用于人事管理的“人员”类，属性有：编号，性别，出生日期，
身份证号。其中出生日期声明为一个日期类的内嵌子对象。用成员函数
实现对人员信息的录入和显示。要求包括：构造函数和析构函数，拷贝
构造函数，内联成员函数，带默认形参值的成员函数，类的组合
*/
#include
using namespace std;
class Date{
  public:
    Date(int y = 0, int m = 0, int d = 0):_year(y), _month(m), _day(d)
    {}
    Date(const Date&amp; d) // 自定义的拷贝构造函数
    {
        _year = d._year;
        _month = d._month;
        _day = d._day;
    }
    void setdate(int y = 0, int m = 0, int d = 0)
    {
        if (y == 0 || m == 0 || d == 0)
            return;
         _year = y;
        _month = m;
        _day = d;
    }
    int getyear(void){return _year;}
    int getmonth(void){return _month;}
    int getday(void){return _day;}
    Date getdate(void)
    {
        return *this;
    }
    ~Date()
    {}
  private:
    int _year, _month, _day;
};
class ManagerPeople{
  public:
    ManagerPeople(string id = "", int No = 0, int gender = 2,
                  Date date = Date(0, 0, 0)):_id(id),_No(No), _gender(gender), _birthday(date)
    {
    }
    ManagerPeople(const ManagerPeople&amp; p)
    {
        _id = p._id;
        _No = p._No;
        _gender = p._gender;
        _birthday = p._birthday;

    }
    void setpeople(string id = "", int No = 0, int gender = 2,
                  Date date = Date(0, 0, 0))
    {
        if (id == "" || No == 0 || gender &gt; 1 )
            return;
        _id = id;
        _No = No;
        _gender = gender;
        _birthday = date;
    }
    void input(void)
    {
        string id;
        int No, y, m, d;
        int gender;
        cout &lt;&lt; "ID No Gender(0 as female, 1 as male) Birthday(eg.Y M D)" &lt;&lt; endl;
        cin  &gt;&gt; id &gt;&gt; No &gt;&gt; gender &gt;&gt; y &gt;&gt; m &gt;&gt; d;</pre>
<pre>        _id = id;
        _No = No;
        _gender = gender;
        _birthday.setdate(y, m, d);
    }
    void output()
    {
        cout &lt;&lt; "ID:" &lt;&lt; _id &lt;&lt; " NO:" &lt;&lt; _No
             &lt;&lt; " Gender:" &lt;&lt; (_gender==0?"Female":(_gender==1?"Male":"Unkonw Gender!"))
             &lt;&lt; " Birthday:" &lt;&lt; _birthday.getyear() &lt;&lt; "," &lt;&lt; _birthday.getmonth() &lt;&lt; "," &lt;&lt; _birthday.getday();
    }
    ~ManagerPeople()
    {
        cout &lt;&lt; "At " &lt;&lt; this &lt;&lt; "  ID " &lt;&lt; _id &lt;&lt; " will gone." &lt;&lt; endl;
    }
  private:
    string _id;
    int _No, _gender;
    Date _birthday;
};

int main()
{
    cout &lt;&lt; "Manager Starting..." &lt;&lt; endl;
    ManagerPeople p1, p2, p3("1100011", 3, 2, Date(1991, 3, 5));

    p1.input();

    p1.output();
    cout &lt;&lt; endl;

    p2 = p1;

    p2.output();
    cout &lt;&lt; endl;

    p3.output();
    cout &lt;&lt; endl;

    cout &lt;&lt; "All over!" &lt;&lt; endl;
    return 0;
}

/*
定义一个tree类，有成员ages，成员函数grow(int years)对ages加上
years，age（）显示tree对象的ages的值
*/
#include
using namespace std;

class Tree{
  public:
    Tree(int y = 0):_ages(y)
    {}
    Tree(const Tree&amp; t)
    {
        _ages = t._ages;
    }
    int grow(int years = 0)
    {
        _ages += years;
        return _ages;
    }
    int age()
    {
        cout &lt;&lt; "tree's ages:" &lt;&lt; _ages;
        return _ages;
    }
    ~Tree()
    {}
  private:
    int _ages;
};

int main()
{
    Tree t1, t2, t3(1);

    t1.grow(1);
    t1.age();
    cout &lt;&lt; endl;

    t2 = t1;
    t2.grow(2);
    t2.age();
    cout &lt;&lt; endl;

    t3.age();
    cout &lt;&lt; endl;

    return 0;
}</pre>
