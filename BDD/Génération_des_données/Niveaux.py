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
timerN1 = range(211000,60000,-15100)
timerN2 = range(715000,228000,-16233)
timerN3 = range(883000,732000,-15100)
# generation des modalités
def master():
    data = []
    liste = {}
    for i in range(0,50):
        
        
        
        idCollection = liste_col[i]
        seuiExp = i*10
        if i<11:
            timer1 =timerN1[i]
            liste = {"idNiveau": i+1, "seuilExpN":seuiExp, "nbEmplacements": 4, "timerN": timer1, "idCollection": idCollection}
        else:
            if i < 41:
                timer2 =timerN2[i]
                liste = {"idNiveau": i+1, "seuilExpN":seuiExp, "nbEmplacements": 6, "timerN": timer2,
                     "idCollection": idCollection}
            else:
                timer3 =timerN3[i]
                liste = {"idNiveau": i+1, "seuilExpN":seuiExp, "nbEmplacements": 10, "timerN":timer3,
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
