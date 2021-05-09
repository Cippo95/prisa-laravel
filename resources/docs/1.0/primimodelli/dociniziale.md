# DOCUMENTO DEI REQUISITI DEL PROGETTO

---
- [Caso d'uso tipico](#section-1)
- [Requisiti della base di dati](#section-2)
- [Modelli architetturali](#section-3)
- [Dubbi attuali](#section-4)

**(Questa documentazione iniziale è per far capire da dove sono partito, molte cose sono cambiate, come affonto in "Documentazione 1.0".)**

---

<a name="section-1"></a>
### CASO D'USO TIPICO

Si vuole gestire il ciclo di vita dei progetti dei corsi universitari attraverso una applicazione web apposita piuttosto che tramite email.
L'applicazione verrà usata dagli studenti e i docenti per la gestione dei progetti universitari.  
Effettutato il login gli studenti e i docenti avranno opzioni diverse:  

- Gli studenti potranno gestire i loro progetti per i vari corsi.
Nello specifico potranno proporre o richiede (se possibile) un progetto per un corso (o più corsi), il docente (o docenti) quindi valuterà i requisiti e proporrà in caso modifiche.   

- Raggiunto un accordo sui requisiti il progetto sarà approvato dal docente(o docenti) e al termine del progetto lo studente condividerà la documentazione e il codice sorgente tramite allegato o tramite link a repository remoti.  
I docenti potranno vedere i vari progetti legati ai corsi che insegnano e quindi interagire con essi nella definizione dei requisiti, accettandoli e chiudendoli una volta terminati.  

---

<a name="section-2"></a>
### REQUISITI DELLA BASE DI DATI

La base di dati deve tenere traccia degli utenti (studenti e docenti), dei corsi, dei progetti e degli allegati (note o file).

- Gli utenti hanno una matricola che li identifica univocamente, un nome e un cognome.

- Gli studenti sono utenti che seguono dei corsi e sviluppano per essi dei progetti. 

- I docenti sono utenti che insegnano i corsi (almeno 1).

- I corsi hanno un nome del corso che li identifica univocamente. Un corso avrà diversi progetti sviluppati per esso dagli studenti (userò per questa relazione la parola "controlla").

- I progetti hanno un codice progetto e uno stato.

- Gli allegati sono contenuti all'interno dei progetti, essi contengono messaggi, file binari, o entrambi, creati dagli utenti. Ad esempio un utente può scrivere un messaggio e condividere dei file di documentazione o sorgenti del progetto. Gli allegati all'interno del progetto si distinguono per il loro numero d'ordine.

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
### DUBBI ATTUALI

- Per leggere i dubbi attuali guardare "dubbi_attuali.md".