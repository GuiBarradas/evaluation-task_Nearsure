# Evaluation Task - Nearsure

Implement a simple page with an input form to collect credit card information and send it to a Backend API for validation.

## Technologies Used
* PHP
* JavaScript
* HTML & CSS
* jQuery
* Stripe API
* Composer
* XAMPP
---
### How to run the application

1. Download the project and (if you don't have it) install [PHP](https://www.php.net/downloads.php) and [XAMPP](https://www.apachefriends.org/pt_br/download.html) to use Apache and test the application.
2. Download [Composer](https://getcomposer.org/download/) to manage the installation of the Stripe library.
3. After installing the components, open the terminal (Make sure you are in the project folder) and run `composer install`.
4. Once Composer is installed, run the following code in your terminal: `composer require stripe/stripe-php`. This will complete the Stripe API files if any are corrupted or missing.
5. After that, start the XAMPP CPANEL and start Apache.
6. Drag the project folder to the **htdocs** folder of XAMPP. Path: **C:\xampp\htdocs**
7. Access the application through localhost.
---

PS: On `secrets.php` you'll need to put the secret key of Stripe API. Here on [Stripe API Quickstart](https://stripe.com/docs/checkout/quickstart) guide you have some explanations and samples to test.
