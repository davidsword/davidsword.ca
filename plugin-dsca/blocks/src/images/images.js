//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { withAPIData } = wp.components; // Import registerBlockType() from wp.blocks

registerBlockType( 'cgb/block-ds-cpts-gutenberg-images', {
	title: __( 'RECENT Images' ), // Block title.
	icon: 'shield',
	category: 'common',
	keywords: [ 'images' ],

	edit: withAPIData( () => {
        return {
            posts: '/wp/v2/images?per_page=4&_embed'
        };
      } )( ( { posts, className } ) => {
          if ( ! posts.data ) {
              return "loading !";
          }
          if ( posts.data.length === 0 ) {
              return "No posts";
          }
			return (
				<div className={ className }>
					<h2>Recent Images</h2>
					<div class='grid images'>
					{ posts.data.map( ( post, i ) =>
						[
							<img src={ post._embedded['wp:featuredmedia'][0].source_url } />
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
