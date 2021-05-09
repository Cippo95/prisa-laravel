# PRISA PRogetto d'Ingegneria del Software Avanzata

---

- [Introduzione](#section-1)
- [Requisiti della applicazione](#section-2)
- [Parliamo del database 1/2](#section-3)
- [Parliamo del database 2/2](#section-4)
- [Parliamo dell'implementazione](#section-5)

<a name="section-1"></a>
## Introduzione al progetto

Prisa è il mio progetto di ingegneria del software e consiste in una applicazione web per la gestione dei progetti universitari.  
Di norma gli studenti e i docenti si accordano tramite email per i requisiti, ulteriori informazioni e la presentazione dei progetti, ho provato a catturare queste necessità in un questa applicazione web.  
È la mia prima applicazione web e mi sta consentendo di imparare molte cose.  
Potete visionare le mie prime idee per la app a questo indirizzo github: https://github.com/Cippo95/prisa  
Ho utilizzato il framework Laravel (come dovreste già sapere se leggete questa documentazione), ho cercato di aderire il più possibile alle convenzioni e standard di Laravel, il che ha aggiunto diverse cose al mio pensiero iniziale.

---

<a name="section-2"></a>
## Requisiti della applicazione

I requisiti sono in continuo cambiamento poiché questo progetto potrebbe diventare estremamente complesso da gestire per un singolo studente come me, l'idea che mi propongo è quella di scrivere una applicazione completa almeno dei requisiti davvero essenziali.

Ho cercato quindi tenere le cose il più semplici possibile, aggiungerò comunque commenti di eventuali ulteriori funzionalità più complesse.

L'idea principale è quella di avere un sistema con autenticazione e autorizzazione per studenti e docenti, solo loro sono autorizzati all'uso della app tramite login.  

*Già qui ci sono diverse complicazioni: ci serve qualcuno col ruolo di amministratore (cosa facilmente risolvibile ma che aggiunge una miriade di funzionalità che l'amministratore dovrebbe poter fare, devo pensare se implementarle) e sarebbe anche interessante (come proposto dal mio docente) usare i sistemi di autenticazione che usa l'università (simplesamlphp).*

Gli studenti possono creare delle sezioni per i propri progetti che poi i docenti di tali corsi potranno visionare per accettare/discutere dei requisiti di progetto con gli studenti.
*Una possibile complicazione qui e se gli studenti possano inviare solo messaggi o anche file allegati (come si fa spesso tramite email).*  

Se può aiutare a capire, la struttura principale è molto simile a quella di un forum dove solo alcune persone possono accedere a determinati thread.

---

<a name="section-3"></a>
## Parliamo del database

Invito nuovamente a leggere i miei primi pensieri per capire come le cose siano cambiate.

Cercando di abbracciare al meglio le convenzioni di Laravel, ho deciso di usare mysql, in congiunta con le migrazioni per creare il database e l'ORM Eloquent per la gestione delle query e i vincoli del database.

Parlo quindi di come le cose stanno allo stato attuale dopo aver fatto un po' di implementazione.
Le tabelle principali sono:

- Gli utenti (users): essi hanno un codice identificativo (tipo matricola), un nome (nome e cognome), un ruolo (per distinguere studenti, docenti e amministratori), una email, una password (per ovvie ragioni di login) e altri campi inseriti di default da Laravel ad esempio il timestamp (di creazione e modifica), un remember_token (per ricordarsi le sessioni utente) ed email_verified at che al momento onestamente non so a cosa serva. 

- I corsi (courses): essi hanno un codice identificativo, un nome e i timestamp.

- I progetti (projects): essi hanno un codice identificativo, un corso di appartenenza, uno studente che li ha creati e i timestamp. 

- I messaggi (attachments): chiamati inizialmente allegati(da cui attachments) hanno anche essi un id univoco, un identificativo del progetto e del utente a cui appartengono, un messaggio e i timestamp.

- Ci sono inoltre altre tabelle create da Laravel per l'autenticazione e una tabella detta di "pivot" che serve alla relazione N:N che avviene tra gli utenti e i corsi (le relazioni 1:N non necessitano di pivot table in quanto rappresentabili da un singolo attributo nella tabella lato N)

---

<a name="section-4"></a>
## Parliamo ancora del database

Come si può notare ci sono molte modifiche dai miei modelli iniziali e voglio commentarle (sperando di ricordarle tutte):

- La differenza tra docenti e studenti è data solo dal loro ruolo, è importante unificarli per ragioni di login (stesso login per tutti), le relazioni che avevo prima tipo "segue" e "insegna" essenzialmente sono rappresentate dalla stessa relazione (N:N) con il ruolo dell'utente che definisce di quale stiamo parlando.

- Sviluppa non è più una relazione ternaria (N:N:N) ma 1:N tra utenti (solo studenti) e progetti: l'idea era avere una applicazione dove un progetto poteva essere fatto per più corsi, da più studenti, il che è interessante però molto complicato da gestire, ora un progetto fa capo a un solo studente e un studente può fare più progetti.

- I corsi hanno un identificativo unico, l'uso di un identificativo autoincrementante a quanto pare è la norma per ragioni di semplicità e robustezza.

- I messaggi/allegati hanno un numero identificativo univoco (chiave primaria), dai miei studi di basi di dati li avevo modellati come entità debole dei progetti, questo nella realtà di come funzionano diverse applicazioni non funziona, infatti ho scoperto che nei forum etc. si preferisce usare una tabella per tutti i messaggi e usare gli indici per risolvere gli eventuali problemi di prestazioni nella ricerca nei database, tant'è che addirittura Eloquent non permette proprio di usare chiavi composite cosa che servirebbe per le entità deboli (funzionalità richiesta da tempo ma ignorata, basta cercare online per trovare diversi thread a riguardo).

Credo di aver detto tutte le cose fondamentali.  

<a name="section-5"></a>
## Parliamo dell'implementazione

Laravel è funziona col paradigma Model-View-Controller, quindi una volta scritte le migrazioni per la costruizione del database, ho dovuto definire i modelli per le tabelle della applicazione, ho gestito la view tramite blade e i controller implementano le diverse funzionalità.

Non c'è molto da dire a riguardo, il codice dovrebbe essere autoesplicativo a chi ha alcune basi di Laravel, ho cercato di usare le convenzioni dettate da Laravel per tutto il procedimento.

Importante secondo me in quanto non affrontato nei vari tutorial di base di Laravel è che ho avuto la premura di aggiungere dei "Gate" che sono un metodo base di gestire la autorizzazione così che gli studenti e i docenti non possano leggere e modificare cose che non sono di loro proprietà.

Allo stato attuale devo decidere se lavorare sugli amministratori (non so neanche se abbia senso), se lavorare sull'autenticazione tramite il metodo proposto dal prof oppure se capire se va bene il progetto così o debba avere una api vera e propria, che da quel che ho capito è un po' diverso da avere una applicazione web e basta.

















