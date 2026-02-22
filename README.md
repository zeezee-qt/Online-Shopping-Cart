# Arts Stationery - Online Shopping Web Application

A professional PHP + MySQL based website for Arts Stationery, designed around your complete requirements:
- Public product browsing and advanced search
- Customer registration and order placement
- Role-based portals (Admin, Employee, Customer)
- Delivery and payment flow support (credit card, cheque, VPP)
- Order number and product ID structures as requested
- Feedback collection

## Tech Stack
- HTML5
- CSS3
- JavaScript
- PHP 8+
- MySQL 8+

## Project Structure

- `index.php` - landing page
- `products.php` - product listing and search
- `feedback.php` - feedback form
- `auth/` - login, register, logout
- `admin/` - admin dashboard
- `employee/` - employee dashboard
- `customer/` - customer dashboard and place order
- `includes/` - config, DB connection, authentication, shared helpers
- `database/schema.sql` - full schema + demo seed data

## Database Connection Setup

1. Create MySQL database and tables:

```bash
mysql -u root -p < database/schema.sql
```

2. Configure credentials in `includes/config.php` or environment variables:

```bash
export DB_HOST=127.0.0.1
export DB_PORT=3306
export DB_NAME=arts_shop
export DB_USER=root
export DB_PASS=your_password
```

3. Start PHP local server:

```bash
php -S 0.0.0.0:8080
```

4. Open:

```
http://localhost:8080
```

## Demo Logins
(Password for both is `Password@123`)
- Admin: `admin@arts.local`
- Employee: `employee@arts.local`

## Notes on Business Rules Implemented
- Product ID uses 7 digits.
- Order number uses 16 digits (delivery type + product id + order sequence).
- Guests can browse products but only registered users can place orders.
- For cheque/credit card orders, payment status is set as pending clearance.
- VPP orders are due on delivery.
- Role-based access enforced at route level.

## Next Enhancements Recommended
- Full admin CRUD for products/employees/stock
- Payment data tables for card and cheque details
- Return/replacement request module with 7-day policy enforcement
- FAQ management and detailed reporting exports
- Email/SMS notifications for dispatch and delivery updates
