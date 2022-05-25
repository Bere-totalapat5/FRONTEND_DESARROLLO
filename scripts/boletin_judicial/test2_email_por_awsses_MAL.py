#!/usr/bin/python
# -*- coding: utf-8 -*-

import smtplib, re, sys
#from email.mime.text import MIMEText
from email.message   import Message
from email.header    import Header

def prompt(prompt):
    return raw_input(prompt).strip()

fromaddr = 'SICOR Sistema <sicor_sistema@tsjdf.gob.mx>'

toaddrs  = [
    ('Manolo Mondragón','<manolodragon@gmail.com>'),
]
#OK     '=?UTF-8?Q?Manolo Mondrag=C3=B3n?= <manolodragon@gmail.com>'
#MAL    'Manolo Mondragón <manolodragon@gmail.com>'


# toaddrs  = [
#     'salvador.rios@tsjdf.gob.mx',
#     'arturo.cuellar@tsjdf.gob.mx',
#     'lucina.sanchez@tsjdf.gob.mx',
#     'javierpinedarodriguez@gmail.com',
#     'jorgevaleriosd@gmail.com',
#     'sdadrianalvarez@gmail.com',
#     'adrian@skills-depot.com',
#     'caballeroantonio.com@gmail.com',
#     'manolodragon@gmail.com',
#     'sicor_sistema@tsjdf.gob.mx'
# ]

msg = """Boletín Judicial TSJDF

%s

mailto:sicor_sistema@tsjdf.gob.mx
""" % sys.argv[1]

msg = Message(msg.encode('utf-8'), _charset='utf-8')
msg['Subject'] = "Boletín Judicial del " + sys.argv[2]
msg['From'] = fromaddr
z = []
for  x,y in toaddrs:
    z.append( " ".join((str( Header(x, 'utf-8')),y)))

print("\n\n\n", z, "\n\n\n")
msg['To'] = ", ".join(z)

print("Message length is " + repr(len( msg.as_string() )))

#destin = ", ".join([ re.sub( r'^.*\<',"", x[:-1]) for x in toaddrs ])
#destin = ('sicor_sistema@tsjdf.gob.mx',)
destin = [ str( Header(x[1], 'utf-8')) for x in toaddrs ]

#Change according to your settings
smtp_server = 'email-smtp.us-east-1.amazonaws.com'
smtp_username = "AKIAJCIMGKYVUBUR737A"
smtp_password = 'AjaxaoOQMscaKGIQI5vgHzs6GvjMevXmLt0LsNtjx72h'
smtp_port = '587'
smtp_do_tls = True

print("\n\n\n", destin,"\n\n\n")
print(msg.as_string(),"\n\n\n")

if 1:
    server = smtplib.SMTP(
        host = smtp_server,
        port = smtp_port,
        timeout = 10
    )
    server.set_debuglevel(10)
    server.starttls()
    server.ehlo()
    server.login(smtp_username, smtp_password)
    # server.sendmail(fromaddr, destin, msg.as_string())
    server.send_message( msg )
    print(server.quit())
else:
    print(fromaddr, destin, msg.as_string())
