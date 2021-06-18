# PRISA PRogetto d'Ingegneria del Software Avanzata

---

- [Introduzione al progetto](#section-1)

<a name="section-1"></a>
## Introduzione al progetto

Prisa è il mio PRogetto di Ingegneria del Software Avanzata (e la mia prima applicazione web).
È una applicazione pensata per semplificare la gestione dei progetti universitari: di norma gli studenti e i docenti si accordano tramite email, l'idea è che forse una applicazione apposita risulterebbe più ordinata.

### Tecnologie e conoscenze teoriche
L'applicazione è basata sul framework Laravel, un framework PHP.
Ho suddiviso i documenti in due versioni, la prima è relativa agli schemi che avevo fatto senza sapere come funzionasse Laravel, avevo usato solo le mie conoscenze acquisite dal corso di basi di dati e ingegneria del software avanzata, la seconda è relativa all'implementazione finale.
Credo che sia interessante vedere come siano cambiate le cose poiché (soprattutto parlando del database) ho scoperto diverse divergenze sulla teoria che avevo studiato in precedenza.

### Breve panoramica e considerazioni
- Questa applicazione è effettivamente un prototipo, non ho implementato funzionalità particolarmente complesse e già così si è rivelato essere un lavoro abbastanza lungo.
- Cerco di essere aderente alle convenzioni di Laravel per quanto riguarda il naming. 
Info qui: https://webdevetc.com/blog/laravel-naming-conventions/
- Sui seguenti punti potete trovare info nella documentazione ufficiale Laravel (riporto comunque qualche link):
    - Implemento le varie route rifacendomi o usando i "resource controller", che dovrebbero seguire una filosofia RESTful.  
    Info controllers qui:https://laravel.com/docs/8.x/controllers
    - Uso le migrazioni (migrations) per la definizione del database (basato su mysql).  
    Info migrazioni qui:https://laravel.com/docs/8.x/migrations
    - Per gestire il DB uso l'ORM "Eloquent".  
    Info Eloquent qui:https://laravel.com/docs/8.x/eloquent
    - Per l'autorizzazione a certe route da parte di determinati utenti ho usato i "Gates".    
    Info Gates qui: https://laravel.com/docs/8.x/authorization#gates
    - Ho effettuato testing sia attraverso il test delle richieste HTTP oltre che un piccolo test con laravel dusk che simula l'interazione col browser (simile da quel che ho capito a selenium).  
    Info Http tests qui:https://laravel.com/docs/8.x/http-tests  
    Info Dusk qui:https://laravel.com/docs/8.x/dusk  

- Volutamente o no, in certi casi ho usato Laravel in maniera un po' legacy:
    - Laravel oggi consiglia di usare Laravel Sail per le sue applicazioni: è un nuovo metodo basato su Docker il cui punto di forza sarebbe avere tutte le dipendenze direttamente nel pacchetto piuttosto che essere installate a livello di sistema operativo. La configurazione di questo ambiente non è intuitiva e i passaggi non sono ben descritti nella documentazione, sono riuscito ad installarla ma poi ho notato che molti tutorial seguono il vecchio metodo con composer, visto che inizialmente non sapevo nulla di Laravel ho seguito anche io questa strada.   
    Info su laravel sail:https://laravel.com/docs/8.x/sail
    - Seguendo tutorial ho installato l'autenticazione di Laravel attraverso il package laravel/ui, un pacchetto un po' legacy, esso stesso su GitHub consiglierebbe di considerare Laravel Breeze o Jetstream. Anche per quanto riguarda l'interfaccia grafica sono partito dalle feature installate con questo pacchetto (con esso viene installato bootstrap).   
    Info su laravel/ui qui:https://github.com/laravel/ui
    - Laravel non mi da' la possibilità di usare SAML facilmente, per l'integrazione che ho fatto ho usato un pacchetto su github come consigliato da molti su StackOverflow. 
    Sarebbe un pacchetto scritto per Laravel 5 ma funziona anche su versioni successive (io uso Laravel 8).
    Questa implementazione è di fatto solo un prototipo in quanto fino a che non posso collegare l'applicazione all'IDP dell'università non ha senso svilupparla ulteriormente (l'IDP passa degli attributi che servirebbero alla applicazione ma senza di essi come testo l'applicazione? avrei l'applicazione spaccata a metà).  
    Qui il pacchetto: https://github.com/aacotroneo/laravel-saml2
    
Alla fine come detto ho imparato ad usare i vari strumenti e linguaggi grazie a vari tutorial, discussioni online e leggendo al bisogno la documentazione (all'inizio non è facile leggere la documentazione, bisogna avere una minima base prima di farlo secondo me).
