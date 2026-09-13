# Khoja-Khuji — Simple PHP MVC UI

This version is intentionally database-free and keeps the UI close to the supplied screenshots.

## MVC structure
- `View/` — all pages and shared CSS/header/footer
- `Controller/` — form/login/logout/update handlers
- `Model/AppData.php` — sample data + temporary user storage

## 30-minute registration/login logic
- Registration creates a temporary demo account in an HTTP-only cookie for **30 minutes**.
- Password is stored as a PHP password hash.
- Logging out only removes the login session; it does **not** delete the temporary account cookie.
- Therefore the same email/password can be used to log in again during the remaining 30 minutes.
- After 30 minutes, the demo account expires and the user must register again.

## Run
Put the folder inside XAMPP `htdocs`, start Apache, then open:
`View/home.php`

## Database later
When you are ready to use MySQL, replace the methods inside `Model/AppData.php` and keep the views/controllers mostly unchanged.
