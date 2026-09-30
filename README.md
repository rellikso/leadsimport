# CSV Lead Import

A Laravel application for importing lead data from a CSV file into a database.

## Requirements

* PHP 8.2+
* Laravel 13
* MySQL / MariaDB
* Composer

## Installation

Clone the repository and install dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database connection in `.env`, then run migrations:

```bash
php artisan migrate
```

Start the application:

```bash
php artisan serve
```

## Import

Open the import page:

```text
/leads/import
```

Select the CSV file and click **Import**.

The importer:

* reads the CSV using native PHP CSV functions;
* validates the CSV header and column structure;
* processes the file without loading the entire dataset into memory;
* inserts records in batches of 1,000 rows;
* handles empty CSV fields;
* normalizes `budget_uah` values containing spaces or non-breaking spaces;
* uses a database transaction so that a failed import does not leave a partially imported dataset.

The implementation is designed to import 100,000 rows within the required `max_execution_time=30` seconds.

## Test data

The CSV file used for testing was downloaded from the URL provided in the job assignment:

[https://docs.google.com/spreadsheets/d/1iFoPQqoX_vLMpQMRqp_V0N70TBJiYb66FeOEXYIBN88/edit?gid=0#gid=0](https://docs.google.com/spreadsheets/d/1iFoPQqoX_vLMpQMRqp_V0N70TBJiYb66FeOEXYIBN88/edit?gid=0#gid=0)

The CSV file is not included in this repository.

To test the application, download the file from the URL above, open `/leads/import`, select the downloaded CSV file, and start the import.

## Database structure

The imported records are stored in the `leads` table.

The `external_id` field is indexed but not unique, because the source data may contain duplicate external IDs and every CSV row must be imported.
