# WoodyCraft - Laravel Puzzle Shop

E-commerce web application for selling wooden puzzles, built with Laravel 10, Tailwind CSS and MySQL.

---

## Features

- Puzzle catalog organized by categories
- Persistent shopping cart stored in the database
- Checkout with three payment methods: cheque, PayPal, credit card
- PDF invoice generation for cheque payments
- User profile management
- Admin panel: create, edit and delete puzzles
- PDF export of the full puzzle list

---

## Tech Stack

| Technology | Usage |
|---|---|
| Laravel 10 | PHP back-end framework |
| Blade | Templating engine |
| Tailwind CSS | Styling |
| MySQL | Database |
| Laravel Breeze | Authentication |
| DomPDF | PDF generation |

---

## Project Structure

```
app/
  Models/              User, Categorie, Puzzle, Panier, LignePanier, Adresse, Avis
  Http/Controllers/    PuzzleController, CategorieController, PanierController,
                       CheckoutController, ProfileController, AvisController
database/
  migrations/          All project tables
resources/
  views/               dashboard, categories, puzzles, paniers, checkout, profile, pdf
routes/
  web.php              All application routes
```
