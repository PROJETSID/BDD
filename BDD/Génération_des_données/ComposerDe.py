####################################################
#génération des "insert into" de la table ComposerDe
####################################################

#retourne le Insert Into Values sous la forme d'une chaîne de caractères
def insertion_Composer(idBille, idCollection):
    insert_into ="INSERT INTO COMPOSER VALUES ("+str(idBille)+","+str(idCollection)+");\n"
    return insert_into

#tableau contenant toutes les liens Bille/Collection
Composer = [0] * 64

#création de l'url
for i in range(64) :
    idCollection = ''
    if i < 8 :
        if i < 4 :
            idCollection = 1
        elif i < 8 :
            idCollection = 2
    elif i < 44 :
        if i < 14 :
            idCollection = 3
        elif i < 20 :
            idCollection = 4
        elif i < 26 :
           idCollection = 5
        elif i < 32 :
            idCollection = 6
        elif i < 38 :
            idCollection = 7
        elif i < 44 :
            idCollection = 8
    else :
        if i < 54 :
             idCollection = 9
        elif i < 64 :
             idCollection = 10
             
    Composer[i] = idCollection
        
    
#Ecriture dans un fichier txt
mon_fichier = open("Composer.txt", "w") 

for i in range(64):
    #on ajoute un insert into
    mon_fichier.write(insertion_Composer(i,Composer[i]))

mon_fichier.close()
