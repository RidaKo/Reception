# Reception

## Getting Started

Follow these steps to set up and run the project on your local machine.

### Prerequisites

PHP (version 8.2.5)
- Composer
- Docker
- MySQL (In docker)

### Installation

1. Clone the repository:

```
git clone https://github.com/RidaKo/Reception.git
```
    And then open the project in your code editor.

2. Configure the database and mailer:
    1. While using docker
       Use the command
```
docker-compose up -d
```

3. Install dependencies using Composer:

```
composer install
```
    - If you get an DATABASE_URL missing error due to the variable not being exposed from Docker, Just manually clear the cache with 
    `symfony console cache:clear` command.

4. Configure the mailer dsn in the .env file.
```
MAILER_DSN=sendgrid://enter_your_provided_api_key_insted_of_this_sentence@default
```
> This `enter_your_provided_api_key_insted_of_this_sentence` should be replaced by your provided api key.

4. Migrate migrations
 ```
 symfony console doctrine:migrations:migrate
 ```
6. Install and run yarn.
 ```
 yarn install
 yarn watch
 ```

7.  **Registration setup**
- While using Docker, this command connects to the database: 
```
docker-compose exec database mysql -u root --password=password
```
- For a specialist to register, a manual entry must be made in the database that contains a `secret key` with the command:
```
use main;
INSERT INTO specialist (email, roles, password, secret_key) VALUES ('','[]','','secret_key');
```
  > All the values must be the same. The only one that **has** to be replaced is the `secret_key` value that will be used during registration when creating an account. The value can be any string that you deem to be secure.

8. Run the Symfony development server:

```
symfony server:start
```

9. Access the application in your browser at the provided link in the console.

## Usage

The project has two main functionalities:
1) Registering for an appointment
2) Registering and using an admin/specialist account to manage the appointments designated to the specialist.

#### Registration explanation
Each time you want to register a specialist please repeat the seventh installation step to create a secret key that will be used in the form when creating a specialist for authorization purposes.



#### Pictures with explanations showing all the different web pages:
This is the home page, which directs to two different web pages: one where a customer may make a reservation and another where a specialist can login or choose to register.
![image](https://github.com/RidaKo/Reception/assets/113443126/b2cdf6d8-d215-448d-8cd5-ef4b97aa28cf)

---
This image shows the page where the customer is directed after clicking "reserve now". Here, he can book an appointment by typing in their email and pressing submit. After submission, you will receive an email to the address that was specified.
![image](https://github.com/RidaKo/Reception/assets/113443126/d221cdbc-7683-4fe8-bb8d-bfa61a2af2c6)

---
This image shows the page where you are directed after a reservation has been made. Here you can download a pdf of your reservation details or cancel your reservation.
![image](https://github.com/RidaKo/Reception/assets/113443126/e646d832-0a43-4967-8b30-72ec99203830)

---
This is where you are directed after canceling a reservation and can return to the home page.
![image](https://github.com/RidaKo/Reception/assets/113443126/8e4c9fda-33c1-4d84-8cc7-1c4ee0c01950)

---
This is the login page where you are directed after clicking the "Login as a specialist button" on the homepage. Here, you should submit your login details. If you do not have an account, you can choose to register or change your password if you have forgotten it.
![image](https://github.com/RidaKo/Reception/assets/113443126/b08ece9e-b60a-4393-81b5-b848d39f45ad)

---
This is the registration page where you can create a specialist account. Before registering, make sure you have been provided a secret key that helps identify if you have permission to create an account. Refer to the [Registration setup](#registration-explanation) section on how to create a secret key.
![image](https://github.com/RidaKo/Reception/assets/113443126/9f4f5227-1f99-4ff6-8951-8a8d12d5a77c)

---
This is where you are directed after clicking forgot password on the login page. Here, you need to enter your email and click submit. Then a web page will show up that confirms the sending of the email. After receiving the email, click the provided link, which will direct you to a page where you will be allowed to change your password.
![image](https://github.com/RidaKo/Reception/assets/113443126/abae7f25-636f-49c5-a4ed-8abfb9e3000b)

---
This is the specialist home page, where you are directed after logging in. Here, the specialist can manage his customer appointments by clicking the buttons on the table rows where their credentials reside. The numbered buttons can be used to switch pages where more customers are displayed. Home leads to the general home page, and logout logs the specialist out.
![image](https://github.com/RidaKo/Reception/assets/113443126/d98fb413-3a81-4e8f-9b24-b5f78a8d49a6)

---
This is the general homepage once again, but this time the available options have changed due to the fact that a specialist is logged in. You can choose to either open the display screen or return to the specialist home page.
![image](https://github.com/RidaKo/Reception/assets/113443126/99a08c5a-1a5c-40eb-8700-0b6a8fd247de)

---
This image shows the page where you are directed after clicking "display". Here, we can see the upcoming appointments and the current appointments.
![image](https://github.com/RidaKo/Reception/assets/113443126/ae3a372d-774d-4443-a202-088e391bbba6)


That is everything about the functionalities of the homepage.


## Contributing
There is no way to contribute

## License
The project currently does not have any license.

## Acknowledgments
Big thanks to Gediminas for his assistance over the whole project.

