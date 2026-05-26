# =============================================================================
# ARCHITECTURE SUMMARY - Algerian E-Commerce Store (Kirby CMS)
# =============================================================================

## 1. SYSTEM OVERVIEW

This is a production-ready, enterprise-grade e-commerce platform built on Kirby CMS 4+ 
specifically designed for the Algerian market with COD (Cash on Delivery) as primary 
payment method, comprehensive shipping system for 58 Wilayas, and full marketing 
integration stack.

## 2. CORE ARCHITECTURAL DECISIONS

### 2.1 Why Kirby CMS?
- File-based content storage (no MySQL dependency for content)
- Excellent multilingual support out-of-the-box
- Flexible blueprint system for custom content structures
- Lightweight and fast for content-heavy stores
- Great admin panel customization capabilities

### 2.2 Why SQLite for Orders/Analytics?
- Orders are transactional data requiring ACID compliance
- Separate from content storage for better performance
- Easy backup and migration
- No external database server required
- Perfect for small to medium scale operations

### 2.3 Plugin Architecture Rationale
- **store-core**: Business logic, models, services (orders, products, shipping)
- **store-panel**: Custom admin panel areas, widgets, API endpoints
- **store-i18n**: Centralized translation management for AR/FR/EN
- **store-theme**: Design tokens, theme management, CSS/JS assets
- **store-ai**: AI-powered features (descriptions, fraud detection, recommendations)

### 2.4 Design System Approach
- Design tokens stored in YAML blueprints for admin editing
- CSS custom properties for runtime theming
- Tailwind-inspired utility classes with custom design tokens
- Dark/Light mode via CSS variables and JS toggle
- RTL/LTR switching based on active language

## 3. MODULE BREAKDOWN

### Module 1: Core Store (store-core)
- Product management with variants
- Category hierarchy
- Order lifecycle management
- Shipping calculator (58 Wilayas + Communes)
- Pricing engine (discounts, taxes, shipping)
- UTM tracking & attribution
- Webhook dispatcher
- Integration adapters (Google, Facebook, TikTok, etc.)

### Module 2: Admin Panel (store-panel)
- Dashboard with real-time stats
- Order management with status workflow
- Product catalog manager
- Shipping zone configuration
- Integration settings
- Funnel builder interface
- Analytics viewer

### Module 3: Internationalization (store-i18n)
- AR/FR/EN translations
- RTL/LTR automatic switching
- Currency formatting per locale
- Date/time localization
- Number formatting

### Module 4: Theme System (store-theme)
- Design token management
- Color scheme editor
- Typography controls
- Layout configuration
- Custom CSS/JS injection
- Light/Dark mode toggle

### Module 5: AI Features (store-ai)
- Product description generation
- Fake order detection
- Smart recommendations
- Campaign performance analysis
- Customer segmentation hints

## 4. DATA FLOW

Content Editors → Kirby Panel → YAML Files → Templates → Frontend
Customers → Frontend → Controllers → Models → SQLite DB → APIs → Integrations

## 5. SECURITY LAYERS

1. Kirby's built-in CSRF protection
2. Input validation on all forms
3. Prepared statements for SQLite queries
4. Rate limiting on API endpoints
5. Webhook signature verification
6. Sanitized output in templates
7. Environment-based configuration

## 6. PERFORMANCE STRATEGIES

1. Kirby's caching layer for content
2. Lazy loading for images
3. Alpine.js for minimal JS footprint
4. Critical CSS inlining
5. Database indexes on orders/analytics
6. CDN-ready asset structure
7. Query optimization in models

## 7. SCALABILITY PATH

Phase 1: Single server with SQLite (current)
Phase 2: MySQL migration for orders if needed
Phase 3: Redis caching layer
Phase 4: Horizontal scaling with load balancer
Phase 5: Microservices for integrations
