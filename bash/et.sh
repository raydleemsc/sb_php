#!/usr/bin/bash

echo "parm=$1"

call_type="unset"
(return >/dev/null 2>&1 ) && call_type="return" || call_type="exit"
echo "call_type=$call_type"

if [ "$1" == "e" ]; then
    echo "exit test"
    (return >/dev/null 2>&1 ) && return || exit
fi

echo "extra"

# (return 0 2>/dev/null ) && return 0 || exit 0
