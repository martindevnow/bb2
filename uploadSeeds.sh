#!/bin/bash

echo "copying the seeds to the server"

scp ./seeds/csv/* barfbento@yamenai.com:~/projects/bb2/seeds/
scp ./seeds/fromGoogle/* barfbento@yamenai.com:~/projects/bb2/seeds/

echo "done"
