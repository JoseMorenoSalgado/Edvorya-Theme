# Edvorya visual identity contract for Moodle

## Source of truth

The visual reference is the current `JoseMorenoSalgado/Edvorya-LMS` product, especially:

- protected LMS shell (`src/app/(edvorya)/lms/layout.tsx`);
- protected sidebar (`src/components/edvorya/sidebar.tsx`);
- header actions (`src/components/edvorya/header-actions.tsx`);
- shared Design System primitives (`src/components/edvorya/design-system.tsx`);
- student dashboard (`src/components/student/student-home-dashboard.tsx`);
- public navigation/mobile sheet (`src/components/public-site/public-navigation.tsx`).

The Moodle theme translates these decisions; it does not copy React, shadcn, Radix or Tailwind runtime dependencies.

## Core visual principles

### 1. Less is more

The interface should prioritize content and decisions. Avoid decorative wrappers, nested cards and unnecessary accent bars.

- Page introductions are plain content with a quiet bottom divider.
- Cards are used only when information benefits from grouping.
- Primary colour is an accent, not a page background.
- Shadows remain restrained (`shadow-sm` is the normal surface treatment).

### 2. Neutral product canvas

Default product language:

- canvas: white;
- subtle surface: slate-50;
- primary text: slate-950;
- secondary text: slate-500/600;
- borders: slate-200;
- institutional primary colour: configurable Moodle theme token.

Tenant branding may change the primary/accent colours, but should not destroy contrast or hierarchy.

### 3. Shape and density

- compact action: 36px;
- standard action / navigation row: 40px;
- icon size: 18px for navigation, 16-20px elsewhere;
- compact radius: 8-10px;
- action/surface radius: 12px;
- main card/surface radius: 16px;
- exceptional empty states or marketing surfaces may reach 24px.

### 4. Typography

Edvorya LMS uses Geist as its primary product font. Moodle does not load an external font CDN at runtime. The theme therefore uses a local-first stack:

`Geist, Inter, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif`

If Geist is unavailable on the client, the system fallback preserves the intended density without adding a network dependency.

Headings use medium/semi-bold weight with tight negative letter-spacing. Body copy uses normal weight and generous line-height.

## Application shell

### Topbar

Reference pattern:

- height: 64px;
- sticky;
- white/translucent surface with backdrop blur;
- one quiet bottom border;
- compact 36px ghost action buttons;
- notification badge attached to the icon, not a large separate element;
- user avatar 32px;
- product/institution identity is compact and two-level.

### Sidebar

Reference pattern:

- neutral off-white surface;
- 256px desktop width;
- 18px Lucide-style icons without decorative icon boxes;
- 40px navigation rows;
- quiet active row using a soft primary tint;
- hover uses slate-50;
- navigation groups use small uppercase labels only when grouping adds meaning.

Moodle Core remains the navigation data source. Edvorya only controls composition and presentation.

### Mobile drawer

Reference pattern:

- 18rem width;
- left-side sheet;
- 36px `PanelLeft`-style trigger;
- no oversized rounded drawer shell;
- restrained overlay and shadow;
- selecting a route follows native Moodle navigation behavior.

## Page intro contract

The old alpha used large card-like page headers with a vertical blue accent. Edvorya LMS uses a simpler PageShell:

- optional eyebrow;
- strong page title;
- short description where available;
- optional actions aligned to the end;
- bottom divider;
- no outer card, shadow or coloured side stripe.

Moodle output does not always expose an eyebrow/description, so the theme preserves the available Core header data and applies the same visual hierarchy.

## Dashboard contract

### Student

The dashboard should answer, in this order:

1. Where do I continue?
2. What is pending?
3. How am I progressing?
4. What is coming next?

Moodle Core blocks remain the data source. `theme_edvorya` may reorder presentation but must not invent progress, streaks, risk or recommendations.

Visual reference:

- compact summary/decision surfaces;
- active courses first;
- pending/timeline next;
- calendar/upcoming dates after;
- secondary recommendations only when backed by real data.

### Teacher

The dashboard should help answer:

1. What needs review?
2. Which students need follow-up?
3. Where should I intervene next?
4. Is there communication requiring attention?

Aggregated cross-course intelligence belongs in a future `local_edvorya` service layer, not in expensive theme SQL.

## Components

### Surfaces

Normal reusable surface:

- white background;
- slate-200 border;
- 16px radius;
- restrained shadow-sm.

### Buttons

- primary: institutional primary fill;
- secondary: white, slate border, no unnecessary shadow;
- ghost: transparent, slate text, slate-50 hover;
- minimum normal height: 40px;
- icon-only compact controls: 36px.

### Status and metadata

Use pill treatments for compact metadata and statuses. Semantic colours should remain light-surface + readable foreground where possible.

### Empty states

Use a quiet dashed or subtle border, centered icon, one title, one description and at most one primary action.

## Moodle / Boost boundary

Boost owns:

- generic Bootstrap mechanics;
- forms and validation behavior;
- modal/dropdown/popover behavior;
- File Picker/File Manager mechanics;
- Action Menu mechanics;
- technical fallback layouts.

Edvorya owns:

- visual tokens;
- product shell;
- navigation composition;
- dashboard hierarchy;
- visual surfaces and density;
- Moodle page experience refinements;
- branding.

Any future visual change should be evaluated against this boundary before adding CSS or templates.
