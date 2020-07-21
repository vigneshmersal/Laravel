# GitHub

Open source project CRM(customer relationship system)
> https://github.com/Bottelet/DaybydayCRM

> `git --version` - chk git version

> `git remote -v` - chk remote url

git fetch --all
git branch -al
git branch -v = see branches with last commit msg
git branch --merged = list merged branches

git show __commit_ID__ = show committed changes

git diff = show changes from last commit
git diff __comare_branch__ = to compare branches
git diff __commit_id_first_5_characters__ __compare_commit_characters__

git merge --merged = list merged branches

## Git Configuration
> `git config --list` - list out the configurations
- *git config user.name "vignesh"* - set username
- *git config --global user.name "vignesh"* - set username as global
- *git config user.email "email"* - set email
- *git config --global user.email "email"* - set email as global
- *git config --global core.editor "subl"* - set git editor is sublime text
___

## Alias (shortcut)
> `git config --global alias.s status` - set alias
- *git config --global --unset alias.s* - remove alias
- *vi ~/.gitconfig* - alias stored
___

## Remove old git & set new git repository:
- *rm -rf .git*
- *git init*
- *git remote add origin {{url.git}}*
(or)
- *git remote remove origin*
- *git remote set-url origin {{url.git}}*

The “fatal: refusing to merge unrelated histories”, when switching to git repo origin:
> `git pull origin master --allow-unrelated-histories`
___

## COMPOSER
COMPOSER HTTPS CONFIG - if http restrict
> `composer config --global repo.packagist composer https://packagist.org`
___

## Existing Project Setup
> `git clone {{url.git}}` - download git files to local system
___

## New project Setup
- *git init* - initialise the git repo
- *git remote add origin {{url.git}}* - add origin
___

## Basics
> `git branch {{name}}` - create new branch
- *git checkout {{name}}* - checkout to old branch
- *git checkout -b {{name}}* - checkout to old branch

> `git pull` - get code from origin
- *git pull origin {{branch}}*

> `git diff` - list new changes with existing files
- *git diff f1.txt* - chk diff on particualr file

> `git status` - list out the modified files

> `git add .` - add all files to commit
- *git add f1.txt f2.txt*

> `git commit -m "initial commit"` - commit the added files to push
- *git commit* - To add description for that commit
- *git commit --amend* - append new changes to last commit (not recommanded)

> `git merge {{branch}}` - merge two branches
- *git mergetool* - resolve conflicts
___

# Merge Tool
Homepage: http://kdiff3.sourceforge.net

Start from commandline:
- Comparing 2 files:       kdiff3 file1 file2
- Merging 2 files:         kdiff3 file1 file2 -o outputfile
- Comparing 3 files:       kdiff3 file1 file2 file3
- Merging 3 files:         kdiff3 file1 file2 file3 -o outputfile

- Comparing 2 directories: kdiff3 dir1 dir2
- Merging 2 directories:   kdiff3 dir1 dir2-o destinationdir
- Comparing 3 directories: kdiff3 dir1 dir2 dir3
- Merging 3 directories:   kdiff3 dir1 dir2 dir3 -o destinationdir

___

## stash
- `git stash`
- *git stash list* - list all stash
- *git stash -u* - untracked (new file)
- *git stash -a* - all files
- *git stash save "message"* - with description
- *git stash pop*
- *git stash pop stash@{2}*
- *git stash apply*
- *git stash show* - show only file name of diff
- *git stash show -p* - show full code diff
- *git stash drop -q stash@{0}* - to drop stash
___

## list out last pushes
> `gitk`

> `git log`
- *git log --graph*
- *git log --summary*
- *git log --oneline --graph*
- *git log --oneline* - show commit name only
- *git log -p {{file}}* - track all modifications on particular file
