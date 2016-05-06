<?php
namespace CNP;

class ACF_PostList extends PostList {

	public $post_args;
	public $data_type;

	public function __construct( $data ) {

		if ( ! isset( $data['name'] ) ) {
			$this->name = 'acf-postlist';
		}

		parent::__construct( $data );

		if ( 'Automatic' === $data['data_type'] ) {

			$this->post_args = [
				'post_type'   => $data['post_type'],
				'numberposts' => $data['number_of_posts']
			];

			$postlist_post_args_filter = $this->name . '_post_args';
			$this->post_args = apply_filters( $postlist_post_args_filter, $this->post_args );
			Atom::AddDebugEntry( 'Filter', $postlist_post_args_filter );

			$this->posts = new \WP_Query( $this->post_args );
		}

		if ( 'Manual' === $data['data_type'] ) {
			$this->posts = $data['manual_posts'];
		}

		$this->structure = [
			'listtitle' => [
				'tag'      => 'h2',
				'tag_type' => 'false_without_content',
				'content'  => $data['list_title']
			]
		];

		$this->posts_structure = [
			'PostClass' => [
				'children' => [ 'image', 'text' ],
			],
			'image'     => [
				'parts' => [
					'PostThumbnail'
				]
			],
			'text'      => [
				'parts' => [
					'PostTitleLink',
					'ExcerptForce',
					'PostLink' => 'Read More'
				]
			]
		];

		$link_name = $this->name . $this->separator . 'link';
		$link_args = [
			'name'     => $link_name,
			'tag_type' => 'false_without_content',
			'content'  => $data['link_text'],
			'href'     => $data['link']
		];
		$link_obj  = new Link( $link_args );
		$link_obj->getMarkup();

		if ( '' !== $link_obj->markup ) {
			$this->after_content = $link_obj->markup;
		}

	}
}