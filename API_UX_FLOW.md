# API UX Flow Mapping
## Screen → Action → API Endpoint

### 🏠 Home Screen
**Visual**: Social feed with gradient category cards
**Action**: User scrolls, sees categories
**API**: `GET /api/v1/wizard/start`
**Response**: Pre-aggregated categories with counts, featured providers

---

### 📂 Step 1: Choose Category
**Visual**: Big gradient cards (metallic: gold/bronze/emerald/midnight)
**Action**: Tap a category card
**API**: `GET /api/v1/wizard/categories`
**Response**: Flat list of categories with service counts, icons

---

### 🔧 Step 2: Choose Service
**Visual**: Scrollable social feed (Instagram-like)
**Action**: Scroll through services, tap to select
**API**: `GET /api/v1/wizard/services?category_id={id}&page={cursor}`
**Response**: Infinite scroll pagination, lightweight service cards

---

### 👤 Step 3: Choose Provider
**Visual**: Provider cards with recommendation badges
**Action**: Scroll providers, see trust badges, tap to view
**API**: `GET /api/v1/wizard/providers?service_id={id}&page={cursor}`
**Response**: Flat provider list with trust badges, ratings, photos

---

### ➕ Step 4: Suggest Provider (If Not Found)
**Visual**: Simple 1-2 tap form
**Action**: Quick suggestion form
**API**: `POST /api/v1/wizard/suggest`
**Response**: Immediate feedback with points earned

---

### 🎁 Reward Feedback
**Visual**: Celebration animation
**Action**: Show points earned
**API**: `GET /api/v1/me/rewards?submission_id={id}`
**Response**: Points earned, trust level, next milestone

---

## Data Bundling Strategy

### Home Screen Bundle
- Categories (with counts)
- Featured providers (top 6)
- User's points & trust level
- Recent suggestions status

### Wizard Step Bundles
- **Categories**: Just name, icon, service_count
- **Services**: Name, icon, provider_count, category_name
- **Providers**: Name, avatar, badge, rating, city, phone (flat, no nesting)

## Pagination Strategy
- **Type**: Cursor-based for infinite scroll
- **Format**: `?cursor={last_id}&limit=20`
- **Response**: `{ data: [...], next_cursor: 123, has_more: true }`

## Trust & Recommendation Levels
- **Bronze**: New provider (0-2 recommendations)
- **Silver**: Trusted (3-10 recommendations)
- **Gold**: Highly trusted (11+ recommendations)
- **Featured**: Admin-selected + high trust

