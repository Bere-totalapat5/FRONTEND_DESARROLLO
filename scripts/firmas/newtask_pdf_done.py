#!/usr/bin/env python3
# -*- coding: utf-8 -*-

debugis = 1

import os
from time import strftime, localtime
import logging
import sys
from base64 import b64encode
logging.basicConfig()

mypid     = os.getpid()
logger    = logging.getLogger('rabbitMQ')
hdlr      = logging.FileHandler("/tmp/docs.log")
logger.addHandler(hdlr)

if debugis:
    logger.setLevel(logging.DEBUG)
    formatter = logging.Formatter("%(asctime)-15s [%(name)s] "+str(mypid)+" %(levelname)s - %(message)s")
else:
    logger.setLevel(logging.INFO)
    formatter = logging.Formatter("%(asctime)s [%(name)s] "+str(mypid)+" %(levelname)s - %(message)s")
hdlr.setFormatter(formatter)
logger.info("New Init")


# -- AMPQ queue -- Start
import pika
QUEUEH      = "172.19.228.38"
VHOST       = "sicor2"
ROUTE       = 'pdf_done'
credentials = pika.PlainCredentials('sicor2', 'sicor2rabbit')
connection  = pika.BlockingConnection(pika.ConnectionParameters(host=QUEUEH,
                                                               virtual_host=VHOST,
                                                               credentials=credentials))
if not connection:
    logger.error("Connection failed.")
channel = connection.channel()
if not channel:
    logger.error("Channel failed.")
channel.queue_declare(queue=ROUTE, durable=True)
# -- AMPQ queue -- End


for hfilename in sys.argv[1:]:
    logger.info("Got: %s" % (hfilename,))
    with open(hfilename,"rb") as f:
        channel.basic_publish(exchange='',
                    routing_key=ROUTE,
                    body=hfilename.encode() + b"|" + b64encode(f.read()),
                    properties=pika.BasicProperties(
                    delivery_mode = 2, # make message persistent
                        ))
        logger.info("Sent: %s" % (hfilename,))

logger.info("New End.")
connection.close()
