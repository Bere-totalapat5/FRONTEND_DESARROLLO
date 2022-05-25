#!/bin/sh

while [ : ] 
do echo 
    echo 
    date 
    # -- borra PDFs antiguos
    hour=$(date +%H)
    # if [ ${hour} -gt 18 -o ${hour} -lt 9 ] ; then
    if [ ${hour} -gt 22 ] ; then
	touch -d '7 days ago' /dev/shm/to_pdfold
	sudo -u www-data HOME=/var/www find /files/firmados ! -newer /dev/shm/to_pdfold -name '*.pdf' -delete -print >> /tmp/oldpdfs 2>&1
	rm  /dev/shm/to_pdfold
    fi
    # -- busca PDFs nuevos
    touch -d '6 days ago' /dev/shm/to_pdf
    find /files/firmados/2017 -newer /dev/shm/to_pdf -name '*.doc' | \
    while read f 
	do [ ! -e ${f%.doc}2.pdf ] && echo $f 
	done | wc -l 
    ( 
	find /files/firmados/2017 -newer /dev/shm/to_pdf -name '*.doc' | while read f 
	do [ -e ${f%.doc}2.pdf ] && { [ $f -nt  ${f%.doc}2.pdf ] && echo $f ; } 
	done 
	find /files/firmados/2017 -newer /dev/shm/to_pdf -name '*.doc' | while read f 
	do [ ! -e ${f%.doc}2.pdf ] && echo $f 
	done
	#-- # docx
	find /files/firmados/2017 -newer /dev/shm/to_pdf -name '*.docx' | while read f 
	do [ -e ${f%.docx}2.pdf ] && { [ $f -nt  ${f%.docx}2.pdf ] && echo $f ; } 
	done 
	find /files/firmados/2017 -newer /dev/shm/to_pdf -name '*.docx' | while read f 
	do [ ! -e ${f%.docx}2.pdf ] && echo $f 
	done
    ) | sort -r | head -20 | tee /dev/shm/to_pdf2
    cat /dev/shm/to_pdf2 | \
    time xargs -r sudo -u www-data HOME=/var/www/ python3 /var/www/scripts/firmas/doc_para_coser_V6.py3 
    date
    rm /dev/shm/to_pdf /dev/shm/to_pdf2
    sleep 30 
done
