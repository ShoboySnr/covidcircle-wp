<?php
if($query->have_posts()) {
$paged = get_query_var( 'paged');
$pagination_links_args = [
  'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
  'total'        => $query->max_num_pages,
  'current'      => max( 1, $paged),
  'format'       => '?paged=%#%',
  'show_all'     => true,
  'type'         => 'array',
  'end_size'     => 0,
  'mid_size'     => 2,
  'prev_next'    => true,
  'prev_text'    => sprintf( '<i></i> %1$s', __( 'Previous', 'covid-circle-wp' ) ),
  'next_text'    => sprintf( '%1$s <i></i>', __( 'Next', 'covid-circle-wp' ) ),
  'add_args'     => true,
  'add_fragment' => '',
  'use_dots'     => '0',
];

$paginations = apply_filters('filter_pagination', paginate_links($pagination_links_args), $paged);

?>
<section id="pagination">
  <div class="pagination-container container">
    <div class="flex justify-center items-center w-full pagination-container flex-wrap">
      <?php foreach($paginations as $pagination) {
        echo $pagination;
      }
      ?>
    </div>
  </div>
</section>
<?php } ?>

