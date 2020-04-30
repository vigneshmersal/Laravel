# Location: C:\Users\Vignesh\.bash_profile

# Some shortcuts for easier navigation & access
alias ..="cd ../"
alias ...="cd ../../"
alias ....="cd ../../../"
alias .....="cd ../../../../"
alias h="cd ~"
alias c="clear"

alias vm="ssh vagrant@127.0.0.1 -p 2222"

# -----Homestead shortcut-----
function homestead() {
    ( cd ~/laravel/Homestead && vagrant $* )
}


# ----------------------
# Git Aliases
# ----------------------
alias g="git"
alias gs="git status"
alias ga="git add"
alias gc="git commit -m"
alias gb="git branch"
alias gco="git checkout"
alias gd="git diff"
alias gm="git merge"
alias gp="git pull"
alias gr="git remote"

#-----Git log-----
alias gl="git log"
alias glg="git log --graph --oneline --decorate --all"

#-----Git Stash-----
alias gst="git stash"
alias gsta="git stash apply"
alias gstd="git stash drop"
alias gstl="git stash list"
alias gstp="git stash pop"
alias gsts="git stash save"


# ----------------------
# Project
# ----------------------
alias pos="cd D:/dev/ecpay_pos"
alias ecpay="cd D:/dev/ecpay_pos"
alias laundry="cd D:/dev/BestAtDryCleaning"
alias ki="cd D:/dev/ki-document"
alias laravel="cd D:/dev/laravel"

alias doccure="cd D:/dev/doccure"

# ----------------------
# Laravel
# ----------------------
alias pa="php artisan"

alias pal="php artisan list"
alias pam="php artisan migrate"
alias pat="php artisan tinker"
alias pas="php artisan serve"

alias list="php artisan list"
alias migrate="php artisan migrate"
alias tinker="php artisan tinker"
alias serve="artisan serve"

alias parl="php artisan route:list"
alias pasl='php artisan storage:link'

alias pamf="php artisan migrate:fresh"
alias pamfs="php artisan migrate:fresh --seed"
alias pamr="php artisan migrate:refresh"
alias pamrs="php artisan migrate:refresh --seed"
alias pads="php artisan db:seed"

#-----clear-----
alias cachec="php artisan cache:clear"
alias routec="php artisan route:clear"
alias configc="php artisan config:clear"
alias viewc="php artisan view:clear"

alias ccompiled="php artisan clear-compiled"

#-----app up/down-----
alias up="php artisan up"
alias down="php artisan down"

#-----cache-----
alias rcache="php artisan route:cache"
alias ccache="php artisan config:cache"

#-----make:-----
alias mauth="php artisan make:auth"
alias mchannel="php artisan make:channel"
alias mcommand="php artisan make:command"
alias mcontroller="php artisan make:controller"
alias mevent="php artisan make:event"
alias mexception="php artisan make:exception"
alias mexport="php artisan make:export"
alias mfactory="php artisan make:factory"
alias minport="php artisan make:import"
alias mjob="php artisan make:job"
alias mlistener="php artisan make:listener"
alias mmail="php artisan make:mail"
alias mmiddleware="php artisan make:middleware"
alias mmigration="php artisan make:migration"
alias mmodel="php artisan make:model"
alias mnotification="php artisan make:notification"
alias mobserver="php artisan make:observer"
alias mpolicy="php artisan make:policy"
alias mprovider="php artisan make:provider"
alias mrequest="php artisan make:request"
alias mresource="php artisan make:resource"
alias mrule="php artisan make:rule"
alias mseed="php artisan make:seeder"
alias mseeder="php artisan make:seeder"
alias mtest="php artisan make:test"
alias mtransformer="php artisan make:transformer"


# ----------------------
# Composer
# ----------------------
alias ci="composer install"
alias cu="composer update"
alias cda="composer dump-autoload -o"
alias cr="composer require"


# ----------------------
# NPM
# ----------------------
alias nrd="npm run dev"
alias nrw="npm run watch"
alias nrwp="npm run watch-poll"
alias nrh="npm run hot"
alias nrp="npm run production"


# ----------------------
# Yarn
# ----------------------
alias yrd="yarn run dev"
alias yrw="yarn run watch"
alias yrwp="yarn run watch-poll"
alias yrh="yarn run hot"
alias yrp="yarn run production"
