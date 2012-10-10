#!/bin/bash

function ergodic(){
for file in ` ls $1 `
do
    if [ -d $1"/"$file ]
    then
        ergodic $1"/"$file
    else
        python md.py $1"/"$file 
    fi
done
}
INIT_PATH="../_posts"
ergodic $INIT_PATH
