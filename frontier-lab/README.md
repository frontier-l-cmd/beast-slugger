# FRONTIER LAB. — WordPress ブロックテーマ（FSE）

「判断の記録（a record of judgment）」を読ませるための編集的ブロックテーマ。
`frontierlabspec.md`（正本）を基準に実装。**モノクローム（ネイビー一族）／余白主導／装飾は情報のときだけ。**

---

## 設計の要点（仕様書との対応）

| 仕様書 | 実装 |
|---|---|
| §1 カラー（確定） | `theme.json` の `color.palette`。`color.custom:false` 等で**ネイビー一族以外を出せないように固定**（緑・他色・カスタム色を禁止）。 |
| §2 タイポ（確定） | `theme.json` の `fontFamilies`（明朝/Newsreader/ゴシック/等幅）。本文 17px・行間 2.0・左揃え。Google Fonts は `functions.php` で読み込み。 |
| §3 レイアウト | `contentSize:680px`（可読幅）/ `wideSize:1080px`（コンテナ）。セクションはヘアライン罫＋広い余白。 |
| §4 トップ | `templates/front-page.html`：ヘッダー → 言葉のヒーロー（画像なし）→ 編集リスト（サムネなし）→ About。 |
| §5 記事テンプレ | `templates/single.html`：パンくず → カテゴリチップ＋h1＋日付 → 本文 → 図版 → 記事末LINE → 関連（テキストのみ）→ Index へ。h2/h3 まで・指標非表示。 |
| §5 図版3型 | `patterns/figure-contrast.php` / `figure-comparison.php` / `figure-process.php`。**ネイティブ SVG/HTML、ラスター画像化しない。** |
| §5 記事末LINE | `patterns/line-entry.php`（罫で囲った静かなブロック・煽らない）。 |
| §6 禁止事項 | ヒーロー画像・アイキャッチ・指標・装飾囲み・カラフル図を出さない構造。 |
| §7 OGP | `functions.php` が白地＋タイトルの定型カード（`assets/og-default.png`／編集元 `og-default.svg`）を `og:image` に出力。 |

---

## インストール

1. このディレクトリ **`frontier-lab/` ごと** を WordPress の `wp-content/themes/` に置く
   （`wp-content/themes/frontier-lab/style.css` になる配置）。
   - ZIP で入れる場合：`frontier-lab` フォルダを zip 化し、管理画面「外観 → テーマ → 新規追加 → テーマのアップロード」。
2. 「外観 → テーマ」で **FRONTIER LAB.** を有効化。
3. WordPress 6.5 以上 / PHP 7.4 以上。

## 初期セットアップ（推奨）

1. **カテゴリ**を2つ作る（ナビ／URL と一致させる）：
   - 「考察」 slug: `consideration`
   - 「実験」 slug: `experiment`
   （ナビの URL を変えたい場合は `parts/header.html` / `parts/footer.html` を編集）
2. **固定ページ「About」**（slug: `about`）を作成。本文だけ見せたいなら
   ページ属性のテンプレートで「ページ（見出しなし）」を選択。
3. **表示設定**：「設定 → 表示設定」でホームページを最新の投稿のままにすると
   `front-page.html`（ヒーロー＋編集リスト）が出る。
4. **LINE リンク**：`patterns/line-entry.php` と `templates/single.html` の
   `href="#"` を実際の LINE URL に差し替え（記事末のみ・トップには置かない）。
5. **指標は出さない**：いいね・PV・著者名・SNSシェアのプラグインは入れない（仕様 §6）。

## 記事の書き方

- 新規投稿 → 本文先頭で**パターン「記事ひな型 — 考察 / 実験」**を挿入すると、
  リード（明朝）→ h2 → 図版 → 引用 → 記事末LINE の確定構造から始められる。
- 図版は**パターン「図版・型1〜3」**から挿入（対比図／比較表／プロセス図）。
  3型に固定し、記事ごとにスタイルを変えない。
- 太字（strong）はごく稀に。色変え・マーカー・装飾囲みは使わない。

## ファイル構成

```
frontier-lab/
├── style.css            テーマヘッダ＋補助CSS（編集リスト・図版3型・LINE・関連）
├── theme.json           カラー/タイポ/余白/レイアウトの宣言（正本）
├── functions.php        フォント読込・OGP・パターンカテゴリ・抜粋調整
├── templates/           front-page / index / single / page / page-no-title / archive / search / 404
├── parts/               header / footer
├── patterns/            hero / 図版3型 / line-entry / article-starter
└── assets/              og-default.svg（編集元）/ og-default.png（出力カード）
```

## カスタマイズの勘所

- **色を増やさない**：`theme.json` の `palette` がブランドの境界。新色は足さない。
- **可読幅は 680px**：本文は `contentSize`。図版・LINE・関連も同じ measure に揃えている。
- **書体の置き換え**：見出し和＝Shippori Mincho B1／本文＝Zen Kaku Gothic New／等幅＝JetBrains Mono。
  差し替える場合は `theme.json` の `fontFamilies` と `functions.php` の Google Fonts URL を両方直す。
- **OGP カード**：文言を変えるなら `assets/og-default.svg` を編集し、PNG に書き出して差し替える
  （煽りサムネ・顔・大コピーにしない＝§7）。
