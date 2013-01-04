# UCF Human Resources Theme

## Installation

### This theme requires the following plugins:
* Relevanssi
* (see notes)

### Required Installation Settings:
* Appearance > Widgets: 							  Sidebar should be empty
* Theme Options > Events > Events Max Items:          4
* Theme Options > Events > Events Calendar URL:       TBD
* Theme Options > Site > Contact Email:               AskHR@ucf.edu
* Theme Options > Site > Organization Name:           UCF Human Resources Department
* Theme Options > Site > Organization Street Address: 3280 Progress Drive
* Theme Options > Site > Address Line 2:              Suite 100
* Theme Options > Site > City, State, ZIP:            Orlando, FL 32826
* Theme Options > Site > Phone #:                     (407) 823-2771
* Theme Options > Site > Fax #:                       (407) 823-1095
* (From Network Admin) All Sites > /hr/ > Edit > Settings > Uploads Use Yearmonth Folders: 0 (removes month/year permalink structure for media library uploads)
* Settings > Reading > Blog pages show at most: 	  -1
* Settings > Relevanssi > Indexing options > Post types to index: 'post', 'page', 'resourcelink'
* Settings > Relevanssi > Indexing options > Minimum word length to index: 2

(Remember to build the Relevanssi index when saving indexing options!)

## Custom Post Types

### Resource Links
Similar to Documents, but are more open-ended and allow for more types of content (internal/external links, pages.)  Used primarily in this theme to define content within Page Sections, and are searchable via the post search shortcode used in the two-column page template of the site.

## Custom Taxonomies

### Organizational Groups
Describes organizational groups (used for Person post type)

### Page Sections
Describes 'subcategories' of pages (used for Resource Link post type)

## Short Codes

### [ post-type-search ]
Used in this theme to search through Resource Links.

### [ site-contact-email ]
Outputs a styled email link that pulls the e-mail address set within the site Theme Options.

### [ site-contact-info ]
Outputs a styled box containing HR contact info, as defined within the site Theme Options.

## Notes

* Page Sections are intended to follow a specific structure that somewhat mirrors the site's page relationships.  Any given two-column page should have a similarly-named Page Section with child Page Sections to define 'subcategories' for Resource Links.  No Page Section structure should go beyond a single parent > children relationship.
* Some pages have extensive HTML markup and/or custom stylesheets; these are located in the *dev* directory of this repo
* This theme comes packaged with code from the Enable Media Replace plugin v2.8.1 (http://wordpress.org/extend/plugins/enable-media-replace/).  The code has been simplfied to remove the 'Replace the file, use new file name and update all links' functionality to prevent users from modifying existing attachment URI's; this functionality can be achieved via the Resource Link 'File' meta field by uploading a new file.  The file modification time shortcode has also been removed as it isn't particularly necessary here.  The plugin code has been included within the theme to prevent the actual plugin from having to be installed across the network, but be aware that it can not receive automatic updates like standard plugins as it is just an include in *functions.php*.