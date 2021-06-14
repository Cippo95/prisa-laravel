# DOCUMENTO DEI REQUISITI DEL PROGETTO

---

- [Caso d'uso tipico](#section-1)
- [Requisiti della applicazione](#section-2)
- [Struttura della base di dati](#section-3)
- [Parliamo dell'implementazione](#section-4)
- [Schemi architetturali](#section-5)
  
<a name="section-1"></a>
## PREMESSA

**Sono state apportate diverse semplificazioni dalla prima documentazione**: durante l'implementazione mi sono accorto di varie complicazioni, quindi ho semplificato diversi requisiti.

---

<a name="section-2"></a>
## REQUISITI DELLA APPLICAZIONE

Si vuole gestire il ciclo di vita dei progetti dei corsi universitari attraverso una applicazione web apposita piuttosto che tramite email.
L'applicazione verrà usata dagli studenti e i docenti per la gestione dei progetti universitari:  

- Si vuole avere un sistema di autenticazione e autorizzazione per studenti e docenti, sarebbe interessante integrare l'applicazione col sistema universitario (saml).  

- Gli studenti potranno gestire i loro progetti per i vari corsi.
Potranno creare un progetto per un corso da loro seguito e concordare col docente del corso i requisiti tramite messaggi in una sezione apposita.

- Raggiunto un accordo sui requisiti il progetto, lo studente implementerà il progetto e al termine condividerà un link a un repository/drive remoto con i sorgenti e documentazione di progetto.  

- I docenti potranno vedere i vari progetti legati ai corsi che insegnano e quindi interagire con essi nella definizione dei requisiti e una volta terminati, possono metterli nello stato "concluso".  

Essenzialmente la struttura principale è molto simile a quella di un forum dove solo alcune persone possono accedere a determinati thread.

Consiglio di leggere la sezione "Parliamo dell'implementazione" per avere più informazioni su come ho gestito i vari requisiti e le scelte che ho fatto durante l'implementazione.

---

<a name="section-3"></a>
## STRUTTURA DELLA BASE DI DATI

Come detto nella introduzione ho usato le migrazioni ed Eloquent per gestire la base di dati, descrivo qui la struttura di essa.

La base di dati ha come tabelle principali:

- Gli utenti (users): essi hanno un codice identificativo (tipo matricola), un nome (nome e cognome), un ruolo (per distinguere studenti, docenti e amministratori), una email, una password (per ovvie ragioni di login) e altri campi inseriti di default da Laravel ad esempio il timestamp (di creazione e modifica), un remember_token (per ricordarsi le sessioni utente) ed email_verified_at per la verifica della email alla registrazione (cosa non implementata).

- I corsi (courses): essi hanno un codice identificativo, un nome e i timestamp.

- I progetti (projects): essi hanno un codice identificativo, un corso di appartenenza, uno studente che li ha creati, uno stato e i timestamp. 

- Gli allegati (attachments): hanno anche essi un id univoco, un identificativo del progetto e del utente a cui appartengono, un messaggio (per ora ho deciso di avere solo un messaggio e niente allegati binari) e i timestamp.

- Ci sono inoltre altre tabelle create da Laravel per l'autenticazione e una tabella detta di "pivot" che serve alla relazione N:N che avviene tra gli utenti e i corsi (couse_user), le relazioni 1:N non necessitano di pivot table in quanto rappresentabili da un singolo attributo nella tabella lato N.

---

<a name="section-4"></a>
##PARLIAMO DELL'IMPLEMENTAZIONE

Prima di vedere degli schemi ricapitolo alcune mie scelte.

- Partendo dallo schema del database è chiaro che ho fatto diverse semplificazioni:
    - Sviluppa non è più una relazione ternaria (N:N:N) ma 1:N tra utenti (solo studenti) e progetti, l'idea era avere una applicazione dove un progetto poteva essere fatto per più corsi, da più studenti, il che è interessante però molto complicato da gestire:
        - Ora lo studente può fare un progetto per un solo corso alla volta (relazione 1:N tra corso e progetto), ma nella realtà abbiamo casi di progetti singoli fatti per più corsi (sarebbe quindi N:N). E.G. Gli studenti della triennale di ingegneria informatica ed elettronica che seguono i corsi di Cento possono scegliere di fare un "mega" progetto che vale mi pare ingegneria dei sistemi web e basi di dati.
        - Ora progetti possono avere un solo studente che li ha creati (relazione 1:N tra utenti e progetti), in realtà molto spesso i progetti vengono fatti da più persone (N:N), in questo caso un workaround sarebbe che gli studenti si mettessero d'accordo e uno facesse il rappresentante però in ogni caso non sarebbe male che tutti avessero visione del loro progetto tramite l'applicazione web.
    - Gli allegati inizialmente entità deboli sono diventate entità forti, quindi ho in teoria una "megatabella" di allegati, ma dalle mie ricerche, seppur un po' in contrasto con gli studi di basi di dati, è giusto così, nella realtà si implementano così le cose creando però anche degli indici per non avere problemi di prestazioni: basti pensare che Eloquent di fatto non supporta le chiavi composite cosa che mi sarebbe servita nel caso di una entità debole, cosa lo stesso richiesta da molti utenti ma sono stati ignorati, si capisce che Laravel è abbastanza "opinionated" come si suol dire.
    - Dallo schema ER si evincono certi vincoli che poi nella applicazione non si riflettono in maniera così vincolante:
        - Posso creare un corso senza che esso abbia un insegnante e viceversa posso creare un docente senza corsi, sta all'amministratore tenere tutto in ordine.
        - Si evince che un progetto possa esistere senza allegati, ma in realtà nella app alla creazione di un progetto bisogna scrivere il primo.
- I corsi hanno un identificativo unico: l'uso di un identificativo autoincrementante a quanto pare è la norma per ragioni di semplicità e robustezza.
- La differenza tra docenti e studenti è data solo dal loro ruolo, è importante unificarli per ragioni di login (stesso login per tutti), le relazioni che avevo prima tipo "segue" e "insegna" essenzialmente sono rappresentate dalla stessa relazione (N:N) con il ruolo dell'utente che definisce di quale stiamo parlando, ho anche creato il ruolo dei amministratore:
    - L'amministratore può creare i corsi, eliminare utenti, assegnare i corsi ai docenti, dare i privilegi di docente ai docenti appena iscritti al servizio (tutti i nuovi iscritti per ragioni di sicurezza hanno ruolo studente).
- Gli allegati sono solo messaggi, ho tolto gli allegati binari per tenere i requisiti in termini di memoria al minimo, non sapendo nemmeno quale sarebbe una dimensione massima accettabile per i file allegati visto il numero possibile di studenti.  
- Lo stato del progetto è solo "attivo" o "concluso", è importante concludere i progetti così da metterli in secondo piano a quelli attivi nella interfaccia utente.
- Oltre l'autenticazione con il pacchetto legacy laravel/ui ho implementato una serie di regole di autorizzazioni alle varie route attraverso i così detti Gates.
- Per l'implementazione con SAML ho usato un pacchetto su github che si trova a questo indirizzo: https://github.com/aacotroneo/laravel-saml2. Per integrare davvero la app con i servizi dell'università (quindi usare l'SSO, Single Sign On) bisognerebbe contattare gli amministratori dell'IDP (Identity Provider) dell'università per scambiare dei dati di configurazione. Ho usato il plug-in piuttosto che seguire la documentazione di SAML che a quanto pare non è super semplice da implementare (se no non ci sarebbe questo plugin probabilmente).

---

<a name="section-5"></a>
## SCHEMI ARCHITETTURALI

Si possono visionare gli attuali modelli in diversi pdf: 

- Schema eer della base di dati in "prisa_eer-SCHEMA_EER.pdf"  

- Schema relazionale in "prisa_eer-SCHEMA_RELAZIONALE.pdf"  

- Modello a statechart del funzionamento della applicazione e modello a fsm del passaggio di stato dei progetti in "prisa_eer-MODELLO_SC_FSM.pdf" (per ora non c'è la parte legata all'amministratore). 
