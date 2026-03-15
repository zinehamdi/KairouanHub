# API v1 Design Summary
## UX-Driven, Social, Wizard-Style Architecture

---

## 🎯 Design Philosophy

**Goal**: A mobile experience that feels like Facebook & Instagram, guided like a wizard, powered by a clean Laravel API.

### Core Principles
- ✅ **Social-first**: Feed-like scrolling, visual cards, minimal text
- ✅ **Wizard-guided**: One decision per screen, clear CTAs
- ✅ **Instant rewards**: Immediate feedback, celebration animations
- ✅ **Lightweight**: Flat JSON, no deep nesting, optimized pagination
- ✅ **Flutter-friendly**: Clean error codes, actionable messages

---

## 📱 UX Flow → API Mapping

### Home Screen
**Endpoint**: `GET /api/v1/wizard/start`
**Response**: Pre-aggregated bundle
- Categories with service counts
- Featured providers (top 6)
- User stats (points, trust, pending suggestions)

**Why**: Single request loads entire home screen instantly

---

### Step 1: Choose Category
**Endpoint**: `GET /api/v1/wizard/categories`
**Response**: Flat category cards
- Name, icon, service_count
- Gradient color suggestion

**Why**: Minimal data for big gradient cards

---

### Step 2: Choose Service
**Endpoint**: `GET /api/v1/wizard/services?category_id={id}&cursor={id}&limit=20`
**Response**: Infinite scroll pagination
- Cursor-based pagination
- `has_more` flag for smooth scrolling
- Lightweight service cards

**Why**: Instagram-like feed, no page numbers

---

### Step 3: Choose Provider
**Endpoint**: `GET /api/v1/wizard/providers?service_id={id}&cursor={id}&limit=20`
**Response**: Provider cards with trust badges
- Flat structure (no nesting)
- Trust badges (bronze/silver/gold)
- Recommendation levels
- Photos (first 3 for preview)

**Why**: Social feed style, trust indicators for community validation

---

### Step 4: Suggest Provider
**Endpoint**: `POST /api/v1/wizard/suggest`
**Response**: Immediate feedback
- Submission status
- Points potential (50 if approved)
- Trust level & next milestone
- Celebration message

**Why**: Instant gratification, shows value immediately

---

### Rewards & Progress
**Endpoints**:
- `GET /api/v1/rewards/{submissionId}` - Celebration feedback
- `GET /api/v1/me/progress` - User progress dashboard

**Response**: Points, trust, milestones, progress percentage

**Why**: Motivation without pressure, clear progression

---

## 🏗️ Architecture Decisions

### 1. Cursor-Based Pagination
**Why**: Perfect for infinite scroll
- No page numbers to manage
- Smooth scrolling experience
- Efficient for large datasets

**Format**:
```json
{
  "data": [...],
  "pagination": {
    "next_cursor": 123,
    "has_more": true,
    "limit": 20
  }
}
```

### 2. Flat Resource Structure
**Why**: Mobile-friendly, fast parsing
- No deep nesting
- Only essential fields
- Pre-computed values (badges, levels)

**Example**: Provider card includes `category_name` instead of nested `category` object

### 3. Pre-Aggregated Home Data
**Why**: Single request, instant loading
- Categories with counts
- Featured providers
- User stats bundled together

**Trade-off**: Slightly larger initial payload, but eliminates multiple requests

### 4. Trust & Recommendation System
**Levels**:
- **Bronze** (new): 0-2 recommendations
- **Silver** (trusted): 3-10 recommendations  
- **Gold** (highly trusted): 11+ recommendations
- **Featured**: Admin-selected + high trust

**Why**: Community validation, "people recommend people"

---

## ⚡ Performance Optimizations

### 1. Selective Loading
- Only load relationships when needed
- Use `withCount()` for counts instead of loading full relationships
- Limit photo arrays to first 3 for card previews

### 2. Cursor Pagination
- More efficient than offset pagination
- No performance degradation on large datasets
- Perfect for infinite scroll

### 3. Pre-computed Values
- Trust badges calculated once
- Recommendation levels cached
- No real-time calculations in loops

### 4. Response Size
- Truncate long text (bio to 100 chars in cards)
- Only include essential fields
- No unnecessary metadata

---

## 🛡️ Error Handling

### Flutter-Friendly Format
```json
{
  "status": "error",
  "message": "User-friendly message",
  "code": "VALIDATION_ERROR",
  "errors": {
    "field": ["Error message"]
  }
}
```

### Error Codes
- `BAD_REQUEST` (400)
- `UNAUTHORIZED` (401)
- `FORBIDDEN` (403)
- `NOT_FOUND` (404)
- `VALIDATION_ERROR` (422)
- `RATE_LIMIT` (429)
- `SERVER_ERROR` (500)

**Why**: Easy error handling in Flutter, actionable messages

---

## ⚠️ Risks & Mitigations

### Risk 1: Over-fetching in Home Bundle
**Mitigation**: Only include essential data, use counts instead of full objects

### Risk 2: Cursor Pagination Complexity
**Mitigation**: Simple ID-based cursor, clear documentation

### Risk 3: Trust Badge Calculation
**Mitigation**: Cache badge_level in database, calculate only when needed

### Risk 4: Photo URLs Performance
**Mitigation**: Limit to 3 photos for cards, full gallery on detail view

---

## 🎨 Cultural Identity

### Kairouan Spirit
- Community trust system
- "People recommend people"
- Familiar language (Arabic support)
- Local context (city-based filtering)

### Modern Social Look
- Metallic gradients (gold/bronze/emerald/midnight)
- Rounded pills & soft cards
- Subtle shadows
- Visual-first design

---

## 📊 Data Bundling Strategy

### Home Screen
- Categories (6-10 items)
- Featured providers (6 items)
- User stats (3-4 fields)
**Total**: ~15-20KB JSON

### Wizard Steps
- Categories: ~2KB per item
- Services: ~1KB per item (20 per page = ~20KB)
- Providers: ~2KB per item (20 per page = ~40KB)

**Target**: Keep responses under 50KB for fast mobile loading

---

## 🚀 Next Steps

1. **Testing**: Load test cursor pagination with large datasets
2. **Caching**: Consider Redis for frequently accessed data (categories, featured providers)
3. **Analytics**: Track which endpoints are most used
4. **Optimization**: Monitor response times, optimize slow queries

---

## 📝 API Endpoints Summary

### Public Endpoints
- `GET /api/v1/wizard/start` - Home screen bundle
- `GET /api/v1/wizard/categories` - Category cards
- `GET /api/v1/wizard/services` - Service feed
- `GET /api/v1/wizard/providers` - Provider feed

### Authenticated Endpoints
- `POST /api/v1/wizard/suggest` - Suggest provider
- `GET /api/v1/rewards/{id}` - Reward feedback
- `GET /api/v1/me/progress` - User progress

---

## ✅ Success Criteria

- [x] Flat, lightweight JSON responses
- [x] Cursor-based infinite scroll pagination
- [x] Pre-aggregated home data
- [x] Trust badges & recommendation levels
- [x] Immediate reward feedback
- [x] Flutter-friendly error format
- [x] Social, feed-like structure
- [x] Wizard-guided flow

---

**Result**: An API that feels social, easy, fun, and elegant. Not technical, native-heavy, or complicated.

