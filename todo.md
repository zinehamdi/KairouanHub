

# Role-Based Platform Implementation Plan (Detailed)

## 1. Superadmin Role
- Create `superadmin` role in roles seeder and assign to main owner.
- Restrict `/superadmin` routes and dashboard to only superadmin users.
- Dashboard:
    - Show advanced stats: total admins, users, providers, services, categories, requests, recent activity.
    - Admin management UI: list, add, remove, and (optionally) edit admins.
    - Platform settings UI: update site name, contact info, maintenance mode, etc.
    - Google Maps provider import tool (see below).
- Permissions: Only superadmin can manage admins and platform-wide settings.
- UI: Add navigation for superadmin dashboard and features.
Here’s a detailed, professional plan for your superadmin dashboard and Google Maps provider import feature:

---

## 1. Superadmin Dashboard Features

### a. Advanced Stats
- Show total counts for: Admins, Users, Providers, Services, Categories, Requests.
- Display recent activity (optional): latest users, providers, requests.

### b. Admin Management
- List all admin users (name, email).
- Add admin: Form to create a new admin (name, email, password, assign role).
- Remove admin: Button to remove admin role from a user.
- (Optional) Edit admin: Update admin details.

### c. Platform Settings
- Section for global settings (site name, contact info, maintenance mode, etc.).
- Form to update settings (store in a settings table or .env).

---

## 2. Google Maps Provider Import

### a. Requirements
- Google Places API key (get from Google Cloud Console).
- Enable Places API for your project.
- Set up billing if required by Google.

### b. UI/Workflow
- Search bar for Kairouan providers (e.g., “doctor”, “plumber”, “restaurant”).
- Show results from Google Maps (name, address, phone, category, rating, etc.).
- Select one or more providers to import.
- Map Google data fields to your ProviderProfile fields (name → display_name, phone → phone, etc.).
- Button to import selected providers into your database.

### c. Backend
- Create a controller to handle Google Places API requests (search, details).
- Parse and validate data before saving.
- Prevent duplicates (check by phone or name/address).

### d. Security/Quotas
- Store API key securely (in .env).
- Handle API quota limits and errors gracefully.

---

## 3. Implementation Steps

1. **Expand superadmin dashboard Blade view** with all stats, admin management table, settings section, and Google Maps import UI.
2. **Add methods to DashboardController** for:
   - Fetching all stats.
   - Listing, adding, and removing admins.
   - Saving platform settings.
   - Handling Google Maps search and import.
3. **Create routes** for all superadmin actions (in /superadmin group).
4. **Set up Google Places API integration** (controller, service class, .env config).
5. **Test the full workflow**: stats, admin management, settings, and provider import.

---

## 4. Example .env Additions

```
GOOGLE_PLACES_API_KEY=your_google_api_key_here
```

---

## 5. References

- [Google Places API Docs](https://developers.google.com/maps/documentation/places/web-service/overview)
- [Laravel Settings Packages (optional)](https://github.com/anlutro/laravel-settings)

---


## 2. Admin Role
- Create `admin` role for managers.
- Restrict `/admin` routes and dashboard to admin users.
- Dashboard:
    - Manage providers: approve, reject, delete, edit provider profiles.
    - Manage services and categories.
    - View and manage provider suggestions and notifications.
- Permissions: Admins cannot manage other admins or platform settings.
- UI: Add navigation for admin dashboard and features.

## 3. Provider Role
- Create `provider` role for users offering services.
- Upgrade Flow:
    - Allow any user to upgrade to provider instantly (no admin approval required).
    - Provider onboarding: collect specialization (driver, doctor, plumber, etc.), phone, city, etc.
- Profile:
    - Providers can edit their profile and add services.
    - Providers can be suggested by users/providers.
- Admin Review:
    - Admins can review, approve, or delete providers from dashboard.
- Ranking:
    - If a suggested provider’s phone already exists, increase their rank/score.

## 4. User Role
- Default Role: Assign `user` role to all new signups.
- Features:
    - Browse providers and services.
    - Request services.
    - Suggest new providers (with form: name, phone, category, etc.).
    - Earn points for approved provider suggestions.

## 5. Suggestion & Notification System
- Suggestion Flow:
    - Any user/provider can suggest a provider via a form.
    - Store suggestions in a dedicated table (with status: pending, approved, rejected).
- Admin Dashboard:
    - Show notification badge for new suggestions.
    - List and review all suggestions.
    - Approve or delete suggestions.
- Rewards:
    - When a suggestion is approved, reward the suggester with points.
    - If provider’s phone already exists, increase provider’s rank.

## 6. Google Maps Import (Superadmin)
- API Setup:
    - Get Google Places API key and enable Places API in Google Cloud Console.
    - Store API key in .env.
- UI/Workflow:
    - Add search bar for Kairouan providers (e.g., “doctor”, “plumber”).
    - Show results from Google Maps (name, address, phone, category, rating, etc.).
    - Allow superadmin to select and import providers.
    - Map Google data fields to ProviderProfile fields.
    - Prevent duplicates by phone/name.
- Backend:
    - Controller/service to handle Google Places API requests and data mapping.
    - Validate and save imported providers.
- Security:
    - Handle API quota limits and errors.
    - Secure API key.

## 7. Platform Settings (Superadmin)
- Settings UI:
    - Add section in superadmin dashboard for global settings (site name, contact, maintenance, etc.).
    - Form to update settings.
- Storage:
    - Store settings in a settings table or .env.

## 8. Documentation
- Document:
    - All roles, permissions, and workflows.
    - User/admin/superadmin guides for platform management.

