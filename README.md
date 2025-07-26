# 🧠 Laravel AI Semantic Category Search

This project is a Laravel 12 web application that allows users to:

- Import category data from an Excel file (`categories.xlsx`)
- Convert each category into an AI vector embedding using OpenAI
- Perform **semantic search** in plain English to find the most relevant category

---

## 🚀 Features

- Import Excel (`categories.xlsx`) containing a single column: `Category`
- Store categories with AI vector embeddings (OpenAI `text-embedding-ada-002`)
- Simple web interface to input a search query
- Cosine similarity algorithm returns top 5 closest matches
- Clean MVC structure with Laravel best practices

---

## 🧰 Tech Stack

- Laravel 12
- PHP 8.2+
- Laravel Excel (Maatwebsite)
- OpenAI PHP SDK
- MySQL

---

## 📂 Setup Instructions

### 1. Clone the Repo

```bash
git clone https://github.com/ankitjogani99/ai-category-search.git
cd ai-category-search
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Create `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` with database credentials and OpenAI key:

```
DB_CONNECTION=sqlite   # or mysql/postgres
OPENAI_API_KEY=sk-xxxxxx
```

> ✅ Tip: For SQLite, create the DB file and set `DB_DATABASE` to its path.

### 4. Migrate the Database

```bash
php artisan migrate
```

### 5. Add Your Excel File

Place your Excel file here:

```
storage/app/public/categories.xlsx
```

Format: single column with header `Category`.

---

### 6. Run the Import Command

```bash
php artisan import:categories
```

This will:
- Read all rows from the Excel file
- Convert each category into an OpenAI vector embedding
- Store the category and embedding into the database

---

## 🔎 Access the Search Interface

Start the Laravel development server:

```bash
php artisan serve
```

Open your browser at:

```
http://localhost:8000/search
```

---

## 🧠 Example Query

**Input:**  
> "flooring services"

**Output:**
```
1. Flooring (Score: 0.942)
2. Interior Decor (Score: 0.712)
3. Renovation (Score: 0.610)
...
```

