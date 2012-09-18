# UCF Human Resources Theme

## Installation

This theme requires the following plugins:
* (none)

Required Installation Settings:
* Theme Options > Events > Events Max Items:          4
* Theme Options > Events > Events Calendar URL:       TBD
* Theme Options > Site > Contact Email:               AskHR@ucf.edu
* Theme Options > Site > Organization Name:           UCF Human Resources Department
* Theme Options > Site > Organization Street Address: 3280 Progress Drive
* Theme Options > Site > Address Line 2:              Suite 100
* Theme Options > Site > City, State, ZIP:            Orlando, FL 32826
* Theme Options > Site > Phone #:                     (407) 823-2771
* Theme Options > Site > Fax #:                       (407) 823-1095

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