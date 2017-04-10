####################################################
#génération des "insert into" de la table Bille
####################################################

#retourne le Insert Into Values sous la forme d'une chaîne de caractères
def insertion_Bille(idBille,url):
    insert_into ="INSERT INTO BILLE VALUES ("+str(idBille)+",'"+str(url)+"');\n"
    return insert_into

#tableau contenant toutes les billes
Billes = [1] * 64
    
#initialisation des numéros des billes
num_coll_1 = 1
num_coll_2 = 1
num_coll_3 = 1
num_coll_4 = 1
num_coll_5 = 1
num_coll_6 = 1
num_coll_7 = 1
num_coll_8 = 1
num_coll_9 = 1
num_coll_10 = 1

#création de l'url
for i in range(64) :
    url = ''
    if i < 8 :
        url = '/Collections/4_billes/'
        if i < 4 :
            url += 'Rayures/' + str(num_coll_1) + '.jpg'
            num_coll_1 += 1
        elif i < 8 :
            url += 'Gris/' + str(num_coll_2) + '.jpg'
            num_coll_2 += 1
        
    elif i < 44 :
        url = '/Collections/6_billes/'
        if i < 14 :
            url += 'Couleurs/' + str(num_coll_3) + '.jpg'
            num_coll_3 += 1
        elif i < 20 :
            url += 'Formes/' + str(num_coll_4) + '.jpg'
            num_coll_4 += 1
        elif i < 26 :
            url += 'Mathématiciens/' + str(num_coll_5) + '.jpg'
            num_coll_5 += 1
        elif i < 32 :
            url += 'Planètes/' + str(num_coll_6) + '.jpg'
            num_coll_6 += 1
        elif i < 38 :
            url += 'Politiques/' + str(num_coll_7) + '.jpg'
            num_coll_7 += 1
        elif i < 44 :
            url += 'Psychédélique/' + str(num_coll_8) + '.jpg'
            num_coll_8 += 1
            
    else :
        url = '/Collections/10_billes/'
        if i < 54 :
            url += 'Arbres/' + str(num_coll_9) + '.jpg'
            num_coll_9 += 1
        elif i < 64 :
            url += 'Yeux/' + str(num_coll_10) + '.jpg'
            num_coll_10 += 1
    Billes[i] = url
        
        
#Ecriture dans un fichier txt
mon_fichier = open("Billes.txt", "w") 

for i in range(64):
    #on ajoute un insert into
    mon_fichier.write(insertion_Bille(i+1,Billes[i]))

mon_fichier.close()
