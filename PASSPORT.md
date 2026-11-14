# Dashboard Passport and Profile

## Setup

Follow `LOCAL_SETUP.md` to prepare the database and local `config.php` settings. These pages use PDO through `passport_connection.php`. Other project pages use MySQLi through `db.php`. Both connections read the same settings and use the same database.

## Files

- `dashboard.php` displays experience totals different cafes visited collected stamps and the latest three experiences
- `passport.php` displays the coffee passport
- `profile.php` displays the account name and email and allows the logged in user to update only their name
- `CoffeePassport.php` reads statistics recent experiences and stamps using prepared PDO statements
- `passport_connection.php` opens the PDO connection using the local settings
- `passport_bootstrap.php` checks the login session and loads the account
- `passport_content.php` builds the passport HTML and stamp totals
- `passport_helpers.php` escapes displayed text and returns local icon image tags
- `progress.php` returns passport HTML for AJAX requests and returns `login` when the session has ended
- `passport.js` requests updated passport data when the page opens and handles the profile pencil and name validation
- `member.css` defines the member page layout and appearance
- `images/icons` contains the local PNG icons

## Behavior

Each saved experience has one linked stamp. Editing an experience does not add a stamp and deleting it removes its stamp. The passport displays the latest ten stamps while the total can exceed ten. The first badge is earned at ten stamps. Dates are displayed as stored in the database.

The initial page request reads the current database values. Once the page is ready AJAX requests the passport section and updates the displayed totals. There is no refresh timer or window focus handler. To see changes made elsewhere after this request open the page again.

The profile displays the email as text inside a box. The pencil reveals the name input and Save Changes button. PHP checks for an empty name and uses a prepared update restricted to the account ID in the session. After saving it stores a session message and redirects to the profile page. HTML and JavaScript limit the input to 100 characters and the database column is VARCHAR(100).

`database.sql` includes the stamps table and starter records. `stamps.sql` is an optional migration for an older existing database that is missing stamps. It is not required after importing `database.sql` and is not executed by the website.
