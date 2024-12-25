# Ypsilon

This is a project for the Laboratório de Bases de Dados e Aplicações Web (Databases and Web Applications Laboratory) 2024-2025 course at **FEUP**, using various technologies listed and detailed below to build a functional social network that implements features of every known real-world social network, focusing more on Twitter/X.

## Description
Ypsilon is a modern, easy-to-use, and intuitive social network that combines the best aspects of contemporary social networks. Share your thoughts, feelings, and life highlights via text, image, video, or even audio. Follow your favorite celebrities, connect with your best friends, visit their profiles, and interact with their posts by liking, replying, or even reposting.

## Features
- **User Profiles**: Create and customize your profile with images, bios, and more.
- **Posts**: Share text, images, videos, and audio with your followers.
- **Comments**: Engage with posts by leaving comments.
- **Reactions**: Show your appreciation for posts with likes or dislikes.
- **Reposts**: Share other people's posts that you agree with.
- **Saved Posts**: Save every post you want to review it later.
- **Groups**: Join or create groups to connect with like-minded individuals.
- **Notifications**: Stay updated with real-time notifications.
- **Messaging**: Send direct messages to other users.
- **Search**: Find users, posts, and groups easily.
- **Admin Panel**: Manage users and content with advanced admin tools.
- **Privacy Settings**: Control who can see your posts and profile.

## Technologies Used
- **Backend**: Laravel (PHP)
- **Frontend**: Blade templates, Bootstrap, Quill.js
- **Database**: PostgreSQL
- **Authentication**: Laravel Sanctum
- **Real-time Communication**: Pusher
- **Statistics**: Chart.js
- **Image Processing**: Intervention Image
- **Containerization**: Docker

## Getting Started

### Prerequisites
- PHP ^8.1
- Composer
- Node.js
- PostgreSQL

### Installation
1. Clone the repository:
    ```sh
    git clone https://gitlab.up.pt/lbaw/lbaw2425/lbaw24092.git
    cd lbaw24092
    ```

2. Install PHP dependencies:
    ```sh
    composer install
    ```

3. Install Node.js dependencies:
    ```sh
    npm install
    ```

4. Copy the `.env.example` file to `.env` and configure your environment variables:
    ```sh
    cp .env.example .env
    ```

5. Generate the application key:
    ```sh
    php artisan key:generate
    ```

6. Seed the database:
    ```sh
    php artisan db:seed
    ```

7. Start the development server:
    ```sh
    php artisan serve
    ```

### Usage
To start using the application, navigate to `http://localhost:8000` in your web browser.

## API Routes
API routes are defined in [routes/api.php](routes/api.php).

## Web Routes
Web routes are defined in [routes/web.php](routes/web.php).

## Configuration
Configuration files are located in the [config](config) directory.

## Database
The database schema is defined using Eloquent models located in the [app/Models](app/Models) directory. The database is seeded using the SQL file located at [database/database.sql](database/database.sql).

## Authors and Acknowledgment
- Gabriel da Quinta Braga - up202207784
- Gonçalo Nuno Santos Pires Barroso - up202207832
- Guilherme Silveira Rego - up202207041
- Tomás de Vasconcelos Fernandes Vinhas - up202208437
