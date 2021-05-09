# Dubbi Attuali

**(Questa documentazione iniziale è per far capire da dove sono partito, molte cose sono cambiate, come affonto in "Documentazione 1.0".)**  

---

- [Dubbi](#section-1)

---

<a name="section-1"></a>
### Come gestire al meglio multi-corso?  
- Ha senso creare un'ulteriore relazione per i corsi che collaborano così che lo studente aggiungendo i corsi a un progetto lì prenda da lì? 
> {info}Se sì bisogna aggiungere la relazione COLLABORA 
- Come gestisco lo stato di progetto? per come ho fatto io il progetto ha uno stato, ogni docente potrebbe convalidarlo: i docenti si dovrebbero accordare e poi uno di loro accetta i requisiti/conclude il progetto.  
> {info}Non mi convince per niente fare più stati dello stesso progetto per i diversi corsi, credo che sia necessario che i docenti si accordino attraverso messaggi dentro al progetto o attraverso diversi mezzi.

### Come gestire al meglio multi-studente?  
- Come aggiungo gli studenti? lo fa l'utente che crea per primo il progetto: li aggiunge direttamente? li invita?
> {info}Abbastanza indeciso su questo, se li aggiunge direttamente lo studente potrebbe aggiungere gente a caso, quindi bisognerebbe dare la possibilità agli studenti di cancellarsi da certi progetti in caso. In caso di invito invece dovrei creare almeno un'altra relazione.

### Nomi dei corsi come chiave?
- Come gestisco lo stesso corso fatto da prof differenti ma che si sovrappongono per un certo periodo di tempo, penso che sia meglio assegnare un codice ai corsi.
> {info}Qui credo che sia necessario mettere un codice_corso

### I corsi possono avere o no progetti
- Devo poter far aggiungere allo studente progetti solo per corsi che attualmente possano avere dei progetti?
> {info}Qui credo sia necessario aggiungere ai corsi l'attributo che indica se necessita o meno di progetto. Così lo studente fa la query solo di quei corsi che ne necessitano.