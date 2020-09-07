> `vim` - show the editor

## install & config
- `oh-my-zsh` - mac editor to install
- `:colorscheme [hit tab]` - to see list of themes, *:colorscheme blue* - use theme

## Theme
https://github.com/gosukiwi/vim-atom-dark/tree/master/colors


- `:pwd` - know the current working dir
- `:so %` - source the current file (affact the changes to terminal)

## mode
- `i` - insert mode
- `v` - visual mode
- `Esc` - exit from insert mode to normal mode

## shortcuts
- `h,j,k,l` - select letters left,down,up,right (working only in visual mode)
- `V` - (capital v) select entire line
- `y` - copy the line
- `p` - paste the line
- `shift+insert` - paste (copy from outside)
- `yyp` - copy and paste the line fast
- `.` - execute the last command
- `u` - undo the changes (like ctrl+z)
- `/word` - search & find the word (n-find next)
- `zz` - move current line as the center of the screen

## save & exit
- `:q` - quit
- `:wq` - write and quit
- `:w f.txt` - save new file with name
- `:e f.txt` - edit existing file (file name tab to autocompletion)
- `:e ~/.vimrc` - edit vim config file
- `:tabedit f.txt` - open and edit file in new tab
- `:tabc` - close the current tab
- `:bd` - buffer close all same files

## help
- `:help tabclose`

## In visual mode
- `(h,j,k,l)` - select word
- `d` - delete selections, letters, line

## ~/.vimrc
imap - insert mode map
nmap - normal mode map

```sh
Syntax enable

colorscheme desert				"editor background color"

set backspace=indent,eol,start 	"Make backspace behave like every other editor"
let mapleader=','				"The default leader is \,but a comma is much better"
set number						"let's activate line numbers"
set linespace=15				"Macvim-specific line height"

"-----Search-----"
set hlsearch 					"highlight the search words"
set incsearch					"search at the time of typing"

"-----Mapping-----"

"Make it easy to edit the vimrc file"
nmap <leader>ev :tabedit $MYVIMRC<cr>	",ev"

"(, ) to search highlight removal after searching complete"
nmap <leader><space> :nohlsearch<cr>	", "

"-----Auto-commands-----"
"Automatically source the vimrc file on save"
"this will only affect at vimrc file only"
augroup autosourcing
	autocmd!
	autocmd BufWritePost .vimrc source %
augroup END
```
