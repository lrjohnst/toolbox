# Changelog — toolbox

---

## 2026-08-03

### Bugfix: 405 Not Allowed bij formulier-submit

- Form action van alle drie de tools wees nog naar `/` (correct toen het subdomeinen waren, maar kapot na consolidatie naar submappen). POST naar `/` gaf 405 Not Allowed.
- Form actions bijgewerkt naar hun eigen submap: `/base64/`, `/json-encode/`, `/openssl-encrypt/`

---

## 2026-07-30

### Consolidatie naar submappen

- Toolbox-tools verplaatst van subdomeinen naar submappen:
  - base64.toolbox.phitech.cloud → toolbox.phitech.cloud/base64
  - json-encode.toolbox.phitech.cloud → toolbox.phitech.cloud/json-encode
  - openssl-encrypt.toolbox.phitech.cloud → toolbox.phitech.cloud/openssl-encrypt
- Alle interne links bijgewerkt naar relatieve paden
- Duplicate style.css verwijderd (één gedeelde root CSS)

---

## 2026-07-27

### Migratie srv2 → srv6: openssl-encrypt bugfixes

- **16:25** — Bugfixes in index.php:
  - Form action `/openssl-encrypt/index.php` → `/` (was kapot)
  - `<!DOCTYPE html>` toegevoegd
  - XSS-kwetsbaarheden gefixed: alle user-input nu via `htmlspecialchars()`
  - Ongesloten `<td>` tag gefixed
  - HTML entity `&laquo;` i.p.v. raw `<<<`

### Toolbox suite: base64, json-encode, index + restyling openssl-encrypt

- **17:30** — base64.toolbox.phitech.cloud aangemaakt: Base64 encode/decode tool met XSS-bescherming, foutafhandeling bij ongeldige Base64 input, form action gefixed naar `/`
- **17:30** — json-encode.toolbox.phitech.cloud aangemaakt: JSON decode/inspect tool met foutafhandeling (json_last_error_msg), veilige array_slice (controleert of result een array is), XSS-bescherming, form action gefixed naar `/`
- **17:31** — openssl-encrypt.toolbox.phitech.cloud restyled: uniforme styling met de andere tools, topmenu toegevoegd, foutafhandeling bij mislukte decryptie
- **17:31** — toolbox.phitech.cloud aangemaakt: indexpagina met kaarten naar alle drie de tools
- **17:32** — Uniforme CSS (`style.css`) gedeeld over alle vier de sites: donkere topnavigatie, consistente formulieren, resultaatweergave
- **17:34** — Alle tools functioneel getest: encode/decode/encrypt/decrypt werken correct
