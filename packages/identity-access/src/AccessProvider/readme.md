# Access provider

Provides data for Role-Based Access Control.

- create, update and query roles and permissions
- update and query role permissions
- assign roles to user
- query user roles and permissions

## Roles and Permissions

- Role is a group permission
- Permission is access rights to service operation Example: post:create, post:update or
  post:delete

### Root role

- This is a special role called "root"
- 'root' role is has access to all permissions
- 'root' role has empty permission and resources because it is not needed

## Permission formatting

- format: [service]:[operation]
- max length: 255

### Examples:

Super Admin

- `root` - super admin access

Module permissions `[medule id]:[query or command]`

- `user_account:RegisterUserAccount` - Command for user registration
- `user_account:DeleteUserAccount` - Command for user registration
- `user_account:*` - access to all queries and commands
