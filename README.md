# We're in the battle for the net.

#### Help spread the word on Net Neutrality by displaying an image on your WordPress site that links to https://www.battleforthenet.com/

This plugin comes with 3 different images used from https://www.battleforthenet.com/, or you may use your own.
If you'd like to use an image that comes with the plugin, you can identify them by using '1', '2', or '3'

**Comes with a Widget.**

**Comes with a shortcode**: `[battleforthenet]` that uses a default image size of X and uses this image:
- Use a different image we've supplied, Ex: `[battleforthenet battle_image=2]`
- Use your own image, ex:  `[battleforthenet custom_image=yourcustomimage.png]`

**Use a PHP function**:
`<?php if function_exists( 'battleforthenet_output' ) : ?>
	<?php battleforthenet_output( $battle_image, $custom_image ); ?>
<?php endif; ?>`

- $battle_image is '1', '2', or '3'