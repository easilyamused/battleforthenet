# We're in the battle for the net.

#### Help spread the word in our fight for Net Neutrality by displaying an image on your WordPress site that links to https://www.battleforthenet.com/

### Types of Displays ###

This plugin comes with 3 different javascript overlays: Modal, Lightbanner, Darkbanner
- See examples of these here: https://www.battleforthenet.com/sept10th/#sites
- These will only display on Sept 10th
- Add `#SHOW_BFTN_WIDGET` to the end of your URL to force it to show

It also comes with a Modal Embed that you can embed in pages and posts.
- Displays regardless of Sept 10th

It also comes with 3 static images that will link to https://www.battleforthenet.com/
- These are the dark images at the bottom of this page: https://www.battleforthenet.com/sept10th/

**Type names**: modal, embed, lightbanner, darkbanner, image1, image2, image3

### How You Can Display These ###

**Display via Widget.**

**Display via shortcode**: `[battleforthenet]` that uses a default type of `modal`:
- Use a different display, Ex: `[battleforthenet type=darkbanner]`  Ex: `[battleforthenet type=image2]`

**Display via PHP function**:
`<?php if function_exists( 'battleforthenet_output' ) : ?>
	<?php battleforthenet_output( $type ); ?>
<?php endif; ?>`