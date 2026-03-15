# 🏛️ KairouanHub

**KairouanHub** is a premium, localized platform designed to connect the residents of Kairouan with trusted local service providers and craftsmen.

## 🌟 Features

- **Luxurious Dashboard**: A dedicated space for providers to manage their profiles, services, and galleries.
- **Service Discovery**: Easy-to-navigate interface for users to find the best local talent.
- **Points & Rewards**: A community-driven system where users earn points for recommending trusted providers.
- **Multilingual Support**: Fully localized in Arabic (🇹🇳), French (🇫🇷), and English (🇬🇧).
- **Mobile Responsive**: Designed to work perfectly on any device.

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (or MySQL)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/zinehamdi/KairouanHub.git
   cd KairouanHub
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup:**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Build Assets:**
   ```bash
   npm run dev
   ```

6. **Serve Application:**
   ```bash
   php artisan serve
   ```

## 🛡️ Admin Panel
Admin routes are protected and localized. Admnins can moderate provider suggestions, manage categories, and import data from Google Maps.

## 📄 License
Open-source software licensed under the [MIT license](LICENSE).
