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