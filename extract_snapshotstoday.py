#!/Python27/python

import requests
import time
import StringIO
import csv
import datetime
import pymssql
import io
import sys
import os
import datetime


print "Extractor de Snapshots"

nombreBSM = ["ENLACE","SuperNet","Benchmark","Expresso","Jupiter","Jupiter Contact Center","Portal de Solucion","Consumo","Neo Jupiter","PeopleSoft","Portal Santander","SEL","SESAR","ASIGNET"]
canales = ["HPBSM_ENLACE","HPBSM_SUPERNET","HPBSM_BENCHMARK","HPBSM_EXPRESSO","HPBSM_JUPITER","HPBSM_CONTACT_CENTER","HPBSM_PORTAL_SOLUCION","HPBSM_CONSUMO","HPBSM_NEOJPTR","HPBSM_PEOPLESOFT","HPBSM_PORTALES","HPBSM_SEL","HPBSM_SESAR","HPBSM_ASIGNET"]

#canal = "HPBSM_ENLACE"

def get_snapshots(canal,fecha):
    print fecha
    host = "190.210.183.102"
    user = "sa"
    passwd = "Tsoft123"
    #base = "vun_bimbo"
    conn = pymssql.connect(host,user,passwd,canal)
    print canal
    cursor = conn.cursor()
    query = """
    SELECT TUID, EAI_SNAPSHOT
    FROM BPM_TRANS_ERR_SNAP 
    WHERE DBDATE >= '"""+ str(fecha)+"""'
    """
    print "-"*20
    print query
    cursor.execute(query)
    row = cursor.fetchone()
    root = "C://Program Files (x86)//Apache Software Foundation//Apache2.2//htdocs//snapshots//"
    #print "indice:", canales.index(canal),nombreBSM[canales.index(canal)]
    #directorio = root + canal + "//" + str(ayer)
    directorio = root + nombreBSM[canales.index(canal)] + "//" + str(fecha)
    print "Directorio: " + directorio
    if not os.path.exists(directorio):
        os.makedirs(directorio)
    
    while row:
        print "x"
        #print row[0]
        img =  StringIO.StringIO(row[1])
        img2 = io.BytesIO(row[1])
		#print str(row[0])
        if not os.path.isfile(directorio + '/' + str(row[0]) + '.zip'):
            file = open( directorio + '//' + str(row[0]) + '.zip', 'wb')
            file.write(img2.getvalue())
        row = cursor.fetchone()

    conn.commit()
    conn.close()


print "ERRORES BSM"
hoy = datetime.date.today()
print "Hoy: " + str(hoy)
un_dia = datetime.timedelta(days=1)
ayer = hoy - un_dia
print "Ayer: " + str(ayer)
for canal in canales:
	#for single_date in (hoy - datetime.timedelta(days = n) for n in range(30)):
	#	#print canal, single_date, ayer
		#get_snapshots(canal,single_date)
	get_snapshots(canal,hoy)