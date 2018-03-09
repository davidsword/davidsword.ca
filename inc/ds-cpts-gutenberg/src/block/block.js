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
registerBlockType( 'cgb/block-ds-cpts-gutenberg', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'RECENT Projects' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [ 'projects' ],

	edit: withAPIData( () => {
        return {
            posts: '/wp/v2/projects?per_page=4&_embed'
        };
      } )( ( { posts, className } ) => {
          if ( ! posts.data ) {
              return "loading !";
          }
          if ( posts.data.length === 0 ) {
              return "No posts";
          }
          var post = posts.data[ 0 ];

		  // return (
		  // );

			return (
				<div className={ className }>
					<h2>Recent Projects</h2>
					{ posts.data.map( ( post, i ) =>
						[ <div class='grid'>
							<a href={ post.link }>
								<img src={ post._embedded['wp:featuredmedia'][0].source_url } />
							</a>
							{ console.log( post.excerpt ) }
							<div>
								<strong>{ post.title.rendered }</strong><br />
								{ post.excerpt.rendered }
							</div>
						</div> ]
					) }
				</div>
			);
      } ),

	save: function( props ) {
		return (
			<div className={ props.className }>
				<p>— Hello from the frontend.</p>
				<p>
					CGB BLOCK: <code>ds-cpts-gutenberg</code> is a new Gutenberg block.
				</p>
				<p>
					It was created via{ ' ' }
					<code>
						<a href="https://github.com/ahmadawais/create-guten-block">
							create-guten-block
						</a>
					</code>.
				</p>
			</div>
		);
	},
} );
