/**
 * BLOCK: ds-cpts-gutenberg
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { withAPIData } = wp.components; // Import registerBlockType() from wp.blocks
/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'cgb/block-ds-cpts-gutenberg-status', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'RECENT status' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [ 'status' ],

	edit: withAPIData( () => {
        return {
            posts: '/wp/v2/status?per_page=5&_embed'
        };
      } )( ( { posts, className } ) => {
          if ( ! posts.data ) {
              return "loading !";
          }
          if ( posts.data.length === 0 ) {
              return "No posts";
          }
          var post = posts.data[ 0 ];

		  function mydateformat(date) {
			  var dateObj = new Date(date);
			  var month = dateObj.getUTCMonth() + 1; //months from 1-12
			  var day = dateObj.getUTCDate();
			  var year = dateObj.getUTCFullYear();

			  if (day < 10)
			  	day = "0" + day;

			  if (month < 10)
			  	month = "0" + month;

			  return "" + year + month + day;

		  }

			return (
				<div className={ className }>
					<h2>Recent status</h2>
					<div class='grid'>
					{ posts.data.map( ( post, i ) =>
						[
							<span>{ mydateformat(post.date) }</span>
							,
							<div>{ post.content.rendered } &raquo;</div>
						]
					) }
					</div>
				</div>
			);
      } ),

	save: function( props ) {
		return null;
	},
} );
