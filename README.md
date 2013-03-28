# Simple Auto Service

Years ago, I often found myself at a mechanic or auto-parts store needing to know the last time I performed a certain service on my vehicles. So I whipped up this tiny web-app to help me track and display this information.

I recently got bored while hanging out in airports and airplanes, so I decided to clean a bit of this old app up publish the code.

It's not that full featured, there's no validation/authentication, and the code's not the prettiest, but I've been using it for years.

Here it is.

## Requirements

* PHP 5.3+ (Uses Late Static Binding for the models)
* MySQL

## Setup

* Create a MySQL DB
* Set it up by importing `setup.sql`
* Rename `config.example.php` to `config.php` and configure the values accordingly

## Notes on some missing features

* **There's no authentication on this application.** If hosting it publicly, place it behind basic-auth or something similar.
* Since I've been the sole user of this application (and never, ever make mistakes), **there is no validation.** Mistakes will attempt to be stored to the DB, but you can always edit them later.
* There's currently not a way to delete anything aside from manually doing so in the DB.
