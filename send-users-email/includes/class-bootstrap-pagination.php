<?php
/**
* Class Bootstrap_Pagination
* Handles the rendering of Bootstrap-styled pagination.
* This is not dependent of wpdb query results, it can be used with any pagination logic.
* This is a reusable class that can be used in any plugin or theme.
* Works with any data source (custom tables, REST results, arrays, etc.)
* Exposes limit() and offset() for your queries
* Renders Bootstrap 5 pagination (<ul class="pagination">…</ul>)
* Preserves any query args you pass in (e.g., search filters)
* Is safe and admin‑friendly (escapes URLs, adds ARIA, supports alignment + sizes)
*/
class Bootstrap_Pagination
{
    protected $total_items   = 0;
    protected $per_page      = 10;
    protected $current_page  = 1;
    protected $total_pages   = 1;
    protected $base_url      = '';
    protected $page_arg      = 'paged';
    protected $mid_size      = 2; // pages to show on each side of current
    protected $preserve_args = []; // extra args to keep in links

    /**
    * @param array $args {
    *   @type int         $total_items   Required. Total number of items.
    *   @type int         $per_page      Optional. Default 10.
    *   @type int|null    $current_page  Optional. Default from $_GET[$page_arg] or 1.
    *   @type string      $base_url      Required. Base URL without the 'paged' (or custom) arg.
    *   @type string      $page_arg      Optional. Query arg name for page. Default 'paged'.
    *   @type int         $mid_size      Optional. Pages around current. Default 2.
    *   @type array       $preserve_args Optional. Extra query args to preserve in links.
    * }
    */
    public function __construct( $args = [] ) {
        $defaults = [
            'total_items'   => 0,
            'per_page'      => 10,
            'current_page'  => null,
            'base_url'      => '',
            'page_arg'      => 'paged',
            'mid_size'      => 2,
            'preserve_args' => [],
        ];
        $args = function_exists('wp_parse_args') ? wp_parse_args( $args, $defaults ) : array_merge( $defaults, $args );

        $this->total_items = max( 0, (int) $args['total_items'] );
        $this->per_page    = max( 1, (int) $args['per_page'] );
        $this->page_arg    = (string) $args['page_arg'];
        $this->mid_size    = max( 0, (int) $args['mid_size'] );

        // Base URL is required for correct links.
        $this->base_url    = (string) $args['base_url'];

        // Sanitize preserve args to only scalars.
        $this->preserve_args = [];
        if ( is_array( $args['preserve_args'] ) ) {
            foreach ( $args['preserve_args'] as $k => $v ) {
                if ( is_scalar( $v ) && $v !== '' && $v !== null ) {
                    $this->preserve_args[ $k ] = $v;
                }
            }
        }

        // Determine current page
        if ( $args['current_page'] !== null ) {
            $this->current_page = (int) $args['current_page'];
        } else {
            $from_get = isset( $_GET[ $this->page_arg ] ) ? (int) $_GET[ $this->page_arg ] : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $this->current_page = $from_get;
        }
        $this->current_page = max( 1, $this->current_page );

        // Compute total pages and clamp current page
        $this->total_pages  = max( 1, (int) ceil( $this->total_items / $this->per_page ) );
        if ( $this->current_page > $this->total_pages ) {
            $this->current_page = $this->total_pages;
        }
    }

    /** Offset to use in queries. */
    public function offset() {
        return ( $this->current_page - 1 ) * $this->per_page;
    }

    /** Limit to use in queries. */
    public function limit() {
        return $this->per_page;
    }

    /** Current page number. */
    public function currentPage() {
        return $this->current_page;
    }

    /** Total pages. */
    public function totalPages() {
        return $this->total_pages;
    }

    /** Total items. */
    public function totalItems() {
        return $this->total_items;
    }

    /** Build URL for a specific page, preserving configured query args. */
    public function pageUrl( $page ) {
        $page = max( 1, (int) $page );
        $args = $this->preserve_args;
        $args[ $this->page_arg ] = $page;

        if ( function_exists('add_query_arg') ) {
            return esc_url( add_query_arg( $args, $this->base_url ) );
        }

        // Fallback (no WP helpers): append query string manually.
        $glue = ( strpos( $this->base_url, '?' ) === false ) ? '?' : '&';
        return htmlspecialchars( $this->base_url . $glue . http_build_query( $args ), ENT_QUOTES, 'UTF-8' );
    }

    /**
    * Return a normalized list of "link items" you can render your own way.
    * Each item is an associative array with keys:
    * - type: 'prev'|'next'|'page'|'dots'|'first'|'last'
    * - label: string
    * - url: string|null
    * - page: int|null
    * - current: bool
    * - disabled: bool
    */
    public function links( $args = [] ) {
        $defaults = [
            'show_prev_next'  => true,
            'show_first_last' => false,
        ];
        $args = function_exists('wp_parse_args') ? wp_parse_args( $args, $defaults ) : array_merge( $defaults, $args );

        $items = [];

        // Prev
        if ( $args['show_prev_next'] ) {
            $items[] = [
                'type'     => 'prev',
                'label'    => '«',
                'url'      => $this->current_page > 1 ? $this->pageUrl( $this->current_page - 1 ) : null,
                'page'     => $this->current_page - 1,
                'current'  => false,
                'disabled' => $this->current_page <= 1,
            ];
        }

        // First
        if ( $args['show_first_last'] && $this->total_pages > 1 ) {
            $items[] = [
                'type'     => 'first',
                'label'    => '1',
                'url'      => $this->current_page === 1 ? null : $this->pageUrl( 1 ),
                'page'     => 1,
                'current'  => $this->current_page === 1,
                'disabled' => $this->current_page === 1,
            ];
        }

        // Determine window
        $start = max( 1, $this->current_page - $this->mid_size );
        $end   = min( $this->total_pages, $this->current_page + $this->mid_size );

        // Leading dots if needed (and avoid duplicate "1" if showing First)
        if ( $start > 2 && ! $args['show_first_last'] ) {
            // show first page before dots
            $items[] = [
                'type'     => 'page',
                'label'    => '1',
                'url'      => $this->pageUrl( 1 ),
                'page'     => 1,
                'current'  => false,
                'disabled' => false,
            ];
        }
        if ( $start > 2 ) {
            $items[] = [
                'type'     => 'dots',
                'label'    => '…',
                'url'      => null,
                'page'     => null,
                'current'  => false,
                'disabled' => true,
            ];
        } elseif ( $start === 2 && ! $args['show_first_last'] ) {
            // show page 1 if it's right before start and we didn't show 'first'
            $items[] = [
                'type'     => 'page',
                'label'    => '1',
                'url'      => $this->pageUrl( 1 ),
                'page'     => 1,
                'current'  => false,
                'disabled' => false,
            ];
        }

        // Middle pages
        for ( $i = $start; $i <= $end; $i++ ) {
            // Avoid duplicating page 1/last if show_first_last true
            if ( $args['show_first_last'] && ( $i === 1 || $i === $this->total_pages ) ) {
                continue;
            }
            $items[] = [
                'type'     => 'page',
                'label'    => (string) $i,
                'url'      => $i === $this->current_page ? null : $this->pageUrl( $i ),
                'page'     => $i,
                'current'  => $i === $this->current_page,
                'disabled' => $i === $this->current_page,
            ];
        }

        // Trailing dots if needed
        if ( $end < $this->total_pages - 1 ) {
            $items[] = [
                'type'     => 'dots',
                'label'    => '…',
                'url'      => null,
                'page'     => null,
                'current'  => false,
                'disabled' => true,
            ];
        } elseif ( $end === $this->total_pages - 1 && ! $args['show_first_last'] ) {
            // show last page if adjacent and we didn't show 'last'
            $page = $this->total_pages;
            $items[] = [
                'type'     => 'page',
                'label'    => (string) $page,
                'url'      => $this->pageUrl( $page ),
                'page'     => $page,
                'current'  => false,
                'disabled' => false,
            ];
        }

        // Last
        if ( $args['show_first_last'] && $this->total_pages > 1 ) {
            $page = $this->total_pages;
            $items[] = [
                'type'     => 'last',
                'label'    => (string) $page,
                'url'      => $this->current_page === $page ? null : $this->pageUrl( $page ),
                'page'     => $page,
                'current'  => $this->current_page === $page,
                'disabled' => $this->current_page === $page,
            ];
        }

        // Next
        if ( $args['show_prev_next'] ) {
            $items[] = [
                'type'     => 'next',
                'label'    => '»',
                'url'      => $this->current_page < $this->total_pages ? $this->pageUrl( $this->current_page + 1 ) : null,
                'page'     => $this->current_page + 1,
                'current'  => false,
                'disabled' => $this->current_page >= $this->total_pages,
            ];
        }

        return $items;
    }

    /**
    * Render Bootstrap 5 pagination.
    *
    * @param array $args {
    *   @type string $alignment       '', 'center', or 'end' (uses justify-content-*).
    *   @type string $size            '', 'sm', or 'lg'.
    *   @type string $aria_label      ARIA label. Default 'Pagination'.
    *   @type bool   $show_prev_next  Show « and » links. Default true.
    *   @type bool   $show_first_last Show first/last page numbers. Default false.
    * }
    * @return string HTML
    */
    public function render( $args = array() ) {
        if ( $this->total_pages < 2 ) {
            return ''; // No need to render
        }
        // this is the 
        $defaults = [
            'alignment'       => '',
            'size'            => '',
            'aria_label'      => 'Pagination',
            'show_prev_next'  => true,
            'show_first_last' => false,
        ];
        $args = function_exists('wp_parse_args') ? wp_parse_args( $args, $defaults ) : array_merge( $defaults, $args );

        $links = $this->links( $args );

        // Classes for <ul>
        $ul_classes = array( 'pagination', 'mb-0' );
        if ( $args['size'] === 'sm' ) $ul_classes[] = 'pagination-sm';
        if ( $args['size'] === 'lg' ) $ul_classes[] = 'pagination-lg';

        $wrap_classes = array();
        if ( $args['alignment'] === 'center' ) $wrap_classes[] = 'justify-content-center';
        if ( $args['alignment'] === 'end' )    $wrap_classes[] = 'justify-content-end';

        $html  = '<nav aria-label="' . esc_attr( $args['aria_label'] ) . '">';
        $html .= '<ul class="' . esc_attr( implode( ' ', $ul_classes ) ) . ' ' . esc_attr( implode( ' ', $wrap_classes ) ) . '">';

        foreach ( $links as $item ) {
            $li_classes = array( 'page-item' );
            $link_attrs = '';
            $content    = '';

            if ( $item['disabled'] ) {
                $li_classes[] = 'disabled';
            }
            if ( $item['current'] ) {
                $li_classes[] = 'active';
            }

            if ( $item['url'] ) {
                $rel = '';
                if ( $item['type'] === 'prev' ) $rel = ' rel="prev"';
                if ( $item['type'] === 'next' ) $rel = ' rel="next"';
                $content = '<a class="page-link" href="' . esc_url( $item['url'] ) . '"' . $rel . '>' . esc_html( $item['label'] ) . '</a>';
            } else {
                // current or disabled item
                $content = '<span class="page-link">' . esc_html( $item['label'] ) . '</span>';
            }

            $html .= '<li class="' . esc_attr( implode( ' ', $li_classes ) ) . '">' . $content . '</li>';
        }

        $html .= '</ul></nav>';
        return $html;
    }
}