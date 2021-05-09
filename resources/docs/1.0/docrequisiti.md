# DOCUMENTO DEI REQUISITI DEL PROGETTO

---

- [Caso d'uso tipico](#section-1)
- [Requisiti della base di dati](#section-2)
- [Modelli architetturali](#section-3)
- [Dubbi attuali](#section-4)

<a name="section-1"></a>
### PREMESSA

**Sono state apportate diverse semplificazioni dalla prima documentazione**: durante l'implementazione mi sono accorto della enorme complicazione che si generava da certi requisiti, quindi ho fatto scelte volte a semplificarli di molto.

<a name="section-2"></a>
### REQUISITI DELLA APPLICAZIONE

Si vuole gestire il ciclo di vita dei progetti dei corsi universitari attraverso una applicazione web apposita piuttosto che tramite email.
L'applicazione verrà usata dagli studenti e i docenti per la gestione dei progetti universitari:  

- Si vuole avere un sistema di autenticazione e autorizzazione per studenti e docenti.
**NOTARE BENE: ci serve qualcuno col ruolo di amministratore (cosa già implementata di base ma questo aggiunge una miriade di funzionalità che l'amministratore dovrebbe poter fare, queste non ancora implementate) e sarebbe anche interessante (come proposto dal mio docente) usare i sistemi di autenticazione che usa l'università (simplesamlphp).**

- Gli studenti potranno gestire i loro progetti per i vari corsi.
Potranno creare un progetto **per un corso alla volta**, il docente quindi valuterà i requisiti e proporrà in caso modifiche.  
**NOTARE BENE: è stata eliminata l'opzione di creare un progetto per più corsi.**

- Raggiunto un accordo sui requisiti il progetto sarà approvato dal docente e al termine del progetto lo studente condividerà un link a un repository/drive remoto con i sorgenti e documentazione di progetto.  
**NOTARE BENE: è stata mantenuta la funzione fondamentale dei messaggi ma eliminati gli allegati binari per tenere i requisiti in termini di memoria al minimo, non sapendo nemmeno quale sarebbe una dimensione massima accettabile per i file allegati visto il numero possibile di studenti.**

- I docenti potranno vedere i vari progetti legati ai corsi che insegnano e quindi interagire con essi nella definizione dei requisiti e una volta terminati, possono metterli nello stato "concluso".  
**NOTARE BENE: lo stato del progetto adesso sarà solo "attivo" o "concluso", tutto il ciclo di vita del progetto che avevo pensato mi pare pesante, l'unica cosa importante è concludere i progetti così che possano essere messi in secondo piano rispetto a quelli attivi, al fine di avere una interfaccia più chiara.**

Infine se può aiutare a capire, la struttura principale è molto simile a quella di un forum dove solo alcune persone possono accedere a determinati thread.

<a name="section-2"></a>
### STRUTTURA DELLA BASE DI DATI

Ho discusso delle scelte tecnologiche (abbinate a qualche link) nella introduzione, invito a darci un'occhiata se interessa quella parte del discorso, qui discuto della struttura della base di dati.

La base di dati ha come tabelle principali:

- Gli utenti (users): essi hanno un codice identificativo (tipo matricola), un nome (nome e cognome), un ruolo (per distinguere studenti, docenti e amministratori), una email, una password (per ovvie ragioni di login) e altri campi inseriti di default da Laravel ad esempio il timestamp (di creazione e modifica), un remember_token (per ricordarsi le sessioni utente) ed email_verified at che al momento onestamente non so a cosa serva. 

- I corsi (courses): essi hanno un codice identificativo, un nome e i timestamp.

- I progetti (projects): essi hanno un codice identificativo, un corso di appartenenza, uno studente che li ha creati e i timestamp. 
**DEVO ANCORA IMPLEMENTARE LA QUESTIONE DELLO STATO**

- I messaggi (attachments): chiamati inizialmente allegati(da cui attachments) hanno anche essi un id univoco, un identificativo del progetto e del utente a cui appartengono, un messaggio e i timestamp.

- Ci sono inoltre altre tabelle create da Laravel per l'autenticazione e una tabella detta di "pivot" che serve alla relazione N:N che avviene tra gli utenti e i corsi (le relazioni 1:N non necessitano di pivot table in quanto rappresentabili da un singolo attributo nella tabella lato N)

---

<a name="section-3"></a>
### MODELLI ARCHITETTURALI

Si possono visionare gli attuali modelli in diversi pdf: 

- Schema eer della base di dati in "prisa_eer-SCHEMA_EER.pdf"  

- Schema relazionale in "prisa_eer-SCHEMA_RELAZIONALE.pdf"  

- Modello a statechart del funzionamento della applicazione e modello a fsm del passaggio di stato dei progetti in "prisa_eer-MODELLO_SC_FSM.pdf". 

Si possono leggere le possibili query della applicazione in "query_sql_prova.md".  

---

<a name="section-4"></a>
### PARLIAMO DEI MODELLI/BASE DI DATI

Come si può notare ci sono molte modifiche dai miei modelli iniziali e voglio commentarle (sperando di ricordarle tutte):

- La differenza tra docenti e studenti è data solo dal loro ruolo, è importante unificarli per ragioni di login (stesso login per tutti), le relazioni che avevo prima tipo "segue" e "insegna" essenzialmente sono rappresentate dalla stessa relazione (N:N) con il ruolo dell'utente che definisce di quale stiamo parlando.

- Sviluppa non è più una relazione ternaria (N:N:N) ma 1:N tra utenti (solo studenti) e progetti: l'idea era avere una applicazione dove un progetto poteva essere fatto per più corsi, da più studenti, il che è interessante però molto complicato da gestire, ora un progetto fa capo a un solo studente e un studente può fare più progetti.

- I corsi hanno un identificativo unico, l'uso di un identificativo autoincrementante a quanto pare è la norma per ragioni di semplicità e robustezza.

- I messaggi/allegati hanno un numero identificativo univoco (chiave primaria), dai miei studi di basi di dati li avevo modellati come entità debole dei progetti, questo nella realtà di come funzionano diverse applicazioni non funziona, infatti ho scoperto che nei forum etc. si preferisce usare una tabella per tutti i messaggi e usare gli indici per risolvere gli eventuali problemi di prestazioni nella ricerca nei database, tant'è che addirittura Eloquent non permette proprio di usare chiavi composite cosa che servirebbe per le entità deboli (funzionalità richiesta da tempo ma ignorata, basta cercare online per trovare diversi thread a riguardo).

Credo di aver detto tutte le cose fondamentali.  

<a name="section-5"></a>
### DUBBI ATTUALI

- Per leggere i dubbi attuali guardare "dubbi_attuali.md".