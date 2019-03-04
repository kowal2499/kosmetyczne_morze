<?php

/**
 *
 * sidebar
 *
 * 1. ustalamy czy zabieg ma dzieci
 * 2. jeśli tak to rysujemy sidebar
 * 3. nad sidebarem nazwa i link do zabiegu macierzystego
 * 4. w sidebarze rodzeństwo
 *
 * content
 * 1. content
 * 2. odnośniki do dzieci
 * 3. nawigacja left/right pomiędzy rodzeństwem
 *
 *
 */

$children = get_children([
    'post_parent' => $id,
    'post_type'   => 'zabiegi',
    'numberposts' => -1,
    'order' => 'ASC',
]);


if (empty($children)) {
    get_template_part('template-parts/content-zabiegi-no-sidebar');
} else {
    get_template_part('template-parts/content-zabiegi-with-sidebar');
}


