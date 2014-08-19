#!/bin/bash

echo "Install custom dependencies"
cat dependencies | while read dir path; do
  if [ -x $dir ]; then
    echo " => Updating $dir"
    ( cd $dir; git pull )
  else
    echo " => Installing $dir from $path"
    mkdir -p $dir
    ( cd $dir; git clone $path . )
  fi
done

test -f config.php || cp config-dist.php config.php
