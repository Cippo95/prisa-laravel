# PRISA PRogetto d'Ingegneria del Software Avanzata

---

- [Introduzione](#section-1)

<a name="section-1"></a>
## Introduzione al progetto

Prisa è il mio PRogetto di Ingegneria del Software Avanzata e consiste in una applicazione web per la gestione dei progetti universitari.  
Di norma gli studenti e i docenti si accordano tramite email per la gestione dei progetti: PRISA è il mio tentativo di sostituire questa metodologia con una applicazione web.   
<br>
È la prima volta che sviluppo una applicazione web e come dovreste aver già notato sto usando il framework Laravel per costruirla.   
Inizialmente mi ero fatto delle idee e degli schemi della applicazione senza sapere come funzionasse Laravel, soprattutto usando le mie conoscenze acquisite al corso di basi di dati e ingegneria del software avanzata, inserirò la documentazione iniziale perché credo sia interessante vedere come sono cambiate le cose una volta che mi sono scontrato con l'implementazione e come le cose funzionano nella realtà.  
<br>
Per quanto riguarda l'implementazione: 
- Ho deciso di fare una implementazione volta alla semplicità, niente funzionalità super complesse, già così ho dovuto e dovrò lavorare molto.
- Cerco sempre di essere il più possibile aderente alle convenzioni di Laravel per quanto riguarda le convenzioni sul naming. Potete leggerne alcune qui: https://webdevetc.com/blog/laravel-naming-conventions/
- Ho implementato/implemento una API RESTful come si può vedere del routing delle richieste e i nomi dei metodi usati. Potete leggere qui dei resource controller, anche se in realtà non ho usato propriamente i resource controller ma la struttura usata è la stessa: https://laravel.com/docs/8.x/controllers#resource-controllers
- Uso le migrazioni per la definizione del database (basato su mysql): https://laravel.com/docs/8.x/migrations
- Utilizzo query e vincoli sul database attraverso l'ORM Eloquent:https://laravel.com/docs/8.x/eloquent
- Ho usato blade e bootstrap per avere una interfaccia decente (spero).  

Alla fine ho imparato ad usare i vari strumenti e linguaggi grazie a vari tutorial (per quanto incompleto e semplice consiglio quello del canale YouTube NetNinja) e leggendo al bisogno la documentazione.
