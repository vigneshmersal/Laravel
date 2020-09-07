## Terminal
* `GUI` - Graphical User Interface
* `CLI` - Command Line Interface
* `ctrl+alt+t` - opening terminal in linux machine
* `ctrl+shift+t` - open new tab

## combine two commands
> ls ; pwd - (`;`) - if the 1st CMD fails , 2nd CMD will run

> ls && ped - (`&&`) - if the 1st CMD fails, then 2nd CMD will not run

> ls || ped - (`||`) - if the 1st CMD success, then 2nd CMD will not run

## Basics
> `man [command]` - help

> `clear` - clear contents in the terminal

> `sudo [command]` - super user do (administrator)

> `sudo -s` - login to root user

___

## User & Group

### Create user
> `sudo useradd [userName]` - create user
- *sudo useradd vignesh -m -g users* - `(-m)` create home dir for this user, `(-g)` assign user to `users` group

### change password
> `sudo passwd` - change current user password
- *sudo passwd vignesh* - change user password

### Delete user
> `sudo userdel [userName]` - delete user
- *sudo userdel -r vignesh* - `(-r)` remove home dir

### List groups
> `groups` - list current user groups
- *cat /etc/group* - list all groups

### Create group
> `sudo groupadd [name]` - create new group

### Delete group
> `sudo groupdel [name]` - delete the group

### add/remove user group
> `sudo gpassswd -a [user] [group]` - *(-a)* adding user to this group,
- `sudo gpasswd -d [user] [group]` - *(-d)* deleting user to this group

> su vignesh

___

## file/directory common
> `~` - home directory

> `/` - root directory

> `.` - current dir

> `..` - backward dir

> `"My books/"` - forward

> `My\ books/*.html` - search file with format

> `> out.txt` - redirect output to a new file

> `>> out.txt` - append content to an existing file

## Options
> `-v` - verbose display the extended output information

> `-i` - (interactive mode) Ask for overwrite

## Directory & Files
> `pwd` - present working directory

> `cd [dir]` - change directory

> `ls [options] [fd]` - list files
- *ls*
- *ls -l* - content in long format (date,time,permission)
- *ls -a* - show hidden files
- *ls -S* - short by size [DESC]
- *ls > out.txt* - save output in a file
- *ls -d */* - list only directories
- *ls -R* - show directory structure

> `cp [options] [source] [destination]` - copy files
- *cp f1.txt f2.txt* - if the f2 not exist it will create f2 file
- *cp f1.txt f2.txt dir* - copy files and paste into dir (files will be overwrited if exist)
- *cp -i f1.txt dir* - (-i interactive mode) Ask overwrite a existing file
- *cp -R dir1 dir2* - copy dir which contain files (-R recursive) (copy inside files only)

> `mv [options] [source] [destination]` = move files
- *mv f1.txt rename.txt* - rename the file
- *mv f1.txt dir/* - if the file is already exist, it will overwrite
- *mv dir1 dir2* - if dir2 exist - o/p like `dir2/dir1/f1.txt`

> `mkdir [dir]` - create a new directory
- *mkdir -p dir/subdir* - `--parents` create dir and subdir also like a tree structure
- *mkdir -p dir/{sub1,sub2}* - create dir with many subdir

> `rmdir [options] [dir]` - delete dir
- *rmdir a/b/c* - remove c dir
- *rmdir -p a/b/c* - remove dir structure (only when empty)

> `rm [options] [dir/file]` - delete dir/file
- *rm -r a* - remove dir & inside files/dir also (-r recursive)

> `find searchDir/ -name test.*` - search file (`-name` search by name)
- *find home/ -mtime -1* - search file created 1 day ago

> `wc file.txt` - (o/p: 1 6 42 file.txt) word count
- 1 - no of line (`-l` flag)
- 6 - no of words (`-w` flag)
- 42 - no of characters (`-c` flag)
- file.txt - name of the file
- *-L* flag - (no of characters in the longest line)

## permission - rwx
> `[type][owner][group][others] 1 [ownerFileName] [groupFileName] [size] [date] [fileName]` -
- *type* - (dash - normal file), (d-dir), (c-character file), (b-binary file)
- *1* - symbolic link
- *rwx* - read/write/execute

> `chmod [u/g/o][+/-/=][r/w/x] [file]` - change the permission of the file for the given user
- *chmod u=r,g+w,o-w file* - assign / add / remove
- *chmod go-wx file* - multiple user , multiple permission
- *chmod a-r file* - all type of user

> `4 2 1(r w x)`
- *chmod 755 f.txt*
- | rwx | xxx |  0 |
- | :-- | :-: | -: |
- | --- | 000 | 0  |
- | --x | 001 | 1  |
- | -w- | 010 | 2  |
- | -wx | 011 | 3  |
- | r-- | 100 | 4  |
- | r-x | 101 | 5  |
- | rw- | 110 | 6  |
- | rwx | 111 | 7  |

## Editor
make empty
> cat /dev/null > `file.log`

> `head [file]` - see first 10 lines of the file
- *head -n3 [file]* - see first 3 lines

> `tail [file]` - see last 10 lines of the file
- *tail -3 [file]* - see last 3 lines

> `echo [options] [var/string]` - scripting
- *name="vignesh"* - assign value to the variable (`echo $name`)
- *echo -e 'some \t boys'* - (`\t`-tab,`\n`-new line,`\b`,`\a`-alert) escape sequence

> `touch [file]` - create a new empty file, if already exist it will update the timestamp

> `cat [options] [file]` - display | combine | create txt files
- *cat file.txt* - display the content of the file
- *cat -n file.txt* - display with line number including the blank lines
- *cat -s file.txt* - reduce multiple blank line to one line for display
- *cat -E file.txt* - add `$` symbol on each line end
- *cat > out.txt* - create file and add a content
- *cat f1.txt f2.txt > out.txt* - concatenate 2 files content into new output file
- *cat - out.txt* - append content to an existing file
- *cat f1.txt - f2.txt* - append f1 content to an existing file

> `less [file]` - show only the starting of the file
- *:up* - move up
- *:down* - move down
- *:p* - move one page up
- *:space* - move one page down
- *:g* - move to beginning of the file
- *:G* - move to end of the file
- */word* - search word from up to down
- *?word* - search word from down to up
- *:n* - find next search item
- *:q* - quit command

SYNTAX COlORFULL TEXT EDITOR
> `nano [file]` - create a new file in the terminal
- `ctrl+o` - save the file
- `ctrl+x` - Exit from nano editor
- `ctrl+k` - cut the line
- `ctrl+u` - paste the line
- `ctrl+y` - prev page
- `ctrl+v` - next page

> `gedit [file]` - open file in notepad editor

## system
> `df -h` - view free/used memory space for files (*-h* human readable)

> dir:`du -h` - disk space used by the files (*-h* human readable)
- dir:*du -sh* - (`-s` sum of total)

> `free -m` - view free space on dir (*-m* memory in MB)

> `pidof [programName]` - know the PID of the program

> `ps -ux` - long list of running processes in current user
- *ps -aux* - list of processes used by all the user
- *ps -U [userName]* - given user list of processes
- *ps -C [programName]* - list of all the programs related to the program

> `top` - system information (refresh every 3sec)
- *i* - show only running processes
- *k* - Ask PID for close the process

> `kill [options] [PID]` - close the program
- *kill -KILL [PID]* - force kill
- *kill -9 [PID]* - force kill

___

## Scripting
> `.bashrc` - This is the default script will executed, when open a new terminal
- we can customise by adding a new scripts at the end of the file

> `nano myscript.sh` - create a scripting file
- *chmod +x myscript.sh* - give execute permission
- *./myscript.sh* - run the scripting

## which [program/command]- return path
> `which ls` - `\bin\ls`
- *which bash* - `/bin/bash`
- *which firefox* - `/usr/bin/firefox`

## whatis [program/command] - return short description
> `whatis ls` - list directory contents

## watch [command] - run the command continuously at certain interval (default 2 sec)
> `watch free -h`
- *watch -n 1,5 free -h* - change interval to 1.5sec

___
## SSH
> `ssh` - check whether ssh is installed or not
- *sudo apt-get install openssh-server* - install open ssh server
- *sudo service ssh status* - check open ssh server is running
- *ssh localhost* - check ssh server is installed
- *ssh userName@IP -p1222* - (`-p` port number) - chk ssh client is installed
- *ssh -i D:/dev/key.pem uname@IP* - connect
- *sudo gedit /etc/ssh/sshd_config* - In this file we can change the default ssh port `22`

> `ifconfig` - know ip address near (inet addr)

> `scp` - secure copy files
- *scp file hostUserName@IP:LocationPath* - ex: scp hello.txt root@192.0.0.1:/var/path - copy files from local to remote
- *scp -r dirName hostUserName@IP:LocationPath* - (`-r` recursively copy all files and dir)
- *scp remoteUserName@IP:/home/file.txt destinationLocation* - copy from remote to local
- *scp -r remoteUserName@IP:/home/file.txt destinationLocation -P 1234 -i /home/public.key* - (`-r` recursively copy files) (`-P` mention diff port if need) (`-i` - if public key add location here)
