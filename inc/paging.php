<?php
function foundation_pagination($arrows = true, $ends = true, $pages = 2)
{
	if (is_singular()) return;

	global $wp_query, $paged;
	$pagination = '';

	$max_page = $wp_query->max_num_pages;
	if ($max_page == 1) return;
	if (empty($paged)) $paged = 1;

	if ($arrows) $pagination .= foundation_pagination_link($paged - 1, 'arrow' . (($paged <= 1) ? ' unavailable' : ''), '&laquo;', 'Previous Page');
	if ($ends && $paged > $pages + 1) $pagination .= foundation_pagination_link(1);
	if ($ends && $paged > $pages + 2) $pagination .= foundation_pagination_link(1, 'unavailable', '&hellip;');
	for ($i = $paged - $pages; $i <= $paged + $pages; $i++) {
		if ($i > 0 && $i <= $max_page)
			$pagination .= foundation_pagination_link($i, ($i == $paged) ? 'current' : '');
	}
	if ($ends && $paged < $max_page - $pages - 1) $pagination .= foundation_pagination_link($max_page, 'unavailable', '&hellip;');
	if ($ends && $paged < $max_page - $pages) $pagination .= foundation_pagination_link($max_page);

	if ($arrows) $pagination .= foundation_pagination_link($paged + 1, 'arrow' . (($paged >= $max_page) ? ' unavailable' : ''), '&raquo;', 'Next Page');

	$pagination = '<ul class="pagination">' . $pagination . '</ul>';
	$pagination = '<div class="pagination-centered">' . $pagination . '</div>';

	echo $pagination;
}

function foundation_pagination_link($page, $class = '', $content = '', $title = '')
{
	$id = sanitize_title_with_dashes('pagination-page-' . $page . ' ' . $class);
	$href = (strrpos($class, 'unavailable') === false && strrpos($class, 'current') === false) ? get_pagenum_link($page) : "#$id";

	$class = empty($class) ? $class : " class=\"$class\"";
	$content = !empty($content) ? $content : $page;
	$title = !empty($title) ? $title : 'Page ' . $page;

	return "<li$class><a id=\"$id\" href=\"$href\" title=\"$title\">$content</a></li>\n";
}