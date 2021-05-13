# PRISA PRogetto d'Ingegneria del Software Avanzata

---

- [Introduzione](#section-1)

<a name="section-1"></a>
## Introduzione al progetto

Prisa è il mio PRogetto di Ingegneria del Software Avanzata e consiste in una applicazione web per la gestione dei progetti universitari.  
Prisa cerca di semplificare la gestione dei progetti universitari, dove di norma gli studenti e i docenti si accordano tramite email, attraverso una applicazione web fatta ad hoc per questa attività.  
<br>
È la prima volta che sviluppo una applicazione web e mi sono affidato al framework Laravel per costruirla.   
Inizialmente mi ero fatto delle idee e degli schemi della applicazione senza sapere come funzionasse Laravel, soprattutto usando le mie conoscenze acquisite al corso di basi di dati e ingegneria del software avanzata, inserirò la documentazione iniziale perché credo sia interessante vedere come sono cambiate le cose una volta che mi sono avvicinato all'implementazione scoprendo come le cose funzionino nella realtà.  
<br>
Per quanto riguarda l'implementazione: 
- Questa applicazione è effettivamente un prototipo, non ho implementato funzionalità particolarmente complesse: già così si è rivelato essere un lavoro abbastanza lungo.
- Cerco di essere aderente alle convenzioni di Laravel per quanto riguarda il naming. Info qui: https://webdevetc.com/blog/laravel-naming-conventions/
- Sui seguenti punti potete trovare info nella documentazione ufficiale Laravel:
    - Implemento le varie route rifacendomi o usando i "resource controller", che dovrebbero seguire una filosofia RESTful. 
    - Uso le migrazioni (migrations) per la definizione del database (basato su mysql).
    - Per gestire il DB uso l'ORM "Eloquent".
    - Per l'autorizzazione a certe route da parte di determinati utenti ho usato i "Gates".  

- Volutamente o non, in certi casi ho usato Laravel in maniera legacy:
    - Laravel adesso consiglia di installare Laravel Sail per le sue applicazioni: è un nuovo metodo basato su Docker il cui punto di forza sarebbe avere tutte le dipendenze direttamente nel pacchetto piuttosto che essere installate a livello di sistema operativo. La configurazione di questo ambiente non è scritta bene nella documentazione ma anche una volta fatta poi la maggior parte dei tutorial segue il vecchio metodo con composer, visto che inizialmente non sapevo nulla di Laravel ho seguito anche io questa strada.  
    - Sempre seguendo tutorial ho installato l'autenticazione di Laravel attraverso il package laravel/ui, un pacchetto di fatto legacy che su GitHub consiglierebbe di usare Laravel Breeze o Jetstream al giorno d'oggi. Anche per quanto riguarda l'interfaccia grafica sono partito dalle feature installate con questo pacchetto (più che altro bootstrap).  
    - Laravel non mi da' la possibilità di usare SAML facilmente, per l'integrazione che ho fatto ho usato un pacchetto su github come consigliato da molti su StackOverflow. Qui il pacchetto: https://github.com/aacotroneo/laravel-saml2
    
Alla fine come detto ho imparato ad usare i vari strumenti e linguaggi grazie a vari tutorial (per quanto incompleto e semplice consiglio quello del canale YouTube NetNinja) e leggendo al bisogno la documentazione.
