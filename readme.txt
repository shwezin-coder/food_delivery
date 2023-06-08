User Role
    Admin => 1
    Staff => 2
    Customer => 3

Deleted_at => 0 (not delete), 1 => (deleted)

User Management
- Sign Up
    Validation 
        - Email is unique
        - Confirm password and password must be same
        - all fields must be filled 
- Sign In
    Validation
        - all fields must be filled
        - Email exists or not
        - Password is correct 
- Change Password
    Validation
        - current password is correct
        - new password and confirm password must be same
- User Profile
    Validation
        - allow to update information like name, phone number and address except Email
- Logout 
        - can log out and destroy session 
- Manage Users by admin
    Create 
        Validation
            - Email is unique
            - Confirm password and password must be same
            - all fields must be filled
Order Management 
  - Manage Category
    Create 
     Validation 
        - category is unique
        - all fields must be filled.
  - Manage menus
        Validation 
        - menu is unique 
        - menu image must be unique
        - file size must be less than 5 mb
        - file type must be one of png, jpg, jpeg
   - menu lists
        - quantity must be required.
        - authenticated users must be added to cart 
   - cart 
        - users can update quantity 
        - users can be added to cart if total ordered items must be lower or equal than noofitems in menu table. 
Delivery Management
    - Manage location
        - location is unique
        - all field is required
    - Manage Delivery
        - delivery added by admin
        - delivery will be chosen by system depending on status of delivery
        - order is not available if delivery is not free
    
Payment
    - Manage Payment type
        - Payment type is unique
        - all field is required
    - Manage Payment
        - User can pay food order by all payment types
         

    


        



