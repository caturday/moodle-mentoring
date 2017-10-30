#!/bin/bash

me=`basename "$0"`
diff -y <(grep "get_string([^)]*)" * -roh --exclude ${me} | cut -d"'" -f2 | sort | uniq) <(grep "string\[.*\]" lang/en/local_mentoring.php | cut -d"'" -f2 | sort | uniq)
