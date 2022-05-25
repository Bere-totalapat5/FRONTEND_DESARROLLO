#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import smtplib
import sys

TO = [
'"Salvador Garcia Rios"<salvador.rios@tsjdf.gob.mx>',
'"Arturo Garcia Cuellar"<arturo.cuellar@tsjdf.gob.mx>',
'"Lucina Sanchez Quiroz"<lucina.sanchez@tsjdf.gob.mx>',
'"Adrian Alvarez Martinez"<sdadrianalvarez@gmail.com>',
'"Javier Pineda Rodriguez"<javierpinedarodriguez@gmail.com>',
'"Erika Padilla" <ecamargo03@gmail.com>',
'"Manolo Mondragon"<manolodragon@gmail.com>', 
'"Jorge Valerio"<jorgevaleriosd@gmail.com>'
]

TO = [
    'salvador.rios@tsjdf.gob.mx',
    'arturo.cuellar@tsjdf.gob.mx',
    'lucina.sanchez@tsjdf.gob.mx',
    'ecamargo03@gmail.com',
    'jorgevaleriosd@gmail.com',
    'javierpinedarodriguez@gmail.com',
    'sdadrianalvarez@gmail.com',
    'josueescobarc@gmail.com',
    'manolodragon@gmail.com'
]


SUBJECT = 'TSJDF Boletin Judicial Automatizado'
TEXT = "Esta es una prueba\n\n" + sys.argv[1] + "\n\n" + "por favor responda con OK, solo al remitente"

if 0:
    # https://docs.python.org/3.1/library/email-examples.html
    from email.mime.text import MIMEText
    with open(sys.argv[2],"r") as f:
        t = f.read()
    TEXT += t.encode('utf-8').decode("ascii","ignore")
    print("texto:",TEXT,"\n"*3)

# Gmail Sign In
gmail_sender = 'sicor_sistema@tsjdf.gob.mx'
gmail_passwd = 'tsjdfdf88'

server = smtplib.SMTP('smtp.gmail.com', 587)
server.ehlo()
server.starttls()
server.login(gmail_sender, gmail_passwd)

TO   = ",".join(TO)
BODY = '\r\n'.join(['To: %s' % TO,
                    'From: %s' % gmail_sender,
                    'Subject: %s' % SUBJECT,
                    '', TEXT])

try:
    server.sendmail(gmail_sender, [TO], BODY)
    print ('email sent')
except Exception as e:
    print ('error sending mail')
    print (str(e))
server.quit()
