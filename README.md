# Business Listing Application

A web-based application for managing business listings with customer ratings and reviews.

## Features

- **Business Management**: Add, edit, and delete business listings
- **Customer Ratings**: Interactive star rating system for businesses
- **Average Ratings**: Automatic calculation and display of average ratings
- **Responsive Design**: Bootstrap-based UI that works on all devices
- **AJAX Operations**: Seamless add/edit/delete without page refreshes

## Technologies Used

- **Backend**: PHP 8.0+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Libraries**:
  - Bootstrap 5
  - jQuery
  - jQuery Raty (star rating plugin)

## Installation & Setup

### 1. Clone the Repository

```bash
git clone <repository-url>
cd business-listing
```

### 2. Database Setup
Use the schema.sql file to create the db.

### 3. Configuration

Update the database configuration in `config/db.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'business_listing');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_CHARSET', 'utf8mb4');
```

**Important**: The `config/db.php` file contains sensitive database credentials and is included in `.gitignore`. Make sure to create this file locally with your actual database credentials.

### 4. Web Server Setup

Configure your web server to point to the project root directory and ensure PHP is enabled.

## Usage

### Accessing the Application
Open your browser and navigate to the application URL (e.g., `http://localhost/business-listing`).


### Rating Businesses
- Click the star icon on any business row
- Fill in your details and select a rating (0.5 to 5 stars)
- Submit your rating

### Features Overview
- Businesses are displayed in a table with sequential numbering
- Average ratings are calculated and displayed with star visualizations
- All operations use AJAX for smooth user experience
- Form validation ensures data integrity

## Project Structure

```
business-listing/
├── index.php              # Main entry point
├── ajax/                  # AJAX handlers
│   ├── business_ajax.php
│   └── rating_ajax.php
├── assets/                # Static assets
│   ├── css/
│   ├── js/
│   └── plugins/
├── config/                # Configuration files
│   └── db.php            # Database configuration (gitignored)
├── controllers/           # Business logic
│   ├── BusinessController.php
│   └── RatingController.php
├── models/                # Data models
│   ├── Business.php
│   └── Rating.php
└── views/                 # UI templates
    ├── business_table.php
    └── modals/
```

## API Endpoints

### Business Management
- `POST /ajax/business_ajax.php?action=add` - Add new business
- `POST /ajax/business_ajax.php?action=update` - Update business
- `POST /ajax/business_ajax.php?action=delete` - Delete business

### Rating System
- `POST /ajax/rating_ajax.php?action=submit` - Submit rating

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source. Please check the license file for details.

## Support

For issues or questions, please create an issue in the repository or contact the development team.