# Taskly — To-Do List Web App

A simple, responsive To-Do List web application built with **HTML**, **CSS**, and **PHP** — no database, no frameworks.

---

## Features

- ✅ Add new tasks via a clean input form
- ✅ View all tasks in a styled list
- ✅ Mark tasks as complete (strike-through styling)
- ✅ Delete individual tasks
- ✅ Progress bar showing completion status
- ✅ Session-based runtime storage (no database needed)
- ✅ Fully responsive — works on mobile & desktop

---

## Project Structure

```
todo-app/
├── index.php      # Main application (UI + PHP logic)
├── style.css      # All styles and responsive layout
└── README.md      # This file
```

---

## Getting Started

### Requirements

- PHP 7.4 or higher
- A local server (e.g. XAMPP, WAMP, MAMP, or PHP's built-in server)

### Run Locally

1. **Clone or download** this repository into your server's web root (e.g. `htdocs/` for XAMPP).

2. **Start your local PHP server** — or use PHP's built-in server:
   ```bash
   php -S localhost:8000
   ```

3. **Open your browser** and navigate to:
   ```
   http://localhost:8000/index.php
   ```

---

## How It Works

| Action      | Mechanism                                              |
|-------------|--------------------------------------------------------|
| **Add task**    | HTML form POST → PHP appends to `$_SESSION['tasks']` |
| **Toggle done** | POST with task ID → PHP flips the `done` boolean     |
| **Delete task** | POST with task ID → PHP filters the task out         |
| **Storage**     | PHP sessions (`session_start()`) — resets on session end |

> ⚠️ Tasks are stored in the PHP session only. They will be lost when the browser session ends or the server restarts. No database is used by design.

---

## Design Highlights

- **Font:** DM Serif Display (italic heading) + DM Sans (body)
- **Color palette:** Warm cream background, terracotta accent, soft green for completed tasks
- **Effects:** Subtle grain texture, progress bar, smooth hover transitions, entrance animations
- **Responsive:** Single-column layout on mobile, full layout on desktop

---

## Tech Stack

| Layer      | Technology              |
|------------|-------------------------|
| Structure  | HTML5 (inside PHP)      |
| Styling    | CSS3 (custom properties, flexbox, animations) |
| Logic      | PHP 8+ (sessions, form handling) |
| Storage    | PHP `$_SESSION`         |
| Fonts      | Google Fonts (DM Serif Display, DM Sans) |

---

## License

MIT — free to use and modify.
