# -*- coding: utf-8 -*-
"""
Created on Mon Mar  6 10:15:32 2017

@author: Natchley
"""

import sys
import math
# import numpy
from random import *
# import xlrd
# from xlwt import workbook, formula
import string

# import pandas as pd


# creation du pseudo
liste_chaine = string.ascii_letters + string.digits
k = 7

w = 5
# generation de nombre de point de 1 à 500
liste_experienceJ = range(1, 300)

liste_niv = range(1, 3)


# generation des modalités
def master(n):
    data = []
    liste = {}
    for i in range(n):
        vPseudo = ''.join(sample(liste_chaine, k))
        list_experienceJ = choice(liste_experienceJ)
        liste_motDePasse = ''.join(sample(liste_chaine, w))
        liste_niveau = choice(liste_niv)
        if liste_niveau == 1:
            idCat = 1
            seuilExpN = 100
            NBEmplacementsN = 2
            idCollection = 1
            timerN = ""
            liste_categ = "debutant"
            liste = {"idJoueur": i, "pseudoJ": vPseudo, "experienceJ": list_experienceJ, "motDePasse": liste_motDePasse,
                     "idCat": idCat, "nomCat": liste_categ,
                     "idNiveau": i, "seuilExpN": seuilExpN, "nbEmplacements": NBEmplacementsN, "timerN": timerN,
                     "idCollection": idCollection}
        else:
            if liste_niveau == 2:
                idCat = 2
                seuilExpN = 200
                NBEmplacementsN = 4
                idCollection = 2
                timerN = ""
                liste_categ = "intermediare"
                liste = {"idJoueur": i, "pseudoJ": vPseudo, "experienceJ": list_experienceJ,
                         "motDePasse": liste_motDePasse, "idCat": idCat, "nomCat": liste_categ,
                         "idNiveau": i, "seuilExpN": seuilExpN, "nbEmplacements": NBEmplacementsN, "timerN": timerN,
                         "idCollection": idCollection}
            else:
                idCat = 3
                seuilExpN = 200
                NBEmplacementsN = 4
                idCollection = 3
                timerN = ""
                liste_categ = "confirmé"
                liste = {"idJoueur": i, "pseudoJ": vPseudo, "experienceJ": list_experienceJ,
                         "motDePasse": liste_motDePasse, "idCat": idCat, "nomCat": liste_categ,
                         "idNiveau": i, "seuilExpN": seuilExpN, "nbEmplacements": NBEmplacementsN, "timerN": timerN,
                         "idCollection": idCollection}
        data.append(liste)
    return data


data1 = master(10)
for i in range(0,len(data1)):
    print (data1[i]['nomCat'])
    
print(data1)


#Ecriture dans un fichier txt
mon_fichier = open("fichier.txt", "w") 


for i in range(0,len(data1)):
    mon_fichier.write("INSERT INTO \"21400692\".CATEGORIEJOUEUR VALUES (0,'"
                                                                        + data1[i]['nomCat'] +"','ddddddd');\n")

mon_fichier.close()



###########
#génération des "insert into" de la table Collection
###########

#nombre de collection de chaque taille à insérer (4 billes, 6 billes et 10 billes)
nbCol_par_type = [2,3,0]


col_1 = [1,'Gris',4,'paisible']
col_2 = [1,'Rayures',4,'paisible']
col_3 = [1,'Classique',6,'facile']
col_4 = [1,'Formes',6,'facile']
col_5 = [1,'Politique',6,'modérée']
#col_6 = [1,'a',6,'modérée']
#col_7 = [1,'a',6,'difficile']
#col_8 = [1,'a',10,'difficile']
#col_9 = [1,'a',10,'cauchemardesque']
#col_10 = [1,'a',10,'cauchemardesque']

Collections = []


#penser à rajouter cinq collections !!! après avoir rajouté des images
#Ecriture dans un fichier txt
mon_fichier = open("fichier.txt", "w") 
i = 0
for i in range(5):
    
for i in range(0,len(data1)):
    mon_fichier.write("INSERT INTO \"21400692\".CATEGORIEJOUEUR VALUES (0,'"
                                                                        + data1[i]['nomCat'] +"','ddddddd');\n")

    

def insertion_Collection():
    insert_into_Collection = 
    

liste = {"idJoueur": i, "pseudoJ": vPseudo, "experienceJ": list_experienceJ,
                         "motDePasse": liste_motDePasse, "idCat": idCat, "nomCat": liste_categ,
                         "idNiveau": i, "seuilExpN": seuilExpN, "nbEmplacements": NBEmplacementsN, "timerN": timerN,
                         "idCollection": idCollection}


mon_fichier.close()



