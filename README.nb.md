
# 📂 Index Page Generator

Velkommen til **«Index Page Generator»** – et allsidig og kraftig PHP-skript designet for å gjøre navigering i mapper til en lek. Enten du er en utvikler som trenger en organisert struktur for dine webmapper eller noen som ønsker å bla gjennom filer med letthet, er dette skriptet den perfekte løsningen.

## 🎉 Hva er det?

«Index Page Generator» er et PHP-skript som automatisk lager `index.html`-filer for hver mappe innenfor en spesifisert bane. Disse `index.html`-filene er strukturert og stylet, og gir et brukervennlig rutenettoppsett som viser innholdet i hver mappe med passende inline SVG-ikoner for forskjellige filtyper.

### 🛠 Nøkkelfunksjoner

- **Rekursiv mappelisting**: Skriptet traverserer alle mapper og undermapper, og genererer `index.html`-filer for hver, og sikrer en fullstendig og navigerbar filstruktur.
  
- **Inline SVG-ikoner**: Ulike filtyper og mapper er representert med inline SVG-ikoner, noe som gjør det visuelt enklere å identifisere innholdet ved første øyekast.

- **Flerspråklig støtte**: Skriptet støtter fem språk: Engelsk, Norsk, Filippinsk, Spansk og Fransk. Det tilpasser seg intelligent til ditt foretrukne språk, og tilbyr en virkelig internasjonal opplevelse.

- **Dobbel brukermodus**: Enten du foretrekker å kjøre skriptet i et webmiljø eller direkte fra kommandolinjen, har «Index Page Generator» deg dekket. Det gir sanntidsstatusoppdateringer og ytelsesmetrikker i CLI-modus.

- **Minimalistisk design**: De genererte `index.html`-filene er enkle, men elegante, designet med responsivitet i tankene for å sikre at de ser bra ut på alle enheter.

## ✅ Krav

Før du begynner å bruke **Index Page Generator**, sørg for at miljøet ditt oppfyller følgende krav:

- **PHP 7.1 eller høyere**: Skriptet krever PHP 7.1 eller senere. Du kan sjekke PHP-versjonen din ved å kjøre `php -v` i terminalen din.
- **Webserver (valgfritt)**: For bruk på nettet, sørg for at du har en webserver som Apache eller Nginx kjørende. Skriptet bør plasseres i en katalog som betjenes av webserveren din.
- **Tilgang til kommandolinjegrensesnitt (CLI)**: For bruk med CLI trenger du tilgang til en terminal hvor du kan kjøre PHP-skript.

### Valgfrie avhengigheter:

- **Composer (valgfritt)**: Hvis du planlegger å utvide skriptet eller administrere flere PHP-avhengigheter, kan det være nyttig å ha Composer installert.
- **.htaccess (valgfritt)**: Hvis du vil begrense tilgangen til skriptet eller mapper, kan du bruke `.htaccess` for grunnleggende autentisering eller andre sikkerhetstiltak.

### Installasjonsnotater:
- **Filrettigheter**: Sørg for at PHP-skriptet har de nødvendige rettighetene til å lese mapper og skrive `index.html`-filer i målmappene.
- **PHP-utvidelser**: Ingen ekstra PHP-utvidelser kreves utover standard PHP-installasjon. Sørg imidlertid for at vanlige utvidelser som `mbstring` og `json` er aktivert.


## 🚀 Kom i gang

### Installasjon

1. **Last ned skriptet**: Klon repositoryet til din lokale maskin eller last ned `ipg.php`-filen direkte.

2. **Plasser skriptet**: Last opp `ipg.php`-skriptet til roten av mappen du ønsker å indeksere.

3. **Kjør skriptet**:
   - **Webbruk**: Få tilgang til skriptet via nettleseren din. Skriptet vil generere `index.html`-filer for hver mappe. Du kan spesifisere språket ved å bruke URL-parameteren `?lang=xx` (f.eks. `?lang=nb` for norsk bokmål).
   - **CLI-bruk**: Kjør skriptet i terminalen din:
     ```bash
     php ipg.php
     php ipg.php --lang=es
     ```
     Skriptet bruker engelsk som standard hvis skriptet kalles uten en parameter. Bytt ut `es` med din ønskede språkkode (`en`, `nb`, `fil`, `es`, `fr`).

### Eksempel på webbruk

Hvis nettstedet ditt ligger på `http://yourdomain.com`, og du vil at katalogene skal være på spansk, naviger enkelt til:

```
http://yourdomain.com/ipg.php?lang=fil
```

Skriptet vil generere `index.html`-filer med kataloger på filippinsk.

### Eksempel på CLI-bruk

Hvis du foretrekker å bruke kommandolinjen og ønsker at listene skal være på fransk, naviger til mappen der skriptet er plassert og kjør:

```bash
php ipg.php --lang=fr
```

### Språkstøtte

Skriptet støtter følgende språk:

- Engelsk (en) – Standard
- Norsk (nb)
- Filippinsk (fil)
- Spansk (es)
- Fransk (fr)

Du kan bytte språk ved å angi riktig språkkode enten i URL-en (`lang=xx`) eller i kommandolinjen (`--lang=xx`).

## 🚨 Bemerk

Vær oppmerksom på at kjøring av dette skriptet vil **overskrive eventuelle eksisterende `index.html`-filer** i mappene det behandler. Sørg for å ta sikkerhetskopi av viktige `index.html`-filer eller gi dem nye navn før du kjører skriptet.

## 📄 Perfekt for GitHub Pages

**Index Page Generator** er et utmerket verktøy for å forbedre GitHub Pages-opplevelsen din. Hvis du har en repository på GitHub Pages som mangler `index.html`-sider, vil dette skriptet automatisk generere vakre, strukturerte kataloger for alle filene og mappene dine.

### Hvorfor bruke det for GitHub Pages?

- **Automatisk fil- og mappeindeksering**: Ingen flere mapper som ikke er navigerbare! Dette skriptet sikrer at hver mappe i repositoryen din har en navigerbar `index.html`, som viser alle inneholdte filer og mapper.
- **Enkelt oppsett**: Bare slipp skriptet inn i repositoryens rotmappe, så tar det seg av resten. Perfekt for prosjekter der du enkelt vil dele filer eller gi tilgang til ressurser.
- **Flerspråklig støtte**: Enten publikummet ditt er globalt eller lokalt, sikrer manusets flerspråklige støtte (inkludert engelsk, norsk, filippinsk, spansk og fransk) at katalogene dine er tilgjengelige for et bredt publikum.
- **Visuell appell**: Med innebygde SVG-ikoner og en ren, responsiv design, ser de genererte `index.html`-sidene profesjonelle ut på både stasjonære og mobile enheter.

Ved å bruke dette skriptet med GitHub Pages forvandler repositoryen din fra en filoppsamling til et godt organisert, brukervennlig ressurssenter. Den er perfekt for dokumentasjonssider, fillager eller ethvert prosjekt der brukere trenger enkel tilgang til flere filer og mapper.

## 🌟 Hvorfor bruke «Index Page Generator»?

### Forbedre mappenavigasjon

Dette skriptet er perfekt for webutviklere, systemadministratorer og alle som trenger å navigere gjennom store filstrukturer. De organiserte, lettnavigerbare `index.html`-filene lar deg raskt finne det du leter etter uten å måtte grave deg ned i rå mapper.

### Forenkle filhåndtering

Ved automatisk å generere rene, lesbare indekser, reduserer skriptet rotet og forvirringen som ofte er forbundet med store filoppsamlinger. Det forbedrer også den visuelle opplevelsen ved å legge til ikoner som gjør filtyper umiddelbart gjenkjennelige.

### Språkfleksibilitet

Enten du jobber på et internasjonalt prosjekt eller bare foretrekker å bla gjennom på ditt eget språk, sikrer den flerspråklige støtten at katalogene er tilgjengelige og forståelige for et globalt publikum.

## 📚 Hvordan fungerer det?

Skriptet traverserer rekursivt hver mappe og undermappe, ignorerer skjulte filer og seg selv, for å unngå rekursjonsproblemer. Det samler inn fildetaljer som navn, sist endret dato og størrelse, og genererer deretter et stylet rutenettoppsett i `index.html`-filen.

### Ikonrepresentasjon
Skriptet bruker inline SVG-ikoner for å representere forskjellige filtyper:

- ![Folders](images/folder.svg) Mapper
- ![Images](images/image.svg) Bilder
- ![Videos](images/video.svg) Videoer
- ![Audio Files](images/audio.svg) Lydfiler
- ![Documents](images/document.svg) Dokumenter (PDF, Word, Excel, PowerPoint)
- ![Archives](images/archive.svg) ArArkiver (ZIP, RAR, 7z, etc.)
- ![Text Files](images/text.svg) Tekstfiler(TXT, MD, LOG)
- ![Code Files](images/code.svg) Kodefiler (HTML, CSS, JS)
- ![Generic Files](images/file.svg) Generiske filer (for andre typer)

Ikonene legger til en visuell dimensjon til fillistene, noe som gjør det enklere å navigere og forstå innholdet i hver mappe.

## 🔧 Tilpasning

### Styling 

De genererte `index.html`-filene er stylet med et minimalistisk design ved hjelp av innebygd CSS. Hvis du ønsker å tilpasse utseendet, kan du endre stilene direkte i skriptet. Designet er responsivt og fungerer godt på både stasjonære og mobile enheter.

## 💡 Tips og triks
- **Automatiser**: Sett opp en cron-jobb for å kjøre dette skriptet periodisk, og sørg for at katalogene dine alltid er oppdaterte.
- **Integrering**: Integrer dette skriptet med eksisterende webprosjekter for å gi en brukervennlig måte å bla gjennom filer direkte fra nettleseren.
- **Sikkerhet**: Hvis du kun vil at skriptet skal være tilgjengelig for bestemte brukere, vurder å bruke `.htaccess` for grunnleggende autentisering.

## 📄 Lisens

Dette prosjektet er lisensiert under MIT-lisensen – se `LICENSE`-filen for detaljer. Dette betyr at du fritt kan bruke, modifisere og distribuere skriptet i både personlige og kommersielle prosjekter.

## 🌍 Bidra

Vi ønsker bidrag velkommen! Hvis du har ideer til nye funksjoner eller forbedringer, kan du gjerne åpne en sak eller sende inn en pull request. La oss gjøre «Index Page Generator» enda bedre sammen.

## 🛠️ Støtte

Hvis du støter på problemer eller har spørsmål, kan du gjerne åpne en sak på GitHub eller kontakte meg direkte.

## 📚 Demo

Se [dokumentasjonen](./docs) for en demo. Skriptet [ipg.php](./ipg.php) ble brukt i mappene [docs-en](./docs/docs-en/) og [docs-nb](./docs/docs-nb).


---
Takk for at du sjekket ut «Index Page Generator»! Lykke til med koding! 🚀

-- John Filipstad
