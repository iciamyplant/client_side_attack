Client Side Attack

= attaque où la connexion au contenu malveillant est initiée à partir du client (généralement en étant incité à cliquer sur un lien malveillant dans un e-mail, un message instantané, ou autre : user interaction often needed), contrairement aux server-side attacks où le serveur initie l'attaque (par exemple SQL injection). 
- l'attaquant send un link ou autre
- le client clique et initie la connection au serveur malicieux
- le serveur send back le code malicieux

L'objectif étant de cibler les vulnérabilités de l'appareil client ou d'un ou plusieurs de ses logiciels (comprennent des logiciels de traitement de texte, lecteur PDF, des navigateurs Web, environnement Java, etc). Dans le but d’obtenir des informations sensibles (cookies, identifiants, numéro de CB, etc.) ou carrément de prendre le contrôle des postes de travail infectés.

Exemple : les attaquants peuvent exploiter une vulnérabilité d'un serveur web pour exécuter des scripts malicieux dans l'ordinateur de victimes et voler leurs données sensibles

Types de client-side attacks : cross-site scripting (xss), cross-site request forgery (csrf), content spoofing, session fixation, clickjacking


## plan
### I - Failles XSS
### II - Etapes avec BeEF-xss
### III - En pratique
### IV - JSshell


# I. Failles XSS

Faille XSS (=cross-site scripting) : dans une page web on a donc du HTML, CSS, Javascript. On a deux côtés : le côté client, qui voit la page, et le côté serveur. Le client et le serveur communiquent. Un personne peut prendre la page, et ajouter du JS (ou du HTML) dedans si pas protégé. Par exemple le pirate peut écrire un commentaire sur un blog, où il va mettre du JS qui fait une XSS. Et la prochaine fois qu'un mec va venir sur le blog, il va charger la page, qui contient le commentaire en JS (c'est une stored XSS) et le code malveillant va s'executer. Ce XSS va se déclencher pour chacun des utilisteurs légitimes qui vont charger la page après l'injection du JS. Donc une faille xss c'est la possibilité pour un attaquant d'injecter du code javascript, ou html, qu'on va en tant que victime, exécuter à notre ainsu. [Exemple d'exploitation faille XSS](https://www.youtube.com/watch?v=iHcXH8eByDA)

`````
// dans index.php 'Name' n'est pas protégé
// possibilité d'injecter du code
`````

3 catégories de XSS : 
- stored (persistent) = injects scripts that remain on the server
- reflected = injects scripts that are sent to server and then bounce back to user
- DOM-based = executed completly on the client side nothing to do with the server

## 1. Fonctionnement des navigateurs

Qu'est-ce qu'ils exécutent en badground ? Comment ? Tout le process où une page s'affiche 

Les navigateurs tels qu'Internet Explorer et Firefox sont en fait un ensemble de logiciels : le navigateur lui-même, plus des logiciels tiers tels qu'Adobe Acrobat Reader, Adobe Flash, iTunes, QuickTime, RealPlayer, etc. Tous sont potentiellement vulnérables aux attaques côté client. 

Serveur web : sert les pages web au client. Le client (navigateur) fait une demande de page web au serveur, qui lui envoie la page demandée, ils communiquent via le protocole HTTP. C'est un serveur informatique qui permet de stocker et publier des pages web, générallement écrites en HTML. Au niveau matériel : ordinateur qui stocke des fichiers qui constituent une page web (documents HTML, images, fichiers JS...). Au niveau logiciel : 
- statique : un OS, et un serveur HTTP (= logiciel qui prend en charge les requettes client/serveur du protocole HTTP, ex : Apache, 2is, Nginx)
- dynamique : en + inclue une BDD et un langage de script comme PHP (= dont le rôle est d'interpréter les demandes du client et de les traduire en HTML)

## 2. Sites vulnérables

unprotected input

## 3. Malicious code

Que fait le code malicieux que j'injecte ? 
- steal cookies
- read sensitive info
- inject malware
- install a keylogger
- ....


[vidéo explication](https://www.youtube.com/watch?v=TVBMqQGLCYM)








## 1. Explication







## 2. Pratique

