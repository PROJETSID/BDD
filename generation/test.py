# -*- coding: utf-8 -*-
"""
Created on Mon Mar 13 06:07:25 2017

@author: formationsid
"""

import sys
import math
# import numpy
from random import *
# import xlrd
# from xlwt import workbook, formula
import string

# import pandas as pd

liste_niveau = [range(1,51)]



# generation des modalités
def master(n):
    data = []
    liste = {}
    for i in range(n):
        timerN = ""
        idCollection = ""
        seuiExp = i+10
        if i<10:
            liste = {"idNiveau": i, "seuilExpN":seuiExp, "nbEmplacements": 2, "timerN": timerN, "idCollection": idCollection}
        else:
            if i < 40:
                liste = {"idNiveau": i, "seuilExpN":seuiExp, "nbEmplacements": 4, "timerN": timerN,
                     "idCollection": idCollection}
            else:
                liste = {"idNiveau": i, "seuilExpN":seuiExp, "nbEmplacements": 8, "timerN": timerN,
                     "idCollection": idCollection}    
        data.append(liste)
    return data

data1 = master(50)
    
print(data1)


#Ecriture dans un fichier txt
mon_fichier = open("fichier.txt", "w") 


for i in range(0,len(data1)):
    mon_fichier.write("INSERT INTO \"21400692\".CATEGORIEJOUEUR VALUES (0,'"
                                                                        + data1[i]['nomCat'] +"','ddddddd');\n")

mon_fichier.close()