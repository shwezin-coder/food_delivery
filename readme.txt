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
- Logout 
- Manage Users by admin
    Create 
        Validation
            - Email is unique
            - Confirm password and password must be same
            - all fields must be filled

