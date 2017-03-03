import sys
import math
from nympy.random import randn
from random import *
import xlrd
from xlwt import workbook, formula 
import string

#creation du pseudo
liste_chaine = string.ascii_letters+string.digits
k=7


#generation des modalités
def master(n):
    data = []
    liste = {}
    for i in range(n):
        vPseudo = ''.join(liste_chaine,k)
    return data 