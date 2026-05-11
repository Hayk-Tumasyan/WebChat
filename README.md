# WebChat

Small PHP + MySQL realtime-style chat (client polling). Armenian UI labels.

**Armenian documentation:** [docs/Արձանագրություն.md](docs/Արձանագրություն.md)

## Requirements

- **PHP** 7.4 or newer (8.x recommended) with extensions: `mysqli`, `session`, `fileinfo` (recommended for uploads).
- **MySQL** 5.7+ or MariaDB 10.3+.
- A web server that runs PHP (Apache with `mod_php` or PHP-FPM + Nginx, or the PHP built-in server for local use).

## Setup

### 1. Document root

Point the site **document root** to this project directory (the folder that contains `index.php`, `assets/`, `php/`, etc.), so URLs resolve as:

- `/index.php`, `/login.php`, `/users.php`, `/chat.php`
- `/assets/css/style.css`, `/assets/js/...`
- `/php/signup.php`, `/php/login.php`, …

**PHP built-in server (development only):**

```bash
cd /path/to/WebChat-main
php -S localhost:8080
```

Then open `http://localhost:8080/index.php`.

### 2. Database

Create the schema and database (adjust the database name if you change it in config):

```bash
mysql -u root -p < sql/schema.sql
```

Or import `sql/schema.sql` with phpMyAdmin / your GUI client.

### 3. Writable upload directories

The web server user must be able to **write** to:

- `php/images/` — registration avatars and default `profile.png`
- `php/uploadedFiles/` — chat attachments

Example (macOS/Linux, paths and user vary):

```bash
chmod -R ug+rwX php/images php/uploadedFiles
# If needed, set owner to the PHP/web user, e.g. www-data:
# sudo chown -R www-data:www-data php/images php/uploadedFiles
```

### 4. Configuration

Default DB settings live in `php/config.php` (`localhost`, `root`, empty password, database `chat`).

For local overrides **without editing committed files**:

1. Copy `php/config.local.example.php` to `php/config.local.php` (this file is gitignored).
2. Set `$db_host`, `$db_user`, `$db_pass`, and `$db_name` in `config.local.php`.

`php/config.php` loads `php/config.local.php` automatically when that file exists.

### 5. Security: CSRF

Forms on **signup**, **login**, and **chat** include a session-bound CSRF token. The following endpoints verify it:

- `php/signup.php`, `php/login.php`
- `php/insert-chat.php`, `php/get-chat.php`
- `php/search.php` (token is provided from the users page via `assets/js/users.js`)

If a token is missing or wrong, the request is rejected (plain-text or HTTP 403 where appropriate).

---

## Manual regression checklist

Run through this after changes or before a release:

1. **Signup** — Open `index.php`, register a new user (with and without profile image). Expect redirect or success path to `users.php` and no CSRF error.
2. **Login** — Log out, open `login.php`, sign in with valid credentials. Expect `users.php` and status online.
3. **Message** — Open a chat with another user, send a text message. Expect message to appear for both sides (may take a short moment due to polling).
4. **File** — In chat, attach an allowed file (e.g. image or PDF), send. Expect file or preview behavior as before.
5. **Logout** — Use logout; expect redirect to login and offline status for that user.

Optional: clear cookies / use another browser to confirm cross-site POSTs to `php/login.php` without a valid token do not succeed.

---

## Project layout (short)

| Path | Purpose |
|------|---------|
| `index.php`, `login.php`, `users.php`, `chat.php` | Pages |
| `includes/header.php` | Shared `<head>` |
| `assets/css`, `assets/js` | Static assets |
| `php/` | AJAX handlers, `config.php`, `csrf.php`, uploads |
| `sql/schema.sql` | MySQL schema |
