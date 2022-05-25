#!/bin/bash
cd /var/www
git status | grep -q 'nothing to commit, working directory clean' || { git add --all public_html html icons scripts webservices cgi-bin php-inc && git commit -a -m "Cambios: `date '+%F %T'`" ; }
