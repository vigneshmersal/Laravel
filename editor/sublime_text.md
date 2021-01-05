# sublime text

## Keyboard Shortcuts
> `ctrl+k+v` - paste by log
### Show/Hide
> `ctrl+k+b` - toggle folders sidebar
> `Fn+F11` - Full screen
> `Fn+shift+F11` - Distraction Free Full screen
> `alt+shift+2` - 2 screen layouts
> `ctrl+` - show console
### Alignment
> `shift+tab` - remove tab and move lines to beginning
> `ctrl+fn+]` - align HTML Format
### Jump/switch file
> `ctrl+tab` - jump to last file
### Search file
> `ctrl+p` - search files
> `ctrl+r` - search function method
### Search & Replace (Multiple cursor)
> `ctrl+d` - select next matching word

---
## packages
> `ctrl+shift+p` - search package
- A File Icon
- Alignment
- All Autocomplete
- BracketHighlighter
- console wrap
- DocBlockr
- Emmet
- HTMLBeautify
- Javascript Beautify
- Laravel 5 Artisan
- Laravel 5 Helper Completion
- Laravel Goto
- Php companion
- Php cs fixer
- Pretty JSON
- sidebar
- sublimeLinter
- HTML/CSS/JS Prettify
- Javascript Completions
### Edit Package Files
> `PackageResourceViewer` - modify packages
### Theme Packages
> `Material theme`
> `pretty JSON` - ctrl+shift+p -> json format, align, minify
> `php cs fixer` - php code standard fixer (psr-4)
> `outline` - functions list
> `AdvanceNewFile` - tab to autocomplete folders, current directory (:), ctrl+shift+p -> ANF: Rename/Delete, "settings" -> "rename_default": "<filename>" (or) "<filepath>" (or) "<filedirectory>"
	- `ctrl+alt+n` - create new file
	- `ctrl+shift+alt+n` - create new folder
### Mark down Package
> `Markdown Extended` - .md file colorfull
> `Markdown preview` - ctrl+shift+p -> select markdown preview
> `Markdown editing` - choose editor
### Css
> `tailwind css autocomplete` - https://packagecontrol.io/packages/Tailwind%20CSS%20Autocomplete

---
## Setting

### User Setting
```php
{
	"bold_folder_labels": true,
	"color_scheme": "Packages/Material Theme/schemes/Material-Theme.tmTheme",
	"ensure_newline_at_eof_on_save": true,
	"font_face": "Operator Mono Book",
	"font_options":
	[
		"gray_antialias",
		"subpixel_antialias"
	],
	"font_size": 11,
	"ignored_packages":
	[
		"Markdown",
		"MarkdownPreview",
		"Terminal",
		"Vintage"
	],
	"indent_guide_options":
	[
		"draw_normal",
		"draw_active"
	],
	"line_padding_bottom": 8,
	"line_padding_top": 8,
	"margin": 0,
	"material_theme_accent_bright": true,
	"material_theme_bold_tab": true,
	"material_theme_compact_sidebar": true,
	"material_theme_contrast_mode": true,
	"material_theme_small_statusbar": true,
	"material_theme_small_tab": true,
	"material_theme_tree_headings": true,
	"overlay_scroll_bars": "enabled",
	"remember_full_screen": true,
	"theme": "Material-Theme.sublime-theme",
	"trim_trailing_white_space_on_save": true
}
```

### Key Bindings
```php
[
	{ "keys": ["ctrl+]"], "command": "html_beautify" },
]
```
