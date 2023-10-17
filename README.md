# Reception

## Getting Started

Follow these steps to set up and run the project on your local machine.

### Prerequisites

- PHP (version 7.4 or higher)
- Composer
- MySQL

### Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/RidaKo/Reception.git
    cd hospital
    ```

2. Install dependencies using Composer:

    ```bash
    composer install
    ```

3. Configure the database and mailer:

    - Configure the database connection parameters in the .env file.
    - Configure the mailer dsn in the .env file.

4. Create the database and schema:

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
    ```

5. Run the Symfony development server:

    ```bash
    symfony server:start
    ```

6. Access the application in your browser at the the provided link in the console.

## Usage

The project has two main functionalities:
1) Registering for an appointment
2) Registering and using an admin/specialist account to manage the appointments designated to the specialist.
If a specialist is logged in the home page will display different options than default.
- For a specialist to register, a manual entry must be made in the database that contains a secret key with the command: `INSERT INTO specialist (email, roles, password, secret_key) VALUES ('','[]','','secret_key');`

## Contributing
There is no way to contribute

## License
The project currently does not have any liscencing.

## Acknowledgments
Big thanks to Gediminas for his assistance over the whole project.

