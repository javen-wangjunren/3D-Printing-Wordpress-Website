I will implement the `prefix_name` support across all global blocks and update the page templates to pass the correct prefixes.

### 1. Modify Block Render Files (`blocks/global/*/render.php`)
I will update **all** `render.php` files in `blocks/global/` to dynamically handle field name prefixes.
- **Action**:
  - Add `$pfx = isset($block['prefix']) ? $block['prefix'] : '';` to the top of each file.
  - Replace all instances of `get_field('field_name')` with `get_field($pfx . 'field_name')`.
- **Files**:
  - `hero-banner/render.php`, `capability-list/render.php`, `review-grid/render.php`, `related-blog/render.php`, `mission/render.php`, `timeline/render.php`, `team/render.php`, `factory-image/render.php`, `cta/render.php`, and all others in `blocks/global/`.

### 2. Update Page Templates (`templates/`)
I will update the `_3dp_render_block()` calls in the page templates to pass the specific prefix defined in the ACF Clone settings.

#### `templates/page-home.php`
- **Hero Banner**: Add `'prefix' => 'field_home_overview_hero_clone_'`
- **Capability/Review/Blog**: No prefix change needed (currently `prefix_name => 0`), but I will ensure the structure allows adding it later if enabled.

#### `templates/page-about.php`
- **Hero Banner**: Add `'prefix' => 'field_about_hero_clone_'`
- **Mission**: Add `'prefix' => 'field_about_mission_clone_'`
- **Timeline/Team/Factory**: Pass empty prefix (currently `prefix_name => 0`).

#### `templates/page-contact.php`
- **Hero Banner**: Add `'prefix' => 'contact_hero_clone_'`

#### `templates/page-all-capabilities.php`
- **Hero Banner**: Add `'prefix' => 'hero_content_'`
  - *Note*: This template splits Hero content and design into two separate clone groups (`hero_content` and `hero_design_settings`). The `render.php` change will fix the content fields. Design fields may revert to defaults if their prefix differs; this is a known structural constraint we can address if needed.
- **Other Modules**: Pass empty prefix (currently `prefix_name => 0`).

#### `templates/single-capability.php` (CPT)
- **Hero Banner**: Add `'prefix' => 'cap_hero_content_'`
- **Process (How It Works)**: Add `'prefix' => 'cap_hiw_content_'`

#### `templates/single-material.php` (CPT)
- **Hero Banner**: Add `'prefix' => 'mat_hero_content_'`
- **Manufacturing Showcase**: Add `'prefix' => 'mat_mfs_content_'`

### 3. Verification
- I will verify that `page-home.php` and `page-about.php` correctly load the Hero Banner fields with the new prefixes.
- I will verify that `page-all-materials.php` (which uses standard fields) continues to work by passing an empty prefix.
