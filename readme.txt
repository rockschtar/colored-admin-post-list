=== Colored Admin Post List ===
Contributors: rockschtar
Tags: posts, color, status, highlight, post status
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=B2WSC5FR2L8MU
Requires at least: 6.2
Tested up to: 6.9
Requires PHP: 8.3
Stable tag: develop
License: MIT
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Color-code your admin post list by post status. Instantly spot drafts, pending reviews, scheduled, private, and published posts at a glance.

== Description ==
Managing lots of content in WordPress means constantly scanning post lists to figure out what needs attention. **Colored Admin Post List** solves this by highlighting each row in the post list with a background color based on its post status — no more squinting at the status column.

**Features:**

* Color-coded rows for all built-in WordPress post statuses: Draft, Pending Review, Scheduled, Private, and Published
* Full support for **custom post statuses** registered by themes or plugins
* **Fully customizable colors** — pick any color via the built-in WordPress color picker
* Can be enabled or disabled without losing your color settings
* Lightweight — no JavaScript on the frontend, no database bloat, no external requests

**Supported post statuses (default):**

* Draft
* Pending Review
* Scheduled (Future)
* Private
* Published
* Any custom post status registered in your WordPress installation

== Installation ==
1. Upload the `colored-admin-post-list` folder to the `/wp-content/plugins/` directory, or install directly via the WordPress plugin screen.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Go to **Settings → Colored Post List** to customize colors for each post status.

== Frequently Asked Questions ==
= Can I use my own colors? =
Yes. Go to **Settings → Colored Post List** and use the color picker to choose any color for each post status.

= Does the plugin support custom post statuses? =
Yes. Any custom post status registered by a theme or plugin will automatically appear in the settings and can be assigned its own color.

= Does this plugin affect the frontend of my site? =
No. The color highlighting is applied exclusively in the WordPress admin area and has no impact on your site's frontend.

= Can I disable the highlighting temporarily without losing my settings? =
Yes. There is an Enable/Disable toggle in the settings page. Your color configuration is preserved when the plugin is disabled.

== Screenshots ==
1. Colored rows by post status in the post list
2. Settings page with color picker for each post status