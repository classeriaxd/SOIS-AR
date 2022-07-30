# Student Organization Information System: Accomplishment Report

When the university, PUP Taguig, started to operate during the Covid-19 pandemic, face-to-face transactions has been limited inside the university. The School Organizations had been affected by this implemented rule. With this situation, a group of BSIT students developed the Student Organization Information System – Accomplishment Module to help the PUP Taguig Student Organizations transpose their processes to an online platform. This system is an application that will maintain and manage the Accomplishment Reports submitted from each Student Organization.

## Features

- Upload Event Reports and Organization Documents of Organizations
- Generate Accomplishment Reports to PDF or XLSX
- Export and Download Accomplishment Reports
- Approval Processes for Student Accomplishment and Accomplishment Report
- Maintainable Categories in Event and Accomplishment Reports

## Libraries

SOIS-AR uses a number of open source libraries to work properly:
- [Laravel 8](https://laravel.com/docs/8.x) - as PHP Framework
- [Laravel-DomPDF](https://github.com/barryvdh/laravel-dompdf) - for generating Accomplishment Reports in PDF
- [Laravel-Excel](https://github.com/SpartnerNL/Laravel-Excel) - for generating Accomplishment Reports in XLSX
- [libmergepdf](https://github.com/hanneskod/libmergepdf) - for merging PDFs
- [madzipper](https://github.com/madnest/madzipper) - for compiling and zipping ARs 
- [searchable](https://github.com/nicolaslopezj/searchable) - for typeahead

## Installation

SOIS-AR requires [XAMPP with PHP 7.4](https://www.apachefriends.org/download.html) and [Composer](https://getcomposer.org/download/) to run.

After cloning the repository and installing its primary dependencies...

1. Run XAMPP Control Panel and Start Apache and MySQL 
2. Import the given Database to localhost/phpmyadmin
2. Modify/Replace the env file from the cloned repository with the given ENV.
3. Go to your Terminal and change to the directory of the cloned repository
4. Run these commands in the Terminal
    ```sh
    composer install
    php artisan key:generate
    php artisan storage:link
    ```
5. Run ``` php artisan serve``` to deploy  the system locally and access it with the given link.

## Developers

### D&G Tech (PUP-T BSIT 4-1 Batch 2022)
- Juan Carlos Amaguin
- Russel M. Claveria
- Bryan S. Laserna

## License

MIT