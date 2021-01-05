# GitHub

## install
```sh
# Linux
sudo apt-get update
sudo apt-get install git

# Mac
brew install git
```

## git version
> `git --version` - chk git version

## git remote
> `git remote -v` - chk remote url
```sh
> `git remote show origin`
* remote origin
  Fetch URL:
	...git
  Push  URL:
	...git
  HEAD branch:
	master
  Remote branch:
    master tracked
  Local branch configured for 'git pull':
    master merges with remote master
  Local ref configured for 'git push':
    master pushes to master (up to date)
```

## git fetch
> `git fetch --all`

## git Config
> `git config` - list of git configs
> `git config --list` - list out the configurations
- *git config user.name "vignesh"* - set username
- *git config --global user.name "vignesh"* - set username as global
- *git config user.email "email"* - set email
- *git config --global user.email "email"* - set email as global
- *git config --global core.editor "subl"* - set git editor is sublime text

## git alias
> `git config --global alias.s status` - set alias
- *git config --global --unset alias.s* - remove alias
- *vi ~/.gitconfig* - alias stored

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

## git Clone
```sh
$ git clone <url>

# Clone a Git repository into a specific folder
$ git clone <url> <directory>

# Git clone a specific branch
$ git clone -b <branch> <remote_repo>

# Git clone exclusively one branch - clone only particular branch
$ git clone --single-branch --branch <branchn> <repository>

# Clone a private Git repository
https://devconnected.com/how-to-clone-a-git-repository/
```

## New project Setup
```sh
- *git init* - initialise the git repo
- *git remote add origin <url>* - add origin
```

## git Branch
```sh
# create new branch
$ git branch <branch-name>

# list all branches
git branch -al

# branches with last commit msg
git branch -v

# list merged branches
git branch --merged
```

## git checkout
```sh
# checkout to old branch
$ git checkout <branch-name>
$ git checkout -b <branch-name>

$ git checkout -b <branch-name> <origin/branch_name>

# undo new changes - before commit
$ git checkout -- app/user.php

# goto particular commit
$ git checkout <commit_ID>
```

## git add
> `git add .` - add all files to commit
- *git add f1.txt f2.txt*
- *git add -- app/user.php*

## git commit
> `git commit -m "initial commit"` - commit the added files to push
- *git commit* - To add description for that commit
- *git commit -q -m commitmessage*
- *git commit --amend* - append new changes to last commit (not recommanded)

## git revert
> *git revert --no-commit <commitId>* - revert last commit
> *git revert --abort* - Abort revert (undo revert cmd)
> *git commit -q -m <msg>* - complete revert

## git clean
> *git clean -qf -- app/test.php* - delete new file before add

## git push
> *git push origin master*

## git status
> `git status` - list out the modified files

## git reset
> `git reset` = unstage all added files
> `git reset -q -- app/user.php` - unstage file from staged file
> `git reset HEAD` - unstage all added files
> `git reset HEAD __file__` = To unstage particular file
> `$ git reset --hard HEAD` (discards local conflicts, and resets to remote branch HEAD)
> `git reset --hard __commit_ID__` = go to commit, remove new changes
> `git reset --soft __commit_ID__` = go to commit, still hold new changes

## git show
> git show __commit_ID__ = show committed changes

## git diff
```sh
# show changes from last commit
$ git diff
# chk diff on particualr file
$ git diff f1.txt

# to compare branches
$ git diff __comare_branch__
$ git diff __commit_id_first_5_characters__ __compare_commit_characters__
```

## git pull
```sh
# get code from origin
$ git pull
$ git pull origin <branch>
```

## git Merge
```sh
# merge your work to master
$ git merge origin/master

# merge two branches
$ git merge <branch>

# resolve conflicts
$ git mergetool

# list merged branches
$ git merge --merged

$ git merge abort -> last pull abort
git checkout
git pull
composer install
.lock
```

## Rebase

```php
$ git rebase origin/master
```

## Kdiff3
Homepage: http://kdiff3.sourceforge.net

```sh
# Comparing 2 files:
kdiff3 file1 file2
# Merging 2 files:
kdiff3 file1 file2 -o outputfile
# Comparing 3 files:
kdiff3 file1 file2 file3
# Merging 3 files:
kdiff3 file1 file2 file3 -o outputfile

# Comparing 2 directories:
kdiff3 dir1 dir2
# Merging 2 directories:
kdiff3 dir1 dir2-o destinationdir
# Comparing 3 directories:
kdiff3 dir1 dir2 dir3
# Merging 3 directories:
kdiff3 dir1 dir2 dir3 -o destinationdir
```

___

## git stash
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

## git log
> `gitk`

> `git log`
- *git log --graph*
- *git log --summary*
- *git log --oneline --graph*
- *git log --oneline* - show commit name only
- *git log -p {{file}}* - track all modifications on particular file

---

## issue

### How to fix Git Error ‘Your local changes to the following files will be overwritten by merge’

https://appuals.com/how-to-fix-git-error-your-local-changes-to-the-following-files-will-be-overwritten-by-merge/

## “Pull is not possible because you have unmerged files”
git clean -df
git reset --hard HEAD
git reset --hard origin/master
git checkout REMOTE_BRANCH_NAME
git pull origin REMOTE_BRANCH_NAME
