#!/usr/bin/env sh

placeEnvVars(){
    for file in "$1"/*
    do
      if [ -d "$file" ]
      then
        placeEnvVars "$file"
      else
        IN=$(env)
        for i in $(echo $IN | tr ";" "\n")
        do
          varValue="${i#*=}"
          strRepl="\${${i%=*}}"
          sed -i -e "s;${strRepl};${varValue};g" "$file"
        done
      fi
    done
}

placeEnvVars "$1"
