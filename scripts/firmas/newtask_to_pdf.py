#!/usr/bin/env python3
# -*- coding: utf-8 -*-

debugis = 1

import os
from time import strftime, localtime
import sys
from base64 import b64encode

logger      = False
log_enabled = False

# -- AMPQ queue -- Start
import pika
QUEUEH      = "172.19.228.38"
VHOST       = "sicor2"
ROUTE       = 'to_pdf'
credentials = pika.PlainCredentials('sicor2', 'sicor2rabbit')
connection  = pika.BlockingConnection(pika.ConnectionParameters(host=QUEUEH,
                                                               virtual_host=VHOST,
                                                               credentials=credentials))
if not connection:
    if log_enabled: logger.error("Connection failed.")
channel = connection.channel()
if not channel:
    if log_enabled: logger.error("Channel failed.")
channel.queue_declare(queue=ROUTE, durable=True)
# -- AMPQ queue -- End

def send_to_win_queue( hfilename ):
    if False and log_enabled: logger.info("Got: %s" % (hfilename,))
    with open(hfilename,"rb") as f:
        channel.basic_publish(exchange='',
                    routing_key=ROUTE,
                    body=hfilename.encode() + b"|" + b64encode(f.read()),
                    properties=pika.BasicProperties(
                    delivery_mode = 2, # make message persistent
                        ))
        if log_enabled: logger.info("Sent: %s" % (hfilename,))

# connection.close()
