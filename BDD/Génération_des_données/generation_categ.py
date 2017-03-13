# -*- coding: utf-8 -*-
"""
Created on Mon Mar 13 09:48:09 2017

@author: Natchley
"""

liste_categ = ["Aluminium","Fer","Carbone","Bronze","Inox","Argent","Chrome","Or","Platine","Titane"]


#Ecriture dans un fichier txt
mon_fichier = open("fichier_categ.txt", "w") 

for i in range(0,len(liste_categ)):
    mon_fichier.write("INSERT INTO CATEGORIEJOUEUR VALUES (Seq_CategorieJoueur_idCat.nextval,'"
                                                                        + liste_categ[i]+"','Categorie_joueur\\"+liste_categ[i]+".jpg');\n")

mon_fichier.close()