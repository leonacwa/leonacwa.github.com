#!/bin/bash
git config --global user.name "leonacwa"
git config --global user.email leon.acwa@gmail.com
git init
git add .
git commit -m 'init blog'
git remote add origin git@github.com:leonacwa/leonacwa.github.com.git
git push origin master
