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
- `passport.js` loads or hides passport details from the dashboard link using AJAX and handles the profile pencil and name validation
- `member.css` defines the member page layout and appearance
- `images/icons` contains the local PNG icons

## Behavior

Each saved experience has one linked stamp. Editing an experience does not add a stamp and deleting it removes its stamp. The passport displays the latest ten stamps while the total can exceed ten. The first badge is earned at ten stamps. Dates are displayed as stored in the database.

The initial dashboard request reads the current summary from the database. Clicking View Passport requests the full passport through AJAX and displays its stamps inside the dashboard without reloading the page. The same link becomes Hide Passport and returns to the summary when clicked again. Each request reads the latest totals. The sidebar passport link opens the full passport page normally. There is no automatic duplicate request timer or window focus handler.

The profile displays the email as text inside a box. The pencil reveals the name input and Save Changes button. PHP checks for an empty name and uses a prepared update restricted to the account ID in the session. After saving it stores a session message and redirects to the profile page. HTML and JavaScript limit the input to 100 characters and the database column is VARCHAR(100).

`database.sql` includes the stamps table and starter records. No separate stamps import is required.
