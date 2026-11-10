# Passport, Dashboard and Profile

These pages use Lama's `header.php` and `style.css`. Extra styles in `member.css` only apply to the new pages. There are no extra packages to install.

## Run locally

1. Enter your database settings in the local `config.php`. If that file is missing on another computer, copy `config.example.php` to `config.php` first. Do not upload `config.php` to GitHub.
2. In phpMyAdmin, select the existing project database and run `stamps.sql`. It keeps the existing tables and adds stamps for older experiences. If `stamps` already exists, it is kept. Do not import Lama's original `database.sql` over the shared database because it drops existing tables.
3. For local testing before the login module is available, set `DEMO_USER_ID` to the ID of an existing test user in your local `config.php`. Leave it `0` when using real login sessions. The new pages read `$_SESSION["user_id"]` from the login module.
4. Run `php -S localhost:8000` in the project folder, then open `http://localhost:8000/dashboard.php`.
5. PHP needs MySQLi and mbstring. No profile upload folder or image-upload settings are needed.

## Files and database columns

- `dashboard.php`: counts experiences, distinct cafés visited and stamps for the signed-in user; shows the latest three experiences.
- `passport.php`: shows the latest ten stamps, the total collected and a short message about the first badge at ten stamps. This is an in-app achievement, not a café discount.
- `CoffeePassport.php`: a PHP class with methods for statistics, recent experiences and stamps. It uses prepared MySQLi statements.
- `progress.php`, `passport_content.php`, `passport.js`: jQuery AJAX refreshes the stamp list and totals automatically without reloading the page. It checks every 15 seconds while the page is visible and immediately when the user returns to the tab/window. There is no refresh button. The recent-experience list refreshes on a normal page load.
- `profile.php`: updates only `users.name`, always using the session's user ID. The email is displayed in a read-only box and cannot be edited through this page. A letter from the user's name is shown in a circle. Profile photo upload was removed to keep the feature within the agreed course scope. The existing `users.profile_pic` column and any saved image paths are left unchanged.
- `add_experience.php`: inserts the experience and one stamp in a transaction. `stamps.experience_id` refers to `experiences.id`, and the unique key prevents a second stamp for the same experience. Editing a rating does not add a stamp; deleting the experience removes the stamp through the foreign key.

Existing `db.php` and experience pages still contain Lama's temporary user-1 fallback. The authentication owner must remove that fallback when integrating real login/logout. New member pages check the session before including `db.php`, with demo access only when explicitly enabled locally.

The café/favorites branch has not been merged here. These files are based on `feature/experiences`, with the approved member-page changes kept in `feature/passport`. The shared MySQL connection was checked and missing stamps were added for the two existing experiences without changing those experiences.

The experience edit page now places Save Changes and Cancel on the same row. Ratings on My Experiences are display-only and are changed through Edit and Save Changes. The old direct rating endpoint no longer updates ratings.

## Review completed locally

- All PHP files passed syntax checks, and `passport.js` passed the JavaScript syntax check.
- The actual passport class and view passed checks for empty accounts, separate user totals, distinct café counts, stamp backfill without duplicates, the ten-stamp goal and cascading deletion. These checks used a local SQLite query adapter, not a live MySQL connection.
- HTTP checks ran the actual profile and add-experience handlers with the local adapter. Profile validation, form token checks, user isolation and paired experience/stamp inserts were checked. Photo upload is no longer part of the profile feature.
- Dashboard, Passport and Profile were visually checked in a browser. AJAX refresh and client-side profile validation were checked there too. The narrow-screen statistics cards were adjusted so their text remains visible.
- The real MySQL connection, table structure, cascading stamp relationship and passport queries were checked successfully. The user also verified that adding an experience creates its stamp and deleting that test experience removes the stamp. The simulated review server uses separate sample data only.

The main programming approach follows the course topics: HTML forms, external CSS with floats, JavaScript validation and DOM updates, PHP functions/classes/sessions, prepared MySQLi queries, transactions and jQuery AJAX. Session-bound form-token helpers protect profile updates; these individual helper functions may need additional explanation beyond the slide examples.

## Check the finished flow

- Check a user with no experiences: zero totals, empty stamp slots, no badge.
- Add an experience: exactly one new stamp and increased totals. Edit its rating: no extra stamp. Delete it: its stamp disappears.
- Keep the passport open, then add an experience elsewhere. Return to the passport (or wait up to 15 seconds while it is visible): the new stamp appears without a page reload or refresh button.
- Reach ten stamps: the badge is earned. At more than ten, the total continues increasing and the latest ten stamps remain visible. Progress is shown as plain text, without a progress bar.
- Save a name: only `users.name` should change; the email and existing profile photo data must stay unchanged. No file input or editable email input should appear on the page.
- With JavaScript available, the name starts read-only and Save Changes is hidden. Clicking the pencil enables the name and reveals Save Changes. The email appears in a matching read-only input without a submitted field name; it cannot be updated by the handler. Without JavaScript, the normal name form remains usable.
- Try an empty name, a name longer than 100 characters and a form with a missing/incorrect token: no profile change should be saved. Sending an extra email field manually must not change the account email.
- Switch to another user: their profile, counts and stamps must be separate. With demo mode off, signed-out requests to the new pages must return 401.
