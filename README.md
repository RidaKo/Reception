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

#### Tips
- While using docker this command connects to the database: 
```bash
docker-compose exec database mysql -u root --password=password
```
- If a specialist is logged, the home page will display different options than default.
- For a specialist to register, a manual entry must be made in the database that contains a secret key with the command:
  ```bash
  INSERT INTO specialist (email, roles, password, secret_key) VALUES ('','[]','','secret_key');
  ```

#### Pictures with explanations showing all the different web pages:
This is the home page which directs to two different web pages: one where a customer may make a reservation and another one where a specialist can login or choose to register.
![image](https://github.com/RidaKo/Reception/assets/113443126/b2cdf6d8-d215-448d-8cd5-ef4b97aa28cf)

---
This image shows the page where the customer is directed after clicking "reserve now". Here he can book an appointment by typing in their email and pressing submit. After submiton you will recieve an email to the adress that was specified.
![image](https://github.com/RidaKo/Reception/assets/113443126/d221cdbc-7683-4fe8-bb8d-bfa61a2af2c6)

---
This image shows the page where you are directed after a reservation has been made. Here you can download a pdf format of your reservation details or cancel your reservation.
![image](https://github.com/RidaKo/Reception/assets/113443126/e646d832-0a43-4967-8b30-72ec99203830)

---
This is where you are directed after cancelling a reservation and can retrun to home page.
![image](https://github.com/RidaKo/Reception/assets/113443126/8e4c9fda-33c1-4d84-8cc7-1c4ee0c01950)

---
This is the login page where you are directed after clicking "Login as specialist button" in the homepage. Her you should submit your login details. If you do not have an accout you can choose to register or change your password if you have forgotten it.
![image](https://github.com/RidaKo/Reception/assets/113443126/b08ece9e-b60a-4393-81b5-b848d39f45ad)

---
This is the registration page where you can create a specialist accout. Befor registering make sure you have been provided a secret key that helps identify if you have permission to create an account. Refer to the tips section on how to create a secret key.
![image](https://github.com/RidaKo/Reception/assets/113443126/9f4f5227-1f99-4ff6-8951-8a8d12d5a77c)

---
This is where you are directed after clicking forgot password in the login page. Here you need to enter your email and click submit. After recieveing the email click the provided link which will direct you to a page where you will be allowed to chage your password.
![image](https://github.com/RidaKo/Reception/assets/113443126/abae7f25-636f-49c5-a4ed-8abfb9e3000b)

---
This is the specialist home page where you are directed after loging in. Here the specialist can manage his customer appointments by clicking the buttons on the table rows where there credentials reside. The numbered buttons can be used to switch pages. Home lead to the general home page and logout logs the specialist out.
![image](https://github.com/RidaKo/Reception/assets/113443126/70c6d89f-4bd7-4092-b940-703307354888)

---
This is the general hompage once again, but this time the avaliable options have changed due to the fact that a specialist is logged in. You can choose to either open the display screen or return to the specialist home page.
![image](https://github.com/RidaKo/Reception/assets/113443126/99a08c5a-1a5c-40eb-8700-0b6a8fd247de)

---
This image show the page where you are directed afeer clicking "display". Here we can see the upcoming apointment and the current appointments.
![image](https://github.com/RidaKo/Reception/assets/113443126/ae3a372d-774d-4443-a202-088e391bbba6)




## Contributing
There is no way to contribute

## License
The project currently does not have any liscencing.

## Acknowledgments
Big thanks to Gediminas for his assistance over the whole project.

