# -*- coding: utf-8 -*-
"""
Created on Mon Mar 13 06:07:25 2017

@author: formationsid
"""

import sys
import math
from random import *
import string


liste_col = [1,1,1,1,1,2,2,2,2,2,3,3,3,3,3,4,4,4,4,4,5,5,5,5,5,6,6,6,6,6,7,7,7,7,7,8,8,8,8,8,9,9,9,9,9,10,10,10,10,10]
timerN = range(60000,900000,16800)
# generation des modalités
def master():
    data = []
    liste = {}
    for i in range(0,len(timerN)):
        timer =timerN[i]
        idCollection = liste_col[i]
        seuiExp = i*10
        if i<11:
            liste = {"idNiveau": i+1, "seuilExpN":seuiExp, "nbEmplacements": 2, "timerN": timer, "idCollection": idCollection}
        else:
            if i < 41:
                liste = {"idNiveau": i+1, "seuilExpN":seuiExp, "nbEmplacements": 4, "timerN": timer,
                     "idCollection": idCollection}
            else:
                liste = {"idNiveau": i+1, "seuilExpN":seuiExp, "nbEmplacements": 8, "timerN":timer,
                     "idCollection": idCollection}    
        data.append(liste)
    return data

data1 = master()
    
print(data1)


#Ecriture dans un fichier txt
mon_fichier = open("Niveau.txt", "w") 



print(data1)

for i in range(0,len(data1)):
    mon_fichier.write("INSERT INTO Niveau VALUES ("+str(data1[i]['idNiveau'])+","+str(data1[i]['seuilExpN'])+","+str(data1[i]['nbEmplacements'])+","+str(data1[i]['timerN'])+","+str(data1[i]['idCollection'])+");\n")
mon_fichier.close()
