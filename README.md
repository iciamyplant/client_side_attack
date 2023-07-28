Client Side Attack

### I - Failles XSS
### II - Etapes avec BeEF-xss
### III - En pratique
### IV - JSshell


# I. Failles XSS

## 1. Explication

Serveur web : sert les pages web au client. Le client (navigateur) fait une demande de page web au serveur, qui lui envoie la page demandée, ils communiquent via le protocole HTTP. C'est un serveur informatique qui permet de stocker et publier des pages web, générallement écrites en HTML. Au niveau matériel : ordinateur qui stocke des fichiers qui constituent une page web (documents HTML, images, fichiers JS...). Au niveau logiciel : 
- statique : un OS, et un serveur HTTP (= logiciel qui prend en charge les requettes client/serveur du protocole HTTP, ex : Apache, 2is, Nginx)
- dynamique : en + inclue une BDD et un langage de script comme PHP (= dont le rôle est d'interpréter les demandes du client et de les traduire en HTML)

Faille XSS (=cross-site scripting) : dans une page web on a donc du HTML, CSS, Javascript. On a deux côtés : le côté client, qui voit la page, et le côté serveur. Le client et le serveur communiquent. Un personne peut se mettre au milieu, prendre la page et ajouter du JS (ou du HTML) dedans si pas protégé. Par exemple le pirate peut écrire un commentaire sur un blog, où il va mettre du JS qui fait une XSS. Et la prochaine fois qu'un mec va venir sur le blog, il va charger la page, qui contient le commentaire en JS (c'est une stored XSS) et le code malveillant va s'executer. Ce XSS va se déclencher pour chacun des utilisteurs légitimes qui vont charger la page après l'injection du JS. Donc une faille xss c'est la possibilité pour un attaquant d'injecter du code javascript, ou html, qu'on va en tant que victime, exécuter à notre ainsu. [Exemple d'exploitation faille XSS](https://www.youtube.com/watch?v=iHcXH8eByDA)

Faille CSRF (=cross-site request forgery) : consiste à faire exécuter à une victime une requête HTTP à son insu. Le but est de faire aller notre victime sur une page pour qu'il exécute les actions de la page, avec ses privilèges (généralement plus élevés que les nôtres). Par exemple, je tiens un blog et on m'envoie un lien de suppression d’un article, par exemple : http://www.monblog.fr/del.php?id=1 qui supprime l'article 1. Si je clique dessus, l'article peut être supprimé si pas protégé. 

`````
// dans index.php 'Name' n'est pas protégé
// possibilité d'injecter du code
`````

## 2. Pratique

