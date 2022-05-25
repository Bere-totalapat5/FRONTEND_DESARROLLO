#!/usr/bin/python
import smtplib, re, sys
from email.mime.text import MIMEText
from email.header import Header

def prompt(prompt):
    return raw_input(prompt).strip()

fromaddr = 'SICOR Sistema <sicor_sistema@tsjdf.gob.mx>'

toaddrs  = [
    'Salvador Garcia Rios <salvador.rios@tsjdf.gob.mx>',
    'Arturo Garcia Cuellar <arturo.cuellar@tsjdf.gob.mx>',
    'Lucina Sanchez Quiroz <lucina.sanchez@tsjdf.gob.mx>',
    'SICOR Sistema <sicor_sistema@tsjdf.gob.mx>',
    'AdianSD <adrian@skills-depot.com>',
    'Javier Pineda Rodriguez <javierpinedarodriguez@gmail.com>',
    'Erika Padilla <ecamargo03@gmail.com>',
    'Jorge Valerio <jorgevaleriosd@gmail.com>',
    'Adabella Danae Rayon Bravo <adabella.rayon@gmail.com>',
    'Antonio Sobrino <asobrino70@gmail.com>'.
    'Misael Nelson Cruz <misaelnelson.cruz@gmail.com>',
    'Manolo Mondragon <manolodragon@gmail.com>'
]

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

msg = MIMEText(msg.encode('utf-8'), _charset='utf-8')
msg['Subject'] = "Boletín Judicial del " + sys.argv[2]
msg['From'] = fromaddr
msg['To'] = ", ".join( [ str( Header(x, 'utf-8')) for x in toaddrs ])

print("Message length is " + repr(len( msg.as_string() )))

#destin = ", ".join([ re.sub( r'^.*\<',"", x[:-1]) for x in toaddrs ])
#destin = ('sicor_sistema@tsjdf.gob.mx',)
destin = [ str( Header(x, 'utf-8')) for x in toaddrs ]

#Change according to your settings
smtp_server = 'email-smtp.us-east-1.amazonaws.com'
smtp_username = "AKIAJCIMGKYVUBUR737A"
smtp_password = 'AjaxaoOQMscaKGIQI5vgHzs6GvjMevXmLt0LsNtjx72h'
smtp_port = '587'
smtp_do_tls = True

print("\n\n\n",destin,"\n\n\n")

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
    server.sendmail(fromaddr, destin, msg.as_string())
    print(server.quit())
else:
    print(fromaddr, destin, msg.as_string())
