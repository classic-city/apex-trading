# Custom Blocks
We will be using Advanced Custom Fields for any custom block creation. There should be a folder created in the root of the theme called `/blocks`. Each custom ACF block should get it's own folder (the view and associated fields should live here). In the root of the `/blocks` folder should be a file called `main.php`. This is the file that will do all the appropriate "includes" to get all the blocks included into WordPress. Inside of `functions.php`, there should be a single include for `/blocks/main.php` that will bring in everything.

# /includes folder
For each new feature built, there should be a subfolder created inside of /includes. Inside the feature's subfolder, there should be a file called "main.php" where all individual files are included. In an effort to keep the functions.php file clean, the "main.php" file within each subfolder should be the only file needed to be included for that feature.

# Custom Post Types
If a new CPT is requested, please add a new folder inside of /includes. If that CPT has associated custom blocks, there should be a subfolder created inside of it to house the custom blocks associated with that CPT.

# CSS Naming Conventions
We use BEM methodology in this theme. Every new "parent-level" CSS class should begin with "ccc-" to ensure we have consistency and specificity. Any CSS class that is an "add-on" to something else can use a logical prefix (ie. "is-vertical" for a image that requires a vertical aspect ratio).

# SCSS rules
We use SCSS rules for this website. The CSS class prefix (as notated above) will live in a variable called $ns. When writing CSS code, please use #{$ns} at the parent-level CSS classes to denote this prefix.

Every parent-level CSS class gets it's own file. The file name should be the name of the CSS class. For example: a CSS class of `ccc-image-hanger` would turn into a file called `_image-hanger.scss`. Upon creating a new SCSS file, please import it into the main CSS file, styles.scss, for compilation.

# Apex Trading Seller Sync (Theme API Integration)

This theme ships a seller importer that pulls data from the Apex Trading marketing-website APIs, writes sellers into WordPress, and exposes state/seller URLs like `/wholesale-cannabis-sellers/{state}/{seller}`.

## What it does
- Registers a custom post type `apex_seller` and a taxonomy `apex_seller_state`.
- Per-state WP-Cron jobs fetch sellers, normalize fields (name, slug, description, website/profile URL, city, logo), upsert posts, and assign the correct state term.
- Seller logos are downloaded and set as featured images; refreshed on every sync.
- Front-end templates:
  - `page-wholesale-cannabis-sellers.php` – landing page (create a WP page with that slug).
  - `taxonomy-apex_seller_state.php` – state listings.
  - `single-apex_seller.php` – seller detail (shows logo, name, description, state link, meta).

## Configuration
Added to `wp-config.php` - these are the API end point locations:
```
define('APEX_SELLER_SOURCE_STATES', 'https://app.apextrading.com/api/partners/marketing-website/sellers?state=');
define('APEX_SELLER_SOURCE_SINGLE', 'https://app.apextrading.com/api/partners/marketing-website/single?slug=');
```
Optional API debugging:
```
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('APEX_SELLER_SYNC_DEBUG', true);
```

## Cron schedule & triggers
- WP-Cron hook: `apex_trading_sync_sellers` (scheduled weekly by default; see `includes/sellers/main.php`).
- Per-state hook: `apex_trading_sync_seller_state` (queued one per state when the main hook runs to prevent long runs and timeout issues).
- Manual triggers (must be logged-in as admin) this allows you to queue the API:
  - Queue all states: `/wp-admin/admin-post.php?action=apex_seller_sync`
  - Single state: `/wp-admin/admin-post.php?action=apex_seller_sync&state=CO`
- WP-CLI examples (if available):
  - `wp cron event run apex_trading_sync_sellers`
  - `wp cron event run apex_trading_sync_seller_state --args=CO`

## Purging data
- Purge endpoint (must be logged-in as admin): `/wp-admin/admin-post.php?action=apex_seller_purge`
- This deletes all `apex_seller` posts, featured images, and all `apex_seller_state` terms.

## How it works (data flow)
1) Main hook queues per-state jobs (staggered) using the state map in `apex_trading_state_map()`.
2) Each state job:
   - Fetches sellers for that state; optionally hydrates from the single-seller endpoint.
   - Normalizes fields (name, slug, description, city, website, profile URL, logo URL); state is forced from the job context only.
   - Merges by slug; upserts posts and assigns the state term (lookup/insert by slug).
   - Downloads logo and sets featured image (replaces prior thumbnail).

## Templates / URLs
- Seller CPT rewrite: `/wholesale-cannabis-sellers/%apex_seller_state%/%postname%`
- State taxonomy rewrite: `/wholesale-cannabis-sellers/{state-slug}/`
- Create a page with slug `wholesale-cannabis-sellers` to use the landing template.

## Debugging
- Logs go to `wp-content/debug.log` when `APEX_SELLER_SYNC_DEBUG` is true.
- Key log messages: state fetch counts, term lookups/attachments, seller upserts, logo download errors.
- If terms go bad, purge (see above), resave Permalinks, rerun a state via the admin-post URL, and watch the log.

## File map (key parts)
- `includes/sellers/main.php` – CPT/taxonomy registration, cron, sync logic, logo handling.
- `single-apex_seller.php` – seller detail page.
- `taxonomy-apex_seller_state.php` – state listings.
- `page-wholesale-cannabis-sellers.php` – landing page for states.
