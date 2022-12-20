# Opdracht: PHP checks voor docker-compose Magento stack

## Introductie
Bij het gebruik van een container stack (bijvoorbeeld een `docker-compose` stack of een Kubernetes stack) voor het hosten van Magento, kan er veel mis gaan. Het analyseren van die stack volgt vaak bepaalde stappen, die misschien het beste geautomatiseerd kunnen worden.

Het doel van deze opdracht is om een kleine PHP applicatie te schrijven, die rapporteert of een bepaalde `docker-compose` stack met daarin PHP-FPM, Nginx, ElasticSearch, MySQL en Redis operationeel is.

## Taak: Maak een dummy PHP applicatie aan
Zorg ervoor dat je PHP 8.1 hebt geinstalleerd (`php -v`). Gebruik Symfony om een nieuwe applicatie aan te maken:

```bash
composer create-project symfony/skeleton docker-stack-check
```

Controleer of `bin/console` uit te voeren is vanaf de command-line.

## Taak: Upload alle bestanden naar GitHub
Initialiseer een nieuwe git repository in de nieuw aangemaakte folder `docker-stack-check/` door middel van `git init`. Voeg alle bestanden toe aan de repository via `git add *` en daarna `git commit .`.

Maak een nieuwe private GitHub repository. Configureer je SSH keys zodat je kan pushen en pullen naar deze repository. Nodig `jissereitsma` uit als collaborator voor deze nieuwe repository. Push alle bestanden die lokaal staan naar deze nieuwe repository. Stel de docent op de hoogte van de nieuwe repository (mocht de uitnodiging tot collaboration verloren gaan).

## Taak: Draai de beschikbare stack
In de bijgeleverde `docker-compose.yml` file wordt de volgende stack beschikbaar gemaakt:

- Nginx webserver (HTTP op poort 80)
- PHP-FPM (poort 9000)
- Varnish (HTTP op poort 80)
- MySQL database (poort 3306)
- ElasticSearch database (poort 9200)
- Redis in-memory database (poort 6379)

Het doel van de opdracht is om vanuit PHP (dus ofwel vanaf de PHP CLI, ofwel vanaf de Nginx webserver in combinatie met PHP-FPM) de overige services te controleren: Varnish, MySQL, ElasticSearch en Redis.

- Draai eerst `docker-compose up` om de stack op te starten. Controleer met `docker-compose status` @todo of dit is gelukt.
- Controleer daarna per service of je er goed bij kan:
    - Gebruik een MySQL client om een connectie met de database te maken.
    - Gebruik de Redis CLI client om Redis statistieken te bekijken.
    - Navigeer naar http://localhost:9200 voor output van ElasticSearch.
    - Gebruik `docker inspect VARNISH` om het IP adres van de Varnish instance te achterhalen. Vervang hierbij `VARNISH` met de Docker container name of ID zoals die met `docker ps` wordt weergegeven. Navigeer naar het IP adres van Varnish poort 80 (bijvoorbeeld )

## Taak: Voeg een nieuwe CLI toe
Volg de [Symfony documentatie](https://symfony.com/doc/current/console.html#creating-a-command) voor het toevoegen van een nieuw commando `bin/console stack-check:mysql` met een PHP klasse `App\Command\StackCheck\MySQL`

Begin hierbij

- Gebruik de `docker-compose` stack in deze opdracht;

## Taak
De PHP applicatie bestaat uit een aantal CLI commando's waarmee je een connectie kan maken met de nodige services om details zoals de huidige versie op te halen.

Schijf hiernaast een frontend in HTML, CSS en JavaScript, waarbij door middel van AJAX calls de API van dezelfde applicatie wordt aangeroepen om dezelfde gegevens te tonen. Schrijf hierbij controllers volgens de REST standaard.

## 

## Eisen aan de opdracht
- Installeer pakketten via `composer` waar mogelijk;
- Plaats de eigen code in een `lib/` of `src/` folder, met een eigen PHP namespace en registreer dit pad en deze namespace als PSR-4 autoloading sectie in de `composer.json` file, zodat je autoloading kan gebruiken;
- Gebruik het Symfony `Console` component voor de CLI commando's en toon gegevens in een console tabel;

## Stap 1: Clone de docker-compose configuratie

## Nice-to-haves
- Extra checks
    - Rapporteer alle beschikbare databases voor de opgegeven database user;
      @todo

@todo: Check minimum requirements