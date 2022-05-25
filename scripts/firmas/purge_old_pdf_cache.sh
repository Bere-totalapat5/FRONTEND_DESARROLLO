#!/bin/sh

# As User: www-data HOME=/var/www 
date  >> /tmp/deleted 2>&1
touch -d '7 days ago' /dev/shm/to_pdfold
find /files/porfirmar /files/firmados -type f ! -newer /dev/shm/to_pdfold -name '*.pdf' -delete -print >> /tmp/deleted 2>&1
rm  /dev/shm/to_pdfold
