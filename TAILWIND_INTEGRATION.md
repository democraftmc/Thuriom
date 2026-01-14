# Tailwind CSS & DaisyUI Integration Guide

## Overview

This project has been configured to use Tailwind CSS v4 and DaisyUI alongside the existing Bootstrap framework. This allows for a gradual migration from Bootstrap to Tailwind/DaisyUI.

## What's Been Done

### 1. Dependencies Installed
- `tailwindcss@latest` - Tailwind CSS v4
- `daisyui@latest` - DaisyUI component library
- `@tailwindcss/postcss` - PostCSS plugin for Tailwind v4
- `autoprefixer` - CSS autoprefixer

### 2. Configuration Files Created

#### `tailwind.config.js`
Configured to scan all Blade templates, JS, and Vue files for Tailwind classes. DaisyUI is enabled with light and dark theme support.

#### `postcss.config.js`
Configured to process CSS with Tailwind and Autoprefixer.

#### `webpack.mix.js`
Updated to:
- Remove Bootstrap from vendor dependencies (keeping it available via CDN in existing templates)
- Compile Tailwind CSS for both admin and frontend
- Output to `public/assets/vendor/admin.css` and `public/css/app.css`

### 3. CSS Files Created

#### `resources/css/admin.css`
Tailwind CSS setup for admin panel with custom components for sidebar, navigation, etc.

#### `resources/css/app.css`
Tailwind CSS setup for frontend views.

## Using Tailwind & DaisyUI

### In New Components

When creating new components or pages, you can use Tailwind utility classes and DaisyUI components:

```blade
<!-- DaisyUI Button -->
<button class="btn btn-primary">Click me</button>

<!-- DaisyUI Card -->
<div class="card bg-base-100 shadow-xl">
  <div class="card-body">
    <h2 class="card-title">Card Title</h2>
    <p>Card content goes here</p>
  </div>
</div>

<!-- DaisyUI Alert -->
<div class="alert alert-info">
  <span>This is an info alert</span>
</div>

<!-- DaisyUI Form -->
<input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
```

### Migrating Existing Components

To migrate existing Bootstrap components to Tailwind/DaisyUI:

1. **Buttons**: Replace `btn btn-primary` (Bootstrap) with `btn btn-primary` (DaisyUI)
2. **Cards**: Replace Bootstrap card classes with DaisyUI `card` component
3. **Alerts**: Replace Bootstrap alerts with DaisyUI `alert` component  
4. **Forms**: Replace Bootstrap form classes with DaisyUI `input`, `select`, `textarea` classes
5. **Tables**: Use DaisyUI `table` component
6. **Modals**: Use DaisyUI `modal` component

### Theme Support

The project now uses DaisyUI's theme system. The theme is set on the `<html>` tag:

```blade
<html data-theme="light">  <!-- or data-theme="dark" -->
```

The admin layout has been updated to use this system.

## Build Commands

```bash
# Development build
npm run dev

# Production build
npm run production

# Watch for changes
npm run watch
```

## Next Steps for Full Migration

While the foundation is in place, converting all 111+ Blade templates would be a massive undertaking. Here's a recommended approach:

### Priority 1: Core Layouts (Partially Complete)
- ✓ Admin layout structure updated
- ✓ Theme system integrated
- ⚠️ Admin sidebar partially converted
- ⏳ Admin topbar/navbar needs conversion
- ⏳ Frontend base layout needs conversion
- ⏳ Frontend app layout needs conversion

### Priority 2: Common Components
- Session alerts
- Form elements
- Buttons
- Modals
- Pagination

### Priority 3: Admin Views
- Dashboard
- Settings pages
- User management
- Content management

### Priority 4: Frontend Views
- Home page
- Post/page displays
- Navigation elements
- Footer

## Coexistence Strategy

Both Bootstrap and Tailwind CSS can coexist in the project:
- Existing views continue to use Bootstrap (loaded via existing CDN links)
- New views use Tailwind/DaisyUI  
- Gradually migrate views as needed

## Reference Links

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [DaisyUI Components](https://daisyui.com/components/)
- [DaisyUI Themes](https://daisyui.com/docs/themes/)

## Notes

The problem statement mentioned a "litchi theme folder" with example setup, but this was not found in the repository. This integration was implemented using standard Tailwind CSS v4 and DaisyUI best practices.
