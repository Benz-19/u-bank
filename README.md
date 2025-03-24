# U-Bank

U-Bank is a web-based banking application designed to provide users with a seamless and secure online banking experience. The application offers features such as user authentication, account management, fund transfers, and transaction history tracking.

## Features

- **User Authentication:** Secure login and registration system for users.
- **Account Management:** View and manage account details and balances.
- **Fund Transfers:** Transfer funds between accounts with ease.
- **Transaction History:** Track and view past transactions.

## Technologies Used

- **Backend:** Laravel PHP Framework
- **Frontend:** Blade templating engine, Tailwind CSS
- **Database:** MySQL
- **Version Control:** Git

## Installation

To set up the U-Bank application on your local machine, follow these steps:

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/Benz-19/u-bank.git
   ```

2. **Navigate to the Project Directory:**

   ```bash
   cd u-bank
   ```

3. **Install Dependencies:**

   ```bash
   composer install
   npm install
   ```

4. **Set Up Environment File:**

   Copy the `.env.example` file to `.env` and update the necessary environment variables, such as database connection details.

5. **Generate Application Key:**

   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations:**

   ```bash
   php artisan migrate
   ```

7. **Serve the Application:**

   ```bash
   php artisan serve
   ```

   The application will be accessible at `http://127.0.0.1:8000`.

## Usage

- **Register a New Account:** Navigate to the registration page and create a new user account.
- **Log In:** Use your credentials to log in to the application.
- **Dashboard:** After logging in, you will be redirected to the dashboard, where you can view account details and perform transactions.
- **Transfer Funds:** Use the transfer feature to send funds to other accounts.
- **View Transactions:** Access your transaction history to review past activities.

## Contributing

Contributions are welcome! If you'd like to contribute to U-Bank, please fork the repository and create a pull request with your changes.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.

---

*Note: This README is a general template based on typical Laravel projects and the information provided. For more specific details about the U-Bank project, please refer to the project's documentation or contact the repository owner.*
