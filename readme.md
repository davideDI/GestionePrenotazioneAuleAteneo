# Tesi Magistrale
## Gestione Prenotazione Aule e Laboratori - Univaq

Web-application per la gestione della prenotazione delle aule e laboratori nell'università dell'Univaq.

## Risorse

[Laravel website](http://laravel.com)
[Full Calendar JS](http://fullcalendar.io)
[Bootstrap](http://getbootstrap.com)   

## Links

Università degli studi de L'Aquila [Univaq](http://univaq.it)

## How to

1. Scarica e installa [Wampserver](http://www.wampserver.com/en/)  
2. Scarica e installa [Composer](https://getcomposer.org/download/)
3. Importa da Git il progetto -> git clone https://github.com/davideDI/GestionePrenotazioneAuleAteneo
4. Vai da prompt nella cartella appena creata ed esegui il comando "composer install"
5. "php artisan migrate" per la creazione del db e relative tabelle [comando ancora da definire]
6. "php artisan db:seed" per l'inserimento dei dati iniziali

N.B. 
 1. Se eseguendo il comando "php artisan db:seed" si presenta una "ReflectionException" esegui il comando "composer dump-autoload"
 2. Se avviando l'applicazione si presenta un messaggio "The only supported ciphers are AES-128-CBC and AES-256-CBC with the correct key lengths"
    eseguire i seguenti comandi "php artisan config:clear" e successivamente "php artisan config:cache"

Prerequisiti
1. Git
2. NodeJs 