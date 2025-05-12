# JuggleSocial

This project is a demonstration for a job application. 

The setup for this app is a platform where people can share images, like them and comment on them.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running Migrations and Seeding](#running-migrations-and-seeding)
- [Job Queue](#job-queue)
- [Running the Application](#running-the-application)
- [Known bugs](#known-bugs)

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP >= 8.0
- Composer
- MySQL (or any other database system supported by Laravel. Durring development a MySQL db was used)

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/JugglingLars/JuggleSocial.git
   cd JuggleSocial
   ```
2. **Install PHP dependencies:**

   ```bash
   composer install
   ```

## Configuration

1. **Copy the example environment file:**

   ```bash
   cp .env.example .env
   ```
2. **Generate an application key:**

   ```bash
   php artisan key:generate
   ```

## Database Setup

1. **Create a new database:**

    Create a new database for your project using your preferred database management tool.

2. **Update .env with your database credentials:**
    ```bash 
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
   ```


## Running Migrations and Seeding

1. **Run the migrations:**
    ```bash 
    php artisan migrate
    ```
2. **Seed the database:**
    ```bash 
    php artisan db:seed
    ```
    (The seeder includes a account with email ```test@test.test``` and password ```testtest1```)

## Job Queue

1. **Start the queue worker:**
    ```bash 
    php artisan queue:work
    ```

## Running the Application

1. **Serve the application:**

    ```bash 
    php artisan serve
    ```
    This will start a development server at http://localhost:8000.

## Known bugs
1. **Image won't load**

    While in the development folder, the images get displayed propperly on the ```images.index``` and ```images.show``` pages. However, when cloning the project to a different folder (over GitHub), setting up and running the project, the new images get a 403-Forbidden. 

    It is possible to view the images from a text editor or file explorer. When the form for a new image is send, the image is uploaded to the ```/storage/app/public/temp``` folder. When the ```/app/Jobs/ProcessImage.php``` job processes the image (adding the watermark), this image gets moved to the ```/storage/app/public/images``` folder.

2. **Image format limited to png**

    When processing the images to add a watermark I got issues with the image types. I could only get ```.png``` files to work propperly. I've spent some time trying to install different ways of achieving the goal without success. Eventually limited uploadable images to only allow ```.png``` files and to fix later.
    
Because of self imposed time contraints I'm letting this bug in for the moment.