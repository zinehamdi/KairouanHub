# KairouanHub Button Style Guide

## 🎨 Button Styles Reference

### 1️⃣ **Primary Button (Gold Gradient)**
**Use for:** Main CTAs, Submit actions, Important navigation

```html
<a href="#" class="px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
    Button Text
</a>
```

**Visual:**
- Background: Gold (#D4AF37) → Amber (#E28E0C) gradient
- Text: White, bold
- Shadow: Large shadow with gold glow on hover
- Size: px-8 py-4 (2rem x 1rem padding)
- Effect: Scale to 105% on hover

**Examples:**
- "Become a Provider" (Navigation)
- "Browse Services" (Home)
- "Request Service Now" (Services page)
- "Start Now" (Dashboard)

---

### 2️⃣ **Secondary Button (White with Gold Border)**
**Use for:** Secondary actions, Alternative options

```html
<a href="#" class="px-8 py-4 bg-white border-2 border-accent-DEFAULT text-brand-dark font-bold text-lg rounded-lg hover:bg-accent-DEFAULT hover:text-white shadow-lg hover:shadow-gold transition-all duration-300">
    Button Text
</a>
```

**Visual:**
- Background: White → Gold on hover
- Border: 2px gold (#D4AF37)
- Text: Dark brown → White on hover
- Shadow: Large shadow with gold glow on hover
- Size: px-8 py-4

**Examples:**
- "Find Providers" (Home)
- Secondary navigation options
- "Cancel" or "Back" actions

---

### 3️⃣ **Tertiary Button (Copper Gradient)**
**Use for:** Special actions, Premium features

```html
<a href="#" class="px-8 py-4 bg-gradient-to-r from-accent-copper to-accent-amber text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
    Button Text
</a>
```

**Visual:**
- Background: Copper (#C89160) → Amber (#E28E0C) gradient
- Text: White, bold
- Shadow: Extra large on hover
- Size: px-8 py-4
- Effect: Scale to 105% on hover

**Examples:**
- "Become Provider" (Home - guest users)
- Special promotional actions

---

### 4️⃣ **Search/Submit Button**
**Use for:** Search forms, Quick submissions

```html
<button type="submit" class="px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold rounded-lg hover:shadow-gold transition-all duration-300 hover:scale-105 whitespace-nowrap shadow-lg">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    Search Text
</button>
```

**Visual:**
- Same as Primary Button
- Often includes icon (search, arrow, etc.)
- whitespace-nowrap to prevent text wrapping

**Examples:**
- Search bars (Home, Services, Providers)
- Form submissions

---

### 5️⃣ **Icon Button (Gold Circle)**
**Use for:** Visual actions in cards, Quick access features

```html
<button class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-300">
    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
</button>
```

**Visual:**
- Circle: 64px (w-16 h-16)
- Background: Gold → Amber gradient
- Icon: White, 32px (w-8 h-8)
- Effect: Scale to 110% on hover

**Examples:**
- Feature icons (Dashboard cards)
- Quick action buttons
- Decorative elements

---

### 6️⃣ **Full-Width Button (Card CTA)**
**Use for:** Card actions, Mobile-friendly CTAs

```html
<button class="w-full px-6 py-3 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold rounded-lg hover:shadow-gold transition-all duration-300 hover:scale-105">
    View Profile
</button>
```

**Visual:**
- Width: Full (w-full)
- Padding: Slightly smaller (px-6 py-3)
- Same gradient and effects as Primary
- Fits perfectly in cards

**Examples:**
- Provider card "View Profile"
- Service card actions
- Mobile navigation

---

## 📐 Size Variations

### **Large (Hero/CTA)**
```html
class="px-10 py-5 ... text-xl"
```
- Padding: 2.5rem x 1.25rem
- Text: Extra large (text-xl)

### **Medium (Standard)**
```html
class="px-8 py-4 ... text-lg"
```
- Padding: 2rem x 1rem
- Text: Large (text-lg)

### **Small (Cards)**
```html
class="px-6 py-3 ... text-base"
```
- Padding: 1.5rem x 0.75rem
- Text: Base (text-base)

---

## 🎭 State Classes

### **Default State:**
- `shadow-lg` - Large shadow
- `rounded-lg` - Rounded corners
- `font-bold` - Bold text

### **Hover State:**
- `hover:shadow-gold` - Gold glow shadow
- `hover:scale-105` - Slightly larger (5%)
- `hover:bg-accent-DEFAULT` - Gold background (secondary)
- `hover:text-white` - White text (secondary)

### **Active/Focus State:**
- `focus:ring-4 focus:ring-accent-DEFAULT/20` - Gold ring
- `focus:border-accent-DEFAULT` - Gold border
- `transition-all duration-300` - Smooth transitions

---

## 🎨 Color Reference

```css
/* Primary Gold Gradient */
from-accent-DEFAULT to-accent-amber
/* #D4AF37 → #E28E0C */

/* Copper Gradient */
from-accent-copper to-accent-amber
/* #C89160 → #E28E0C */

/* Text Colors */
text-white              /* #FFFFFF */
text-brand-dark         /* #8B6647 */
text-accent-DEFAULT     /* #D4AF37 */

/* Borders */
border-accent-DEFAULT   /* #D4AF37 */
border-accent-DEFAULT/20 /* Gold at 20% opacity */
border-accent-DEFAULT/40 /* Gold at 40% opacity */

/* Backgrounds */
bg-white               /* #FFFFFF */
bg-accent-DEFAULT      /* #D4AF37 */
bg-gradient-to-r       /* Left to right gradient */
bg-gradient-to-br      /* Top-left to bottom-right */
```

---

## ✨ Special Effects

### **Shadow Glow (Gold)**
```css
.shadow-gold {
    box-shadow: 0 10px 40px rgba(212, 175, 55, 0.3);
}
```

### **Shadow XL**
```css
.shadow-xl {
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.shadow-2xl {
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
}
```

---

## 📱 Responsive Behavior

### **Mobile (< 768px)**
```html
<div class="flex flex-col gap-4">
    <!-- Buttons stack vertically -->
    <button class="w-full ...">Button 1</button>
    <button class="w-full ...">Button 2</button>
</div>
```

### **Tablet/Desktop (≥ 768px)**
```html
<div class="flex flex-col sm:flex-row gap-4">
    <!-- Buttons display inline -->
    <button class="px-8 py-4 ...">Button 1</button>
    <button class="px-8 py-4 ...">Button 2</button>
</div>
```

---

## 🎯 Best Practices

1. **Hierarchy:**
   - Primary (gold gradient) for main actions
   - Secondary (white bordered) for alternatives
   - Tertiary (copper) for special cases

2. **Consistency:**
   - Use same padding sizes across similar buttons
   - Maintain 300ms transition duration
   - Always include hover states

3. **Accessibility:**
   - Font-bold for readability
   - High contrast (white on gold)
   - Focus rings for keyboard navigation

4. **Spacing:**
   - Use `gap-4` between button groups
   - Responsive with `flex-col sm:flex-row`
   - Center align on mobile

---

**Quick Copy:**

Primary:
```
px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300
```

Secondary:
```
px-8 py-4 bg-white border-2 border-accent-DEFAULT text-brand-dark font-bold text-lg rounded-lg hover:bg-accent-DEFAULT hover:text-white shadow-lg hover:shadow-gold transition-all duration-300
```
