# Faire fonctionner le test:
**Le binaire symfony est requis.**  
Lancer le projet : 
`make start` docker est requis (container mysql)

Si erreur lors de la migration de la BDD, lancer :
`symfony console doctrine:migrations:migrate`

Si le serveur ne se lance pas : 
`symfony serve -d`

La donnée est au format CSV. (le fichier se trouve dans le dossier `data`)
Pour importer les données, prendre le fichier '/datas/encodedBase64data.txt'
Pourquoi encodé ? Pour que la donnée sur les commandes et les utilisateurs ne soit pas "lisible" si la requête est interceptée. (On pourrait même renforcer cette sécurité avec une clef de cryptage custom)

Copier coller les données et faire une requête POST sur 'http://127.0.0.1:8000/factory-upload-orders' avec un body en json.
Les clefs `filename` et `data` sont obligatoires.
Exemple de payload :
`{
    "filename": "test.txt",
    "data": "some data encoded"
}̀`  
Le swagger est disponible a l'adresse suivante: `https://127.0.0.1:8000/api/docs

# Aller plus loin
- La partie utilisateur (receiver) est assez légère. Possibilité de créer des vrais utilisateurs avec une gestion des droits, et de la traçabilité des insertions/modifications de la donnée.  
- Il n'y a pas de table stock. Cette partie est calculée dynamiquement via le `StatisticHelper`. On pourrait imaginer une table stock
automatiquement alimenter via un Event. Cet event pourrait être dispatch lors de l'import des datas ou lors de la modification d'une commande 
(si gestion des quantités).
- On pourrait augmenter les validations faites lors de l'import, notamment regarder si le fichier décodé est bien un CSV et s'il contient bien toutes les clefs
attendues.
- Dans un souci de performance, si le(s) fichier(s) téléchargé(s) s'avérai(en)t être beaucoup plus volumineux, je remplacerais l'utilisation de doctrine par du sql natif.  