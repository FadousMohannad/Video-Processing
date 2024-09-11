# Video Processing and Summarization API

This Laravel project is designed to process videos, transcribe them, and generate summaries. The project utilizes Laravel's job processing system to handle these tasks efficiently.

## About the Project

The project consists of three main components:

1. **Video Transcription**: Converts video content into text using an external transcription service.
2. **Video Summarization**: Generates a summary of the transcribed text using an external summarization service.
3. **Job Processing**: Uses Laravel's queue system to manage and execute the transcription and summarization tasks.

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP (version 8.0 or higher)
- Composer
- Laravel Installer
- A web server (e.g., Apache, Nginx)
- MySQL or another supported database system

## Getting Started

Follow these steps to get your development environment set up:

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/yourrepository.git
cd yourrepository
```

### 2. Install Dependencies

Install the project dependencies using Composer:
```
composer install
```

### 3. Set Up the Environment

Copy the .env.example file to create your .env file:

```
cp .env.example .env
```

### 4. Run Migrations

```
php artisan migrate
```

### 5. Start the Queue Worker

```
php artisan queue:work
```

## Configuration

API keys to your .env file. Example configuration:
```
DEEPGRAM_API_KEY="c72583687fb7f4e407a4dcb67d79ddf0a03347e7"
OPENAI_API_KEY="sk-Nr7wKnqGjqfOvr55GLPOHKZGsc99uNxx4TlqdVH2Q0T3BlbkFJ4POc4weKVu6qIsRkW7BMFOjVX11kAEG3hyzmrCtFIA"
QUEUE_CONNECTION=database
```



