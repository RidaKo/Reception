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
    cd Reception
    ```

2. Install dependencies using Composer:

    ```bash
    composer install
    ```

3. Configure the database and mailer:
    1. While using docker
       Use the command
       ```bash
       docker-compose up -d
       ```

    2. If docker is not avaliable:
       Configure the database connection parameters in the .env file.

- Configure the mailer dsn in the .env file.

4. Migrate migrations
   ```bash
   symfony console doctrine:migrations:migrate
   ```
6. Install and run yarn
   ```bash
   yarn install
   yarn watch
   ```

7. Run the Symfony development server:

    ```bash
    symfony server:start
    ```

8. Access the application in your browser at the the provided link in the console.

## Usage

The project has two main functionalities:
1) Registering for an appointment
2) Registering and using an admin/specialist account to manage the appointments designated to the specialist.

While using docker this command connects to the database: 
`docker-compose exec database mysql -u root --password=password`
If a specialist is logged in the home page will display different options than default.
- For a specialist to register, a manual entry must be made in the database that contains a secret key with the command:
  ```
  INSERT INTO specialist (email, roles, password, secret_key) VALUES ('','[]','','secret_key');```

#### Pictures showing all the different web pages.
![image](https://github.com/RidaKo/Reception/assets/113443126/b2cdf6d8-d215-448d-8cd5-ef4b97aa28cf)
![image](https://github.com/RidaKo/Reception/assets/113443126/d221cdbc-7683-4fe8-bb8d-bfa61a2af2c6)
![image](https://github.com/RidaKo/Reception/assets/113443126/e646d832-0a43-4967-8b30-72ec99203830)
![image](https://github.com/RidaKo/Reception/assets/113443126/8e4c9fda-33c1-4d84-8cc7-1c4ee0c01950)
![image](https://github.com/RidaKo/Reception/assets/113443126/b08ece9e-b60a-4393-81b5-b848d39f45ad)
![image](https://github.com/RidaKo/Reception/assets/113443126/9f4f5227-1f99-4ff6-8951-8a8d12d5a77c)
![image](https://github.com/RidaKo/Reception/assets/113443126/abae7f25-636f-49c5-a4ed-8abfb9e3000b)
![image](https://github.com/RidaKo/Reception/assets/113443126/70c6d89f-4bd7-4092-b940-703307354888)
![image](https://github.com/RidaKo/Reception/assets/113443126/99a08c5a-1a5c-40eb-8700-0b6a8fd247de)
![image](https://github.com/RidaKo/Reception/assets/113443126/ae3a372d-774d-4443-a202-088e391bbba6)




## Contributing
There is no way to contribute

## License
The project currently does not have any liscencing.

## Acknowledgments
Big thanks to Gediminas for his assistance over the whole project.

