<?php
/**
 * Title: 記事末 — LINE導線（静か）
 * Slug: frontier-lab/line-entry
 * Categories: frontier-lab
 * Description: 記事末のみに置く、罫で囲った静かなLINE導線。煽らない・抑えたボタン。
 * Keywords: LINE, 導線, cta, line
 *
 * @package frontier-lab
 */
?>
<!-- wp:group {"className":"fl-line-entry","layout":{"type":"constrained"}} -->
<div class="wp-block-group fl-line-entry"><!-- wp:html -->
<div class="fl-k">If something moved</div>
<p>ここまで読んで、何かが動いたなら。続きは少人数の場所で話しています。売り込みはありません。読んで止まれなかった人だけ、どうぞ。</p>
<a class="fl-go" href="#"><?php esc_html_e( 'LINEで続きを読む', 'frontier-lab' ); ?> <span class="fl-arw">→</span></a>
<!-- /wp:html --></div>
<!-- /wp:group -->
