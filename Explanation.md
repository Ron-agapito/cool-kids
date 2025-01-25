# Cool Kids Plugin
https://www.loom.com/share/07ec2499ee0b49349918cff295ca8c55



## Problem to be Solved
The goal of this project is to create a WordPress plugin called "Cool Kids" that adds custom user fields, handles user login and signup via the REST API, and provides a shortcode to display user information. The plugin should allow administrators to manage user data and display it on the front end.

## Technical Specification
### Design Overview
1. **Custom User Fields**: The plugin adds a custom field for the user's country in the admin area.
2. **Shortcode**: A shortcode `[cool_kids]` is provided to display user information on the front end.
3. **REST API Endpoints**: The plugin includes endpoints for user login and signup.
4. **Data Sanitization**: All user input is sanitized to ensure security.

## Technical Decisions
1. **Use of WordPress Functions**: Leveraging built-in WordPress functions for user management and data sanitization ensures compatibility and security.
2. **Shortcode for Display**: Using a shortcode allows for flexible placement of user information on the front end.
3. **REST API for User Management**: Implementing REST API endpoints provides a modern and scalable way to handle user login and signup.

## Achieving the Admin’s Desired Outcome
The solution allows administrators to:
- Add and manage custom user fields in the admin area.
- Display user information on the front end using a shortcode.
- Handle user login and signup via the REST API, making it easier to integrate with other systems.
- Update user role using REST API endpoint.

## Shortcode Attributes

The `[cool_kids]` shortcode now supports two attributes: `title` and `description`. These attributes allow you to customize the title and description displayed by the shortcode.

### Usage

To use the shortcode with the `title` and `description` attributes, you can include them as follows:

```php
[cool_kids title="Your Title" description="Your Description"]
