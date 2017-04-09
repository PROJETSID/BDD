####################################################
#génération des "insert into" de la table Collection
####################################################

#retourne le Insert Into Values sous la forme d'une chaîne de caractères
def insertion_Collection(idCollection, nomCol, nbBillesCol, difficulté):
    insert_into ="INSERT INTO COLLECTION VALUES ("+str(idCollection)+",'"+nomCol+"',"+str(nbBillesCol)+",'"+difficulté+"');\n"
    return insert_into

#les 10 collections existantes
col_1 = [1,'Gris',6,'paisible']
col_2 = [2,'Rayures',6,'paisible']
col_3 = [3,'Couleurs',8,'facile']
col_4 = [4,'Formes',8,'facile']
col_5 = [5,'Politiques',8,'modérée']
col_6 = [6,'Planètes',8,'modérée']
col_7 = [7,'Psychédélique',8,'difficile']
col_8 = [8,'Planètes',8,'difficile']
col_9 = [9,'Arbres',10,'cauchemardesque']
col_10 = [10,'Yeux',10,'cauchemardesque']

#on les range dans une liste
Collections = [col_1,col_2,col_3,col_4,col_5,col_6,col_7,col_8,col_9,col_10]

#Ecriture dans un fichier txt
mon_fichier = open("Collection.txt", "w") 

for i in range(10):
    #on ajoute un insert into
    mon_fichier.write(insertion_Collection(Collections[i][0],Collections[i][1],Collections[i][2],Collections[i][3]))

mon_fichier.close()
