# API v1 Quick Reference
## For Flutter Development

---

## 🚀 Wizard Flow Endpoints

### Home Screen
```http
GET /api/v1/wizard/start
```
**Response**: Pre-aggregated bundle (categories, featured providers, user stats)

---

### Step 1: Categories
```http
GET /api/v1/wizard/categories
```
**Response**: Array of category cards (name, icon, service_count, color)

---

### Step 2: Services Feed
```http
GET /api/v1/wizard/services?category_id={id}&cursor={id}&limit=20
```
**Response**: 
```json
{
  "status": "success",
  "data": {
    "data": [...services],
    "pagination": {
      "next_cursor": 123,
      "has_more": true,
      "limit": 20
    }
  }
}
```

**Usage**: Use `next_cursor` for next page, check `has_more` for loading indicator

---

### Step 3: Providers Feed
```http
GET /api/v1/wizard/providers?service_id={id}&cursor={id}&limit=20
```
**Response**: Provider cards with trust badges, ratings, photos

**Fields**:
- `badge`: "bronze" | "silver" | "gold"
- `recommendation_level`: "new" | "trusted" | "highly_recommended"
- `is_featured`: boolean

---

### Step 4: Suggest Provider
```http
POST /api/v1/wizard/suggest
Authorization: Bearer {token}
Content-Type: application/json

{
  "provider_name": "Dr. Ahmed",
  "phone": "+21612345678",
  "category_id": 1,
  "city": "Kairouan",
  "description": "Great doctor"
}
```

**Response**: Immediate feedback with points potential, trust level, next milestone

---

## 🎁 Rewards & Progress

### Get Reward Feedback
```http
GET /api/v1/rewards/{submissionId}
Authorization: Bearer {token}
```

**Response**: Points earned, trust progression, celebration data

---

### Get User Progress
```http
GET /api/v1/me/progress
Authorization: Bearer {token}
```

**Response**: Points balance, trust level, progress percentage, next milestone

---

## ⚠️ Error Handling

### Error Response Format
```json
{
  "status": "error",
  "message": "User-friendly error message",
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

---

## 📊 Response Structure

### Success Response
```json
{
  "status": "success",
  "message": "Optional message",
  "data": { ... }
}
```

### Pagination (Cursor-Based)
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

**Implementation**:
```dart
if (response.pagination.hasMore) {
  loadMore(response.pagination.nextCursor);
}
```

---

## 🎨 Trust & Badges

### Trust Levels
- `new` (0-99 points)
- `contributor` (100-299 points)
- `trusted` (300-799 points)
- `ambassador` (800+ points)

### Provider Badges
- `bronze`: New provider
- `silver`: Trusted (3-10 recommendations)
- `gold`: Highly trusted (11+ recommendations)

### Recommendation Levels
- `new`: Bronze badge
- `trusted`: Silver badge
- `highly_recommended`: Gold badge

---

## 🔑 Authentication

### Register
```http
POST /api/v1/auth/register
Content-Type: application/json

{
  "name": "User Name",
  "email": "user@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

### Login
```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

**Response**: `{ "data": { "user": {...}, "token": "..." } }`

### Authenticated Requests
```http
Authorization: Bearer {token}
```

---

## 📱 Best Practices

1. **Infinite Scroll**: Use cursor pagination, load 20 items at a time
2. **Error Handling**: Check `status` field, use `code` for specific handling
3. **Loading States**: Show loading indicator when `has_more` is true
4. **Caching**: Cache home screen data, refresh on pull-to-refresh
5. **Optimistic Updates**: Update UI immediately, sync with server

---

## 🎯 Key Endpoints Summary

| Endpoint | Method | Auth | Purpose |
|----------|--------|------|---------|
| `/wizard/start` | GET | No | Home screen bundle |
| `/wizard/categories` | GET | No | Category cards |
| `/wizard/services` | GET | No | Service feed (infinite scroll) |
| `/wizard/providers` | GET | No | Provider feed (infinite scroll) |
| `/wizard/suggest` | POST | Yes | Suggest provider |
| `/rewards/{id}` | GET | Yes | Reward feedback |
| `/me/progress` | GET | Yes | User progress |

---

## 🚨 Common Issues

### Issue: Pagination not working
**Solution**: Use `cursor` parameter, not `page`. Check `has_more` flag.

### Issue: Trust badge not showing
**Solution**: Check `badge` field, fallback to `recommendation_level`.

### Issue: Photos not loading
**Solution**: Photos are full URLs, use `asset()` helper on backend.

---

**Need Help?** Check `API_DESIGN_SUMMARY.md` for detailed architecture decisions.

