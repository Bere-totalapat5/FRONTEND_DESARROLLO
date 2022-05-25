#!/usr/bin/env python3
# -*- coding: utf-8 -*-

debugis   = 1
FILESBASE = "/tmp/gotfile"

import os
from time import strftime, localtime
import logging
import shutil
from base64   import b64decode
from tempfile import mkdtemp

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
logger.info("Worker Init")

# -- AMPQ queue -- Start
import pika
QUEUEH      = "localhott"
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


logger.info('Worker ready')

def callback(ch, method, properties, body):
    (filename,payload) = body.split(b"|",1)
    filename = filename.decode()
    logger.debug("Got: %s" % filename)
    original = os.path.join( FILESBASE, filename)

    ch.basic_ack(delivery_tag = method.delivery_tag)
    if not os.path.isfile(original):
        mytdir  = mkdtemp(prefix='fromwin_',dir=FILESBASE)
        mytfile = os.path.join(mytdir, filename)
        with open(mytfile,"wb") as f:
            f.write( b64decode(payload) )
        if not os.path.isfile(original):
            shutil.move(mytfile, original)
        shutil.rmtree(mytdir)

    if os.path.isfile(original):
        statinfo = os.stat(original)
        logger.info( "orig %14d %s %s" % (statinfo.st_size, strftime("%Y-%m-%d %X", localtime(statinfo.st_mtime)), original))
    else:
        logger.error( "Did not save: %s" % (original,))

channel.basic_qos(prefetch_count=1)
channel.basic_consume(on_message_callback=callback, queue=ROUTE)
channel.start_consuming()
