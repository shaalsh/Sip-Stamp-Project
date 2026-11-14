# Dashboard Passport and Profile

## Local setup

Follow `LOCAL_SETUP.md` to prepare the local database and `config.php`. The pages use the shared connection in `db.php` and the logged in account id in the session. No additional PHP package is needed for these pages.

## Pages and shared files

- `dashboard.php` shows experience totals different cafes visited collected stamps and the latest three experiences
- `passport.php` displays the passport through `passport_content.php`
- `profile.php` displays the account name and email and updates only `users.name` with a prepared statement filtered by the logged in user id
- `CoffeePassport.php` reads statistics recent experiences and stamps using prepared MySQLi statements
- `passport_bootstrap.php` checks the login session and loads the account
- `passport_helpers.php` escapes displayed text and returns local image tags for icons
- `progress.php` returns the current passport HTML for AJAX requests and returns `login` when the session has ended
- `passport.js` refreshes passport data when the page opens and when the browser window receives focus again and handles the profile pencil and name validation
- `member.css` keeps the desktop layout and uses floats and simple classes
- `images/icons` contains the five transparent PNG icons used by these pages

## Current behavior

The passport has no timed refresh and no refresh button. It uses AJAX when the page opens and when the user returns focus to it. Normal navigation to the page also reads the current data from MySQL.

Dates are shown as stored in the database including the time. Each saved experience has one linked stamp. Editing the experience does not add a stamp and deleting the experience removes its stamp. The passport shows the latest ten stamps while its total can exceed ten.

Profile updates use the login session a POST form an empty name check a prepared update a session message and a redirect after saving. HTML maxlength and JavaScript limit the name to 100 characters and the MySQL name column is VARCHAR(100). The email is read only and is not updated by the handler.

The additional profile form token was removed as requested. The simplified profile form no longer performs that additional token check.

The additional narrow screen layout rules were removed. The desktop presentation layout remains the target for these pages.

## Verification

The current pages passed HTTP checks with two temporary accounts on real local MySQL for registration login favorites experience creation and editing deletion of experiences and stamps isolated account data badge totals Arabic profile names and logout protection. The test accounts and their related rows were removed afterwards.

Browser checks verified loading all PNG icons enabling name editing keeping email fixed saving an Arabic name and displaying the passport with saved dates. The AJAX script was checked to run on initial setup and on the window focus event without a timer.
