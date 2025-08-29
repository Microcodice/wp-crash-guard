
# Manuale Utente Completo di WP Crash Guard

Versione 1.4.0

## Indice

1.  [Introduzione]
2.  [Caratteristiche Principali]
3.  [Installazione]
4.  [Configurazione]
5.  [Gestione Whitelist]
6.  [Monitoraggio e Log]
7.  [Impostazioni Avanzate]
8.  [Casi d'Uso e Best Practice]
9.  [Risoluzione Problemi]
10.  [Dettagli Tecnici]

## Introduzione

WP Crash Guard è un plugin di sicurezza e stabilità per WordPress che agisce come scudo protettivo per il tuo sito web. Operando come plugin "must-use", intercetta gli errori critici prima che possano bloccare il sito e prende automaticamente azioni correttive disattivando il plugin o tema problematico.

### Perché WP Crash Guard?

-   **Zero Downtime**: Il tuo sito rimane accessibile anche quando un plugin fallisce
-   **Recupero Automatico**: Non richiede intervento manuale
-   **Rilevamento Intelligente**: Identifica esattamente quale plugin causa problemi
-   **Risposta Flessibile**: Comportamento personalizzabile per diversi scenari
-   **Trasparenza Completa**: Log dettagliati di tutte le azioni

## Caratteristiche Principali

### Funzionalità di Protezione Core

-   **Intercettazione Errori Fatali**: Cattura errori PHP fatali, errori di parsing e di compilazione
-   **Gestione Memoria**: Gestisce errori di memoria esaurita con recupero d'emergenza
-   **Gestione Eccezioni**: Gestisce eccezioni non catturate che normalmente bloccherebbero il sito
-   **Identificazione Plugin Intelligente**: Individua esattamente quale plugin causa l'errore

### Funzionalità Esperienza Utente

-   **Esperienza Visitatori Personalizzabile**: 5 modalità diverse per gestire errori sul frontend
-   **Opzioni Notifica Admin**: 4 modi diversi per notificare gli amministratori
-   **Sistema Whitelist**: Esclude plugin fidati dal monitoraggio
-   **Supporto Multilingua**: Supporto completo per l'internazionalizzazione

### Funzionalità per Sviluppatori

-   **Modalità Dry Run**: Testa senza disattivare realmente i plugin
-   **Livelli Errore Configurabili**: Scegli quali errori PHP attivano la protezione
-   **Log Completi**: Log dettagliati di errori e azioni
-   **Architettura Must-Use**: Si carica prima di tutti gli altri plugin per massima protezione

## Installazione

### Installazione Automatica

1.  Scarica l'ultimo pacchetto installer di WP Crash Guard
2.  Accedi al pannello admin di WordPress
3.  Vai su **Plugin → Aggiungi nuovo → Carica plugin**
4.  Seleziona il file ZIP scaricato e clicca **Installa ora**
5.  Clicca **Attiva plugin** quando richiesto

### Cosa Succede Durante l'Installazione

1.  L'installer crea la directory `mu-plugins` se non esiste
2.  Copia tutti i file del plugin in `mu-plugins/wp-crash-guard/`
3.  Crea un file loader `wp-crash-guard-loader.php` in `mu-plugins`
4.  Si disattiva e rimuove automaticamente
5.  Ti reindirizza alla lista plugin

### Post-Installazione

Dopo l'installazione, WP Crash Guard:

-   Non apparirà più nella lista plugin normale
-   Sarà visibile sotto **Plugin → Obbligatori**
-   Mostrerà una nuova voce menu **Crash Guard** nel pannello admin

## Configurazione

### Accesso alle Impostazioni

Vai su **Crash Guard → Impostazioni** nel pannello admin di WordPress.

### Impostazioni Comportamento Visitatori

Configura come il tuo sito risponde agli errori per i visitatori normali:

#### Non Fare Nulla (Modalità Silenziosa)

-   **Cosa succede**: Il plugin viene disattivato silenziosamente, la pagina si ricarica automaticamente
-   **L'utente vede**: Niente - la pagina si aggiorna semplicemente
-   **Ideale per**: Siti dove l'esperienza utente è fondamentale
-   **Nota**: Opzione più trasparente

#### Ricarica Automaticamente

-   **Cosa succede**: Mostra schermata di caricamento, poi ricarica dopo un ritardo
-   **L'utente vede**: Messaggio "Aggiornamento..." con countdown
-   **Ideale per**: Siti dove brevi interruzioni sono accettabili
-   **Personalizzabile**: Imposta ritardo da 0-60 secondi

#### Mostra Pagina Manutenzione

-   **Cosa succede**: Visualizza pagina di manutenzione professionale
-   **L'utente vede**: Messaggio "Manutenzione in corso"
-   **Ideale per**: Siti professionali, e-commerce
-   **Status HTTP**: Ritorna 503 Service Unavailable

#### Mostra Messaggio Personalizzato

-   **Cosa succede**: Visualizza il tuo contenuto HTML personalizzato
-   **L'utente vede**: Il tuo messaggio personalizzato
-   **Ideale per**: Esperienze branded, istruzioni specifiche
-   **Supporta**: HTML completo inclusi stili

#### Modalità Stealth

-   **Cosa succede**: Redirect istantaneo senza pagina intermedia
-   **L'utente vede**: La pagina lampeggia e si ricarica
-   **Ideale per**: Recupero alla massima velocità
-   **Nota**: Può essere brusco per gli utenti

### Impostazioni Comportamento Amministratori

Configura le notifiche per amministratori connessi:

#### Mostra Dettagli Errore Completi

-   **Cosa mostra**: Pagina errore completa con dettagli tecnici
-   **Informazioni**: Messaggio errore, percorso file, numero riga
-   **Ideale per**: Ambienti di sviluppo
-   **Nota**: Blocca la pagina finché non viene riconosciuta

#### Mostra Notifica Toast

-   **Cosa mostra**: Piccolo popup nell'angolo in alto a destra
-   **Durata**: 5 secondi (estendibile al passaggio del mouse)
-   **Ideale per**: Siti di produzione con admin attivi
-   **Non bloccante**: Puoi continuare a lavorare

#### Ricarica Automaticamente

-   **Cosa succede**: La pagina si aggiorna con notifica nella bacheca
-   **Ideale per**: Admin che vogliono minima interruzione
-   **Combina**: Auto-recupero con notifica

#### Non Mostrare Nulla

-   **Cosa succede**: Silenzio completo, controlla i log dopo
-   **Ideale per**: Siti di produzione con monitoraggio
-   **Nota**: Appaiono solo notifiche nella bacheca

## Gestione Whitelist

### Accesso alla Whitelist

Vai su **Crash Guard** e clicca sulla scheda **Whitelist**.

### Comprendere la Whitelist

La whitelist ti permette di escludere plugin specifici dal monitoraggio di WP Crash Guard. I plugin nella whitelist:

-   Non verranno mai disattivati da WP Crash Guard
-   Continuano a essere caricati anche se causano errori
-   Sono tua responsabilità da monitorare

### Quando Usare la Whitelist

Aggiungi plugin alla whitelist quando:

-   **Plugin di sviluppo/debug**: Query Monitor, Debug Bar
-   **Plugin di test**: Causano errori intenzionalmente
-   **Plugin critici**: Devono girare nonostante warning occasionali
-   **Plugin comportamento speciale**: Gestori di errori personalizzati

### Gestire Plugin nella Whitelist

1.  **Funzione Ricerca**: Digita per filtrare i plugin istantaneamente
2.  **Indicatori Stato**: Mostra stato attivo/inattivo
3.  **Selezione Multipla**: Seleziona più plugin contemporaneamente
4.  **Salva Modifiche**: Clicca "Salva Whitelist" per applicare

### Best Practice

-   Metti nella whitelist solo plugin di cui ti fidi completamente
-   Rivedi regolarmente la tua whitelist
-   Rimuovi plugin dalla whitelist quando non più necessari
-   Documenta perché ogni plugin è nella whitelist

## Monitoraggio e Log

### Scheda Errori Recenti

Visualizza tutti gli errori intercettati con informazioni dettagliate:

#### Informazioni Visualizzate

-   **Nome Plugin**: Quale plugin ha causato l'errore
-   **Messaggio Errore**: La descrizione dell'errore PHP
-   **Posizione File**: File esatto e numero di riga
-   **Timestamp**: Quando è avvenuto l'errore
-   **Utente**: Chi era connesso quando è successo

#### Indicatori Speciali

-   **Errori Memoria**: Mostra avviso sul limite memoria PHP
-   **Errori Ripetuti**: Raggruppa errori simili insieme

### Scheda Registro Azioni

Traccia tutte le azioni di WP Crash Guard:

#### Azioni Registrate

-   **Attivazioni Plugin**: Quando i plugin vengono attivati
-   **Disattivazioni Automatiche**: Quando WP Crash Guard interviene
-   **Azioni Manuali**: Modifiche iniziate dall'admin

#### Gestione Log

-   **Cancella Log**: Rimuove voci vecchie
-   **Esporta**: Copia dati per analisi esterna
-   **Ritenzione**: Ultime 100 azioni mantenute automaticamente

## Impostazioni Avanzate

### Soglia Intercettazione Errori

Scegli quali errori PHP attivano la protezione:

#### Solo Errori Fatali (Default)

-   **Cattura**: E_ERROR, E_PARSE, E_COMPILE_ERROR
-   **Ignora**: Warning, notice, deprecazioni
-   **Ideale per**: Siti di produzione
-   **Sicurezza**: Massima - solo errori critici

#### Warning e Superiori

-   **Cattura**: E_WARNING + Superiori
-   **Caso d'uso**: Ambienti staging
-   **Rischio**: Può disattivare per problemi non critici

#### Notice e Superiori

-   **Cattura**: Quasi tutti gli errori PHP
-   **Caso d'uso**: Solo sviluppo
-   **Attenzione**: Alto rischio di falsi positivi

### Modalità Operative

#### Modalità Dry Run

-   **Funzione**: Rileva e registra senza disattivare
-   **Usa per**: Testare comportamento WP Crash Guard
-   **Mostra**: Cosa succederebbe senza farlo
-   **Sicuro per**: Test in produzione

#### Toggle Auto-Disattivazione

-   **Abilitato**: Plugin problematici vengono disattivati
-   **Disabilitato**: Solo log, nessuna azione intrapresa
-   **Attenzione**: Disabilitare può lasciare il sito rotto

#### Log Errori

-   **Abilitato**: Tutti gli errori salvati nel database
-   **Disabilitato**: Nessuna cronologia errori mantenuta
-   **Performance**: Impatto minimo quando abilitato

### Ritardo Ricaricamento

-   **Range**: 0-60 secondi
-   **Default**: 5 secondi
-   **0 secondi**: Ricaricamento istantaneo
-   **Valori più alti**: Danno tempo agli utenti di leggere i messaggi

### Messaggi Personalizzati

Crea pagine di errore personalizzate:

```html
<div style="text-align: center; padding: 50px;">
  <h1>Torniamo subito!</h1>
  <p>Il nostro team sta aggiornando il sito. Riprova tra un momento.</p>
  <p>Domande? Email: supporto@esempio.it</p>
</div>

```

## Casi d'Uso e Best Practice

### Ambiente di Sviluppo

**Impostazioni Consigliate**:

-   Modalità Admin: Mostra dettagli errore completi
-   Modalità Visitatori: Non fare nulla
-   Livello Errori: Notice e Superiori
-   Dry Run: Abilitato inizialmente
-   Whitelist: Strumenti di sviluppo

### Ambiente Staging

**Impostazioni Consigliate**:

-   Modalità Admin: Notifica toast
-   Modalità Visitatori: Pagina manutenzione
-   Livello Errori: Warning e Superiori
-   Dry Run: Disabilitato
-   Ritardo Ricaricamento: 3 secondi

### Ambiente di Produzione

**Impostazioni Consigliate**:

-   Modalità Admin: Non mostrare nulla
-   Modalità Visitatori: Non fare nulla (stealth)
-   Livello Errori: Solo Errori Fatali
-   Dry Run: **Disabilitato**
-   Whitelist: Minima

### Siti E-Commerce

**Considerazioni Speciali**:

-   Usa "Non fare nulla" per visitatori (nessuna interruzione carrello)
-   Abilita log completi
-   Imposta monitoraggio esterno
-   Messaggio personalizzato con contatto supporto

### Siti Membership

**Approccio consigliato**:

-   Pagina manutenzione con link login
-   Notifiche toast per admin
-   Inserimento plugin in whitelist con attenzione
-   Ritardi ricaricamento veloci (2-3 secondi)

## Risoluzione Problemi

### Problemi Comuni

#### Plugin Non Visibile Dopo Installazione

-   **Controlla**: Pagina plugin Must-Use
-   **Posizione**: `/wp-content/mu-plugins/`
-   **Soluzione**: Installazione riuscita, funziona come previsto

#### Errori Ancora Visibili

-   **Controlla**: Impostazioni soglia errori
-   **Controlla**: Plugin non in whitelist
-   **Controlla**: Modalità dry run non abilitata
-   **Soluzione**: Verifica che il tipo di errore corrisponda alla soglia

#### Plugin Disattivato Inaspettatamente

-   **Controlla**: Log Errori Recenti
-   **Controlla**: Soglia errori troppo bassa
-   **Soluzione**: Regola soglia o metti plugin in whitelist

#### Errori Memoria Ricorrenti

-   **Problema**: Limite memoria PHP troppo basso
-   **Soluzione**: Aumenta `memory_limit` in php.ini
-   **Temporaneo**: WP Crash Guard aumenta a 256MB su errore

### Risoluzione Problemi Avanzata

#### Modalità Debug

Aggiungi a `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

```

#### Verifica Caricamento Must-Use

1.  FTP in `/wp-content/mu-plugins/`
2.  Verifica che `wp-crash-guard-loader.php` esista
3.  Controlla che directory `wp-crash-guard/` sia presente

#### Disattivazione Manuale

Se necessario, elimina via FTP:

-   `/wp-content/mu-plugins/wp-crash-guard-loader.php`
-   `/wp-content/mu-plugins/wp-crash-guard/`

## Dettagli Tecnici

### Architettura

WP Crash Guard usa il sistema must-use plugin di WordPress:

-   Si carica prima di tutti i plugin normali
-   Non può essere disattivato dall'admin
-   Sopravvive a conflitti tra plugin

### Flusso Gestione Errori

1.  **Si Verifica Errore**: PHP genera errore fatale
2.  **Intercettazione**: Handler shutdown cattura errore
3.  **Identificazione**: Traccia errore a plugin specifico
4.  **Controllo Whitelist**: Salta se plugin è in whitelist
5.  **Log**: Registra dettagli errore
6.  **Azione**: Imposta transient per disattivazione
7.  **Recupero**: Redirect basato su impostazioni
8.  **Pulizia**: Disattiva plugin al prossimo caricamento

### Considerazioni Performance

-   **Uso Memoria**: ~1MB baseline
-   **Impatto CPU**: Trascurabile eccetto durante errori
-   **Query Database**: 2-3 per evento errore
-   **Caricamento Pagina**: Nessun impatto misurabile

### Funzionalità Sicurezza

-   **Verifica Nonce**: Tutte le azioni admin protette
-   **Controlli Capability**: Richiede `manage_options`
-   **Sanificazione Dati**: Tutti gli input filtrati
-   **Protezione SQL Injection**: Statement preparati

### Compatibilità

-   **WordPress**: 5.0+ richiesto
-   **PHP**: 7.2+ consigliato
-   **MySQL**: 5.6+ richiesto
-   **Multisite**: Completamente supportato


### Struttura File ZIP

```
/wp-crash-guard.zip/
├── wp-crash-guard-installer.php
└── plugin-files/
    ├── wp-crash-guard.php
    ├── readme.md
    ├── readme-italian.md
    └── languages/
	    ├── wp-crash-guard.pot
        ├── wp-crash-guard-it_IT.mo
        └── wp-crash-guard-it_IT.po

```

----------

**Versione**: 1.4.0  
**Autore**: Microcodice  
**Licenza**: GPL v2 o successiva  
**Supporto**: [GitHub Issues](https://github.com/microcodice/wp-crash-guard)
