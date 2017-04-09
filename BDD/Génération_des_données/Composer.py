####################################################
#génération des "insert into" de la table ComposerDe
####################################################

#retourne le Insert Into Values sous la forme d'une chaîne de caractères
def insertion_Composer(idBille, idCollection):
    insert_into ="INSERT INTO COMPOSER VALUES ("+str(idBille)+","+str(idCollection)+");\n"
    return insert_into

#tableau contenant toutes les liens Bille/Collection
Composer = [0] * 84

#création de l'url
for i in range(84) :
    idCollection = ''
    if i < 12 :
        if i < 6 :
            idCollection = 1
        elif i < 12 :
            idCollection = 2
    elif i < 60 :
        if i < 20 :
            idCollection = 3
        elif i < 20 :
            idCollection = 4
        elif i < 28 :
           idCollection = 5
        elif i < 36 :
            idCollection = 6
        elif i < 52 :
            idCollection = 7
        elif i < 60 :
            idCollection = 8
    else :
        if i < 72 :
             idCollection = 9
        elif i < 84 :
             idCollection = 10
             
    Composer[i] = idCollection
        
    
#Ecriture dans un fichier txt
mon_fichier = open("Composer.txt", "w") 

for i in range(84):
    #on ajoute un insert into
    mon_fichier.write(insertion_Composer(i+1,Composer[i]))

mon_fichier.close()
