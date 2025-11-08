# ⚡ Laravel 12 + Livewire 3 Starter Kit

A modern, production-ready **Laravel 12 Starter Kit** built with **Livewire 3**, **Tailwind CSS 4.1\***, **DaisyUI**, and **Alpine.js**.  
Includes clean architecture, component-driven UI, and built-in support for **FFmpeg** and **OpenGraph** for media sharing.

---

## 🚀 Features

- ⚙️ **Laravel 12** — Clean, powerful PHP framework  
- ⚡ **Livewire 3** — Reactive frontend without leaving Laravel  
- 🎨 **Tailwind CSS 4.1\*** + **DaisyUI** — Modern, responsive UI design  
- 💡 **Alpine.js** — Lightweight interactivity for components  
- 🗄️ **MySQL** — Default relational database  
- 🎬 **FFmpeg Integration** — For media processing (audio/video)  
- 🔗 **OpenGraph Meta** — Ready for social sharing previews  
- 🧩 Modular folder structure for scalable development  
- 🔐 Auth scaffolding, media utilities, and example components included  

---

## 🧰 Tech Stack

| Layer         | Technology                  |
| ------------- | --------------------------- |
| Backend       | Laravel 12 (PHP 8.3+)       |
| Frontend      | Livewire 3, Alpine.js       |
| UI Framework  | Tailwind CSS 4.1.*, DaisyUI |
| Database      | MySQL                       |
| Media         | FFmpeg                      |
| SEO / Sharing | OpenGraph Meta Tags         |

---

## 🛠️ Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/laravel-livewire-starter.git
cd laravel-livewire-starter
``` 

2. Install Dependencies
```bash
Copy code
composer install
npm install
```

3. Configure Environment

Copy the example .env file and update your credentials:

```bash
Copy code
cp .env.example .env
```
Update these important environment values:

env
Copy code
APP_NAME="Laravel Starter"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=

# FFmpeg Path (example for macOS/Linux)
FFMPEG_PATH=/usr/bin/ffmpeg
FFPROBE_PATH=/usr/bin/ffprobe

4. Generate Application Key
```bash
Copy code
php artisan key:generate
```

5. Run Migrations & Seeders

```bash
Copy code
php artisan migrate --seed
```

6. Build Assets

```bash
Copy code
npm run dev
```
7. Start the Server

``` bash
Copy code
php artisan serve
```

Your app will be live at:
👉 http://localhost:8000

🎨 UI Stack
This starter uses Tailwind CSS 4.1.* with DaisyUI components.
To customize the theme:

Edit tailwind.config.js

Modify colors, fonts, or DaisyUI themes as needed

Run npm run build after UI updates

🧠 Livewire + Alpine Integration
All components are built using Livewire 3 with Alpine.js for interactivity.
Example:

blade
Copy code
<div x-data="{ open: false }">
    <button @click="open = !open" class="btn btn-primary">Toggle</button>

    <div x-show="open" class="p-4 bg-base-200 rounded-xl mt-2">
        Hello from Alpine + Livewire!
    </div>
</div>
🎬 FFmpeg Integration
Used for video/audio conversion, thumbnail generation, or media previews.

Example command:

bash
Copy code
php artisan media:convert example.mp4
Make sure FFmpeg is installed on your system:

bash
Copy code
ffmpeg -version
If not, install it using:

macOS: brew install ffmpeg

Ubuntu/Debian: sudo apt install ffmpeg

Windows: Download from https://ffmpeg.org/download.html

🔗 OpenGraph Setup
Add this helper to your Blade layout for media sharing:

blade
Copy code
<x-opengraph 
    title="Page Title" 
    description="Short description for SEO"
    image="{{ asset('images/preview.png') }}"
    url="{{ url()->current() }}"
/>
This ensures that pages shared on Facebook, Twitter, or LinkedIn generate proper previews.

📁 Folder Structure
arduino
Copy code
laravel-livewire-starter/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Livewire/
│   │   └── Middleware/
│   ├── Models/
│   └── Services/          # For FFmpeg & media utilities
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── api.php
└── tailwind.config.js
🧪 Testing
Run tests before pushing updates:

``` bash
Copy code
php artisan test
```

🧑‍💻 Contributing
Fork the repository

Create a feature branch

```bash
Copy code
git checkout -b feature/your-feature-name
```

Commit your changes

Push and open a Pull Request

Please follow PSR-12 standards and ensure commits are descriptive.

📄 License
This project is licensed under the MIT License.

💬 Contact
Developer: [Your Name]
📧 Email: you@example.com
🌐 Website: https://yourwebsite.com

💡 A modern Laravel + Livewire starter kit to speed up development — built with scalability and developer happiness in mind.

```bash
Copy code
```