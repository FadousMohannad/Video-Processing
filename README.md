<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Overview

This Laravel project is an API-based application designed for video processing. It includes features for video uploading, trimming, transcription using Deepgram API, and summarization using OpenAI's GPT models. The system leverages Laravel queues to process videos asynchronously in multiple steps: trimming, transcription, and summarization.

The project is designed to work seamlessly with background jobs and is optimized for performance using Laravel's queue system.

## Key Features

- **Video Upload**: Users can upload videos through an API.
- **Video Processing**: Automatically trims videos based on user-defined start and end points.
- **Transcription**: Transcribes the video's audio using Deepgram's API.
- **Summarization**: Summarizes the transcription using OpenAI's API.
- **Job Queues**: Video processing, transcription, and summarization are handled in a background queue using `php artisan queue:work`.

## Technology Stack

- Laravel 10 Framework
- FFMpeg for video processing
- Deepgram API for transcription
- OpenAI API for summarization
- MySQL database
- Redis for queue management (optional)

## Setup and Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/yourproject.git
cd yourproject

### 2. Install Dependencies

```bash
composer install

### 3. Environment Configuration

Update the following in your .env file

```
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
DEEPGRAM_API_KEY=your_deepgram_api_key
OPENAI_API_KEY=your_openai_api_key


Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
