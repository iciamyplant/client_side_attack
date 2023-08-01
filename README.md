# Client Side Attacks

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

Essayer de tester un exemple d'xxs : https://www.0x0ff.info/2021/attaque-cote-client-xss-et-phishing/

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

