<p align="center">
    <a href="https://www.gnu.org/licenses/gpl-3.0.html"><img src="https://img.shields.io/github/license/Bahsiik/Instachat?style=flat-square" alt="GitHub"></a>
    <a href="https://github.com/Bahsiik/Instachat/commits/main"><img src="https://flat.badgen.net/github/commits/Bahsiik/Instachat/main?color=green&amp;icon=github" alt="commits"></a>
</p>
<p align="center">
    <img alt="Instachat-Icon" src="https://github.com/Bahsiik/Instachat/blob/main/static/images/logo-orange.png?raw=true" width="150"/><br>
</p>

# Instachat

* [Instachat](#instachat)
* [Setup](#setup)
    * [Requirements](#requirements)
    * [Installation](#installation)
* [Contributing](#contributing)
    * [Coding standards](#coding-standards)
    * [Documentation](#documentation)
* [Testing](#testing)
* [License](#license)
* [Authors](#authors)

Instachat is a social network made in PHP and MySQL. It is a simple social network that allows you to create an account, add friends, send messages, and more.

# Setup

## Requirements

PHP 8.1
MySQL 8.0
Composer 2.4.4

## Installation

Launch composer to install the dependencies:

```bash
composer install
```

Create a database named `instachat` and import the `dump.sql` file.

Run the following command to start the server:

```bash
php -S localhost:port -t public
```

# Contributing

We welcome contributions to Instachat! If you would like to contribute, please follow these steps:

1. Fork the repository.
2. Create a new branch for your changes.
3. Make your changes and test them thoroughly.
4. Submit a pull request to the main repository with a description of the changes you made and any relevant information.
   Before submitting your pull request, please make sure that your code follows our [coding standards](#coding-standards).

We use GitHub for our version control and pull request workflow. However, we are not using any GitHub Actions.

Thank you for considering contributing to Instachat!

## Coding standards

- 4 tab indentation
- 160 characters per line maximum
- Multiple classes per file.
- Following the rules of PSR-4 for naming conventions and other standards
- Use of PHPDoc for documentation
- Use of the `@var` tag for variables.
- Short array syntax.
- Short echo tags.
- Use of new features from our version of PHP like null coalescing operator, match expression, enum etc.

## Documentation

We document every function and class in our code. We use PHPDoc for this.
Every function and class should have a description of what it does, what parameters it takes, and what it returns (or nothing if it returns `void`).

# Testing

We do not have any tests for Instachat.<br>
Every tests are made manually, if you are contributing to Instachat, please make sure that your code works before submitting a pull request.

# License

[GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.html)

# Authors

- @Ayfri - Lead developer
- @antaww - Developer mainly on front-end
- @Bahsiik - Developer mainly on back-end
