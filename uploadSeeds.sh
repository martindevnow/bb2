#!/bin/bash

echo "copying the seeds to the server"

scp ./seeds/csv/* barfbento@yamenai.com:~/projects/bb2/seeds/csv/
scp ./seeds/fromGoogle/* barfbento@yamenai.com:~/projects/bb2/seeds/fromGoogle/

scp ./seeds/csv/* barfbento@yamenai.com:~/projects/live/seeds/csv/
scp ./seeds/fromGoogle/* barfbento@yamenai.com:~/projects/live/seeds/fromGoogle/

echo "done"
