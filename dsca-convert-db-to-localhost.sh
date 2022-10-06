#!/bin/bash

#$1 is the first parameter being passed when calling the script. The variable filename will be used to refer to this.
FILENAME=$1

# this is mapped to IP in Pihole DNS
# http://pidocker.local/admin/dns_records.php
DSCA_LOCALHOST_ADDR="local.davidsword.ca"

echo "🏃 doing r+r"

# s+r https to http (until I get a RP setup locally)
sed -ie "s|https://davidsword.ca|http://davidsword.ca|g" $FILENAME

# s+r domain
sed -ie "s|//davidsword.ca|//$DSCA_LOCALHOST_ADDR|g" $FILENAME

# delete that extra file sed creates (doesn't seem to work without -e 🤷‍♂️)
WEIRD_FILE="${FILENAME}e" 
if test -f "$WEIRD_FILE"; then
    rm $WEIRD_FILE
    echo "✅ deleted ${WEIRD_FILE}"
fi

echo "🔍 opening file for verification"
/usr/local/bin/code $FILENAME

echo "💪 done!"