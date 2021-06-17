# DOCUMENTO DEI REQUISITI DEL PROGETTO

---

- [Caso d'uso tipico](#section-1)
- [Requisiti iniziali della applicazione](#section-2)
- [Struttura iniziale della base di dati](#section-3)
- [Parliamo dell'implementazione](#section-4)
- [Schemi architetturali](#section-5)
  
<a name="section-1"></a>
## PREMESSA

**Sono state apportate diverse semplificazioni dalla prima documentazione**: durante l'implementazione mi sono accorto di varie complicazioni, quindi ho semplificato diversi requisiti.

---

<a name="section-2"></a>
## REQUISITI INIZIALI DELLA APPLICAZIONE

### Requisiti iniziali

Si vuole gestire il ciclo di vita dei progetti dei corsi universitari attraverso una applicazione web apposita piuttosto che tramite email.
L'applicazione verrà usata dagli studenti e i docenti per la gestione dei progetti universitari:  

- Si vuole avere un sistema di autenticazione e autorizzazione per studenti e docenti, sarebbe interessante integrare l'applicazione col sistema universitario (saml).  

- Gli studenti potranno gestire i loro progetti per i vari corsi.
Potranno creare un progetto per un corso da loro seguito e concordare col docente del corso i requisiti tramite messaggi in una sezione apposita.

- Raggiunto un accordo sui requisiti il progetto, lo studente implementerà il progetto e al termine potra allegare i file di progetto o condividere (sotto forma di messaggio) un link a un repository/drive remoto con i sorgenti e documentazione di progetto.  

- I docenti potranno vedere i vari progetti legati ai corsi che insegnano e quindi interagire con essi nella definizione dei requisiti e una volta terminati, possono metterli nello stato "concluso".  

Essenzialmente la struttura principale è molto simile a quella di un forum dove solo alcune persone possono accedere a determinati thread.

### Requisiti aggiuntivi

Ho considerato necessario aggiungere un ruolo di amministratore per la creazione dei corsi, l'assegnamento di essi a dei docenti, e il controllo degli utenti.
È necessario che gli studenti oltre i messaggi possano anche aggiungere file in allegato.

---

<a name="section-3"></a>
## STRUTTURA DELLA BASE DI DATI

La base di dati ha come tabelle principali:

- Gli utenti (users): che hanno un codice identificativo (tipo matricola), un nome (nome e cognome), un ruolo (indicato da un numero intero 2 per gli studenti, 1 per i docenti, 0 per gli amministratori), una email e una password (per ovvie ragioni di login/autenticazione) e altri campi inseriti di default da Laravel ad esempio il timestamp (di creazione e modifica), un remember_token (per ricordarsi le sessioni utente) ed email_verified_at per la verifica della email alla registrazione (cosa non implementata).

- I corsi (courses): che hanno un codice identificativo, un nome e i timestamp.

- I progetti (projects): che hanno un codice identificativo, un corso di appartenenza, uno studente che li ha creati, uno stato (1 se in corso e 0 se concluso) e i timestamp. 

- Gli allegati (attachments): che hanno un id univoco, un identificativo del progetto e del utente che li ha scritti, un messaggio di testo, una stringa indicante un eventuale allegato al messaggio e i timestamp.

- Ci sono inoltre altre tabelle create da Laravel per l'autenticazione e una tabella detta di "pivot" che serve alla relazione N:N che avviene tra gli utenti e i corsi (couse_user), le relazioni 1:N non necessitano di pivot table in quanto rappresentabili da un singolo attributo nella tabella lato N.

---

<a name="section-4"></a>
##PARLIAMO DELL'IMPLEMENTAZIONE

Questa sezione è abbastanza corposa, l'ho scritta abbastanza a ruota libera quindi potrebbe non essere facilmente leggibile.
Discuterò anche di alcune differenze tra l'implementazione finale e la prima documentazione.

### Laravel

Laravel è un framework in PHP basato sul paradigma Model View Controller.
In queste cartelle che vi indico trovate il succo del mio lavoro:
    - Il Model indica il modello dei dati, cioè come essi (le entità/tabelle) siano relazionati tra di loro nel database, trovate i miei modelli sotto 'app/Models', per scriverli ho usato l'ORM Eloquent integrato in Laravel.
    - Le Views sono le viste, cioè come l'applicazione rappresenta i dati all'utente, trovate le mie viste sotto 'resources/views', esse sfruttano il motore di template blade (estensione .blade.php).
    - I Controller gestiscono le richieste http e interagiscono con Model e View per il funzionamento della app, sono 'la mente' della applicazione, trovate i miei controller sotto 'app/Http/Controllers'.
    - È importante capire che tutto parte da richieste Http fatte attraverso le 'routes' trovate le mie route sotto 'routes/web.php'.   
    - Il database è stato definito attraverso le migrazioni, le trovate sotto 'database/migration', uso inoltre un seed (Databaseeder sotto '/database/seeders') per testare il funzionamento dell'applicazione.
    - L'autenticazione è stata gestita con il pacchetto laravel/ui, ho fatto qualche modifica alle view sotto 'resources/views/auth'.
    - Nei controller troverete anche dei così detti 'Gate' per l'autorizzazione, questi sono definiti sotto '/app/Providers/AuthServiceProvider.php'.
    - Ho effettuato dei test delle richieste HTTP sotto 'tests/Feature/DatabaseTest' un mini test con Laravel dusk (simula interazione con browser chrome) sotto 'tests/Browser/AuthenticationTest.php'.
    - Ho scritto questa stessa documentazione con il pacchetto Larecipe e trovate i documenti sotto 'resources/docs'.
    - L'integrazione con SAML:
        - Sfrutta il pacchetto a questo indirizzo https://github.com/aacotroneo/laravel-saml2.
        - Sarebbe in parte nel file .env che non viene però copiato su git per ragioni di sicurezza, dovrete quindi compilarlo a mano voi stessi con i dati della vostra applicazione: 
            - Prendete .env.example, copiatelo in .env, ed aggiungete i metadati della vostra applicazione alle variabili 'SAML_*'; 
        - Il resto lo trovate in 'config/saml2/test_idp_settings.php' e 'config/saml2_settings.php' nel primo vedrete i dati del mio IDP:
            - Io ho testato il funzionamento di SAML con OneLogin che offre un servizio molto base per il testing, in ogni caso vi servono i miei dati (che sarebbero in .env) per accedere (oltre che sapere le mie credenziali).  
        - Quindi per integrare davvero la app con i servizi dell'università (quindi usare l'SSO, Single Sign On) bisognerebbe contattare gli amministratori dell'IDP (Identity Provider) dell'università per scambiare dei dati di configurazione. Ho usato il pacchetto piuttosto che seguire la documentazione di SAML poiché avevo difficoltà nel seguirla (se non fosse così difficile probabilmente non ci sarebbe questo pacchetto).

### Il database

**_Questa sezione potrebbe essere particolarmente scritta male poiché ho scritto le varie parti in tempi differenti durante la progettazione, mi scuso in anticipo._**

Anche se ne ho già parlato prima ci sono state diverse semplificazioni e scelte nella costruzione del database:
    - Sviluppa non è più una relazione ternaria (N:N:N) ma 1:N tra utenti (solo studenti) e progetti. L'idea iniziale era di avere una applicazione dove un progetto poteva essere fatto per più corsi, da più studenti, il che è interessante però molto complicato da gestire:
        - Ora lo studente può fare un progetto per un solo corso alla volta (relazione 1:N tra corso e progetto), nella realtà abbiamo casi di progetti singoli fatti per più corsi (sarebbe quindi N:N) però non prendo in considerazione questo. E.G. Gli studenti della triennale di ingegneria informatica ed elettronica che seguono i corsi di Cento possono scegliere di fare un "mega" progetto che vale mi pare ingegneria dei sistemi web e basi di dati.
        - Ora progetti possono avere un solo studente che li ha creati (relazione 1:N tra utenti e progetti), in realtà molto spesso i progetti vengono fatti da più persone (N:N), in questo caso un workaround sarebbe che gli studenti si mettessero d'accordo e uno facesse il rappresentante però in ogni caso non sarebbe male che tutti avessero visione del loro progetto tramite l'applicazione web.
    - Gli allegati inizialmente entità deboli sono diventate entità forti: con Laravel non si può fare diversamente (Eloquent non supporta le chiavi composite) quindi ho in teoria una sola grande tabella per gli allegati cosa che sembra problematica dai miei studi di base per quando riguarda le prestazioni, ma dalle mie ulteriori ricerche è giusto così: nella maggioranza dei casi si implementano così le cose creando però anche degli indici per non avere problemi di prestazioni (il che rafforza il motivo per cui Eloquent non supporti questo metodo di funzionamento).
    - Dallo schema ER si evincono certi vincoli che poi nella applicazione non si riflettono in maniera così vincolante:
        - Posso creare un corso senza che esso abbia un insegnante e viceversa posso creare un docente senza corsi, sta all'amministratore tenere tutto in ordine.
        - Si evince che un progetto possa esistere senza allegati, ma in realtà nella app alla creazione di un progetto bisogna scrivere il primo.
    - I corsi hanno un identificativo unico: l'uso di un identificativo autoincrementante è la norma per ragioni di semplicità e robustezza (inizialmente mi era stato chiesto di usare il nome di un corso come chiave primaria).
    - La differenza tra docenti e studenti è data solo dal loro ruolo, è importante unificarli per ragioni di login (stesso login per tutti, le relazioni che avevo prima tipo "segue" e "insegna" essenzialmente sono rappresentate dalla stessa relazione (N:N) con il ruolo dell'utente che definisce di quale stiamo parlando, ho anche creato il ruolo dei amministratore:
        - L'amministratore può creare i corsi, eliminare utenti, assegnare i corsi ai docenti, dare i privilegi di docente ai docenti appena iscritti al servizio (tutti i nuovi iscritti per ragioni di sicurezza hanno ruolo di studente).
    - Lo stato del progetto è solo "attivo" o "concluso", è importante concludere i progetti così da metterli in secondo piano a quelli attivi nella interfaccia utente.

---

<a name="section-5"></a>
## SCHEMI ARCHITETTURALI

Si possono visionare gli attuali modelli in diversi pdf: 

- Schema eer della base di dati in "prisa_eer-SCHEMA_EER.pdf"  

- Schema relazionale in "prisa_eer-SCHEMA_RELAZIONALE.pdf"  

- Modello a statechart del funzionamento della applicazione e modello a fsm del passaggio di stato dei progetti in "prisa_eer-MODELLO_SC_FSM.pdf" (non c'è la parte legata all'amministratore). 
