#!/bin/bash

recursion_block='no_recur'

[ "$1" == "$recursion_block" ] && script=$BASH_SOURCE || script=$(basename $BASH_SOURCE)
echo "running - "$script
script=$(basename $BASH_SOURCE)

src=$(realpath -s "$BASH_SOURCE")
src=${src/\/$script/}
echo "src=$src"
pushd $src >/dev/null

filespecs=( *.md *.sh *.php )
basedir='/d/Clouds/OneDrive/Documents/dev'
dests=(
    $basedir/github/sandbox/sbphp/v8n
    $basedir/work/templates/dev-site/httpdocs/v8n
)

dest_count=0
for dest in "${dests[@]}"
do
    if [ "$dest" != "$src" ]
    then
        echo "dest[$((++dest_count))]=${dest/$basedir\//}"
        copied=
        for filespec in "${filespecs[@]}"; do 
            # echo -n "filespec=$filespec - "
            rm $dest/$filespec
            cp_log=$(cp -u -v $src/$filespec $dest)
            cp_rc=$?
            # [[ "$cp_rc" == 0 && ! -z "$cp_log" ]] && echo "(rc=$cp_rc)${cp_log}"
            if [[ "$cp_rc" == 0 ]]
            then
                copied+=$filespec" "
            else
                if [ -z "$cp_log" ]
                then
                    cp_log= #"nothing copied for $filespec"
                else
                    for src_rep in $src\/ $dest\/ $filespec "'" "'" "'" "'"
                    do
                        cp_log=${cp_log/$src_rep/}
                    done
                fi
                echo $'\t'"copied=$copied"
                echo $'\t'"(rc=$cp_rc)${cp_log}"
                copied=
            fi
            # echo
        done
        [ ! -z "$copied" ] && echo $'\t'"copied=$copied"
        [ "$1" != "$recursion_block" ] && source $dest/$(basename $BASH_SOURCE) $recursion_block
    fi
done

popd >/dev/null
