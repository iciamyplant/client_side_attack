# Client Side Attacks

= attaque où la connexion au contenu malveillant est initiée à partir du client (généralement en étant incité à cliquer sur un lien malveillant dans un e-mail, un message instantané, ou autre : user interaction often needed), contrairement aux server-side attacks où le serveur initie l'attaque (par exemple SQL injection). 
- l'attaquant send un link ou autre
- le client clique et initie la connection au serveur malicieux
- le serveur send back le code malicieux

L'objectif étant de cibler les vulnérabilités de l'appareil client ou d'un ou plusieurs de ses logiciels (comprennent des logiciels de traitement de texte, lecteur PDF, des navigateurs Web, environnement Java, etc). Dans le but d’obtenir des informations sensibles (cookies, identifiants, numéro de CB, etc.) ou carrément de prendre le contrôle des postes de travail infectés.

Types de client-side attacks : cross-site scripting (xss), cross-site request forgery (csrf), content spoofing, session fixation, clickjacking


## plan
### I - Failles XSS
### II - Etapes avec BeEF-xss
### III - En pratique
### IV - JSshell


# I. Failles XSS

Faille XSS (=cross-site scripting) : vulnérabilité de sécurité des pages Web dynamiques, où il y a possibilité pour un attaquant d'injecter du code javascript, ou html, dans une page web qu'on va en tant que victime, exécuter à notre ainsu.

3 catégories de XSS : 
- stored (persistent) = injects scripts that remain on the server
- reflected = injects scripts that are sent to server and then bounce back to user
- DOM-based = executed completly on the client side nothing to do with the server

`````
// dans index.php 'Name' n'est pas protégé
// possibilité d'injecter du code
`````

Exemple : l'attaquant peut écrire un commentaire sur un blog, où il va mettre du JS qui fait une XSS. Et la prochaine fois qu'un mec va venir sur le blog, il va charger la page, qui contient le commentaire en JS (c'est une stored XSS) et le code malveillant va s'executer. Ce XSS va se déclencher pour chacun des utilisteurs légitimes qui vont charger la page après l'injection du JS. [Exemple d'exploitation faille XSS](https://www.youtube.com/watch?v=iHcXH8eByDA)


## 1. Bases du développement web

Dans une page web on a donc du HTML, CSS, Javascript.

- HTML =  langage de balise, qui permet de s'occuper du contenu du site (bouttons, menu, texte, vidéos, images, ...)
- CSS = langage de feuille de style, permet de styliser, mettre en forme le contenu (forme des menus, couleurs, polices d'écriture, ...)
- Javascript = langage qui permet de rendre les sites web interactifs
- React (=Angular JS, VueJS) = javascript library
- Nodejs = logiciel qui permet d'executer des applications javascript
- PHP = 
- Symfony (=Laravel) = framework PHP

```
Créer le premier site :
/img = on range les images du site
/dossier css = on a range les feuilles de style
/dossier js = pour les animations
index.hmtl = page principale de notre site web, première page sur laquelle les utilisateurs arrivent
```

structure de base d'une page HMTL : 
```
<!doctype html> <!--declaration du document, doc HTML-->
<html> <!--balise qui contient l'ensemble de la page, et dedans y a deux sous balises-->
<head> <!--Premiere sous balise, tete de page-->
    <title>Texte</title> <!--balise par defaut, titre de la page qui saffiche sur longlet-->
    <!-- tout ce qui sera interne au site mais sans le voir, refereencement du site, liaison avec les feuilles de style css,..-->
    <meta charset="utf-8"> <!--charset est l'attribut de la balise-->
    <link rel="stylesheet" type="text/css" href="css/styles.css"> <!--link permet de faire une relation avec un fichier, attribut relation definit le type de relaiton, ici une feuille de style. Type de document, et ensuite href chemin pour acceder-->
</head>
<body> <!--contient tout le contenu-->
    <h1> <!--headline1, c'est le gros titre de la page-->
        coucou
    </h1>
    <h2> <!--ca va jusqu'à h6-->
        voilà ma page
    </h2>
    <p> <!--balise paragraphe--> 
        Bienvenue sur mon site le sang
    </p>
    <a href="http://google.com/" target="_BLANK">Lien Vers Google
    </a><!--balise pr integrer des liens, target="_BLANK" permet de dire qu'il ouvre le lien dans une nouvelle page blanche, autre onglet --> 
    <img src="img/TheEnd.jpeg">
    <img src="img/allolaterre.png" width="200">
</body>
</html>
```



[Tuto de Graven pour HTML](https://www.youtube.com/watch?v=J9w-cir5a6U&t=425s)
[Playlist Graven web : HTML, CSS, PHP](https://www.youtube.com/playlist?list=PLMS9Cy4Enq5JAzNgWPK96HnkE_U7Ol3im)
[Tuto de Graven pour créer un site avec React & Nodejs](https://www.youtube.com/watch?v=yHoI0n2VxMU)


## 2. Fonctionnement d'une session HTTP

Quand on demande une page web on fait une requête HTTP. Le navigateur (client) va d'abord établir une connexion avec le serveur. Ensuite le client fait la requête HTTP. Le serveur web renvoie les fichiers qui contiennent du code (HTML donne la structure de la page, CSS la mise en forme, Javascript gère l'intéractivité avec l'internaute : les clics de l'internaute sont récupérés par le Javascript et des traitements sont déclenchés). Ils communiquent via le protocole HTTP, utilisé dans le but de permettre un transfert de fichiers (essentiellement au format HTML) localisés grâce à une chaîne de caractères appelée URL

### a. Etape 1 : Requête HTTP du navigateur

Requête HTTP = ensemble de lignes envoyé au serveur par le navigateur. Comprend :
- Une ligne de requête: c'est une ligne précisant le type de document demandé, la méthode qui doit être appliquée, et la version du protocole utilisée (généralement HTTP/1.0). La ligne comprend ces trois éléments devant être séparés par un espace.
- Les champs d'en-tête de la requête: un ensemble de lignes facultatives permettant de donner des informations supplémentaires sur la requête et/ou le client (Navigateur, système d'exploitation, ...). Chacune de ces lignes est composée d'un nom qualifiant le type d'en-tête, suivi de deux points : et de la valeur de l'en-tête
- Le corps de la requête: c'est un ensemble de lignes optionnelles devant être séparées des lignes précédentes par une ligne vide et permettant par exemple un envoi de données par une commande POST lors de l'envoi de données au serveur par un formulaire


```
GET /fichier.html HTTP/1.1[CRLF]
Host: www.monsite.com[CRLF]
User-Agent: Mozilla/5.0 Safari/531.9[CRLF]
[CRLF]
```

```
----- Ligne de requête -----
GET /fichier.html HTTP/1.1[CRLF] // ici on demande le document fichier.html avec la méthode GET et la version HTTP/1.1 + CRLF = délimiteur utilisé par le protocole HTTP pour séparer les lignes de l'en-tête

----- champs http ou en-têtes http (facultatives) -----
Host: www.monsite.com[CRLF] // champ http avec comme valeur www.monsite.com
User-Agent: Mozilla/5.0 Safari/531.9[CRLF] // champ http User-Agent avec comme valeur Mozilla/5.0 Safari/531.9, donne des informations sur le client

----- ligne vierge -----
[CRLF]

----- corps (facultatif) -----
// pas de corps ici mais pour les requetes POST y en a un par exemple
```

Les différents types de requêtes sont définis par l’utilisation de méthodes HTTP différentes. Ces méthodes HTTP permettent d’indiquer au serveur quelle opération le client souhaite effectuer. Le méthode GET par exemple permet d’indiquer qu’on souhaite récupérer une ressource, tandis que POST est utilisée pour transmettre des données en vue d’un traitement à une ressource, DELETE est utilisée pour indiquer qu’on souhaite supprimer une ressource, etc.

| méthode|utilité|
|---|---|
|GET|permet de demander une ressource sans la modifier |
|POST|permet de transmettre des données dans le but de manipuler une ressource|
|PUT|permet de remplacer ou d’ajouter une ressource sur le serveur|
|DELETE|permet de supprimer une ressource du serveur |
|HEAD|permet de demander des informations sur la ressource sans demander la ressource elle-même|
|PATCH|permet de modifier partiellement une ressource|
|OPTIONS |permet d’obtenir les options de communication d’une ressource ou du serveur|
|CONNECT|permet d’utiliser un proxy comme un tunnel de communication|
|TRACE|permet de tester et d’effectuer un diagnostic de la connexion et demandant au serveur de retourner la requête reçue|



Exemple : On demande la chaîne YouTube, https://www.youtube.com/channel/UC9wzC5mFFcIdguoyveTo6Ng (Format des URLs : protocole://adresse-du-serveur:port/chemin/ressource). Clic droit sur la page du navigateur > inspecter l'élément > Onglet Network // permet de voir toutes les requêtes HTTP que fait notre navigateur.

<img width="1438" alt="Capture d’écran 2023-08-04 à 16 06 43" src="https://github.com/iciamyplant/client_side_attack/assets/57531966/901f61f9-7ab4-43a5-820a-cf0558583259">


### b. Etape 2 : Réponse HTTP du serveur

Réponse HTTP = ensemble de lignes envoyées au navigateur par le serveur. Comprend :
- Une ligne de statut : précisant la version du protocole utilisé et l'état du traitement de la requête à l'aide d'un code et d'un texte explicatif. La ligne comprend trois éléments devant être séparés par un espace : La version du protocole utilisé, Le code de statut, La signification du code
- Les champs d'en-tête de la réponse: il s'agit d'un ensemble de lignes facultatives permettant de donner des informations supplémentaires sur la réponse et/ou le serveur
- Le corps de la réponse: il contient le document demandé

```
HTTP/1.1 200 OK[CRLF]
Date: Thu, 24 Sep 2009 19:37:34 GMT[CRLF]
Server: Apache/2.2.3[CRLF]
Content-Length: 7234[CRLF]
Content-Type: text/html; charset=UTF-8[CRLF]
[CRLF]
[ici se trouve le corps (body) de la réponse]
```

La première ligne de la réponse contient toujours le 'code' HTTP indiquant si la requête a réussi ou pas. Puis, comme pour la réponse, on trouve les lignes des champs HTTP. Tout ceci constitue l'en-tête de la réponse. Ensuite se trouve le corps de la réponse, qui dans le cas d'un GET d'un fichier HTML contient par exemple le code HTML de la page visée.

Exemple : Le serveur renvoie la page HTML

<img width="1439" alt="Capture d’écran 2023-08-04 à 16 07 27" src="https://github.com/iciamyplant/client_side_attack/assets/57531966/92499e9f-2e74-45fe-a368-b2c349c782d8">




### c. Etape 3 : Traitement de la réponse HTTP par le navigateur

Quand il recoit le premier bloc de données, parse les infos pour les transformer en DOM (=transforme le fichier HTML en objets JS) et CSSOM, utilisés par le moteur de rendu.
Le DOM est la représentation interne du balisage pour le navigateur. Le DOM est également exposé et peut être manipulé via diverses API en JavaScript.

cinq étapes dans le chemin de rendu : 
1. traiter le balisage HTML et créer l'arborescence DOM. L'analyse HTML implique la création de jetons, tokenization, et la construction du DOM tree. Les jetons HTML incluent les balises de début et de fin, ainsi que les noms et les valeurs des attributs. Si le document est bien formé, son analyse est simple et rapide. L'analyseur analyse les entrées sous forme de jetons dans le document, créant ainsi le document tree.
2. Le DOM tree décrit le contenu du document. L'élément <html> est la première balise et le premier nœud racine du document tree. L'arbre reflète les relations et les hiérarchies entre différentes balises. Les balises imbriquées dans d'autres balises sont des nœuds enfants. Plus le nombre de nœuds DOM est élevé, le plus de temps ca prends pour construire le DOM tree.






chaque node du DOM, on va pouvoir faire des choses dessus, il faut voir le DOM comme une API JS sur lequel on peut communiquer pour modifier des trucs. get element.id, 




---------

- Qu'est-ce que le navigateur exécute en badground ?

Les navigateurs tels qu'Internet Explorer et Firefox sont en fait un ensemble de logiciels : le navigateur lui-même, plus des logiciels tiers tels qu'Adobe Acrobat Reader, Adobe Flash, iTunes, QuickTime, RealPlayer, etc. Tous sont potentiellement vulnérables aux attaques côté client. 

[cours sur les session HTTP](https://www.pierre-giraud.com/http-reseau-securite-cours/requete-reponse-session/)
[cours sur le traitement de la réponse HTTP par le navigateur](https://developer.mozilla.org/fr/docs/Web/Performance/How_browsers_work)




---------

Mais attention : Les requêtes HTTP sont formulées par le client (c’est-à-dire dans la majorité des cas le navigateur de vos visiteurs) et vous n’avez donc quasiment aucun contrôle dessus. Idem, les réponses HTTP sont créées par le serveur et vont en grande partie dépendre de la configuration de celui-ci. En fonction de votre hébergeur et de votre formule d’hébergement, vous allez avoir plus ou moins de contrôle sur la configuration de votre espace serveur.



## 3. Configurer un serveur HTTP

Quand on parle de serveur, on parle du hardware. Mais y a un certains nombre de programmes qui tournent sur le serveur qu'on appelle aussi serveurs, car ils répondent à des requetes.
- serveur HTTP : logiciel qui prend en charge les requettes client/serveur du protocole HTTP, ex : Apache, 2is, Nginx
- serveur Mysql : s'adresse au système de fichier pour récupérer des données
- serveur FTP : quand le dev a fini sa page web, il l'envoie sur le serveur hardware par l'intermédiaire du serveur ftp

|Type de serveur|Def|
|----|-----|
|serveur statique|un OS, et un serveur HTTP|
|serveur dynamique|en + inclue une BDD et un langage de script comme PHP (= dont le rôle est d'interpréter les demandes du client et de les traduire en HTML)|

![Capture d’écran 2023-08-03 à 18 30 54](https://github.com/iciamyplant/client_side_attack/assets/57531966/351c38cc-3bf5-4f8c-ab66-d700fbe08e6e)














## 3. Sites vulnérables

[OWASP Top 10 most critical security risks to web applications](https://owasp.org/www-project-top-ten/)

De manière générale, tout ce qui vient de l’extérieur − saisi par un être humain dans un formulaire, ou bien reçu lors d’un appel à un webservice externe − doit être traité de manière particulière. [14 règles à suivre selon OWASP pour la prévention des failles XSS](https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.md). [Résumé des préventions] (https://www.geek-directeur-technique.com/2020/04/04/les-failles-de-securite-de-base-dans-le-web-2-le-cross-site-scripting-xss)

- du code en quels langages peut-on injecter ? php, JS, ...
- comment le développeur est-il censé protéger ? cas le plus courant de ces vulnérabilités se produit lorsque des variables GET sont imprimées ou renvoyées en écho sans filtrage ni vérification de leur contenu
- exemples de sites et de non-protection. [démo video](https://www.youtube.com/watch?v=E47rY21gXSY) Exemples : https://www.0x0ff.info/2021/attaque-cote-client-xss-et-phishing/



## 4. Malicious code

Que fait le code malicieux que j'injecte ? 
- steal cookies
- read sensitive info
- inject malware
- install a keylogger
- ....


[vidéo explication](https://www.youtube.com/watch?v=TVBMqQGLCYM)



----------------

How 22 Lines of Code Claimed 380,000 Victims. How We Used Machine Learning to to Pinpoint the Magecart Crime Syndicate.
[whole explanation of british airways xss exploitation](https://schoenbaum.medium.com/inside-the-breach-of-british-airways-how-22-lines-of-code-claimed-380-000-victims-8ce1582801a0)



## II - Etapes avec BeEF-xss

Il existe plusieurs frameworks d'exploitation des failles XSS : BeEF-xss, The Cross-Site Scripting Framework (XSSF), OWASP Xenotix XSS Exploit Framework, Autopwn.

BeEF-xss est un framework d'exploitation Web codé en PHP & JavaScript, se concentre sur l'exploitation de vulnérabilités du coté navigateur (client). Consiste à exploiter un vecteur d’attaque sur une machine cliente (vecteur XSS, CSRF, etc) pour ouvrir une porte d’accès au système, et d’examiner les exploitations potentielles dans le contexte courant du navigateur. Une fois une cible rattachée à BeEF, le framework exploite un tunnel asynchrone (principalement généré par Javascript/Ajax) afin de lancer l’exécution de modules dans le navigateur de la cible, et ainsi perpétuer des attaques à l’encontre du système. 

- lancer un serveur Linux avec beef installé dessus (voir Ngrok, faut ajouter des informations dans le fichier de config) // port forwarding. Serveur de communication = composant qui communique via HTTP avec les navigateurs infectés
- on lance beef, et on obtient : l'url de l'interface administration + le hook.js à injecter
- injecter le hook.js dans une page web, site XSSed recense une grande partie de l’actualité liée à cette famille de vulnérabilités
- envoyer à la victime le lien (email, sms?) et donner une bonne raison de cliquer sur le lien
- la victime clique, son navigateur va exécuter le contenu du paramètre de l'url qui contient le code maveillant, le script nous retourne les données 
- on peut exécuter des commandes : play sound, webcam, ... et accéder à des informations comme cookies, plug-ins installés, log de ce qui est fait sur le site...
- possibilité de faire ses propres modules, regarder ce qui a été fait comme c'est de l'open source
- persistence : faire que ça fonctionne même quand l'onglet est fermé

# III - En pratique

### Lancer un serveur de communication (local, port forwarding, ngrok)

#### A. En local pour avoir le server on en local + le hook.js

[Tutoriel](https://www.youtube.com/watch?v=V26rdXUFQAY)
`````
git clone https://github.com/beefproject/beef.git
cd beef
./install
leafpad config.yaml // change psswrd
./beef 
// server on http://127.0.0.1:3000/ui/panel
// hook.js http://127.0.0.1/hook.js
sudo beef-xss
`````

On va essayer de hook un browser en local sur la meme machine. On a notre pannel Beef ouvert dans firefox. On va ouvrir le hook.js dans un autre browser pour voir si ca marche et que ca s'affiche dans notre pannel. [Tutoriel using beef on LAN](https://www.youtube.com/watch?v=ZYB4B89vAyw)
````
sudo apt install chromium-driver //on instale chromium driver pour ouvrir le hook.js
// on lance le 127.0.0.1:3000/demos/basic.html
// ca fonctionne
// dans le commandes : rouge ca veut dire que la commande ne va pas fonctionner sur le browser de la victime, vert ca signifie que ca va marcher, et blanc ca veut dire que may work or not
````
|commande|explication|
|-----|------|
|alert dialog|pop-up avec un texte où on écrit ce qu'on veut|
|prompt screen|pop-up mais la cible peut ecrire qqch et on peut recuperer ce quelle ecrit|
|fake flash update | pop-up en mode il faut faire une update. Si clique sur install ==> dwld le file. Donc si execute le fichier possibilité d'injecter un payload. On peut changer l'image du pop-up qui s'affiche pr que ca soit credible|
|google phishing| fake google gmail page|
|pretty theft|ask username and password using a floating div (fausse page on peut choisir facebook, linkedin, youtube etc.) |
|spyder eye|take a picture of the victime's browser window|
|get geolocation|retrives the physical location of the hooked browser using third party hosted geolocation APIs |
|redirect browser|redirect the selected hooked browser to the adress specified in the 'redirected URL' input|
|...||

Maintenant on va hook le browser d'une autre machine sur notre LAN. Apache est pré-installé sur Kali Linux. VM sur Virtual Box automatiquement en NAT, mettre en pont si jveux quelle ai son adress ip comme toutes les autres machines du reseau. 
````
ifconfig //doit etre en format 192.168. et pas en 10.
//mettre en bridge
// avoir éteint complétement la VM pr changer
````

````
cd /var/www/html
sudo vim index.html
//on ajoute le hook url dans le index.html
ifconfig //recup mon ip adress de mon vm kali
//je remplace dans la hook url par mon adresse ip de ma machine dans mon index.html
service apache2 start
service apache2 status
// maintenant entrer mon adresse ip de mon serveur avec une autre machine
//OK sur mon tel + sur mon mac
service apache stop
sudo beef-xss-stop
````
Ok, on a accès à notre page web hébergée sur notre serveur Apache sur la VM à partir de mon téléphone + du MAC sur le reseau local. On a réussi sur l'index.html de Apache de mettre le hook.js, et on arrive à envoyer des commandes sur mon tel et mac. Mais là on peut accéder à index.hmtl à partir des machines de mon réseau, mais il sera pas accessible à partir de l'internet. Maintenant on va essayer de hook un navigateur d'une machine qui n'est pas sur mon réseau local. Une solution est de prendre un hébergement et j'y envoyoie mes fichiers : sauf qui si on taff sur wordpress va falloir synchroniser la bdd etc. 2 autres solutions : port forwarding et ngrok

