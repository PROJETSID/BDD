# -*- coding: utf-8 -*-
"""
Created on Thu Mar 16 05:11:57 2017

@author: formationsid
"""

from random import *

import string

# creation du pseudo
liste_chaine = string.ascii_letters + string.digits
k = 7
w = 8

def master(n):
    data = []
    liste = {}
    for i in range(n):
        vPseudo = ''.join(sample(liste_chaine, k))
        list_experienceJ = 0
        liste_motDePasse = ''.join(sample(liste_chaine, w))
        liste_id_Cat = 1
        liste = {"idJoueur": i+1, "pseudoJ": vPseudo, "experienceJ": list_experienceJ, "motDePasse": liste_motDePasse,
                     "idCat": liste_id_Cat}
        data.append(liste)
    return data
    
mon_fichier = open("Joueurs.txt", "w") 


data1 =  master(100)

print(data1)

for i in range(0,len(data1)):
    mon_fichier.write("INSERT INTO JOUEUR VALUES ("+str(data1[i]['idJoueur'])+",'"+data1[i]['pseudoJ']+
    "',"+str(data1[i]['experienceJ'])+",'" +data1[i]['motDePasse']+"',"+str(data1[i]['idCat'])+");\n")
mon_fichier.close()
