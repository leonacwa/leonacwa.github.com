#!/bin/bash
import sys

if 1 == len(sys.argv) :
    print "command line err!"
    exit()

mdfile = open(sys.argv[1], "r")
li = []

ll = 0
for line in mdfile:
    line = line[:-1]
    if (ll == 2) and line != "" and (not line.endswith("  ")) :
        line = line + "  "
    if ll < 2 and line == "---" :
        ll = ll + 1
    line = line + "\n"
    li.append(line)

mdfile.close()

mdfile = open(sys.argv[1], "w")
mdfile.writelines(li)
mdfile.close()

