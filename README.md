# Opdracht: Checks voor docker-compose stack

## Introductie
Bij het gebruik van een container stack (bijvoorbeeld een `docker-compose` stack of een Kubernetes stack) voor het hosten van Magento (of een andere PHP applicatie), kan er veel mis gaan. Het analyseren van die stack volgt vaak bepaalde stappen, die misschien het beste geautomatiseerd kunnen worden: Is de database beschikbaar? Kloppen de credentials? Etcetera.

Het doel van deze opdracht is om een kleine PHP applicatie te schrijven, die rapporteert of een bepaalde `docker-compose` stack met daarin PHP-FPM, Nginx, ElasticSearch, MySQL en Redis operationeel is.

# Backend Developer taken

## Taak: Maak een dummy PHP applicatie aan
Start met een eigen lege folder, dus niet een clone van deze GitHub repository. 

Zorg ervoor dat je PHP 8.1 of PHP 8.2 hebt geinstalleerd (`php -v`). Draai je onder MacOS, gebruik hier dan `brew` voor.

Gebruik Symfony om een nieuwe applicatie aan te maken:

```bash
composer create-project symfony/skeleton docker-stack-check
```

Controleer of `bin/console` uit te voeren is vanaf de command-line. Copieer de files `docker-compose.yml`, `Dockerfile`, `apache.conf` en `varnish.vcl` van deze GitHub repository naar je eigen folder.

## Taak: Upload alle bestanden naar GitHub
Initialiseer een nieuwe git repository in de nieuw aangemaakte Symfony folder `docker-stack-check/` door middel van `git init`. Voeg alle bestanden toe aan de repository en doe een commit.

Maak een nieuwe private GitHub repository. Configureer je SSH keys zodat je kan pushen en pullen naar deze repository. Nodig `jissereitsma` uit als collaborator voor deze nieuwe repository. Push alle bestanden die lokaal staan naar deze nieuwe repository. Stel de docent op de hoogte van de nieuwe repository (mocht de uitnodiging tot collaboration verloren gaan).

Bij de volgende stappen breid je de lokale bestanden iedere keer uit. Commit en push alle veranderingen iedere keer naar GitHub.

## Taak: Draai de beschikbare stack
Installeer Docker als je dat nog niet geinstalleerd hebt. Draai je MacOS, installeer dan Docker niet (!) via `brew` (vanwege compatibileitsproblemen met VirtualBox en `docker-machine`) maar installeer Docker Desktop via de officiele handleiding van Docker zelf.

In de `docker-compose.yml` file van deze repository wordt de volgende stack beschikbaar gemaakt:

- Apache webserver met PHP module (HTTP op poort 8080 gemapt naar poort 80)
- Varnish (HTTP op poort 8081 gemapt naar poort 80)
- MySQL database (poort 3306)
- ElasticSearch database (poort 9200)
- Redis in-memory database (poort 6379)

Het doel van de opdracht is om vanuit PHP (dus ofwel vanaf de PHP CLI, ofwel vanaf de Apache webserver in combinatie met PHP) de overige services te controleren: Varnish, MySQL, ElasticSearch en Redis. Draai eerst `docker-compose up -d` om de stack op te starten. Controleer met `docker-compose ps` en `docker ps` of dit is gelukt.

Controleer daarna per service of je er goed bij kan:

- Navigeer naar http://localhost/public/ voor het bezoeken van de webpagina.
- Gebruik een MySQL client om een connectie met de database te maken.
- Gebruik de Redis CLI client om Redis statistieken te bekijken (`redis-cli` om in te loggen en dan bijvoorbeeld het commando `INFO`).
- Navigeer naar http://localhost:9200 voor output van ElasticSearch.
- Navigeer naar http://localhost:8080/ voor output van Varnish. Je ziet als het goed is een Apache foutmelding. Maar in de HTTP headers van dit GET request zijn headers van Varnish terug te vinden.

Let op dat de `docker-compose` stack gebruik maakt van poort mapping (bijvoorbeeld `80:80`) om de lokale poort naar de poort van de desbetreffende Docker container. In plaats van gebruik te maken van de poort mapping in Docker, kunnen we ook rechtstreeks naar de container toe navigeren. Gebruik `docker inspect DOCKERNAME` om de IP adres van de containers te achterhalen. Vervang hierbij `DOCKERNAME` met de Docker container name of ID zoals die met `docker ps` wordt weergegeven. Navigeer naar het IP adres en het poort nummer om een rechtstreekse verbinding te maken.

## Taak: Voeg een MySQL check toe
Volg de [Symfony documentatie](https://symfony.com/doc/current/console.html#creating-a-command) voor het toevoegen van een nieuw commando `bin/console stack-check:mysql` met een PHP klasse `App\Command\Check\MySQL`. Zorg eerst dat het CLI commando werkt met een simpele `Hello World`. Breid het daarna uit om met `mysqli_connect()` een connectie te maken met de database:

```php
$rs = mysqli_connect('localhost', 'root', 'root', 'magento2');
```

Return de juist `exit` code op basis van de waarde van `$rs`. Geef via `$output->writeln()` meldingen terug over wat er gebeurt. In plaats van de waarden hard te coderen is het handiger de waardes dynamisch in te stellen. Voeg hiervoor het volgende toe aan de `.env` file:

```env
MYSQL_HOST=mysql
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=magento
MYSQL_USER=magento
MYSQL_PASSWORD=magento1234
```

En pas de PHP code aan:

```php
$rs = mysqli_connect($_ENV['MYSQL_HOST'], 'root', $_ENV['MYSQL_ROOT_PASSWORD'], $_ENV['MYSQL_DATABASE']);
```

Let op dat met het draaien van de CLI de hostname `mysql` wel op de correcte manier geresolved moet worden. Hiervoor moet je ofwel een eigen `hosts` file aanmaken met de mapping `mysql` naar IP adres `127.0.0.1`. Of je moet het Symfony commando aanroepen vanuit de Apache container, wat er als volgt uit kan zien:
```bash
docker exec yrac-docker-stack-check-apache-1 php ./bin/console stack-check:mysql
```

Breidt het commando uit om niet alleen als `root` in te loggen, maar ook als de gebruiker geconfigureerd met `MYSQL_USER`. Rapporteer versies terug met `mysqli_get_server_version()` en `mysqli_get_client_version()`.

## Taak: Voeg een ElasticSearch check toe
Voeg een nieuw commando voor ElasticSearch toe. Installeer [Guzzle](https://packagist.org/packages/guzzlehttp/guzzle) voor het maken van een HTTP request naar http://localhost:9200. Lees de JSON uit. Navigeer ook naar andere URLs zoals http://localhost:9200/_nodes/ en http://localhost:9200/_search. 

## Taak: Voeg een Redis check toe
Voeg een nieuw commando voor Redis toe. Installeer [predis/predis](https://packagist.org/packages/predis/predis) voor het maken van een connectie.

## Taak: Voeg een Varnish check toe
Controleer of Varnish benaderbaar is. Gebruik hiervoor ook weer Guzzle maar controleer hierbij de HTTP headers van de response.

## Taak: Refactor de controllers
Maak een nieuwe overkoepelende controller aan die voor alle checks output genereert (in plaats van een controller per check).

# Frontend Developer taken

## Taak: Draai deze repository applicatie
Gebruik de **Use this template** knop in deze GitHub repository om op basis van deze repository een eigen repository op te zetten. Configureer je SSH keys zodat je kan pushen en pullen naar deze repository. Nodig jissereitsma uit als collaborator voor deze nieuwe repository. Clone de nieuwe eigen repository naar jouw eigen development omgeving. Stel de docent op de hoogte van de nieuwe repository (mocht de uitnodiging tot collaboration verloren gaan).

Installeer Docker als je dat nog niet geinstalleerd hebt. Draai je MacOS, installeer dan Docker niet (!) via brew (vanwege compatibileitsproblemen met VirtualBox en `docker-machine`) maar installeer Docker Desktop via de officiele handleiding van Docker zelf.

Installeer `composer` als je dat nog niet geinstalleerd hebt. Draai hierna - binnen jouw eigen lokale repository - `composer install` om alle dependencies te installeren.

Draai hierna `docker-compose up -d` om de stack op te starten. Controleer met `docker-compose ps` en `docker ps` of dit is gelukt.

Navigeer hierna naar http://localhost om de huidige frontend te bezoeken.

## Taak: Frontend voor controles
Gooi de huidige `templates/main.html.twig` file weg en maak een leeg bestand aan.

Schijf een frontend in [Bootstrap CSS](https://getbootstrap.com/) en [jQuery](https://jquery.com/), waarbij door middel van AJAX calls de API van dezelfde applicatie wordt aangeroepen om dezelfde gegevens te tonen. Schrijf hierbij controllers volgens de [Symfony documentatie](https://symfony.com/doc/current/controller.html) en return een JSON antwoord dat dan via jQuery opgepakt kan worden.

Gebruik eventueel iconen van de FontAwesome library om dingen mooi te maken.